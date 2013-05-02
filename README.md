A simple PHP framework
======================

This is a simple PHP framework we have made for our project in which we wanted to archive the following goals;
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

A lot of the public methods are similar to those you find on popular frameworks such as Zend and Yii. So hopefully it is easy for a lot of people to understand/get started to use those Core Classes.

### Coding Standard
In this framework, we follow PSR-2 coding style whenever possible.
For more details about PSR-2, please see the link below.
https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md

