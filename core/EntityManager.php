<?php

namespace Core;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class EntityManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private static $em;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function get()
    {
        if (null == self::$em) {
            try {
                self::$em = self::create();
            } catch (ORMException $exception) {
                // todo handle exception
                var_dump($exception);
            }
        }

        return self::$em;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    private static function create()
    {
        $config = Setup::createAnnotationMetadataConfiguration(
            array(__DIR__ . env('EM_MODELS_DIR')),
            env('EM_IS_DEV_MODE'),
            env('EM_PROXY_DIR'),
            env('EM_CACHE'),
            env('EM_USE_SIMPLE_ANNOTATION_READER')
        );

        $conn = array(
            'driver'   => env('DB_DRIVER'),
            'user'     => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'dbname'   => env('DB_DATABASE'),
        );

        return \Doctrine\ORM\EntityManager::create($conn, $config);
    }
}
