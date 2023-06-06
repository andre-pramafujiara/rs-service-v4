<?php

namespace App\Http\Controllers;

use App\Models\AssesmenNyeri;
use Illuminate\Http\Request;
use App\Http\Helper;

class AssesmennyeriController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], AssesmenNyeri::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'lokasi_nyeri' => 'required|string',
            'durasi_nyeri' => 'required|string',
            'penyebab_nyeri' => 'required|string',
            'frekuensi_nyeri' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $assesmennyeri = AssesmenNyeri::create([
            'lokasi_nyeri' => $request->lokasi_nyeri,
            'durasi_nyeri' => $request->durasi_nyeri,
            'penyebab_nyeri' => $request->penyebab_nyeri,
            'frekuensi_nyeri' => $request->frekuensi_nyeri,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $assesmennyeri);
    }

    public function destroy(Request $request)
    {
        $assesmennyeri = $this->getData($request);

        if ($assesmennyeri == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $assesmennyeri->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $assesmennyeri->deleted_at]);
    }

    public function show(Request $request)
    {
        $assesmennyeri = $this->getData($request);

        if ($assesmennyeri == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $assesmennyeri);
    }

    public function update(Request $request)
    {
        $assesmennyeri = $this->getData($request);
        $this->validate($request, [
            'lokasi_nyeri' => 'required|string',
            'durasi_nyeri' => 'required|string',
            'penyebab_nyeri' => 'required|string',
            'frekuensi_nyeri' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($assesmennyeri == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $assesmennyeri->lokasi_nyeri = $request->lokasi_nyeri;
        $assesmennyeri->durasi_nyeri = $request->durasi_nyeri;
        $assesmennyeri->penyebab_nyeri = $request->penyebab_nyeri;
        $assesmennyeri->frekuensi_nyeri = $request->frekuensi_nyeri;
        $assesmennyeri->user_id = $request->user_id;
        $assesmennyeri->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $assesmennyeri);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $assesmennyeri = AssesmenNyeri::find($request->id);

        if ($assesmennyeri == null) return null;

        return $assesmennyeri;
    }
}
