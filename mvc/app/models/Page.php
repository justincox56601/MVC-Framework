<?php
/**
 * Main page view
 */

 class Page{
	private $db;

	public function __construct(){
		$this->db = Database::getInstance();
	}

	public function getPage($params){
		//returns an array with a specific page object
		$this->db->query('SELECT * FROM pages WHERE slug=?');
		$this->db->bind($params, 's');
		return $this->db->getResults();
	}

	public function getAllPages(){
		//returns an array with all the pages as objects from the database
		$this->db->query('SELECT * FROM pages');
		
		return $this->db->getResults();
	}
 }