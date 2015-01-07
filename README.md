Laravel Queue S3 Event Serivice Provider
======

## Installation

Edit your composer.json

Add Repositories

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/maimai-swap/laravel-queue-s3event.git"
        }
    ],
    
Add Require
    
	"require": {
		"maimai-swap/laravel-queue-s3event": "dev-master"
	}


Next, update Composer from the Terminal:

    composer update


1. Configuration
-------------------

add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'MaimaiSwap\LaravelQueueS3Event\LaravelQueueS3EventServiceProvider'

2. Usage
-------------------

Open `app/config/queue.php`, and set a configuration.
`'class' => 'MyJob'` is your queue job class name

```php
<?php

return array(

	'default' => 's3sqs-con',

	'connections' => array(

        's3sqs-con' => array(
            'driver' => 's3sqs',
            'key'    => '<your key>',
            'secret' => '<your secret>',
            'queue'  => '<queue url>',
            'region' => '<queue region>',
			'class' => 'MyJob'
        ),

	),

);

```

Create php class like this in `app/models/MyJob.php`

```php
<?php
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Log;

class MyJob {

    function __construct()
    {

    }

    /**
     * @param Job $job
     * @param array $data SQS Payload
     */
    public function fire(Job $job, array $data)
    {

        // Data Array
        if (@$data["Records"]) {

            Log::info("S3 Event.");

            $region = $data["Records"][0]["awsRegion"];
            $bucket = $data["Records"][0]["s3"]["bucket"]["name"];
            $key = $data["Records"][0]["s3"]["object"]["key"];

            // Logic
            Log::info(get_class($this)." Region $region Bucket $bucket Key $key File Uploaded.");

        }

        // Delete Job
        $job->delete();

    }

}

```

