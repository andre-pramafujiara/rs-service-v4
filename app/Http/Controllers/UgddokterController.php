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
use App\Models\AssesmenAwalDokterUgd;
use App\Models\Asuransi;
use App\Models\Bbl;
use App\Models\Diagnosis;
use App\Models\Pasienb;
use App\Models\Pekerjaan;
use App\Models\PemeriksaanPenunjang;
use App\Models\Penanggungjawab;
use App\Models\Pendidikan;
use App\Models\Pengantar;
use App\Models\PeriksaFisik;
use App\Models\PersetujuanTindakan;
use App\Models\RencanaRawat;
use App\Models\RiwayatObat;
use App\Models\Screening;
use App\Models\Terapi;
use App\Models\Triase;
use App\Models\UgdDokter;
use App\Services\Sdm;
use App\Services\Temp;
use Illuminate\Validation\Rule;


class UgddokterController extends Controller
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
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], UgdDokter::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));

        $dokterugd = [];
        
        return $this->responseFormatterWithMetaTemp($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $dokterugd, $data['meta']);
    }

    

    public function store(Request $request)
    {
        $this->validate($request, [
            'triase' => 'required|exists:triase,id',
            'sreening' => 'required|exists:sreening,id',
            'assesmen_awal' => 'required|exists:assesmenawaldokterugd,id',
            'rencana_rawat' => 'required|exists:rencanarawat,id',
            'instruksi_medis' => 'required|max:255|string',
            'user_id' => 'required|integer',
        ]);

        $triase = Triase::where('id', $request->triase)->first();
        $screening = Screening::where('id', $request->screening)->first();
        $assesmenawal = AssesmenAwalDokterUgd::where('id', $request->assesmenawal)->first();
        $rencanarawat =RencanaRawat::where('id', $request->rencanarawat)->first();
        

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
        //     'no_rm' => $request->no_rm,

        //     'triase' => $request->triase,
        //     'anamnesis' => $request->anamnesias,
        //     'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
        //     'riwayat_obat' => $request->riwayat_obat,
        //     'instruksi_medis' => $request->instruksi_medis,
        //     'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
        //     'diagnosis' => $request->diagnosis,
        //     'persetujuan_tindakan' => $request->persetujuan_tindakan,
        //     'terapi' => $request->terapi,
        //     'user_id' => $request->user_id,
        // ];

        $dokterugd = UgdDokter::create([
            
            'triase' => $request->triase,
            'sreening' => $request->sreening,
            'assesmen_awal' => $request->assesmen_awal,
            'rencana_rawat' => $request->rencana_rawat,
            'instruksi_medis' => $request->instruksi_medis,
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
        $dokterugd->save();

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $dokterugd);
    }

    public function destroy(Request $request)
    {
        $dokterugd = $this->getData($request);

        if ($dokterugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $dokterugd->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $dokterugd->deleted_at]);

    }

    public function show(Request $request)
    {
        $dokterugd = $this->getData($request);

        if ($dokterugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $dokterugd);
    }

    public function update(Request $request)
    {
        $dokterugd = $this->getData($request);
        $this->validate($request, [
            'triase' => 'required|exists:triase,id',
            'sreening' => 'required|exists:sreening,id',
            'assesmen_awal' => 'required|exists:assesmenawaldokterugd,id',
            'rencana_rawat' => 'required|exists:rencanarawat,id',
            'instruksi_medis' => 'required|max:255|string',
            'user_id' => 'required|integer',
        ]);

        if ($dokterugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $dokterugd->triase = $request->triase;
        $dokterugd->sreening = $request->sreening;
        $dokterugd->assesmen_awal = $request->assesmen_awal;
        $dokterugd->rencana_rawat = $request->rencana_rawat;
        $dokterugd->instruksi_medis = $request->instruksi_medis;
        $dokterugd->user_id = $request->user_id;

        $dokterugd->save();

        // $asuransi = Asuransi::where('id', $request->asuransi)->first();
        // $pasien = Pasien::where('id', $request->pasien)->first();
        // $pasienb =Pasienb::where('id', $request->pasienb)->first();
        // $pen_jaw = Penanggungjawab::where('id', $request->penanggungjawab)->first();
        // $pengantar = Pengantar::where('id', $request->pengantar)->first();
        // $bbl = Bbl::where('id', $request->bbl)->first;
        // $triase = Triase::where('id', $request->triase)->first();

        // $oldData = $this->temp->dokterugdUpdate($request->bearerToken(), [
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

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $dokterugd);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $dokterugd = UgdDokter::find($request->id);

        if ($dokterugd == null) return null;

        return $dokterugd;
    }
}
