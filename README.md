A simple PHP framework
======================

version 0.0.1 as of 2013 May 2

This is a simple PHP framework we started to make for our project in which we want to archive the following goals;
* A framework that is good for small to medium size projects
* MVC architecture (not MOVE)
* A framework that is easy to get started for any PHP coders
* Code/File structure that is organized and scalable
* Easy to use third party libraries (We use a few Zend classes by default)

### Core Classes
Some of the core classes are as follows;
* A simple dispatcher class which enables MVC architecture
* Class AutoLoader that enables easy instantiation without having to include/require class files
* A database abstruct class that uses PDO to access database
* Centralised error handling methods which take care of PHP errors and exceptions
* A session-based Flash Message class that handles messages

We are making the public methods similar to those you find on popular frameworks such as Zend and Yii. So hopefully it will be easy for a lot of people to understand/get started to use those Core Classes.

### Coding Standard
In this framework, we follow PSR-2 coding style whenever possible.
For more details about PSR-2, please see the link below.
https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md

### Directory Structure
Directories are structured in MVC way and each module will have its own directory  

config/  
    config.php ------------- Config file used by whole system  
library/  
    Core/ ------------------ This is where all the Core Classes are stored  
    Zend/ ------------------ You can have library here, for instance Zend  
    global_functions.php --- functions that are included in bootstrap  
module/  
    ModuleName/ ------------ Module directory  
            Controller/ ---- Controller classes for the module  
            Model/ --------- Model classes for the module  
            View/ ---------- View files for the module  
public/ -------------------- Document root  
    css/  
    img/  
    js/  
    index.php -------------- The bootstrap. Every requests hit this PHP file  

    