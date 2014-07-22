<?php

return array(

    'connections' => array(
        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'strivetest',
            'username'  => 'codecept',
            'password'  => 'codecept12345',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'options'   => array(
                // Here is the time zone setting
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET time_zone = \'+00:00\''
            )
        ),
    ),
);
