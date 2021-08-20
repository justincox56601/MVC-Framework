<?php
/**
 * Core App Class
 */

 Class Core{
	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params = [];

	function __construct(){
		$url = $this->getUrl();
		
		//set the current controller
		if(file_exists('../app/controllers/' . ucwords($url[0] . '.php'))){
			$this->currentController = ucwords($url[0]);
			unset($url[0]);
		}
		
		//require the controller
		require_once '../app/controllers/' . $this->currentController . '.php';
		$this->currentController = new $this->currentController;

		//set the current method
		if(isset($url[1]) && method_exists($this->currentController, $url[1])){
			$this->currentMethod = $url[1];
			unset($url[1]);
		}

		//set the params
		$this->params = $url ? array_values($url) : [];

		//callback with the array of params
		call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		
	}


	private function getUrl(){
		if(isset($_GET['url'])){
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url;
		}
	}
 }