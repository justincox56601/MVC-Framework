<?php
/**
 * Pages Controller
 * This is the default controller
 */


 class Pages extends Controller{
	private $db;
	private $data = [];

	function __construct(){
		$this->userModel = $this->Model('Page');
		
	}

	//default method
	public function index($params=[]){
		//if no params are passed in, default to SITE_HOME page defined in config
		$page = $params? $params : SITE_HOME;
		$this->data = $this->userModel->getPage($page);
		$this->view('pages/index', $this->data);
	}
 }