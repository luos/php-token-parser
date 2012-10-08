<?php
	require_once('../../parseproject.php');
	class SimpleClassTest extends PHPUnit_Framework_TestCase{

		protected $parser;

		protected function setUp(){
			$this->parser = new ProjectParser(dirname(__FILE__));
		}

		public function testFileRead(){

			$this->parser->parseFile(dirname(__FILE__).'/simpleclass.php');
			$this->assertNotEmpty($this->parser->getFiles());
			return $this->parser;
		}

		/**
		 *  @depends testFileRead
		 * */

		public function testHasClass($parser){
			$classes = $parser->getClasses();
			$this->assertTrue(isset($classes['Simple']));
			return $parser;
		}

		/**
		 * 	@depends testHasClass
		 * 
		 * */
		public function testClassHasMethod($parser){
			$classes = $parser->getClasses();
			$simple = $classes['Simple'];
			$methods = $simple->getMethods();
			$this->assertTrue(isset($methods['hello']));
		}




	}