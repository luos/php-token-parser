<?php
abstract class PHPLanguageElement{
		protected $name;
		protected $line;
		protected $file;
		protected $position;
		/**
		 * Can be like 'doc' or 'code' if the source is documentation like magic fields or php file source code
		 * 
		 * */
		protected $source; 
		protected $comment;

		protected function getOutputFields(){
			return array('name','line','file');
		}

		public function setPosition($file,$line = 0){
			$this->position = new LanguageElementPosition($file,$line);
		}

		public function getName(){
			return $this->name;
		}
	}