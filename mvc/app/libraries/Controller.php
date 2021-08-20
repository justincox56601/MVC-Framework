<?php
/**
 * This is the primary controller class.  all other controller classes will inherit from this
 * loads the model and the view
 */

 class Controller{
	 public function model($model){
		//require the model file
		require_once '../app/models/' . $model . '.php';

		//instantiate the model object
		return new $model();	
	}

	public function view($view, $data=[]){
		if(file_exists('../app/views/' . $view .'.php')){
			require_once '../app/views/' . $view .'.php';
		}else{
			die('View does not exist');
		}
	}
 }