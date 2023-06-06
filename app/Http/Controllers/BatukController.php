<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Batuk;

class BatukController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Batuk::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'demam' => 'required|string|max:255',
            'keringat_malam' => 'required|string|max:255',
            'riwayat_wabah' => 'required|string|max:255',
            'obat_jangka_panjang' => 'required|string|max:255',
            'turun_bb' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);


        $batuk = Batuk::create([
            'demam' => $request->demam,
            'keringat_malam' => $request->keringat_malam,
            'riwayat_wabah' => $request->riwayat_wabah,
            'obat_jangka_panjang' => $request->obat_jangka_panjang,
            'turun_bb' => $request->turun_bb,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $batuk);
    }

    public function destroy(Request $request)
    {
        $batuk = $this->getData($request);

        if ($batuk == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $batuk->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $batuk->deleted_at]);
    }

    public function show(Request $request)
    {
        $batuk = $this->getData($request);

        if ($batuk == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $batuk);
    }

    public function update(Request $request)
    {
        $batuk = $this->getData($request);
        $this->validate($request, [
            'demam' => 'required|string|max:255',
            'keringat_malam' => 'required|string|max:255',
            'riwayat_wabah' => 'required|string|max:255',
            'obat_jangka_panjang' => 'required|string|max:255',
            'turun_bb' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($batuk == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $batuk->update([
            'demam' => $request->demam,
            'keringat_malam' => $request->keringat_malam,
            'riwayat_wabah' => $request->riwayat_wabah,
            'obat_jangka_panjang' => $request->obat_jangka_panjang,
            'turun_bb' => $request->turun_bb,
            'user_id' => $request->user_id,
        ]);
        $batuk->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $batuk);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $batuk = Batuk::find($request->id);

        if ($batuk == null) return null;

        return $batuk;
    }
}
