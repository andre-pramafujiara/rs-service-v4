<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\PersetujuanPasien;

class PersetujuanpasienController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], PersetujuanPasien::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ketentuan_bayar' => 'required|string|max:255',
            'hak_kewajiban' => 'required|string|max:255',
            'tata_tertib' => 'required|string|max:255',
            'terjemah_bahasa' => 'required|string|max:255',
            'rohaniawan' => 'required|string|max:255',
            'pelepasan_rahasia' => 'required|string|max:255',
            'to_penjamin' => 'required|string|max:255',
            'to_peserta_didik' => 'required|string|max:255',
            'to_anggota_keluarga' => 'required|string|max:255',
            'to_fasyankes' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);


        $persetujuanpasien = PersetujuanPasien::create([
            'ketentuan_bayar' => $request->ketentuan_bayar,
            'hak_keewajiban' => $request->hak_keewajiban,
            'tata_tertib' => $request->tata_tertib,
            'terjemah_bahasa' => $request->terjemah_bahasa,
            'terjemah_bahasa' => $request->terjemah_bahasa,
            'pelepasan_rahasia' => $request->pelepasan_rahasia,
            'to_penjamin' => $request->to_penjamin,
            'to_pserta_didik' => $request->to_pserta_didik,
            'to_angota_keluarga' => $request->to_angota_keluarga,
            'to_fasyankes' => $request->to_fasyankes,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $persetujuanpasien);
    }

    public function destroy(Request $request)
    {
        $persetujuanpasien = $this->getData($request);

        if ($persetujuanpasien == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $persetujuanpasien->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $persetujuanpasien->deleted_at]);
    }

    public function show(Request $request)
    {
        $persetujuanpasien = $this->getData($request);

        if ($persetujuanpasien == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $persetujuanpasien);
    }

    public function update(Request $request)
    {
        $persetujuanpasien = $this->getData($request);
        $this->validate($request, [
            'ketentuan_bayar' => 'required|string|max:255',
            'hak_kewajiban' => 'required|string|max:255',
            'tata_tertib' => 'required|string|max:255',
            'terjemah_bahasa' => 'required|string|max:255',
            'rohaniawan' => 'required|string|max:255',
            'pelepasan_rahasia' => 'required|string|max:255',
            'to_penjamin' => 'required|string|max:255',
            'to_peserta_didik' => 'required|string|max:255',
            'to_anggota_keluarga' => 'required|string|max:255',
            'to_fasyankes' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($persetujuanpasien == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $persetujuanpasien->update([
            'ketentuan_bayar' => $request->ketentuan_bayar,
            'hak_keewajiban' => $request->hak_keewajiban,
            'tata_tertib' => $request->tata_tertib,
            'terjemah_bahasa' => $request->terjemah_bahasa,
            'terjemah_bahasa' => $request->terjemah_bahasa,
            'pelepasan_rahasia' => $request->pelepasan_rahasia,
            'to_penjamin' => $request->to_penjamin,
            'to_pserta_didik' => $request->to_pserta_didik,
            'to_angota_keluarga' => $request->to_angota_keluarga,
            'to_fasyankes' => $request->to_fasyankes,
            'user_id' => $request->user_id,
        ]);
        $persetujuanpasien->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $persetujuanpasien);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $persetujuanpasien = PersetujuanPasien::find($request->id);

        if ($persetujuanpasien == null) return null;

        return $persetujuanpasien;
    }
}
