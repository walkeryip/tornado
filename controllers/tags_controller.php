<?php

class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		$this->set('tags', $this->Tag->find('all'));
	}
	
	function all(){
		if ($this->RequestHandler->isAjax()){
			$tags = $this->Tag->find('all');
			$data["Tags"] = $tags;
			$this->set("data", $data);
        	$this->render('/general/json', 'ajax');
		}
	}

	function view($id){
		/*$tag = $this->Tag->getTagById($id);
		$lists = $this->Tag->TaskList->getTaskListsByTagId($id);
		$tasks = $this->Tag->Task->getTasksByTagId($id, false);
		$tasksDone = $this->Tag->Task->getTasksByTagId($id, true);*/

		if ($this->RequestHandler->isAjax()){
/*			$tag['List'] = $lists;
			$tag['Task'] = $tasks;
        	$this->set('data', $tag);*/


			/*$data["Tasks"] = $this->Task->query("SELECT * FROM tasks as Task where checked = " . $checked);
			$taskIds = $this->accId($data["Tasks"], "Task", "id");

			$data["TaskLists"] = $this->Task->query("select * from task_lists as TaskList where id in (select task_list_id from task_lists_tasks where task_id in (" . implode(",", $taskIds) . "))");

			$data["TagsTasks"] = $this->Task->query("select * from tags_tasks as TagTask where task_id in (" . implode(",", $taskIds) . ")");
			$data["ContextsTasks"] = $this->Task->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");

			$tagsTasksTagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$data["Tags"] = $this->Task->Tag->query("select * from tags as Tag where id in (" . 
				implode(",", $tagsTasksTagIds) . ")");

			$contextsTasksContextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
			$data["Contexts"] = $this->Task->Context->query("select * from contexts as Context where id in (" . 
				implode(",", $contextsTasksContextIds) . ")");
*/

			$data["Tags"] = $this->Tag->query("select * from tags as Tag where id = " . $id);

			$data["TagsTasks"] = $this->Tag->query("select * from tags_tasks as TagTask where tag_id = " . $id);
			$data["TagsTaskLists"] = $this->Tag->query("select * from tags_task_lists as TagTaskList where tag_id = " . $id);

			$taskTagIds = $this->accId($data["TagsTasks"], "TagTask", "task_id");
			$taskListTagIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "task_list_id");

			if (sizeof($taskListTagIds)>0){
				$data["TaskLists"] = $this->Tag->query("select * from task_lists as TaskList where id in (" . implode(",", array_unique($taskListTagIds)) . ")");
			}
			if (sizeof($taskTagIds)>0){
		    	$data["Tasks"] = $this->Tag->query("SELECT * FROM tasks as Task WHERE id in (" . implode(",", array_unique($taskTagIds)) . ")");
			}

			$this->set("data", $data);
        	$this->render('/general/json', 'ajax');
		} else {
			$context = $this->Tag->getTagById($id);
			$this->set('tag_id', $context["Tag"]["id"]);
		}
	}
}

?>
