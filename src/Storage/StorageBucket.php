<?php
/**
 * A PHP  class  client library to interact with Supabase Storage.
 *
 * Provides functions for handling storage buckets.
 *
 * @author    Zero Copy Labs
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace Supabase\Storage;

use Supabase\Util\Constants;
use Supabase\Util\Request;

class StorageBucket
{
	/**
	 * A RESTful endpoint for querying and managing your database.
	 *
	 * @var string
	 */
	protected string $url;

	/**
	 * A header Bearer Token generated by the server in response to a login request
	 * [service key, not anon key].
	 *
	 * @var array
	 */
	protected array $headers = [];

	/**
	 * StorageBucket constructor.
	 *
	 * @throws Exception
	 */
	public function __construct($api_key, $reference_id)
	{
		$headers = ['Authorization' => "Bearer {$api_key}"];
		$this->url = "https://{$reference_id}.supabase.co/storage/v1";
		$this->headers = array_merge(Constants::getDefaultHeaders(), $headers);
	}

	/**
	 * Creates a new Storage bucket.
	 *
	 * @param  string  $bucketId  The bucketId to create.
	 * @param  array  $options  The visibility of the bucket. Public buckets don't require an
	 *                          authorization token to download objects, but still require a valid token for all
	 *                          other operations. By default, buckets are private.
	 * @return string Returns stdClass Object from request
	 */
	public function createBucket($bucketId, $options = ['public' => false])
	{
		try {
			$url = $this->url.'/bucket';
			$body = json_encode([
				'id' => $bucketId,
				'name' => $bucketId,
				'public' => $options['public'],
			]);
			$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
			$data = Request::request('POST', $url, $headers, $body);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Retrieves the details of an existing Storage bucket.
	 *
	 * @param  string  $bucketId  The unique identifier of the bucket you
	 *                            would like to retrieve.
	 * @return string Returns stdClass Object from request
	 */
	public function getBucket($bucketId)
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId;
			$data = Request::request('GET', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Retrieves the details of all Storage buckets within an existing project.
	 *
	 * @return string Returns stdClass Object from request
	 */
	public function listBuckets()
	{
		$url = $this->url.'/bucket';

		try {
			$data = Request::request('GET', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Updates a Storage bucket.
	 *
	 * @param  string  $bucketId  A unique identifier for the bucket you are updating.
	 * @param  array  $options  The visibility of the bucket. Public buckets don't
	 *                          require an authorization token to download objects, but still require a valid
	 *                          token for all other operations.
	 * @return string Returns stdClass Object from request
	 */
	public function updateBucket($bucketId, $options)
	{
		try {
			$body = json_encode([
				'id' => $bucketId,
				'name' => $bucketId,
				'public' => $options['public'] ? 'true' : 'false',
			]);
			$url = $this->url.'/bucket/'.$bucketId;
			$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
			$data = Request::request('PUT', $url, $headers, $body);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Deletes an existing bucket. A bucket can't be deleted with existing objects inside it.
	 * You must first `empty()` the bucket.
	 *
	 * @param  string  $bucketId  The unique identifier of the bucket you would like to delete.
	 * @return string Returns stdClass Object from request
	 */
	public function deleteBucket($bucketId)
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId;
			$data = Request::request('DELETE', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Removes all objects inside a single bucket.
	 *
	 * @param  string  $bucketId  The unique identifier of the bucket you would like to empty.
	 * @return string Returns stdClass Object from request
	 */
	public function emptyBucket($bucketId)
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId.'/empty';
			$data = Request::request('POST', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}
}
