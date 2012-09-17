<?php

class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		$this->set('tags', $this->Tag->find('all'));
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
			$this->set('tag', $tag);
			$this->set('lists', $lists);
			$this->set('tasks', $tasks);
			$this->set('tasksDone', $tasksDone);
		}
	}


	function accId($objList, $ident, $var){
		$result = array();
		foreach ($objList as $obj){
			array_push($result,$obj[$ident][$var]);
		} 

		return $result;
	}

}

?>
