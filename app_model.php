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

		foreach ($labels as $_label){
			$_label = strtolower(trim($_label));

			if ($_label){
				$model->recursive = -1;
				$label = $model->findByName($_label);

				if (!$label){
					$model->create();
					$label = $model->save(array('name' => $_label));
					$label['id'] = $model->id;
				}

				//print_r($label);
				array_push($result, $label[$modelName]["id"]);
			}
		}
//		print_r($result);
		return $result;
	}

}
