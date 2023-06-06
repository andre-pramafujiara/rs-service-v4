<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Http\Helper;
use Carbon\Carbon;

class ObatController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Obat::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'nomor_rekam_medis' => 'required|string|max:255',
            'tanggal_lahir_pasien' => 'required|date',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|string|max:255',
            'luas_permukaan_tubuh' => 'required|string|max:255',
            'ID_resep' => 'required|integer',
            'nama_obat' => 'required|string|max:255',
            'bentuk_sediaan' => 'required|string|max:255',
            'jumlah_obat' => 'required|inetger',
            'aturan_pakai' => 'required|string|max:255',
            'catatan_resep' => 'required|string|max:255',
            'dokter_penulis' => 'required|string|max:255',
            'nomor_telepon_seluler' => 'required|integer',
            'tanggal_penulisan_resep' => 'required|date',
            'jam_penulisan_resep' => 'required|time',
            'tanda_tangan_dokter' => 'required|string|max:255',
            'status_resep' => 'required|string|max:255',
            'pengkajian_resep' => 'required|string|max:255',

        ]);

        //jam otomatis
        $time = Carbon::parse($request->jam_penulisan_resep);
        // tanggal automatis
        $request->merge(['tanggal_penulisan_resep' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $Obat = Obat::create([
            'id' => $request->id,
            'nomor_rekam_medis' => $request->nomor_rekam_medis,
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir_pasien' => $request->tanggal_lahir_pasien,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'luas_permukaan_tubuh' => $request->luas_permukaan_tubuh,
            'ID_resep' => $request->ID_resep,
            'nama_obat' => $request->nama_obat,
            'bentuk_sediaan' => $request->bentuk_sediaan,
            'jumlah_obat' => $request->jumlah_obat,
            'aturan_pakai' => $request->aturan_pakai,
            'catatan_resep' => $request->catatan_resep,
            'dokter_penulis' => $request->dokter_penulis,
            'nomor_telepon_seluler' => $request->nomor_telepon_seluler,
            'tanggal_penulisan_resep' => $request->tanggal_penulisan_resep,
            'jam_pemulisan_resep' => $time->toTimeString(),
            'tanda_tangan_dokter' => $request->tanda_tangan_dokter,
            'status_resep' => $request->status_resep,
            'pengkajian_resep' => $request->pengkajian_resep,

        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $Obat);
    }

    public function destroy(Request $request)
    {
        $Obat = $this->getData($request);

        if ($Obat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $Obat->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $Obat->deleted_at]);
    }

    public function show(Request $request)
    {
        $Obat = $this->getData($request);

        if ($Obat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $Obat);
    }

    public function update(Request $request)
    {
        $Obat = $this->getData($request);
        $this->validate($request, [
            'id' => 'required|integer',
            'nomor_rekam_medis' => 'required|string|max:255',
            'tanggal_lahir_pasien' => 'required|string|max:255',
            'tinggi_badan' => 'required|string|max:255',
            'berat_badan' => 'required|string|max:255',
            'luas_permukaan_tubuh' => 'required|string|max:255',
            'ID_resep' => 'required|integer',
            'nama_obat' => 'required|string|max:255',
            'bentuk_sediaan' => 'required|string|max:255',
            'jumlah_obat' => 'required|string|max:255',
            'aturan_pakai' => 'required|string|max:255',
            'catatan_resep' => 'required|string|max:255',
            'dokter_penulis' => 'required|string|max:255',
            'nomor_telepon_seluler' => 'required|string|max:255',
            'tanggal_penulisan_resep' => 'required|string|max:255',
            'tanda_tangan_dokter' => 'required|string|max:255',
            'status_resep' => 'required|string|max:255',
            'pengkajian_resep' => 'required|string|max:255',
        ]);

        if ($Obat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

         //jam otomatis
         $time = Carbon::parse($request->jam_penulisan_resep);
         // tanggal automatis
         $request->merge(['tanggal_penulisan_resep' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);
 
        $Obat->update([
            'id' => $request->id,
            'nomor_rekam_medis' => $request->nomor_rekam_medis,
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir_pasien' => $request->tanggal_lahir_pasien,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'luas_permukaan_tubuh' => $request->luas_permukaan_tubuh,
            'ID_resep' => $request->ID_resep,
            'nama_obat' => $request->nama_obat,
            'bentuk_sediaan' => $request->bentuk_sediaan,
            'jumlah_obat' => $request->jumlah_obat,
            'aturan_pakai' => $request->aturan_pakai,
            'catatan_resep' => $request->catatan_resep,
            'dokter_penulis' => $request->dokter_penulis,
            'nomor_telepon_seluler' => $request->nomor_telepon_seluler,
            'tanggal_penulisan_resep' => $request->tanggal_penulisan_resep,
            'jam_pemulisan_resep' => $time->toTimeString(),
            'tanda_tangan_dokter' => $request->tanda_tangan_dokter,
            'status_resep' => $request->status_resep,
            'pengkajian_resep' => $request->pengkajian_resep,
        ]);
        $Obat->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $Obat);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $Obat = Obat::find($request->id);

        if ($Obat == null) return null;

        return $Obat;
    }
}