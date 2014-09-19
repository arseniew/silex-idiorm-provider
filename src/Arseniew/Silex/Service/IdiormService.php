<?php

namespace Arseniew\Silex\Service;

class IdiormService
{

    protected $connectionName;

    public function __construct($connectionName)
    {
        $this->connectionName = $connectionName;
    }

    public function for_table($tableName)
    {
        return \ORM::for_table($tableName, $this->connectionName);
    }

    public static function get_db($connectionName)
    {
        return \ORM::get_db($connectionName);
    }

    public function raw_execute($query, $parameters = array())
    {
        return \ORM::raw_execute($query, $parameters = array(), $this->connectionName);
    }

    public static function get_last_statement()
    {
        return \ORM::get_last_statement();
    }

    public function get_last_query()
    {
        return \ORM::get_last_query($this->connectionName);
    }

    public function get_query_log()
    {
        return \ORM::get_query_log($this->connectionName);
    }

    public static function clear_cache()
    {
        return \ORM::clear_cache();
    }

}
