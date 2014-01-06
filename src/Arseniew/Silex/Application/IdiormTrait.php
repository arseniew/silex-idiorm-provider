<?php

namespace Arseniew\Silex\Application;

/**
 * Idiorm trait.
 *
 * @author Marcin Batkowski <arseniew@gmail.com>
 */

trait IdiormTrait
{
    /**
     * Returns configured Idiorm instance
     *
     * @param string $table      table Name
     * @param string $connection Connection name
     *
     * @return \ORM Idiorm instance
     */
    public function getModel($table, $connection = null)
    {
        if (!$connection) {
            return $this['idiorm.db']->for_table($table);
        } else {
            return $this['idiorm.dbs'][$connection]->for_table($table);
        }
    }
}
