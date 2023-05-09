<?php

namespace App\Services;

use App\Traits\ConsumeExternalServices;

class Temp
{
	use ConsumeExternalServices;

	public $baseUri;

	public $secret;

    public function __construct()
	{
		$this->baseUri = config('services.temp.base_uri');
		$this->secret = config('services.temp.secret');
	}

	protected function bearerFormatter($token)
	{
		$headers['Authorization'] = 'Bearer ' . $token;
		return $headers;
	}

    public function rawatJalanStore($token, $data)
	{
		return $this->performRequest('POST', '/rawat/jalan', $data, $this->bearerFormatter($token));
	}

	public function rawatJalanIndex($token, $data)
	{
		return $this->performRequest('GET', '/rawat/jalan/index', $data, $this->bearerFormatter($token));
	}

	public function rawatJalanList($token, $data)
	{
		return $this->performRequest('GET', '/rawat/jalan/list', $data, $this->bearerFormatter($token));
	}

	public function rawatInapStore($token, $data)
	{
		return $this->performRequest('POST', '/rawat/inap', $data, $this->bearerFormatter($token));
	}

	public function rawatInapIndex($token, $data)
	{
		return $this->performRequest('GET', '/rawat/inap/index', $data, $this->bearerFormatter($token));
	}

	public function kamarList($token, $data)
	{
		return $this->performRequest('GET', '/kelas/kamar/list', $data, $this->bearerFormatter($token));
	}

	public function kelasList($token)
	{
		return $this->performRequest('GET', '/kelas/list', [], $this->bearerFormatter($token));
	}

	public function pasienStore($token, $data)
	{
		return $this->performRequest('POST', '/pasien', $data, $this->bearerFormatter($token));
	}

	public function pasienUpdate($token, $data)
	{
		return $this->performRequest('PUT', '/pasien', $data, $this->bearerFormatter($token));
	}

	public function pasienDestroy($token, $data)
	{
		return $this->performRequest('DELETE', '/pasien', $data, $this->bearerFormatter($token));
	}

	public function searchByNoRM($token, $norm)
	{
		return $this->performRequest('POST', '/pasien/search/no-rm', ["no_rm" => $norm], $this->bearerFormatter($token));
	}

	public function pasienIndex($token, $data)
	{
		return $this->performRequest('GET', '/pasien', $data, $this->bearerFormatter($token));
	}

	public function tempDokterList($token, $data)
	{
		return $this->performRequest('GET', '/dokter/list', $data, $this->bearerFormatter($token));
	}

	public function UgdStore($token, $data)
	{
		return $this->performRequest('POST', '/ugd', $data, $this->bearerFormatter($token));
	}
}