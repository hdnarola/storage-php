<?php

include __DIR__.'/../../vendor/autoload.php';

use Dotenv\Dotenv;
use Supabase\Storage\StorageClient;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$client = new  StorageClient($api_key, $reference_id);
$result = $client->createBucket('test-bucket-new');
print_r($result);
