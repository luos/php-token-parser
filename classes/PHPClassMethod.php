<?php
class PHPClassMethod extends PHPLanguageElement{
		private $visibility;
		private $isStatic;
		public function __construct($name,$visibility = 'public', $isStatic = false){
			$this->name = $name;
			$this->visibility = $visibility;
			$this->isStatic = $isStatic;
		}

	}