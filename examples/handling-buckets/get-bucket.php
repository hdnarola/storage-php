<?php

include dirname(__DIR__, 1).'/header.php';
use Supabase\Storage\StorageClient;

$authHeader = ['Authorization' => "Bearer {$api_key}"];
$client = new  StorageClient(
	"https://{$supabase_id}.supabase.co/storage/v1",
	$authHeader
);
$result = $client->getBucket('test-bucket');
print_r($result);
