<?php
require __DIR__.'/vendor/autoload.php';

use Spiral\RoadRunner\Worker;
use Nyholm\Psr7\Factory\Psr17Factory;
use Spiral\RoadRunner\Http\PSR7Worker;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$psr17Factory = new Psr17Factory();
$worker = new Worker();
$psr7 = new PSR7Worker($worker, $psr17Factory, $psr17Factory, $psr17Factory);

$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);

while ($req = $psr7->waitRequest()) {
    try {
        // Convert PSR7 request to Illuminate Request
        $symfonyRequest = (new \Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory())->createRequest($req);
        $laravelRequest = Request::createFromBase($symfonyRequest);

        // Handle request via Laravel kernel
        $response = $kernel->handle($laravelRequest);

        // Convert Laravel response to PSR7 response
        $psr7Response = (new \Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory(
            $psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory
        ))->createResponse($response);

        $psr7->respond($psr7Response);

        $kernel->terminate($laravelRequest, $response);
    } catch (\Throwable $e) {
        $psr7->getWorker()->error((string)$e);
    }
}
