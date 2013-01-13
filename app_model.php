<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */


// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class AppModel extends Model {
	/**
     * Return a comma separated string based on the names of $data.
	 * $data could be for example a list of contexts or tags.
     **/
	function getLabels($data){
		$labels = array();
		$result = array();
		if (isset($data) && !empty($data)){
			foreach ($data as $label){
				$labels[] = $label['name'];
			}

			$result = implode(', ', $labels);
		}

		return $result;
	}

	function getUsers($data, $userId){
		$userNames = explode(',', $data);
		$result = array();
		$usersList = "";
		$index = 0;
		foreach ($userNames as $userName) {
		  if ($index != 0) {
			$usersList .= ",";
		  }
			$usersList .= '"' . strtolower(trim($userName)) . '"';

			$index++;
		}

		$users = $this->query("select User.id from users as User where User.username in (" . $usersList . ")");

		foreach ($users as $user) {
			array_push($result, $user['User']['id']);
		}

		if ($userId) {
			array_push($result, $userId);
		}

		return $result;
	}

	function createLabels($model, $data, $userId){
		$labels = explode(',', $data);
		$modelName = $model->name;
		$result = array();

		// explode on empty string returns one null element (hurray!), so if empty return an array with an empty element
		// this is so that cake deletes all labels from the database associated with the object
		if (sizeof($labels) == 1 && $labels[0] == null){
			return Array(0 => null);
		}


		foreach ($labels as $_label){
			$_label = strtolower(trim($_label));

			if ($_label){
				$model->recursive = -1;
				$label = $model->findByName($_label);

				if (!$label){
					$model->create();
					$label[$modelName]['user_id'] = $userId;
					$label = $model->save(array('name' => $_label, 'user_id' => $userId));
					$label[$modelName]['id'] = $model->id;
				}

				/*print_r($label);
				print_r($result);
				echo $modelName;*/
				array_push($result, $label[$modelName]["id"]);
			}
		}
//		print_r($result);
		return $result;
	}
	

	
	
	
	// Tasks
	public function getTasks($userId, $checked, $shared = false){
		$query = "SELECT Task.* FROM tasks as Task inner join tasks_users as TasksUsers on TasksUsers.task_id = Task.id " .
				 "and TasksUsers.user_id = " . $userId . " where Task.deleted = false and Task.checked = " . $checked;

		if ($shared) {
			$query .= " and exists(select * from tasks_users where tasks_users.task_id = Task.id and tasks_users.user_id != " . $userId . ")";
		}
	
		$query .= " group by Task.id";
		return $this->query($query);
	}

	public function getTaskByTaskId($taskId, $userId){
		return $this->query("SELECT Task.* FROM tasks as Task inner join tasks_users on tasks_users.task_id = Task.id " .
								   "and tasks_users.user_id = " . $userId . " where Task.deleted = false and Task.id = " . $taskId . " group by Task.id");
	}
	
	public function getTaskListsByTasksIds($taskIds){
		return $this->query("select * from task_lists as List where List.deleted = false and id in " .
								   "(select task_list_id from task_lists_tasks where task_id in (" . implode(",", $taskIds) . "))");
	}
	
	public function getTasksByTaskIds($ids, $userId) {
		return $this->query("select Task.* from tasks as Task inner join tasks_users on tasks_users.task_id = Task.id and " . 
							"tasks_users.user_id = " . $userId . " where Task.deleted = false and Task.id in (" . implode(",", array_unique($ids)) . ") group by Task.id");
	}


	// Contexts
	public function getContextById($id, $userId){
		return $this->query("select * from contexts as Context where id = " . $id . " and Context.deleted = false and user_id = " . $userId);
	}
	
	public function getContexts($userId){
		return $this->query("select * from contexts as Context where Context.deleted = false and user_id = " . $userId);
	}
	
	public function getContextsByContextIds($contextIds, $userId){
		return $this->query("select * from contexts as Context where Context.deleted = false and id in (" . 	implode(",", $contextIds) . ") and user_id = " . $userId);
	}

	public function getContextsTasksByTaskIds($taskIds) {
		return $this->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");
	}
	

	// Tags
	public function getTagById($id, $userId){
		return $this->query("select * from tags as Tag where Tag.deleted = false and id = " . $id . " and user_id = " . $userId);
	}
	
	public function getTags($userId){
		return $this->query("select * from tags as Tag where Tag.deleted = false and user_id = " . $userId);
	}

	public function getTagsByTagIds($tagIds, $userId){
		return $this->query("select * from tags as Tag where Tag.deleted = false and id in (" . implode(",", $tagIds) . ") and user_id = " . $userId);
	}
	
	public function getTagsTasksByTaskIds($taskIds){
		return $this->query("select * from tags_tasks as TagTask where task_id in (" . implode(",", $taskIds) . ")");
	}

	
	// Users
	public function getUsersByUserIds($userIds){
		return $this->query("select id, username as name from users as User where User.deleted = false and id in (" . implode(",", $userIds) . ")");
	}
	
	public function getTasksUsersByTaskIds($taskIds) {
		return $this->query("select * from tasks_users as TaskUser where task_id in (" . implode(",", $taskIds) . ")");
	}
	
	public function getTaskListsUsersByTaskListIds($taskListIds) {
		return $this->query("select user_id, task_list_id as list_id from task_lists_users as ListUser where task_list_id in (" . implode(",", $taskListIds) . ")");
	}
	
	public function getTagsUsersByTagIds($tagIds) {
		return $this->query("select * from tags_users as TagUser where tag_id in (" . implode(",", $tagIds) . ")");
	}
	
	public function getContextUsersByContextIds($contextIds) {
		return $this->query("select * from contexts_users as ContextUser where context_id in (" . implode(",", $contextIds) . ")");
	}
	
	// ContextsTasks
	public function getContextsTasksByContextId($id) {
		return $this->query("select * from contexts_tasks as ContextTask where context_id = " . $id);
	}
	
	public function getContextsTasksByContextIds($ids) {
		return $this->query("select * from contexts_tasks as ContextTask where context_id in (" . implode(",", $ids) . ")");
	}
	
	// ContextsTaskLists
	public function getContextsTaskListsByContextId($id) {
		return $this->query("select context_id, task_list_id as list_id from contexts_task_lists as ContextList where context_id = " . $id);
	}
	
	public function getContextsTaskListsByContextIds($ids) {
		return $this->query("select context_id, task_list_id as list_id from contexts_task_lists as ContextList where context_id in (" . implode(",", $ids) . ")");
	}
	
	public function getContextsTaskListsByTaskListId($id) {
		return $this->query("select context_id, task_list_id as list_id from contexts_task_lists as ContextList where task_list_id = " . $id);	
	}

	public function getContextsTaskListsByTaskListIds($ids) {
		return $this->query("select context_id, task_list_id as list_id from contexts_task_lists as ContextList where task_list_id in (" . implode(",", $ids) . ")");	
	}

	// TagsTasks
	public function getTagsTasksByTagId($id) {
		return $this->query("select * from tags_tasks as TagTask where tag_id = " . $id);
	}
	
	public function getTagsTasksByTagIds($ids) {
		return $this->query("select * from tags_tasks as TagTask where tag_id in (" . implode(",", $ids) . ")");
	}
	
	// TagsTaskLists
	public function getTagsTaskListsByTagId($id) {
		return $this->query("select tag_id, task_list_id as list_id from tags_task_lists as TagList where tag_id = " . $id);
	}
	
	public function getTagsTaskListsByTagIds($ids) {
		return $this->query("select tag_id, task_list_id as list_id from tags_task_lists as TagList where tag_id in (" . implode(",", $ids) . ")");
	}
	
	public function getTagsTaskListsByTaskListId($id) {
		return $this->query("select tag_id, task_list_id as list_id from tags_task_lists as TagList where task_list_id = " . $id);	
	}

	public function getTagsTaskListsByTaskListIds($ids) {
		return $this->query("select tag_id, task_list_id as list_id from tags_task_lists as TagList where task_list_id in (" . implode(",", $ids) . ")");	
	}
	
	// TaskLists
	public function getTaskListByTaskListId($id, $userId) {
		return $this->query("select List.* from task_lists as List inner join task_lists_users on task_lists_users.task_list_id = List.id " .
					  	    "and task_lists_users.user_id = " . $userId . " where List.deleted = false and List.id = " . $id  . " group by List.id");
	}
	public function getTaskListsByTaskListIds($ids, $userId) {
		return $this->query("select List.* from task_lists as List inner join task_lists_users on task_lists_users.task_list_id = List.id " .
					  	    "and task_lists_users.user_id = " . $userId . " where List.deleted = false and List.id in (" . implode(",", array_unique($ids)) . ") group by List.id");
	}

	public function getTaskListAndParentByTaskListId($id, $userId, $shared = false) {
		$query = "select List.* from task_lists as List inner join task_lists_users on task_lists_users.task_list_id = List.id" .
				    " and task_lists_users.user_id = " . $userId . " and List.deleted = false";

		if ($shared) {
			$query .= " and exists(select * from task_lists_users where task_lists_users.task_list_id = List.id and task_lists_users.user_id != " . $userId . ")";
		} else {
		  $query .= " and (List.id = " . $id . " or List.parent_id = " . $id . ")";
		}
	
		$query .= " group by List.id";
		return $this->query($query);
	}

	public function getTaskLists($userId) {
		return $this->query("select List.* from task_lists as List inner join task_lists_users on task_lists_users.task_list_id = List.id " .
					  	    "and List.deleted = false and task_lists_users.user_id = " . $userId . " group by List.id");
	}

	public function getRootTaskLists($userId) {
		return $this->query("select List.* from task_lists as List inner join task_lists_users on task_lists_users.task_list_id = List.id " .
					  	    "and List.deleted = false and task_lists_users.user_id = " . $userId . " where List.parent_id is null group by List.id");
	}

	public function getNavigationTree($userId) {
		return $this->query("select List.id, List.name, List.parent_id from task_lists as List inner join task_lists_users on " .
							"task_lists_users.task_list_id = List.id and List.deleted = false and task_lists_users.user_id = " . $userId . " group by List.id");
	}

	// TaskListsTasks
	public function getTaskListsTasksByTaskListId($id) {
		return $this->query("select task_id, task_list_id as list_id from task_lists_tasks as ListTask where ListTask.task_list_id = " . $id);
	}

	public function getTaskListsTasksByTaskListIds($ids) {
		return $this->query("select task_id, task_list_id as list_id from task_lists_tasks as ListTask where ListTask.task_list_id in (" . implode(",", array_unique($ids)) . ")");
	}

	public function getTaskListsTasksByTaskIds($ids) {
		return $this->query("select task_id, task_list_id as list_id from task_lists_tasks as ListTask where ListTask.task_id in (" . implode(",", array_unique($ids)) . ")");
	}

	public function getTaskListsTasksByTaskListTaskId($id) {
		return $this->query("select task_id, task_list_id as list_id from task_lists_tasks as ListTask where ListTask.task_list_id = " . $id);
	}

	public function deleteTaskListTaskByTaskIdAndTaskListId($taskId, $listId) {
		return $this->query("delete from task_lists_tasks where task_id = " . $taskId . " and task_list_id = " . $listId);
	}
	
	public function addTaskListTask($taskId, $listId) {
		return $this->query("insert into task_lists_tasks (task_id, task_list_id) values (" . $taskId . "," . $listId . ")");
	}




	public function addTags($tags, $userId){
		return $this->createLabels($this->Tag, $tags, $userId);
	}

	public function addContexts($contexts, $userId){
		return $this->createLabels($this->Context, $contexts, $userId);
	}

	public function getTagsString(){
		return $this->getLabels($this->Tag);
	}

	public function getContextsString(){
		return $this->getLabels($this->Context);
	}

	public function addUsers($users, $user){
		return $this->getUsers($users, $user);
	}
}
