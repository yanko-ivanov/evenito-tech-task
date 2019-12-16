<?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;
use Phalcon\Di\FactoryDefault;

$app = new Micro();
$di = new FactoryDefault();

/**
 * Loader
 */
$loader = new \Phalcon\Loader();
$loader
    ->registerDirs(
        [
            '../models/',
        ]
    )
    ->register();

/**
 * Database
 */
// Setup the database service

$di->set('db', function () {
    return new MysqlAdapter(
        [
            'host' => getenv('MYSQL_HOST'),
            'username' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'dbname' => getenv('MYSQL_DATABASE'),
        ]
    );
});

$app = new \Phalcon\Mvc\Micro();
$app->setDI($di);

$app->get(
    '/videos',
    function () use ($app) {

        /**
         * No possibility for an sql injection because of the type of check.
         */
        $direction = $app->request->getQuery('direction', 'string') == 'asc' ? 'ASC' : 'DESC';

        $sql = "SELECT * FROM video ORDER BY name $direction";
        $result = $app['db']->query($sql);

        $result->setFetchMode(Phalcon\Db::FETCH_OBJ);

        // Create a response
        $response = new Phalcon\Http\Response();
        $response->setJsonContent([
            'results' => $result->fetchAll()
        ]);

        return $response;
    }
);

$app->post(
    '/video',
    function () use ($app) {

        $payload = file_get_contents('php://input');
        $data = json_decode($payload);


        $video = new Video;
        $video->setTitle($data->title);
        $video->setUrl($data->url);
        $video->setDescription($data->description);
        $video->setDuration($data->duration);
        $video->setThumbnail($data->thumb);
        try {
            $video->create();
        } catch (\Exception $e) {
            die($e->getMessage());
        }


        $response = new Phalcon\Http\Response();
        $response->setJsonContent([
            'data' => ['success' => true]
        ]);

        return $response;
    }
);

$app->notFound(function () {
    echo json_encode([
        'error' => 404
    ]);
});

$app->handle();