<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait ConsumeExternalServices
{
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
	{
		$client = new Client([
			'base_uri' => $this->baseUri,
		]);

        if (!array_key_exists('Authorization', $headers)) {
            $headers['Authorization'] = $this->secret;
        }

        try {
            $response = $client->request($method, $requestUrl, [
                'json' => $formParams,
                'headers' => $headers,
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return (array) json_decode($response->getBody()->getContents());
	}

    public function performRequestVclaim($method, $requestUrl, $formParams = [])
    {
        $client = new Client([
			'base_uri' => config('services.vclaim.base_uri'),
		]);

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $headers = [
            "X-cons-id" => config('services.vclaim.cons_id'),
            "X-timestamp" => $tStamp,
            "X-signature" => $this->signatureVclaim(config('services.vclaim.cons_secret'), config('services.vclaim.cons_id')."&".$tStamp),
            "user_key" => config('services.vclaim.user_key')
        ];

        try {
            $response = $client->request($method, $requestUrl, [
                'json' => $formParams,
                'headers' => $headers,
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $data = (array) json_decode($response->getBody()->getContents());

        return $this->decodeResponseVclaim($tStamp, $data['response']);
    }

    public function signatureVclaim($key, $data)
    {
        $signature = hash_hmac('sha256', $data, $key, true);

        return base64_encode($signature);
    }

    public function decodeResponseVclaim($timestamp, $data)
    {
        $encrypt_method = 'AES-256-CBC';
        
        $key = config('services.vclaim.cons_id') . config('services.vclaim.cons_secret') . $timestamp;

        $key_hash = hex2bin(hash('sha256', $key));
    
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($data), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $result = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
    
        return json_decode($result);
    }
}