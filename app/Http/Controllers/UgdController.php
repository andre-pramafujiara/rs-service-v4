<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Helper;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Status;
use App\Enums\Gender;
use App\Models\AntrianUgd;
use App\Models\Asuransi;
use App\Models\Bbl;
use App\Models\Pasienb;
use App\Models\Pekerjaan;
use App\Models\Penanggungjawab;
use App\Models\Pendidikan;
use App\Models\Pengantar;
use App\Models\Triase;
use App\Models\Ugd;
use App\Services\Sdm;
use App\Services\Temp;
use Illuminate\Validation\Rule;


class UgdController extends Controller
{
    use Helper;

    public $temp;

    public function __construct(Temp $temp)
    {
    	$this->temp = $temp;
    }

    public function index(Request $request)
    {
        $data = $this->temp->ugdIndex($request->bearerToken(), $request->all());
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Ugd::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));

        $ugd = [];
        
        return $this->responseFormatterWithMetaTemp($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $ugd, $data['meta']);
    }

    // public function getAntrian(){
	// 	$antrian = '';
		
	// 	if($data = $this->m->countAntrian(true)){

	// 		$no_urut = (int) substr($data[0]['antrian'],1,3);
			
	// 		if(strlen($no_urut) == 1){
	// 			$antrian = "A00".((int) $no_urut + 1);
	// 		}else if(strlen($no_urut) == 2){
	// 			$antrian = "A0".((int) $no_urut + 1);
	// 		}else{
	// 			$antrian = "A".((int) $no_urut + 1);
	// 		}

	// 		$tanggal = date('Y-m-d');

	// 		$data = array(
	// 			'tanggal' => $tanggal,
	// 			'antrian' => $antrian
	// 		);

	// 		// echo "<pre>";
	// 		// print_r($data);
	// 		// exit();
	// 		$antrian = $this->M_mainmenu->insertAntrian($data);

			
	// 	}else{
	// 		$antrian = 'A001';
	// 		$tanggal = date('Y-m-d');

	// 		$data = array(
	// 			'tanggal' => $tanggal,
	// 			'antrian' => $antrian
	// 		);

	// 	}
	// 	return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $antrian);;
	// }

    public function store(Request $request)
    {
        $this->validate($request, [
            'pas_umum_id' => 'required|max:255|string',
            'pas_td_id' => 'required|max:255|string',
            'pen_jaw_id' => 'required|max:255|string',
            'peng_id' => 'required|max:255|string',
            'bayi_id' => 'required|max:255|string',
            'cara_bayar' => 'required|max:255|string', 
            'asuransi_id' => 'required|max:255|string',
            'persetujuan_umum' => 'required|max:255|string',
            'persetujuan_pasien' => 'required|max:255|string',
            'membuat_pernyataan' => 'required|max:255|string',
            'triase' => 'required|max:255|string',
            'anamnesis' => 'required|max:255|string',
            'asesmen_awal' => 'required|max:255|string',
            'screnning' => 'required|max:255|string',
            'psikologis' => 'required|max:255|string',
            'riwayat_obat' => 'required|max:255|string',
            'pemulangan_pasien' => 'required|max:255|string',
            'rencana_rawat' => 'required|max:255|string',
            'persetujuan_pasien' => 'required|max:255|string',
            'instruksi_medis' => 'required|max:255|string',
            'pemeriksaan_penunjang' => 'required|max:255|string',
            'persetujuan_tindakan' => 'required|max:255|string',
            'terapi' => 'required|max:255|string',
            'user_id' => 'required|integer',
        ]);
        $asuransi = Asuransi::where('id', $request->asuransi)->first();
        $pasien = Pasien::where('id', $request->pasien)->first();
        $pasienb =Pasienb::where('id', $request->pasienb)->first();
        $pen_jaw = Penanggungjawab::where('id', $request->penanggungjawab)->first();
        $pengantar = Pengantar::where('id', $request->pengantar)->first();
        $bbl = Bbl::where('id', $request->bbl)->first;
        $triase = Triase::where('id', $request->triase)->first();

        // $dataSend = [
        //     'pasien_id' => $pasien->id,
        //     'medis_id' => $request->medis_id,
        //     'kamar_id' => $request->kamar_id,
        //     'datetime_in' => $request->datetime_in,
        //     'DPJP' => $request->DPJP,
        //     'dr_in' => $request->dr_in,
        //     'diagnosa' => $request->diagnosa,
        //     'alasan_dirawat' => $request->alasan_dirawat,
        //     'asuransi_id' => $asuransi->kode_rs,
        //     'no_rm' => $request->no_rm
        // ];

        $ugd = Ugd::create([
            'pas_umum_id' => $request->pas_umum_id,
            'pas_td_id' => $request->pas_td_id,
            'pen_jaw_id' => $request->pen_jaw_id,
            'peng_id' => $request->peng_id,
            'bayi_id' => $request->bayi_id,
            'cara_bayar' => $request->cara_bayar,
            'asuransi_id' => $request->asuransi_id,
            'persetujuan_umum' => $request->persetujuan_umum,
            'persetujuan_pasien' => $request->persetujuan_pasien,
            'membuat_pernyataan' => $request->membuat_pernyataan,
            'triase' => $request->triase,
            'anamnesis' => $request->anamnesia,
            'asesmen_awal' => $request->asesmen_awal,
            'screnning' => $request->screnning,
            'psikologis' => $request->psikologis,
            'riwayat_obat' => $request->riwayat_obat,
            'pemulangan_pasien' => $request->pemulangan_pasien,
            'rencana_rawat' => $request->rencana_rawat,
            'persetujuan_pasien' => $request->persetujuan_pasien,
            'instruksi_medis' => $request->instruksi_medis,
            'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
            'persetujuan_tindakan' => $request->persetujuan_tindakan,
            'terapi' => $request->terapi,
            'user_id' => $request->user_id,
        ]);

        $oldData = $this->temp->ugdStore($request->bearerToken(), [
            'pas_umum_id' => $pasien->id,
            'pas_td_id' => $pasienb->id,
            'pen_jaw_id' => $pen_jaw->id,
            'peng_id' => $pengantar->id,
            'bayi_id' => $bbl->id,
            'cara_bayar' => $request->cara_bayar,
            'asuransi_id' => $asuransi->id,
            'persetujuan_umum' => $request->persetujuan_umum,
            'persetujuan_pasien' => $request->persetujuan_pasien,
            'membuat_pernyataan' => $request->membuat_pernyataan,
            'triase' => $triase->id,
            'anamnesis' => $request->anamnesia,
            'asesmen_awal' => $request->asesmen_awal,
            'screnning' => $request->screnning,
            'psikologis' => $request->psikologis,
            'riwayat_obat' => $request->riwayat_obat,
            'pemulangan_pasien' => $request->pemulangan_pasien,
            'rencana_rawat' => $request->rencana_rawat,
            'persetujuan_pasien' => $request->persetujuan_pasien,
            'instruksi_medis' => $request->instruksi_medis,
            'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
            'persetujuan_tindakan' => $request->persetujuan_tindakan,
            'terapi' => $request->terapi,
            'user_id' => $request->user_id,
        ]);

        $ugd->no_rm = $oldData['data']->no_rm;
        // $ugd->pasien_id_old = $oldData['data']->pasien_id;
        $ugd->save();

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $ugd);
    }

    public function destroy(Request $request)
    {
        $ugd = $this->getData($request);

        if ($ugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        // $oldData  = $this->temp->ugdDestroy($request->bearerToken(), [
        //     'pas_umum_id' => $ugd->pas_umum_id,
        // ]);

        $ugd->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $ugd->deleted_at]);

    }

    public function show(Request $request)
    {
        $ugd = $this->getData($request);

        if ($ugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $ugd);
    }

    public function update(Request $request)
    {
        $ugd = $this->getData($request);
        $this->validate($request, [
            'pas_umum_id' => 'required|max:255|string',
            'pas_td_id' => 'required|max:255|string',
            'pen_jaw_id' => 'required|max:255|string',
            'peng_id' => 'required|max:255|string',
            'bayi_id' => 'required|max:255|string',
            'cara_bayar' => 'required|max:255|string', // string
            'asuransi_id' => 'required|max:255|string',
            'persetujuan_umum' => 'required|max:255|string',
            'persetujuan_pasien' => 'required|max:255|string',
            'persetujuan_pasien' => 'required|max:255|string',
            'membuat_pernyataan' => 'required|max:255|string',
            'triase' => 'required|max:255|string',
            'anamnesis' => 'required|max:255|string',
            'asesmen_awal' => 'required|max:255|string',
            'screnning' => 'required|max:255|string',
            'psikologis' => 'required|max:255|string',
            'riwayat_obat' => 'required|max:255|string',
            'pemulangan_pasien' => 'required|max:255|string',
            'rencana_rawat' => 'required|max:255|string',
            'persetujuan_pasien' => 'required|max:255|string',
            'instruksi_medis' => 'required|max:255|string',
            'pemeriksaan_penunjang' => 'required|max:255|string',
            'persetujuan_tindakan' => 'required|max:255|string',
            'terapi' => 'required|max:255|string',
            'user_id' => 'required|integer',
        ]);

        if ($ugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $lahir = Carbon::parse($request->tanggal_lahir);
        $umur = Carbon::now()->diffInYears($lahir);

        $ugd->pas_umum_id = $request->pas_umum_id;
        $ugd->pas_td_id = $request->pas_td_id;
        $ugd->pen_jaw_id = $request->pen_jaw_id;
        $ugd->peng_id = $request->peng_id;
        $ugd->bayi_id = $request->bayi_id;
        $ugd->cara_bayar = $request->cara_bayar;
        $ugd->asuransi_id = $request->asuransi_id;
        $ugd->persetujuan_umum = $request->persetujuan_umum;
        $ugd->persetujuan_pasien = $request->persetujuan_pasien;
        $ugd->membuat_pernyataan = $request->membuat_pernyataan;
        $ugd->triase = $request->triase;
        $ugd->anamnesis = $request->anamnesis;
        $ugd->asesmen_awal = $request->asesmen_awal;
        $ugd->screnning = $request->screnning;
        $ugd->psikologis = $request->psikologis;
        $ugd->riwayat_obat = $request->riwayat_obat;
        $ugd->pemulangan_pasien = $request->pemulangan_pasien;
        $ugd->rencana_rawat = $request->rencana_rawat;
        $ugd->persetujuan_pasien = $request->persetujuan_pasien;
        $ugd->instruksi_medis = $request->instruksi_medis;
        $ugd->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;
        $ugd->persetujuan_tindakan = $request->persetujuan_tindakan;
        $ugd->terapi = $request->terapi;
        $ugd->user_id = $request->user_id;

        $ugd->save();

        // $asuransi = Asuransi::where('id', $request->asuransi)->first();
        // $pasien = Pasien::where('id', $request->pasien)->first();
        // $pasienb =Pasienb::where('id', $request->pasienb)->first();
        // $pen_jaw = Penanggungjawab::where('id', $request->penanggungjawab)->first();
        // $pengantar = Pengantar::where('id', $request->pengantar)->first();
        // $bbl = Bbl::where('id', $request->bbl)->first;
        // $triase = Triase::where('id', $request->triase)->first();

        // $oldData = $this->temp->ugdUpdate($request->bearerToken(), [
        //     'pas_umum_id' => $pasien->id,
        //     'pas_td_id' => $pasienb->id,
        //     'pen_jaw_id' => $pen_jaw->id,
        //     'peng_id' => $pengantar->id,
        //     'bayi_id' => $bbl->id,
        //     'cara_bayar' => $request->cara_bayar,
        //     'asuransi_id' => $asuransi->id,
        //     'persetujuan_umum' => $request->persetujuan_umum,
        //     'persetujuan_pasien' => $request->persetujuan_pasien,
        //     'membuat_pernyataan' => $request->membuat_pernyataan,
        //     'triase' => $triase->id,
        //     'anamnesis' => $request->anamnesia,
        //     'asesmen_awal' => $request->asesmen_awal,
        //     'screnning' => $request->screnning,
        //     'psikologis' => $request->psikologis,
        //     'riwayat_obat' => $request->riwayat_obat,
        //     'pemulangan_pasien' => $request->pemulangan_pasien,
        //     'rencana_rawat' => $request->rencana_rawat,
        //     'persetujuan_pasien' => $request->persetujuan_pasien,
        //     'instruksi_medis' => $request->instruksi_medis,
        //     'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
        //     'persetujuan_tindakan' => $request->persetujuan_tindakan,
        //     'terapi' => $request->terapi,
        //     'user_id' => $request->user_id,
       // ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $ugd);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $ugd = Ugd::find($request->id);

        if ($ugd == null) return null;

        return $ugd;
    }
}
