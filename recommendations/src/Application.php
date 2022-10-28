<?php

namespace Tbd\Recommendations;

use FrameworkX\App;
use FrameworkX\Container;
use React\Http\Message\Response;
use Tbd\Recommendations\Recommendations\ImpressionsRepository;

class Application
{
    protected App $app;

    public function __construct()
    {
        $container = new Container([
            Recommendations\ProductImpressionCreateController::class => function (ImpressionsRepository $repository) {
                return new Recommendations\ProductImpressionCreateController($repository);
            },
            Recommendations\RecommendationsLookupController::class => function (ImpressionsRepository $repository) {
                return new Recommendations\RecommendationsLookupController($repository);
            }
        ]);

        $this->app = new App($container);
        $this->app->post('/impression/{id}',  Recommendations\ProductImpressionCreateController::class);
        $this->app->get('/recommendations/{id}', Recommendations\RecommendationsLookupController::class);

        $this->app->get('/', function () {
            return Response::plaintext(
                "Hello recommendations!\n"
            );
        });
    }

    public function run(){
        $this->app->run();
    }

}