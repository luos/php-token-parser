<?php
	ini_set('display_errors','1');
	error_reporting(E_ALL);
	 

	class ProjectParser{
		private $initDir; 
		const T_WHITESPACE = 371;
		private $classes = array();
		private $files = array();

		public function __construct($dir){
			$this->initDir = $dir;

		}

		public function parse(){

			$this->parseDir($this->initDir);
		}

		private $dirs = array();
		private $currentlyParsing = null;
		private function parseDir($dir){
			$phps = glob('simpleclass.php');
			foreach($phps as $php){
				$this->parseFile($dir.'/'.$php); 
				}

				var_dump($this);
		}


		private function parseFile($file){
			$this->currentlyParsing = $file;
			$this->files[$file]  = new ParserFile($file);
			$this->parseString(file_get_contents($file));
		}

		private function parseString($string){
			$this->parseTokens(token_get_all($string));
		}

		private function parseTokens($tokens){
				$len = count($tokens);
			 	var_dump($tokens);
			 	$classStack = new SplStack();
			 	$nextModifier = false;
			 	$nextScope = false;
				for ($i = 0 ;$i < $len ; $i++){
					$token = $tokens[$i];
					$token_val = is_array($token)?$token[0]:$token;
					 $currentClass = null;
					 $inAClass = !!$classStack->count();
					 // unnecessary to use a stack but im lazy to rewrite :)
					if ( $inAClass ){
						var_dump($token);
						$currentClass = $classStack->top();
				 
						if ( $token != T_WHITESPACE )
							{ 
					        switch ($token_val)
					            {
					            case T_CURLY_OPEN:
					            case '{':
					            case T_DOLLAR_OPEN_CURLY_BRACES: $currentClass->in++; break;  
					            }

					            if ($token == '}'){
					            	$currentClass->in--;
					            
						            if (!$currentClass->in){
						            	echo $currentClass->className . ' ended '.$token."\n";
						            	$classStack->pop();
						            }
								}
					            echo $currentClass->in."\n";
					        }
				    	}

					if ( is_array($token) && $token[1] == 'class' ){
						$classNamePos = $this->nextNotWhitespace($tokens,$i+1,$len); 
						$className = $tokens[$classNamePos][1];
						$classStack->push(new ClassStackElement($className));
						$parent = null;
						$isAbstract = false;
					 	if (isset($tokens[$i -2]) && is_array($tokens[$i-2]) && $tokens[$i-2][1] == 'abstract'){
					 		$isAbstract = true;
					 	}
						if ($tokens[$i+4][1] == 'extends' ){
							$p = $tokens[$i+6]; 
							$parent = $tokens[$i+6][1]; 
						} 
					 
						$class = new PHPClass($className,$parent,$isAbstract);
						$this->addClass($class);
						$class->setPosition($this->currentlyParsing); 
					}


					if ( $inAClass && $currentClass->in == 1){

						if ($token[0] ==  T_PRIVATE || $token[0] == T_PUBLIC || $token[0] == T_PROTECTED ){
							$nextModifier = token_name($token[0]);
							continue;
						}
						if ($token[0] == T_STATIC){
							$nextScope = 'static';
							continue;
						}
						if ($token[0] == T_FUNCTION){

							$method = new PHPClassMethod($tokens[$i+2][1],$nextModifier,$nextScope == 'static');
							$this->addClassMethod($currentClass->className,$method);
							$nextScope = $nextModifier = false;
						}




					}

				 }


		}

		private function addClass(PHPClass $class){

			if (!isset($this->classes[$class->getName()])){
				$this->classes[$class->getName()] = $class;
			}
		}

		private function addClassMethod($className,$method){
			if (isset($this->classes[$className])){
				$this->classes[$className]->addMethod($method);
			}else throw new Exception('No class with this name');
		}


	

	private function nextNotWhitespace($arr, $pos, $len,$step =1 ){
		for($i = $pos ; $i < $len ; $i += $step ){
			if ( token_name($arr[$i][0]) != 'T_WHITESPACE' ){
		 
				return $i;
			}

		}
		throw new Exception("No next not whitespace", 1);
		

	}


}

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


	}

	class PHPClassMethod extends PHPLanguageElement{
		private $visibility;
		private $isStatic;
		public function __construct($name,$visibility = 'public', $isStatic = false){
			$this->name = $name;
			$this->visibility = $visibility;
			$this->isStatic = $isStatic;
		}

	}

	class PHPClassVariable extends PHPLanguageElement{

	}

	class LanguageElementPosition{
		private $file;
		private $line;
		public function __construct($file, $line = 0){
			$this->file = $file;
			$this->line = $line;
		}
	}

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

	class ClassStackElement{
		public $className = null;
		public $in = 0; 

		public function __construct($name){
			$this->className = $name;
		}

	}


	$p = new ProjectParser(dirname(__FILE__));
	$p->parse();