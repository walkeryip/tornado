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
					$label = $model->save(array('name' => $_label));
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
	public function getTasks($userId, $checked){
		return $this->query("SELECT Task.* FROM tasks as Task inner join tasks_users on tasks_users.task_id = Task.id " .
								   "and tasks_users.user_id = " . $userId . " where checked = " . $checked . " group by Task.id");
	}

	public function getTaskByTaskId($taskId, $userId){
		return $this->query("SELECT Task.* FROM tasks as Task inner join tasks_users on tasks_users.task_id = Task.id " .
								   "and tasks_users.user_id = " . $userId . " where Task.id = " . $taskId . " group by Task.id");
	}
	
	public function getTaskListsByTasksIds($taskIds){
		return $this->query("select * from task_lists as TaskList where id in " .
								   "(select task_list_id from task_lists_tasks where task_id in (" . implode(",", $taskIds) . "))");
	}
	
	public function getTasksByTaskIds($ids, $userId) {
		return $this->query("select Task.* from tasks as Task inner join tasks_users on tasks_users.task_id = Task.id and " . 
							"tasks_users.user_id = " . $userId . " where Task.id in (" . implode(",", array_unique($ids)) . ") group by Task.id");
	}

	/*public function getParentsByTaskIds($ids) {
		return $this->query("select TaskListTask.* from task_lists_tasks as TaskListTask where TaskListTask.task_id in (" . implode(",", array_unique($ids)) . ")");
	}*/

	// Contexts
	public function getContextById($id, $userId){
		return $this->query("select * from contexts as Context where id = " . $id . " and user_id = " . $userId);
	}
	
	public function getContexts($userId){
		return $this->query("select * from contexts as Context where user_id = " . $userId);
	}
	
	public function getContextsByContextIds($contextIds, $userId){
		return $this->query("select * from contexts as Context where id in (" . 	implode(",", $contextIds) . ") and user_id = " . $userId);
	}

	public function getContextsTasksByTaskIds($taskIds) {
		return $this->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");
	}
	

	// Tags
	public function getTagById($id, $userId){
		return $this->query("select * from tags as Tag where id = " . $id . " and user_id = " . $userId);
	}
	
	public function getTags($userId){
		return $this->query("select * from tags as Tag where user_id = " . $userId);
	}

	public function getTagsByTagIds($tagIds, $userId){
		return $this->query("select * from tags as Tag where id in (" . implode(",", $tagIds) . ") and user_id = " . $userId);
	}
	
	public function getTagsTasksByTaskIds($taskIds){
		return $this->query("select * from tags_tasks as TagTask where task_id in (" . implode(",", $taskIds) . ")");
	}

	
	// Users
	public function getUsersByUserIds($userIds){
		return $this->query("select id, username from users as User where id in (" . implode(",", $userIds) . ")");
	}
	
	public function getUsersTasksByTaskIds($taskIds) {
		return $this->query("select * from tasks_users as TaskUser where task_id in (" . implode(",", $taskIds) . ")");
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
		return $this->query("select * from contexts_task_lists as ContextTaskList where context_id = " . $id);
	}
	
	public function getContextsTaskListsByContextIds($ids) {
		return $this->query("select * from contexts_task_lists as ContextTaskList where context_id in (" . implode(",", $ids) . ")");
	}
	
	public function getContextsTaskListsByTaskListIds($ids) {
		return $this->query("select * from contexts_task_lists as ContextTaskList where task_list_id in (" . implode(",", $ids) . ")");	
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
		return $this->query("select * from tags_task_lists as TagTaskList where tag_id = " . $id);
	}
	
	public function getTagsTaskListsByTagIds($ids) {
		return $this->query("select * from tags_task_lists as TagTaskList where tag_id in (" . implode(",", $ids) . ")");
	}
	
	public function getTagsTaskListsByTaskListIds($ids) {
		return $this->query("select * from tags_task_lists as TagTaskList where task_list_id in (" . implode(",", $ids) . ")");	
	}
	
	// TaskLists
	public function getTaskListByTaskListId($id, $userId) {
		return $this->query("select TaskList.* from task_lists as TaskList inner join task_lists_users on task_lists_users.task_list_id = TaskList.id " .
					  	    "and task_lists_users.user_id = " . $userId . " where TaskList.id = " . $id  . " group by TaskList.id");
	}
	public function getTaskListsByTaskListIds($ids, $userId) {
		return $this->query("select TaskList.* from task_lists as TaskList inner join task_lists_users on task_lists_users.task_list_id = TaskList.id " .
					  	    "and task_lists_users.user_id = " . $userId . " where TaskList.id in (" . implode(",", array_unique($ids)) . ") group by TaskList.id");
	}

	public function getTaskListAndParentByTaskListId($id, $userId) {
		return $this->query("select TaskList.* from task_lists as TaskList inner join task_lists_users on task_lists_users.task_list_id = TaskList.id " .
					  	    "and task_lists_users.user_id = " . $userId . " and TaskList.id = " . $id . " or TaskList.parent_id = " . $id . " group by TaskList.id");
	}

	public function getTaskLists($userId) {
		return $this->query("select TaskList.* from task_lists as TaskList inner join task_lists_users on task_lists_users.task_list_id = TaskList.id " .
					  	    "and task_lists_users.user_id = " . $userId . " group by TaskList.id");
	}

	public function getNavigationTree($userId) {
		return $this->query("select TaskList.id, TaskList.name, TaskList.parent_id from task_lists as TaskList inner join task_lists_users on " .
							"task_lists_users.task_list_id = TaskList.id and task_lists_users.user_id = " . $userId . " group by TaskList.id");
	}

	// TaskListsTasks
	public function getTaskListsTasksByTaskListIds($ids) {
		return $this->query("select TaskListTask.* from task_lists_tasks as TaskListTask where TaskListTask.task_list_id in (" . implode(",", array_unique($ids)) . ")");
	}

	public function getTaskListsTasksByTaskIds($ids) {
		return $this->query("select TaskListTask.* from task_lists_tasks as TaskListTask where TaskListTask.task_id in (" . implode(",", array_unique($ids)) . ")");
	}

	public function getTaskListsTasksByTaskListTaskId($id) {
		return $this->query("select TaskListTask.* from task_lists_tasks as TaskListTask where TaskListTask.task_list_id = " . $id);
	}

	public function deleteTaskListTaskByTaskIdAndTaskListId($taskId, $listId) {
		return $this->query("delete from task_lists_tasks where task_id = " . $taskId . " and task_list_id = " . $listId);
	}
	
	public function addTaskListTask($taskId, $listId) {
		return $this->query("insert into task_lists_tasks (task_id, task_list_id) values (" . $taskId . "," . $listId . ")");
	}
}
