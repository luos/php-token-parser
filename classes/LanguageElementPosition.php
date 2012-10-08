<?php
class LanguageElementPosition{
		private $file;
		private $line;
		public function __construct($file, $line = 0){
			$this->file = $file;
			$this->line = $line;
		}
	}