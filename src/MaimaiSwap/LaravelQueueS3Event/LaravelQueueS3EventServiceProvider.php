<?php namespace MaimaiSwap\LaravelQueueS3Event;

use MaimaiSwap\LaravelQueueS3Event\Queue\Connectors\S3SqsConnector;
use Illuminate\Support\ServiceProvider;
use Queue;

class LaravelQueueS3EventServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->booted(function () {

			Queue::extend('s3sqs', function () {
				return new S3SqsConnector;
			});

		});
	}
}