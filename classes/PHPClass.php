<?php
	class PHPClass extends PHPLanguageElement{
		protected $parentName;
		protected $isAbstract = false;
		protected $methods = array();
		public function __construct($name,$parent = null, $isAbstract = false ){
			$this->name = $name;
			$this->parentName = $parent;
			$this->isAbstract = $isAbstract;

		}



		public function addMethod(PHPClassMethod $method){
			$this->methods[$method->getName()] = $method;
		}

		public function getMethods(){
			return $this->methods;
		}


	}