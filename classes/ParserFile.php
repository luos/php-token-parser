<?php

class ParserFile{
		private $filename;
		private $md5;
		public function __construct($filename){
			$this->filename = $filename;
			$this->calculate_md5();
		}

		public function calculate_md5(){
			$this->md5 = md5(file_get_contents($this->getFullFilePath()));
		}

		public function getFullFilePath(){
			return $this->filename;
		}

	}