<?php

namespace App\Services;

use App\Traits\ConsumeExternalServices;

class Auth
{
    use ConsumeExternalServices;

	public $baseUri;

	public $secret;

	public function __construct()
	{
		$this->baseUri = config('services.auth.base_uri');
		$this->secret = config('services.auth.secret');
	}

	public function userCan($token, $usercan)
	{
        $headers['Authorization'] = $token;
		return $this->performRequest('POST', '/api/usercan', ["user_can" => $usercan], $headers);
	}
}