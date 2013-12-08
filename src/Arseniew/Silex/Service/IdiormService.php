<?php

namespace Arseniew\Silex\Service;

class IdiormService
{

    protected $connectionName;
    protected $tables = array();

    public function __construct($connectionName)
    {
        $this->connectionName = $connectionName;
    }

    public function for_table($tableName)
    {
        if (!isset($this->tables[$tableName])) {
            $this->tables[$tableName] = \ORM::for_table($tableName, $this->connectionName);
        }
        return $this->tables[$tableName];
    }

    public static function get_db($connectionName)
    {
        return \ORM::get_db($connectionName);
    }

    public static function raw_execute($query, $parameters = array())
    {
        return \ORM::raw_execute($query, $parameters = array(), $this->connectionName);
    }

    public static function get_last_statement()
    {
        return \ORM::get_last_statement();
    }

    public static function get_last_query()
    {
        return \ORM::get_last_query($this->connectionName);
    }

    public static function get_query_log()
    {
        return \ORM::get_query_log($this->connectionName);
    }
        
    public static function clear_cache()
    {
        return \ORM::clear_cache();
    }

}

