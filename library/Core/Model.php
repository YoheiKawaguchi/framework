<?php
/**
 * Core_Model
 * 
 * This is an Abstract database class using PDO.
 * Includes CRUD methods such as 'insert', 'update', 'find', 'delete'
 * 
 * Core_Model must always be extended when creating a db class
 */
class Core_Model
{
    /** @var $db PDO */
    public $db;

    // Properties below must be set in child class
    protected $schema   =  DB_DATABASE;   // db name
    protected $name     = '';             // table name
    protected $primary  = '';             // primary key
    protected $sequence =  true;          // is the primary key auto increment?
    
    final function __construct()
    {
        if (method_exists($this, '__beforeParentConstruct')) {
            $this->__beforeParentConstruct();
        }

        // make it static to prevent it from db being connected again and again
        static $db;

        if (! isset($db) || empty($db)) {
            $dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_SERVER;
            
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            
            $db = new PDO($dsn, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, $options);
        }

        $this->db = $db;

        if (method_exists($this, '__afterParentConstruct')) {
            $this->__afterParentConstruct();
        }
        
        return $this->db;
    }
    
    /*
     * Insert a new record into a table
     * 
     * @param  array $data associative array with column name and value
     * @return int         last inserted ID
     */
    public function insert($data)
    {
        $bind = ':' . implode(',:', array_keys($data));
        $sql  = 'INSERT INTO ' . $this->schema . '.' . $this->name
              . '(' . implode(',', array_keys($data)) . ') ' . 'VALUES ('.$bind.')';
        $sth = $this->db->prepare($sql);
        
        foreach($data as $key => $value) {
            $sth->bindParam(":$key", $data[$key]);
        }
        $sth->execute();
        
        return $this->db->lastInsertId();
    }
    
    /*
     * Update a record by primary key
    *
    * @param  array $data associative array with column name and value
    * @param  int   $id
    * @return int         affected number of rows (0 or 1)
    */
    public function update($data, $id)
    {
        $sql  = "UPDATE $this->schema.$this->name SET ";
        
        // bind values
        foreach($data as $key => $value) {
            $sql .= "`$key` = ?,";
        }
        $sql  = rtrim($sql, ",");
        $sql .= " WHERE $this->primary = ?";
        $sth = $this->db->prepare($sql);
        
        $count = 1;
        foreach($data as $key => $value) {
            $sth->bindParam($count, $data[$key]);
            $count++;
        }
        $sth->bindParam($count, $id);
        $sth->execute();
        
        return $sth->rowCount();
    }
    
    /*
     * Find row(s) by primary key(s)
     * 
     * @param   int|array   $id  id or array of ids
     * @return  array       row(s)
     */
    public function find($id)
    {
        if(false === is_array($id)) {
            $id = array($id);
        }
        
        $place_holders = implode(',', array_fill(0, count($id), '?'));
        $sql = "SELECT * FROM $this->schema.$this->name "
             . "WHERE $this->primary IN ($place_holders)";
        $sth = $this->db->prepare($sql);
        $sth->execute($id);
        
        return $sth->fetchAll();
    }
    
    /*
     * Delete row(s) by primary key(s)
     *
     * @param   int|array   $id  id or an array of ids
     * @return  int         number of rows deleted
     */
    public function delete($id)
    {
        if(false === is_array($id)) {
            $id = array($id);
        }
        
        $place_holders = implode(',', array_fill(0, count($id), '?'));
        $sql = "DELETE FROM $this->schema.$this->name "
             . "WHERE $this->primary IN ($place_holders)";
        $sth = $this->db->prepare($sql);
        $sth->execute($id);
        
        return $sth->rowCount();
    }
}
