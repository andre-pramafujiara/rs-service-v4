<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use Illuminate\Http\Request;
use App\Models\Anamnesis;
use App\Models\AssesmenNyeri;
use App\Models\Pemulangan;
use App\Models\Pses;
use App\Models\Screening;
use App\Models\Triase;
use App\Models\UgdPerawat;
use App\Models\VitalSign;
use App\Services\Temp;


class UgdperawatController extends Controller
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
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], UgdPerawat::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));

        $ugd = [];
        
        return $this->responseFormatterWithMetaTemp($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $ugd, $data['meta']);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'pasien' => 'required|exists:pasien,id',
            'triase' => 'required|exists:triase,id',
            'anamnesis' => 'required|exists:anamnesis,id',
            'asesmen_nyeri' => 'required|exists:asesmennyeri,id',
            'tingkat_kesadaran' => 'required|max:255|string',
            'vital_sign' => 'required|exists:vitalsign,id',
            'screnning' => 'required|exists:screnning,id',
            'pses' => 'required|exists:pses,id',
            'rencana_pemulangan' => 'required|pemulangan,id',
            'rencana_rawat' => 'required|max:255|string',
            'instruksi_medis' => 'required|max:255|string',
            'user_id' => 'required|integer',
        ]);
        $triase = Triase::where('id', $request->triase)->first();
        $anamnesis = Anamnesis::where('id', $request->anamnesis)->first();
        $assesmennyeri = AssesmenNyeri::where('id', $request->assesmennyeri)->first();
        $vitalsign =VitalSign::where('id', $request->vitalsign)->first();
        $screening = Screening::where('id', $request->screening)->first();
        $pses = Pses::where('id', $request->pses)->first();
        $pemulangan = Pemulangan::where('id', $request->pemulangan)->first();

        // $dataSend = [
        //     // 'pasien_id' => $pasien->id,
        //     // 'medis_id' => $request->medis_id,
        //     // 'kamar_id' => $request->kamar_id,
        //     // 'datetime_in' => $request->datetime_in,
        //     // 'DPJP' => $request->DPJP,
        //     // 'dr_in' => $request->dr_in,
        //     // 'diagnosa' => $request->diagnosa,
        //     // 'alasan_dirawat' => $request->alasan_dirawat,
        //     // 'asuransi_id' => $asuransi->kode_rs,
        //     // 'no_rm' => $request->no_rm

        //     'triase' => $triase->id,
        //     'anamnesis' => $request->anamnesis,
        //     'asesmen_nyeri' => $request->asesmen_nyeri,
        //     'tingkat_kesadaran' => $request->tingkat_kesadaran,
        //     'vital_sign' => $request->vital_sign,
        //     'screnning' => $request->screnning,
        //     'pses' => $request->pses,
        //     'rencana_pemulangan' => $request->rencana_pemulangan,
        //     'rencana_rawat' => $request->rencana_rawat,
        //     'instruksi_medis' => $request->instruksi_medis,
        // ];

        $ugd = UgdPerawat::create([
            'triase' => $request->triase,
            'anamnesis' => $request->anamnesis,
            'asesmen_nyeri' => $request->asesmen_nyeri,
            'tingkat_kesadaran' => $request->tingkat_kesadaran,
            'vital_sign' => $request->vital_sign,
            'screnning' => $request->screnning,
            'pses' => $request->pses,
            'rencana_pemulangan' => $request->rencana_pemulangan,
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
        $ugd->save();

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $ugd);
    }

    public function destroy(Request $request)
    {
        $ugd = $this->getData($request);

        if ($ugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

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
            'triase' => 'required|exists:triase,id',
            'anamnesis' => 'required|exists:anamnesis,id',
            'asesmen_nyeri' => 'required|exists:asesmennyeri,id',
            'tingkat_kesadaran' => 'required|max:255|string',
            'vital_sign' => 'required|exists:vitalsign,id',
            'screnning' => 'required|exists:screnning,id',
            'pses' => 'required|exists:pses,id',
            'rencana_pemulangan' => 'required|max:255|string',
            'rencana_rawat' => 'required|max:255|string',
            'instruksi_medis' => 'required|max:255|string',
            'user_id' => 'required|integer',
        ]);

        if ($ugd == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $ugd->triase = $request->triase;
        $ugd->anamnesis = $request->anamnesis;
        $ugd->asesmen_nyeri = $request->asesmen_nyeri;
        $ugd->tingkat_kesadaran = $request->tingkat_kesadaran;
        $ugd->vital_sign = $request->vital_sign;
        $ugd->screnning = $request->screnning;
        $ugd->pses = $request->pses;
        $ugd->rencana_pemulangan = $request->rencana_pemulangan;
        $ugd->rencana_rawat = $request->rencana_rawat;
        $ugd->instruksi_medis = $request->instruksi_medis;
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

        $ugd = UgdPerawat::find($request->id);

        if ($ugd == null) return null;

        return $ugd;
    }
}
