<?php

namespace App\Services;

use App\Traits\ConsumeExternalServices;

class Vclaim
{
	use ConsumeExternalServices;

    public function obtainPesertaByNIK($nik)
	{
		return $this->performRequestVclaim('GET', "Peserta/nik/$nik/tglSEP/2022-02-02");
	}
}