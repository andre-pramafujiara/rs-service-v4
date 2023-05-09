<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Helper;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Status;
use App\Enums\Gender;
use App\Models\Agama;
use App\Models\Asuransi;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Triase;
use App\Models\Ugd;
use App\Services\Sdm;
use App\Services\Temp;
use Illuminate\Validation\Rule;


class UgdController extends Controller
{
    use Helper;

    public $sdm;
    public $temp;

    public function __construct(Sdm $sdm, Temp $temp)
    {
    	$this->sdm = $sdm;
        $this->temp = $temp;
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'search' => 'required'
        ]);

        $search = explode(';', $request->search);

        $pasien = Pasien::select('id', 'nama_pasien', 'nik', 'no_passport', 'alamat_domisili','tanggal_lahir', 'no_rm', 'created_at')
                ->WhereIn('nik', $search)
                ->WhereIn('no_rm', $search)
                ->orWhereIn('no_passport', $search);
                foreach ($search as $value) {
                    $pasien->orWhere('nama_pasien', 'ILIKE', '%' . $value . '%');
                    
                }
        $pasien = $pasien->orderBy('created_at', 'desc')
                ->cursorPaginate($request->input('per_page', 15));

        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pasien);
    }

    public function index(Request $request)
    {
        $data = $this->temp->pasienIndex($request->bearerToken(), $request->all());
        $pasien = [];
        foreach ($data['data'] as $v) {
            if ($v->STATUS_KAWIN == "0") $status = "Single";
            if ($v->STATUS_KAWIN == "1") $status = "Menikah";
            if ($v->STATUS_KAWIN == "2") $status = "Janda/Duda";
            else $status = "Single";

            $agama = Agama::where('agama_id_old', $v->AGAMA_ID)->first();
            if (!$agama) {
                $agama = Agama::where('agama_id_old', "AG01")->first();
            }
            $pend = Pendidikan::where('pendidikan_id_old', $v->PEND_ID)->first();
            if (!$pend) {
                $pend = Pendidikan::where('pendidikan_id_old', "PD01")->first();
            }
            $pek = Pekerjaan::where('pekerjaan_id_old', $v->PEK_ID)->first();
            if (!$pek) {
                $pek = Pekerjaan::where('pekerjaan_id_old', "PK00")->first();
            }
            $asr = Asuransi::where('kode_rs', $v->ASURANSI_ID)->first();
            if (!$asr) {
                $asr = Asuransi::where('kode_rs', "BPJS")->first();
            }

            if ($v->KEL_ID == NULL || $v->KEL_ID == "") {
                $v->KEL_ID = "PV13100904";
            }

            if ($v->KEC_ID == NULL || $v->KEC_ID == "") {
                $v->KEC_ID = "PV131009";
            }

            if ($v->KAB_ID == NULL || $v->KAB_ID == "") {
                $v->KAB_ID = "PV1310";
            }

            if ($v->PROP_ID == NULL || $v->PROP_ID == "") {
                $v->PROP_ID = "PV13";
            }

            if ($v->WARGA_NEGARA == NULL || $v->WARGA_NEGARA == "") {
                $v->WARGA_NEGARA = "Indonesia";
            }

            if ($v->EMAIL == NULL || $v->EMAIL == "") {
                $v->EMAIL = '1111111111111111';
            }

            $p = Pasien::firstOrCreate(
                ['no_rm' => $v->NO_RM],
                [
                    'nama_pasien' => $v->NAME,
                    'kewarganegaraan' => $v->WARGA_NEGARA,
                    'nik' => $v->EMAIL,
                    'jenis_kelamin' => ($v->GENDER) == 1 ? true : false,
                    'tempat_lahir' => ($v->TEMPAT_LAHIR == NULL || $v->TEMPAT_LAHIR == "") ? "Indonesia" : $v->TEMPAT_LAHIR,
                    'tanggal_lahir' => ($v->TGL_LAHIR == NULL || $v->TGL_LAHIR == "") ? "2022-12-12" : $v->TGL_LAHIR,
                    'umur' => ($v->UMUR == NULL || $v->UMUR == "" ) ? "1" : $v->UMUR,
                    'telepon' => ($v->TELEPHONE == NULL || $v->TELEPHONE == "") ? "08111111111" : $v->TELEPHONE,
                    'nowa' => ($v->MOBILE == NULL || $v->MOBILE == "") ? "08111111111" : $v->MOBILE,
                    'status' => $status,
                    'agama' => $agama->id,
                    'pendidikan' => $pend->id,
                    'pekerjaan' => $pek->id,
                    'alamat_ktp' => $v->ADDRESS,
                    'kelurahan_ktp' => $v->KEL_ID,
                    'kecamatan_ktp' => $v->KEC_ID,
                    'kabupaten_ktp' => $v->KAB_ID,
                    'provinsi_ktp' => $v->PROP_ID,
                    'alamat_domisili' => $v->ADDRESS,
                    'kelurahan_domisili' => $v->KEL_ID,
                    'kecamatan_domisili' => $v->KEC_ID,
                    'kabupaten_domisili' => $v->KAB_ID,
                    'provinsi_domisili' => $v->PROP_ID,
                    'nama_ibu' => " ",
                    'suami_istri' => " ",
                    'asuransi' => $asr->id,
                    'no_asuransi' => "0",
                    'user_id' => 1,
                    'pasien_id_old' => $v->PASIEN_ID
                ]
            );

            if ($v->TELEPHONE != NULL && $v->TELEPHONE != "") {
                $p->telepon = $v->TELEPHONE;
            }

            if ($v->MOBILE != NULL && $v->MOBILE != "") {
                $p->nowa = $v->MOBILE;
            }

            $p->save();

            array_push($pasien, [
                "id" => $p->id,
                "nama_pasien" => $p->nama_pasien,
                'nik' => $p->nik, 
                'no_passport' => $p->no_passport, 
                'alamat_domisili' => $p->alamat_domisili, 
                'tanggal_lahir' => $p->tanggal_lahir, 
                'no_rm' => $p->no_rm, 
                'created_at' => $p->created_at
            ]);
        }

       
        return $this->responseFormatterWithMetaTemp($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pasien, $data['meta']);
    }

    public function store(Request $request)
    {
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

        

        // $oldData = $this->temp->pasienStore($request->bearerToken(), [
        //     "name" => $request->nama_pasien,
        //     "address" => $request->alamat_ktp,
        //     "prop" => $request->provinsi_ktp,
        //     "kab" => $request->kabupaten_ktp,
        //     "kec" => $request->kecamatan_ktp,
        //     "kel" => $request->kelurahan_ktp,
        //     "tempat_lahir" => $request->tempat_lahir,
        //     "tgl_lahir" => $lahir->isoFormat('YYYY-MM-DD'),
        //     "gender" => $request->jenis_kelamin,
        //     "marital" => $request->status,
        //     "no_hp" => $request->telepon,
        //     "no_wa" => $request->nowa,
        //     "email" => $request->nik,
        //     "umur" => $umur,
        //     "agama" => $agama->agama_id_old,
        //     "pend" => $pend->pendidikan_id_old,
        //     "pek" => $pek->pekerjaan_id_old,
        //     "kewarganegaraan" => $request->kewarganegaraan,
        //     "nama_ayah" => $request->nama_ayah,
        //     "nama_ibu" => $request->nama_ibu,
        //     "nama_pasangan" => $request->input('suami_istri', null)
        // ]);

        // $pasien->no_rm = $oldData['data']->no_rm;
        // $pasien->pasien_id_old = $oldData['data']->pasien_id;
        // $pasien->save();

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $ugd);
    }

    public function destroy(Request $request)
    {
        $pasien = $this->getData($request);

        if ($pasien == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $oldData = $this->temp->pasienDestroy($request->bearerToken(), [
            'pasien_id' => $pasien->pasien_id_old,
        ]);

        $pasien->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $pasien->deleted_at]);
    }

    public function show(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $pasien = Pasien::with(['agama' => function($query){
            $query->select('id', 'name');
        }, 'pendidikan' => function($query){
            $query->select('id', 'name');
        }, 'pekerjaan' => function($query){
            $query->select('id', 'name');
        }, 'asuransi' => function($query){
            $query->select('id', 'name');
        }, 'suku' => function($query){
            $query->select('id', 'name');
        }, 'bahasa' => function($query){
            $query->select('id', 'name');
        }])->find($request->id);

        if ($pasien == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        
        $provinsi = $this->sdm->showWilayah($pasien->provinsi_ktp, 'Provinsi');
        if ($pasien->provinsi_ktp != NULL) $pasien->provinsi_ktp = $provinsi['data'];

        $kabkot = $this->sdm->showWilayah($pasien->kabupaten_ktp, 'Kabkot');
        if ($pasien->kabupaten_ktp != NULL) $pasien->kabupaten_ktp = $kabkot['data'];

        $kecamatan = $this->sdm->showWilayah($pasien->kecamatan_ktp, 'Kecamatan');
        if ($pasien->kecamatan_ktp != NULL) $pasien->kecamatan_ktp = $kecamatan['data'];

        $keldes = $this->sdm->showWilayah($pasien->kelurahan_ktp, 'Keldes');
        if ($pasien->kelurahan_ktp != NULL) $pasien->kelurahan_ktp = $keldes['data'];

        $provinsi = $this->sdm->showWilayah($pasien->provinsi_domisili, 'Provinsi');
        if ($pasien->provinsi_domisili != NULL) $pasien->provinsi_domisili = $provinsi['data'];

        $kabkot = $this->sdm->showWilayah($pasien->kabupaten_domisili, 'Kabkot');
        if ($pasien->kabupaten_domisili != NULL) $pasien->kabupaten_domisili = $kabkot['data'];

        $kecamatan = $this->sdm->showWilayah($pasien->kecamatan_domisili, 'Kecamatan');
        if ($pasien->kecamatan_domisili != NULL) $pasien->kecamatan_domisili = $kecamatan['data'];

        $keldes = $this->sdm->showWilayah($pasien->kelurahan_domisili, 'Keldes');
        if ($pasien->kelurahan_domisili != NULL) $pasien->kelurahan_domisili = $keldes['data'];

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pasien);
    }

    public function update(Request $request)
    {
        $pasien = $this->getData($request);
        $this->validate($request, [
            'nama_pasien' => 'required|max:255|string',
            'kewarganegaraan' => 'required|max:255|string',
            'nik' => ['max:16', 'string', Rule::unique('pasien')->ignore($pasien->id)],
            'no_passport' => ['max:36', 'string', Rule::unique('pasien')->ignore($pasien->id)],
            'jenis_kelamin' => ['required', new Enum(Gender::class)],
            'tempat_lahir' => 'required|max:255|string', // string
            'tanggal_lahir' => 'required|max:255|date', // format: Y-m-d
            // 'umur' => 'required|max:3|integer', // integer dihitung tgl sekarang - tgl lahir
            'telepon' => 'required|string|regex:/^[0-9]{6,15}$/', // string, regex: /^[0-9]{6,15}$/
            'nowa'=> 'required|string|regex:/^[0-9]{6,15}$/', // string, regex: /^[0-9]{6,15}$/
            'status' => ['required',new Enum(Status::class)], // new Enum(Status::class)
            'agama' => 'required|exists:agamas,id', // in: agama
            'pendidikan' => 'required|exists:pendidikan,id', // in: pendidikan
            'pekerjaan' => 'required|exists:pekerjaans,id', // in: pekerjaan
            'suku' => 'nullable|exists:suku,id', //in :  suku
            'bahasa' => 'nullable|exists:bahasa,id', // in: bahasa
            'alamat_ktp' => 'required|max:255|string', // string
            'rt_ktp' => 'nullable|max:10|string', // string
            'rw_ktp' => 'nullable|max:10|string', // string
            'kelurahan_ktp' => 'required|max:255|string', // string
            'kecamatan_ktp' => 'required|max:255|string', // string
            'kabupaten_ktp' => 'required|max:255|string', // string
            'provinsi_ktp' => 'required|max:255|string', // string
            'kode_pos_ktp' => 'nullable|integer', // integer
            'alamat_domisili' => 'nullable|max:255|string',
            'rt_domisili' => 'nullable|max:10|string',
            'rw_domisili' => 'nullable|max:10|string',
            'kelurahan_domisili' => 'nullable|max:255|string',
            'kecamatan_domisili' => 'nullable|max:255|string',
            'kabupaten_domisili' => 'nullable|max:255|string',
            'provinsi_domisili' => 'nullable|max:255|string',
            'kode_pos_domisili' => 'nullable|integer',
            'negara_domisili' => 'nullable|max:255|string',
            'nama_ibu' => 'nullable|string', // string
            'suami_istri' => 'nullable|string', // string
            'asuransi' => 'nullable|exists:asuransis,id', // in: asuransi
            'no_asuransi' => 'nullable|string', // string
            'user_id' => 'required|integer',
        ]);

        if ($pasien == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $lahir = Carbon::parse($request->tanggal_lahir);
        $umur = Carbon::now()->diffInYears($lahir);

        $pasien->nama_pasien = $request->nama_pasien;
        $pasien->kewarganegaraan = $request->kewarganegaraan;
        $pasien->nik = $request->nik;
        $pasien->no_passport = $request->no_passport;
        $pasien->jenis_kelamin = $request->jenis_kelamin;
        $pasien->tempat_lahir = $request->tempat_lahir;
        $pasien->tanggal_lahir = $lahir;
        $pasien->umur = $umur;
        $pasien->telepon = $request->telepon;
        $pasien->suku = $request->suku;
        $pasien->bahasa = $request->bahasa;
        $pasien->nowa = $request->nowa;
        $pasien->status = $request->status;
        $pasien->agama = $request->agama;
        $pasien->pendidikan = $request->pendidikan;
        $pasien->pekerjaan = $request->pekerjaan;
        $pasien->alamat_ktp = $request->alamat_ktp;
        $pasien->rt_ktp = $request->rt_ktp;
        $pasien->rw_ktp = $request->rw_ktp;
        $pasien->kelurahan_ktp = $request->kelurahan_ktp;
        $pasien->kecamatan_ktp = $request->kecamatan_ktp;
        $pasien->kabupaten_ktp = $request->kabupaten_ktp;
        $pasien->kode_pos_ktp = $request->kode_pos_ktp;
        $pasien->provinsi_ktp = $request->provinsi_ktp;
        $pasien->alamat_domisili = $request->alamat_domisili;
        $pasien->rt_domisili = $request->rt_domisili;
        $pasien->rw_domisili = $request->rw_domisili;
        $pasien->kelurahan_domisili = $request->kelurahan_domisili;
        $pasien->kecamatan_domisili = $request->kecamatan_domisili;
        $pasien->kabupaten_domisili = $request->kabupaten_domisili;
        $pasien->kode_pos_domisili = $request->kode_pos_domisili;
        $pasien->provinsi_domisili = $request->provinsi_domisili;
        $pasien->negara_domisili = $request->negara_domisili;
        $pasien->nama_ibu = $request->input('nama_ibu', " ");
        $pasien->suami_istri = $request->input('suami_istri', null);
        $pasien->asuransi = $request->asuransi;
        $pasien->no_asuransi = $request->input('no_asuransi', null);
        $pasien->user_id = $request->user_id;

        $pasien->save();

        if ($request->jenis_kelamin == false) $request->jenis_kelamin = "2";
        if ($request->status == "Single") $request->status = "0";
        if ($request->status == "Menikah") $request->status = "1";
        if ($request->status == "Janda/Duda") $request->status = "2";

        $agama = Agama::where('id', $request->agama)->first();
        $pend = Pendidikan::where('id', $request->pendidikan)->first();
        $pek = Pekerjaan::where('id', $request->pekerjaan)->first();

        $oldData = $this->temp->pasienUpdate($request->bearerToken(), [
            "pasien_id" => $pasien->pasien_id_old,
            "name" => $request->nama_pasien,
            "address" => $request->alamat_ktp,
            "prop" => $request->provinsi_ktp,
            "kab" => $request->kabupaten_ktp,
            "kec" => $request->kecamatan_ktp,
            "kel" => $request->kelurahan_ktp,
            "kode_pos" => $request->kode_pos_ktp,
            "tempat_lahir" => $request->tempat_lahir,
            "tgl_lahir" => $lahir->isoFormat('YYYY-MM-DD'),
            "gender" => $request->jenis_kelamin,
            "marital" => $request->status,
            "no_hp" => $request->telepon,
            "no_wa" => $request->nowa,
            "email" => $request->nik,
            "umur" => $umur,
            "agama" => $agama->agama_id_old,
            "pend" => $pend->pendidikan_id_old,
            "pek" => $pek->pekerjaan_id_old,
            "kewarganegaraan" => $request->kewarganegaraan,
            "nama_ayah" => $request->nama_ayah,
            "nama_ibu" => $request->input('nama_ibu', " "),
            "nama_pasangan" => $request->input('suami_istri', null)
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pasien);
    }

    public function tempSearchByNoRM(Request $request)
    {
        $data = $this->temp->searchByNoRM($request->bearerToken(), $request->no_rm);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $data['data']);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $pasien = Pasien::find($request->id);

        if ($pasien == null) return null;

        return $pasien;
    }
}
