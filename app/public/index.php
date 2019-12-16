<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/lists',
    function () {
        // Create a response
        $response = new Phalcon\Http\Response();
        $response->setJsonContent([
            'results' => [
                ['number' => 0]
            ]
        ]);

        return $response;
    }
);

$app->options(
    '/lists',
    function () {
        // Create a response
        $response = new Phalcon\Http\Response();
        $response->setJsonContent([
            'results' => [
                ['number' => 0]
            ]
        ]);
    }
);

$app->notFound(function () {
    echo json_encode([
        'error' => 404
    ]);
});

$app->handle();