<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Helper;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Status;
use App\Enums\Gender;
use App\Models\Anamnesis;
use App\Models\AntrianUgd;
use App\Models\AssesmenAwal;
use App\Models\Asuransi;
use App\Models\Bbl;
use App\Models\Diagnosis;
use App\Models\FormUgd;
use App\Models\Pasienb;
use App\Models\Pekerjaan;
use App\Models\PemeriksaanPenunjang;
use App\Models\Pemulangan;
use App\Models\Penanggungjawab;
use App\Models\Pendidikan;
use App\Models\Pengantar;
use App\Models\PeriksaFisik;
use App\Models\PersetujuanTindakan;
use App\Models\Pses;
use App\Models\RiwayatObat;
use App\Models\Screening;
use App\Models\Terapi;
use App\Models\Triase;
use App\Models\Ugd;
use App\Models\VitalSign;
use App\Services\Sdm;
use App\Services\Temp;
use Illuminate\Validation\Rule;


class FormugdController extends Controller
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
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], FormUgd::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));

        $formugd = [];
        
        return $this->responseFormatterWithMetaTemp($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $formugd, $data['meta']);
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
            'pasien' => 'required|exists:pasien,id',
            'triase' => 'required|exists:triase,id',
            'peng_id' => 'required|exists:pengantar,id',
            'anamnesis' => 'required|exists:anamneisis,id',
            'asesmen_awal' => 'required|exists:assesmenawal,id',
            'screening' => 'required|exists:sreenning,id',
            'pses' => 'required|exists:pses,id',
            'riwayat_obat' => 'required|exists:riwayatobat,id', 
            'rencana_pemulangan' => 'required|exists:pemulangan,id',
            'rencana_rawat' => 'required|max:255|string',
            'instruksi_medis' => 'required|max:255|string',
            'pemeriksaan_penunjang' => 'required|exists:pemeriksaaanpenunjang,id',
            'diangnosis' => 'required|exists:diagnosis,id',
            'persetujuan_tindakan' => 'required|exists:persetujuantindakan,id',
            'terapi' => 'required|exists:terapi,id',
            'user_id' => 'required|integer',
        ]);

        $pasien = Pasien::where('id', $request->pasien)->first();
        $triase = Triase::where('id', $request->triase)->first();
        $anamneis = Anamnesis::where('id', $request->anamnesis)->first();
        $periksafisik = PeriksaFisik::where('id', $request->periksafisik)->first();
        $riwayatobat =RiwayatObat::where('id', $request->riwayatobat)->first();
        $pemulangan = Pemulangan::where('id', $request->pemulangan)->first();
        $pemeriksaanpenunjang = PemeriksaanPenunjang::where('id', $request->pemeriksaanpenunjang)->first();
        $diagnosis = Diagnosis::where('id', $request->diagnosis)->first();
        $persetujuantindakan = PersetujuanTindakan::where('id', $request->persetujuantindakan)->first;
        $terapi = Terapi::where('id', $request->terapi)->first();
        $assesmenawal = AssesmenAwal::where('id', $request->assesmenawal)->first();
        $vitalsign =VitalSign::where('id', $request->vitalsign)->first();
        $screening = Screening::where('id', $request->screening)->first();
        $pses = Pses::where('id', $request->pses)->first();

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

        $formugd = FormUgd::create([
            'pasien' => $request->pasien,
            'triase' => $request->triase,
            'peng_id' => $request->peng_id,
            'anamnesis' => $request->anamnesis,
            'asesmen_awal' => $request->asesmen_awal,
            'screening' => $request->screening,
            'pses' => $request->pses,
            'riwayat_obat' => $request->riwayat_obat,
            'rencana_pemulangan' => $request->rencana_pemulangan,
            'rencana_rawat' => $request->rencana_rawat,
            'instruksi_medis' => $request->instruksi_medis,
            'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
            'diangnosis' => $request->diangnosis,
            'persetujuan_tindakan' => $request->persetujuan_tindakan,
            'terapi' => $request->terapi,
            'user_id' => $request->user_id,
        ]);

        // $oldData = $this->temp->ugdStore($request->bearerToken(), [
        //     'pas_id' => $pasien->id,
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

        // $ugd->no_rm = $oldData['data']->no_rm;
        // $ugd->pasien_id_old = $oldData['data']->pasien_id;
        $formugd->save();

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $formugd);
    }

    public function destroy(Request $request)
    {
        $formugd = $this->getData($request);

        if ($formugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        // $oldData  = $this->temp->formugdDestroy($request->bearerToken(), [
        //     'pas_umum_id' => $formugd->pas_umum_id,
        // ]);

        $formugd->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $formugd->deleted_at]);

    }

    public function show(Request $request)
    {
        $formugd = $this->getData($request);

        if ($formugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $formugd);
    }

    public function update(Request $request)
    {
        $formugd = $this->getData($request);
        $this->validate($request, [
            'pasien' => 'required|exists:pasien,id',
            'triase' => 'required|exists:triase,id',
            'peng_id' => 'required|exists:pengantar,id',
            'anamnesis' => 'required|exists:anamneisis,id',
            'asesmen_awal' => 'required|exists:assesmenawal,id',
            'screening' => 'required|exists:sreenning,id',
            'pses' => 'required|exists:pses,id',
            'riwayat_obat' => 'required|exists:riwayatobat,id', 
            'rencana_pemulangan' => 'required|exists:pemulangan,id',
            'rencana_rawat' => 'required|max:255|string',
            'instruksi_medis' => 'required|max:255|string',
            'pemeriksaan_penunjang' => 'required|exists:pemeriksaaanpenunjang,id',
            'diangnosis' => 'required|exists:diagnosis,id',
            'persetujuan_tindakan' => 'required|exists:persetujuantindakan,id',
            'terapi' => 'required|exists:terapi,id',
            'user_id' => 'required|integer',
        ]);

        if ($formugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");
        $formugd->pasien = $request->pasien;
        $formugd->triase = $request->triase;
        $formugd->peng_id = $request->peng_id;
        $formugd->anamnesis = $request->anamnesis;
        $formugd->asesmen_awal = $request->asesmen_awal;
        $formugd->screening = $request->screening;
        $formugd->pses = $request->pses;
        $formugd->riwayat_obat = $request->riwayat_obat;
        $formugd->rencana_pemulangan = $request->rencana_pemulangan;
        $formugd->rencana_rawat = $request->rencana_rawat;
        $formugd->instruksi_medis = $request->instruksi_medis;
        $formugd->rencana_rawat = $request->rencana_rawat;
        $formugd->persetujuan_pasien = $request->persetujuan_pasien;
        $formugd->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;
        $formugd->diangnosis = $request->diangnosis;
        $formugd->persetujuan_tindakan = $request->persetujuan_tindakan;
        $formugd->terapi = $request->terapi;
        $formugd->user_id = $request->user_id;

        $formugd->save();

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

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $formugd);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $formugd = FormUgd::find($request->id);

        if ($formugd == null) return null;

        return $formugd;
    }
}
