<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Gizi;

class GiziController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Gizi::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'turun_bb' => 'required|string|max:255',
            'nafsu_makan_kurang' => 'required|string|max:255',
            'gastrointestinal' => 'required|string|max:255',
            'komorbid' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);


        $gizi = Gizi::create([
            'turun_bb' => $request->turun_bb,
            'nafsu_makan_kurang' => $request->nafsu_makan_kurang,
            'gastrointestinal' => $request->gastrointestinal,
            'komorbid' => $request->komorbid,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $gizi);
    }

    public function destroy(Request $request)
    {
        $gizi = $this->getData($request);

        if ($gizi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $gizi->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $gizi->deleted_at]);
    }

    public function show(Request $request)
    {
        $gizi = $this->getData($request);

        if ($gizi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $gizi);
    }

    public function update(Request $request)
    {
        $gizi = $this->getData($request);
        $this->validate($request, [
            'turun_bb' => 'required|string|max:255',
            'nafsu_makan_kurang' => 'required|string|max:255',
            'gastrointestinal' => 'required|string|max:255',
            'komorbid' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($gizi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $gizi->update([
            'turun_bb' => $request->turun_bb,
            'nafsu_makan_kurang' => $request->nafsu_makan_kurang,
            'gastrointestinal' => $request->gastrointestinal,
            'komorbid' => $request->komorbid,
            'user_id' => $request->user_id,
        ]);
        $gizi->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $gizi);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $batuk = Gizi::find($request->id);

        if ($batuk == null) return null;

        return $batuk;
    }
}
