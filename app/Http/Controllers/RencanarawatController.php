<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\RencanaRawat;
use App\Models\Triase;
use Carbon\Carbon;

class RencanaRawatController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], RencanaRawat::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'rencana_terapi' => 'required|string|max:255',
            'rencana_tindakan' => 'required|string|max:255',
            'rencana_lama_hari_rawat' => 'required|integer',
            'indikasi_rawat_inap' => 'required|string|max:255',
            'preventif' => 'required|string|max:255',
            'paliatif' => 'required|string|max:255',
            'kuratif' => 'required|string|max:255',
            'rehabilitatif' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]); 


        $rencanarawat = RencanaRawat::create([
            'rencana_terapi' => $request->rencana_terapi,
            'rencana_tindakan' => $request->rencana_tindakan,
            'rencana_lama_hari_rawat' => $request->rencana_lama_hari_rawat,
            'indikasi_rawat_inap' => $request->indikasi_rawat_inap,
            'preventif' => $request->preventif,
            'paliatif' => $request->paliatif,
            'kuratif' => $request->kuratif,
            'rehabilitatif' => $request->rehabilitatif,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $rencanarawat);
    }

    public function destroy(Request $request)
    {
        $rencanarawat = $this->getData($request);

        if ($rencanarawat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $rencanarawat->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $rencanarawat->deleted_at]);
    }

    public function show(Request $request)
    {
        $rencanarawat = $this->getData($request);

        if ($rencanarawat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $rencanarawat);
    }

    public function update(Request $request)
    {
        $rencanarawat = $this->getData($request);
        $this->validate($request, [
            'rencana_terapi' => 'required|string|max:255',
            'rencana_tindakan' => 'required|string|max:255',
            'rencana_lama_hari_rawat' => 'required|integer',
            'indikasi_rawat_inap' => 'required|string|max:255',
            'preventif' => 'required|string|max:255',
            'paliatif' => 'required|string|max:255',
            'kuratif' => 'required|string|max:255',
            'rehabilitatif' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($rencanarawat == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        

        $rencanarawat->update([
            'rencana_terapi' => $request->rencana_terapi,
            'rencana_tindakan' => $request->rencana_tindakan,
            'rencana_lama_hari_rawat' => $request->rencana_lama_hari_rawat,
            'indikasi_rawat_inap' => $request->indikasi_rawat_inap,
            'preventif' => $request->preventif,
            'paliatif' => $request->paliatif,
            'kuratif' => $request->kuratif,
            'rehabilitatif' => $request->rehabilitatif,
            'user_id' => $request->user_id,
        ]);
        $rencanarawat->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $rencanarawat);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $rencanarawat = RencanaRawat::find($request->id);

        if ($rencanarawat == null) return null;

        return $rencanarawat;
    }
}
