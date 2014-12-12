<?php namespace MaimaiSwap\LaravelQueueS3Event\Queue\Connectors;

use Aws\Sqs\SqsClient;
use Illuminate\Queue\Connectors\SqsConnector;
use MaimaiSwap\LaravelQueueS3Event\Queue\S3SqsQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;

class S3SqsConnector extends SqsConnector implements ConnectorInterface
{

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Queue\QueueInterface
     */
    public function connect(array $config)
    {
        $sqs = SqsClient::factory($config);

        return new S3SqsQueue($sqs, $config['queue']);
    }

}