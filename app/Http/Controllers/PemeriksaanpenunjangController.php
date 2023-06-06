<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\PemeriksaanPenunjang;
use App\Models\Triase;
use Carbon\Carbon;

class PemeriksaanpenunjangController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], PemeriksaanPenunjang::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nomor_rekam_medis' => 'required|string|max:255',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:255',
            //'jam' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'laboratorium' => 'required|exists:laboratorium,id',
            'radiologi' => 'required|exists:radiologi,id',
            'user_id' => 'required|integer',
        ]);   
        //jam otomatis
        $time = Carbon::parse($request->jam);
        // tanggal PemeriksaanPenunjang
        $request->merge(['tanggal' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);     


        $pemeriksaanpenunjang = PemeriksaanPenunjang::create([
            'nomor_rekam_medis' => $request->nomor_rekam_medis,
            'nama_pasien' => $request->nama_pasien,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jam' => $time->toTimeString(),
            'tanggal' => $request->tanggal,
            'laboratorium' => $request->laboratorium,
            'radiologi' => $request->radiologi,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $pemeriksaanpenunjang);
    }

    public function destroy(Request $request)
    {
        $pemeriksaanpenunjang = $this->getData($request);

        if ($pemeriksaanpenunjang == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pemeriksaanpenunjang->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $pemeriksaanpenunjang->deleted_at]);
    }

    public function show(Request $request)
    {
        $pemeriksaanpenunjang = $this->getData($request);

        if ($pemeriksaanpenunjang == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pemeriksaanpenunjang);
    }

    public function update(Request $request)
    {
        $pemeriksaanpenunjang = $this->getData($request);
        $this->validate($request, [
            'nomor_rekam_medis' => 'required|string|max:255',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'tanggal_lahir' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'jam' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'laboratorium' => 'required|exists:laboratorium,id',
            'radiologi' => 'required|exists:radiologi,id',
            'user_id' => 'required|integer',
        ]);

        if ($pemeriksaanpenunjang == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        //jam otomatis
        $time = Carbon::parse($request->jam);
        // tanggal Triase
        $request->merge(['tanggal' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);

        $pemeriksaanpenunjang->update([
            'nomor_rekam_medis' => $request->nomor_rekam_medis,
            'nama_pasien' => $request->nama_pasien,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jam' => $time->toTimeString(),
            'tanggal' => $request->tanggal,
            'laboratorium' => $request->laboratorium,
            'radiologi' => $request->radiologi,
            'user_id' => $request->user_id,
        ]);
        $pemeriksaanpenunjang->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pemeriksaanpenunjang);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $pemeriksaanpenunjang = PemeriksaanPenunjang::find($request->id);

        if ($pemeriksaanpenunjang == null) return null;

        return $pemeriksaanpenunjang;
    }
}
