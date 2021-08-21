<?php

namespace Core\Controller;

use Core\View\View;

class Controller {

    public View $view;
    
	protected $pageData = array();

	public function __construct() {
		$this->view = new View();
	}	
}