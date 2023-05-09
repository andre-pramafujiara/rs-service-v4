<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Asuransi;
use App\Models\Poliklinik;
use App\Models\RawatJalan;
use App\Services\Auth;
use App\Services\Temp;

class RawatJalanController extends Controller
{
    use Helper;

    public $temp;

    public function __construct(Temp $temp)
    {
    	$this->temp = $temp;
    }

    public function index(Request $request)
    {
        if($request->filter == 'poli') {
            $poli = Poliklinik::where('id', $request->filter_value)->first();
            $request->merge(['filter_value' => $poli->poli_id_old]);
        }
        $data = $this->temp->rawatJalanIndex($request->bearerToken(), $request->all());

        return $this->responseFormatterWithMetaTemp($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data'], $data['meta']);
    }

    public function list(Request $request)
    {
        if($request->filter == 'poli') {
            $poli = Poliklinik::where('id', $request->filter_value)->first();
            $request->merge(['filter_value' => $poli->poli_id_old]);
        }
        $data = $this->temp->rawatJalanList($request->bearerToken(), $request->all());

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data']);
    }

    public function store(Request $request)
    {
        // TODO :: Validation

        // Update data pasien telepon,nowa,alamat

        $poli = Poliklinik::where('id', $request->poli)->first();
        $asuransi = Asuransi::where('id', $request->asuransi)->first();

        $dataSend = [
            "no_rm" => $request->no_rm,
            "telepon" => $request->telepon,
            "no_wa" => $request->no_wa,
            "alamat" => $request->alamat,
            "poli_id" => $poli->poli_id_old,
            "dr_id" => $request->dr_id,
            "datetime_medis" => $request->datetime_medis,
            "asuransi_id" => $asuransi->kode_rs
        ];

        $data = $this->temp->rawatJalanStore($request->bearerToken(), $dataSend);

        // $rawat_jalan = new RawatJalan;
        // $rawat_jalan->medis_id = $data['data']->MEDIS_ID;
        // $rawat_jalan->pasien_id = $data['data']->PASIEN_ID;
        // $rawat_jalan->poli_id = $data['data']->POLI_ID;
        // $rawat_jalan->radio_id = $data['data']->RADIO_ID;
        // $rawat_jalan->lab_id = $data['data']->LAB_ID;
        // $rawat_jalan->diagnosa = $data['data']->DIAGNOSA;
        // $rawat_jalan->status_bayar = $data['data']->STATUS_BAYAR;
        // $rawat_jalan->note = $data['data']->RADIO_ID;
        // $rawat_jalan->datetime_medis = $data['data']->DATETIME_MEDIS;
        // $rawat_jalan->medis_type = $data['data']->MEDIS_TYPE;
        // $rawat_jalan->medis_trx_type = $data['data']->MEDIS_TRX_TYPE;
        // $rawat_jalan->paket_id = $data['data']->PAKET_ID;
        // $rawat_jalan->storage_id = $data['data']->STORAGE_ID;
        // $rawat_jalan->rujukan_id = $data['data']->RUJUKAN_ID;
        // $rawat_jalan->nama_rujukan = $data['data']->NAMA_RUJUKAN;
        // $rawat_jalan->rujukan_data_id = $data['data']->RUJUKAN_DATA_ID;
        // $rawat_jalan->antrian = $data['data']->ANTRIAN;
        // $rawat_jalan->trranap = $data['data']->TRRANAP;
        // $rawat_jalan->norujukan = $data['data']->NORUJUKAN;
        // $rawat_jalan->tglrujukan = $data['data']->TGLRUJUKAN;
        // $rawat_jalan->opname_id = $data['data']->OPNAME_ID;
        // $rawat_jalan->tensi = $data['data']->TENSI;
        // $rawat_jalan->nadi = $data['data']->NADI;
        // $rawat_jalan->suhu = $data['data']->SUHU;
        // $rawat_jalan->respirasi = $data['data']->RESPIRASI;
        // $rawat_jalan->bb = $data['data']->BB;
        // $rawat_jalan->tb = $data['data']->TB;
        // $rawat_jalan->ketsep = $data['data']->KETSEP;
        // $rawat_jalan->nyeri = $data['data']->nyeri;
        // $rawat_jalan->subjektif = $data['data']->subjektif;
        // $rawat_jalan->status_antri = $data['data']->STATUS_ANTRI;
        // $rawat_jalan->status_berkas = $data['data']->STATUS_BERKAS;
        // $rawat_jalan->lk = $data['data']->LK;
        // $rawat_jalan->asuransi_id = $data['data']->ASURANSI_ID;
        // $rawat_jalan->prb = $data['data']->PRB;
        // $rawat_jalan->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data']);
    }
}