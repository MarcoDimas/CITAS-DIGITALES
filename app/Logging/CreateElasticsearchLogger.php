<?php

namespace App\Logging;

use Elastic\Elasticsearch\ClientBuilder;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Logger;

class CreateElasticsearchLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('elasticsearch');

        //create the client
        $client = ClientBuilder::create()
                    ->setHosts([env('ELASTICSEARCH_HOST')])
                    ->setBasicAuthentication(env('ELASTICSEARCH_USERNAME'), env('ELASTICSEARCH_PASSWORD'))
                    ->build();

        //create the handler
        $options = [
            'index' => strtolower(env('ELASTICSEARCH_INDEX')),
        ];
        $handler = new ElasticsearchHandler($client, $options);

        $logger->setHandlers(array($handler));
        
        return $logger;
        
    }
}