<?php

include '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Supabase\Storage\StorageFile;

$dotenv = Dotenv::createUnsafeImmutable('../../', '.env.test');
$dotenv->load();
$api_key = getenv('API_KEY');
$reference_id = getenv('REFERENCE_ID');

$bucket_id = 'test-bucket';
$client = new StorageFile($api_key, $reference_id, $bucket_id);
$result = $client->remove('path/to/file.png');
print_r($result);
