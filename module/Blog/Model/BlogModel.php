<?php
class Blog_Model_BlogModel extends Core_Model
{
    /*
     * These properties are mainly for the CRUD methods in the parent class
     */
    protected $schema   =  DB_DATABASE;   // db name
    protected $name     = 'blog';         // table name
    protected $primary  = 'id_blog';      // primary key
    protected $sequence =  true;          // is the primary key auto increment?
}
