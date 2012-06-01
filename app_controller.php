<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
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
					$label[$modelName]['id'] = $model->id;
				}

				if ($label){
					$labelId = $label[$modelName]['id'];
					$this->data[$modelName][$modelName][$labelId] = $labelId;
				} else {
					$this->Session->setFlash("Could not save ' . $modelName . ' with name " . $label);
				}
			}
		}
	}
}
