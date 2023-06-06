<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PersetujuanTindakan;
use App\Http\Helper;
use Carbon\Carbon;

class PersetujuantindakanController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], PersetujuanTindakan::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_pasien' => 'required|string|max:255',
            'nama_dokter' => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
            'nama_keluarga_pasien' => 'required|string|max:255',
            'tindakan_yang_dilakukan' => 'required|string|max:255',
            'konsekuensi_tindakan' => 'required|string|max:255',
            'persetujuan_atau_penolokan' => 'required|string|max:255',
            'tanggal_pemberian' => 'required|string|max:255',
            'jam_pemberian' => 'required|string|max:255',
            'membuat_pernyataan' => 'required|string|max:255',
        ]);

        //jam otomatis
        $time = Carbon::parse($request->jam_pemberian);
        // tanggal automatis
        $request->merge(['tanggal_pemberian' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $persetujuantindakan = PersetujuanTindakan::create([
            'nama_pasien' => $request->nama_pasien,
            'nama_dokter' => $request->nama_dokter,
            'nama_petugas' => $request->nama_petugas,
            'nama_keluarga_pasien' => $request->nama_keluarga_pasien,
            'tindakan_yang_dilakukan' => $request->tindakan_yang_dilakukan,
            'konsekuensi_tindakan' => $request->konsekuensi_tindakan,
            'persetujuan_atau_penolokan' => $request->persetujuan_atau_penolokan,
            'tanggal_pemberian' => $request->tanggal_pemberian,
            'jam_pemberian' => $time->toTimeString(),
            'membuat_pernyataan' => $request->membuat_pernyataan,

        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $persetujuantindakan);
    }

    public function destroy(Request $request)
    {
        $persetujuantindakan = $this->getData($request);

        if ($persetujuantindakan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $persetujuantindakan->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $persetujuantindakan->deleted_at]);
    }

    public function show(Request $request)
    {
        $persetujuantindakan = $this->getData($request);

        if ($persetujuantindakan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $persetujuantindakan);
    }

    public function update(Request $request)
    {
        $persetujuantindakan = $this->getData($request);
        $this->validate($request, [
            'nama_pasien' => 'required|string|max:255',
            'nama_dokter' => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
            'nama_keluarga_pasien' => 'required|string|max:255',
            'tindakan_yang_dilakukan' => 'required|string|max:255',
            'konsekuensi_tindakan' => 'required|string|max:255',
            'persetujuan_atau_penolokan' => 'required|string|max:255',
            'tanggal_pemberian' => 'required|string|max:255',
            'jam_pemberian' => 'required|string|max:255',
            'membuat_pernyataan' => 'required|string|max:255',
        ]);

        if ($persetujuantindakan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        //jam otomatis
        $time = Carbon::parse($request->jam_pemberian);
        // tanggal automatis
        $request->merge(['tanggal_pemberian' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);

        $persetujuantindakan->update([
            'nama_pasien' => $request->nama_pasien,
            'nama_dokter' => $request->nama_dokter,
            'nama_petugas' => $request->nama_petugas,
            'nama_keluarga_pasien' => $request->nama_keluarga_pasien,
            'tindakan_yang_dilakukan' => $request->tindakan_yang_dilakukan,
            'konsekuensi_tindakan' => $request->konsekuensi_tindakan,
            'persetujuan_atau_penolokan' => $request->persetujuan_atau_penolokan,
            'tanggal_pemberian' => $request->tanggal_pemberian,
            'jam_pemberian' => $time->toTimeString(),
            'membuat_pernyataan' => $request->membuat_pernyataan,

        ]);
        $persetujuantindakan->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $persetujuantindakan);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $persetujuantindakan = PersetujuanTindakan::find($request->id);

        if ($persetujuantindakan == null) return null;

        return $persetujuantindakan;
    }
}