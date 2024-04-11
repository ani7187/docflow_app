<?php

namespace App\Providers;

use App\Documents\DocumentsRepository;
use App\Documents\ElasticsearchRepository;
use App\Documents\EloquentRepository;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DocumentsRepository::class, function () {
            // Это полезно, если мы хотим выключить наш кластер
            // или при развертывании поиска на продакшене
            if (! config('services.search.enabled')) {
                return new EloquentRepository();
            }
            return new ElasticsearchRepository(
                $this->app->make(Client::class)
            );
        });
        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
