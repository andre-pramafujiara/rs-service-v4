<?php

namespace App\Services;

use App\Traits\ConsumeExternalServices;

class Sdm
{
	use ConsumeExternalServices;

	public $baseUri;

	public $secret;

	public function __construct()
	{
		$this->baseUri = config('services.sdm.base_uri');
		$this->secret = config('services.sdm.secret');
	}

	public function obtainEmployees()
	{
		return $this->performRequest('GET', '/employees');
	}

    public function obtainEmployee($id)
    {
        return $this->performRequest('GET', "/employee/" . $id);
    }

    public function createEmployee($data)
    {
        return $this->performRequest('POST', '/employee', $data);
    }

    public function updateEmployee($id, $data)
    {
        return $this->performRequest('PUT', "/employee/" . $id, $data);
    }

    public function createEmployment($data)
    {
        return $this->performRequest('POST', '/employment', $data);
    }

    public function createFamily($data)
    {
        return $this->performRequest('POST', '/family', $data);
    }

    public function obtainFamilyByEmployee($id)
    {
        return $this->performRequest('GET', "/employee/$id/family");
    }

    public function deleteFamily($id)
    {
        return $this->performRequest('DELETE', "/family/$id");
    }

    public function createEducation($data)
    {
        return $this->performRequest('POST', '/education', $data);
    }

    public function createExperience($data)
    {
        return $this->performRequest('POST', '/experience', $data);
    }

    public function createPosition($data)
    {
        return $this->performRequest('POST', '/position', $data);
    }

    public function showWilayah($kode, $wilayah)
    {
        return $this->performRequest('GET', '/wilayah/show', ['kode' => $kode, 'wilayah' => $wilayah]);
    }
}