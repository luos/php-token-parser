<?php

	class ClassStackElement{
		public $className = null;
		public $in = 0; 

		public function __construct($name){
			$this->className = $name;
		}

	}
