<?php
	ini_set('display_errors','1');
	error_reporting(E_ALL);
	

	function parseproject_autoloader($class) {
	    include dirname(__FILE__).'/classes/' . $class . '.php';
	}

	spl_autoload_register('parseproject_autoloader');


 