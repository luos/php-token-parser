php-token-parser
================

php-token-parser

A few months ago I decided to try for code editing vim. I was excited because it was very powerful but I had a little problem with it: lack of good code completion.

A few weeks ago I decided to try Sublime Text 2. It was much better experience than vim, but it has the same problem. I tried SublimeCodeIntel but it is not working for me. It sais "do not despair" and then does nothing. 

So i did not despair, decided to make a better code completion, but first I need to parse the php code. I want to make it open source, so here are my first tries. Its a good occasion to try and practice git too. 

First I wanted to make it in C++ to practice, but it was just too time consuming. (I wrote the first commit in cc 3 hours, the C++ version had the classes in this time, but i'm a php developer so its understandable :)

See this as a first commit, not as a ready-to-production project. I'm just getting familiar whit this token_get_all thingie.  

I want to make this to work with source code, and parse the php docs too for magic model classes like Yii uses. 

Btw it surprises me, that code completion in the "guess from what you have written before" way is working at a good rate, the problems are that it does not show the docs, function parameters and other useful things.


*** How it works?

It parses a php file, get the tokens, and then consumes the array. :)


For this code:

    	class Simple{

    		function hello(){
    			
    		}
    	}


The output is:


       array(1) {
          ["Simple"]=>
          object(PHPClass)#5 (8) {
            ["parentName":protected]=>
            NULL
            ["isAbstract":protected]=>
            bool(false)
            ["methods":protected]=>
            array(1) {
              ["hello"]=>
              object(PHPClassMethod)#7 (7) {
                ["visibility":"PHPClassMethod":private]=>
                bool(false)
                ["isStatic":"PHPClassMethod":private]=>
                bool(false)
                ["name":protected]=>
                string(5) "hello"
                ["line":protected]=>
                NULL
                ["file":protected]=>
                NULL
                ["position":protected]=>
                NULL
                ["source":protected]=>
                NULL
              }
            }
            ["name":protected]=>
            string(6) "Simple"
            ["line":protected]=>
            NULL
            ["file":protected]=>
            NULL
            ["position":protected]=>
            object(LanguageElementPosition)#6 (2) {
              ["file":"LanguageElementPosition":private]=>
              string(55) "/media/jozsefvaros/www/yee/parseproject/simpleclass.php"
              ["line":"LanguageElementPosition":private]=>
              int(0)
            }
            ["source":protected]=>
            NULL
          }



