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


	function createLabels($model, $data){
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
		return $this->query("SELECT * FROM tasks as Task inner join tasks_users on tasks_users.task_id = Task.id " .
								   "and tasks_users.user_id = " . $userId . " where checked = " . $checked);
	}
	
	public function getTaskListsByTasksIds($taskIds){
		return $this->query("select * from task_lists as TaskList where id in " .
								   "(select task_list_id from task_lists_tasks where task_id in (" . implode(",", $taskIds) . "))");
	}
	
	public function getTasksByTaskIds($ids) {
		return $this->query("select * from tasks as Task where id in (" . implode(",", array_unique($ids)) . ")");
	}

	// Contexts
	public function getContextById($id, $userId){
		return $this->query("select * from contexts as Context where id = " . $id . " and user_id = " . $userId);
	}
	
	public function getContexts($userId){
		return $this->query("select * from contexts as Context where user_id = " . $userId);
	}
	
	public function getContextsByContextIds($contextIds){
		return $this->query("select * from contexts as Context where id in (" . 	implode(",", $contextIds) . ")");
	}

	public function getContextsTasksByTaskIds($taskIds) {
		return $this->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");
	}
	

	// Tags
	public function getTagsByTagIds($tagIds){
		return $this->query("select * from tags as Tag where id in (" . implode(",", $tagIds) . ")");
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
	
	// TaskLists
	public function getTaskListsByTaskListIds($ids) {
		return $this->query("select * from task_lists as TaskList where id in (" . implode(",", array_unique($ids)) . ")");
	}
	
	// TagsTaskLists
	public function getTagsTaskListsByTaskListIds($taskListIds){
		return $this->query("select * from tags_task_lists as TagTaskList where task_list_id in (" . implode(",", $taskListIds) . ")");
	}
}
