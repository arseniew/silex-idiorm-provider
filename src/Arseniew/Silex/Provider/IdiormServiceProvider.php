<?php

/**
 * Silex service provider for Idiorm
 *
 * @author Marcin Batkowski <arseniew@gmail.com>
 */

namespace Arseniew\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class IdiormServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['idiorm.dbs.options.initializer'] = $app->protect(function () use ($app) {
            static $initialized = false;

            if ($initialized) {
                return;
            }

            $initialized = true;

            if (!isset($app['idiorm.dbs.options'])) {
                $app['idiorm.dbs.options'] = array('default' => isset($app['idiorm.db.options']) ? $app['idiorm.db.options'] : array());
            }

            // If default configuration was not found, setting first one from idiorm.dbs as such
            if (!isset($app['idiorm.dbs.default'])) {
                $tmp = $app['idiorm.dbs.options'];
                $app['idiorm.dbs.default'] = key($tmp);
            }

            // Creating connection for each configuration
            $tmp = $app['idiorm.dbs.options'];
            foreach ($tmp as $name => $options) {
                if ($app['idiorm.dbs.default'] === $name) {
                    \ORM::configure($options);
                }
                \ORM::configure($options, null, $name);

            }

        });

        $app['idiorm.dbs'] = $app->share(function ($app) {
            $app['idiorm.dbs.options.initializer']();
            $dbs = new \Pimple();

            // Configuration is already set, so we just need keys to return connection
            foreach (array_keys($app['idiorm.dbs.options']) as $connectionName) {
                $dbs[$connectionName] = $dbs->share(function () use ($connectionName) {
                    return new \Arseniew\Silex\Service\IdiormService($connectionName);
                });
            }

            return $dbs;
        });

        $app['idiorm.db'] = $app->share(function ($app) {
            $dbs = $app['idiorm.dbs'];

            return $dbs[$app['idiorm.dbs.default']];
        });

    }

    public function boot(Application $app)
    {
    }
}
