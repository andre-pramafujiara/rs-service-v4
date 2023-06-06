<?php

namespace App\Http\Controllers;

use App\Models\AssesmenAwal;
use Illuminate\Http\Request;
use App\Http\Helper;

class AssesmenawalController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], AssesmenAwal::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'assesmen_nyeri' => 'required|exists:assesmennyeri,id',
            'risiko_jatuh' => 'required|exists:jatuh,id',
            'pemeriksaan_fisik' => 'required|exists:pemeriksaanfisik,id',
            'user_id' => 'required|integer',
        ]);

        $assesmenawal = AssesmenAwal::create([
            'assesmen_nyeri' => $request->assesmen_nyeri,
            'risiko_jatuh' => $request->risiko_jatuh,
            'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $assesmenawal);
    }

    public function destroy(Request $request)
    {
        $assesmenawal = $this->getData($request);

        if ($assesmenawal == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $assesmenawal->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $assesmenawal->deleted_at]);
    }

    public function show(Request $request)
    {
        $assesmenawal = $this->getData($request);

        if ($assesmenawal == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $assesmenawal);
    }

    public function update(Request $request)
    {
        $assesmenawal = $this->getData($request);
        $this->validate($request, [
            'assesmen_nyeri' => 'required|exists:assesmennyeri,id',
            'risiko_jatuh' => 'required|exists:jatuh,id',
            'pemeriksaan_fisik' => 'required|exists:pemeriksaanfisik,id',
            'user_id' => 'required|integer',
        ]);

        if ($assesmenawal == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $assesmenawal->assesmen_nyeri = $request->assesmen_nyeri;
        $assesmenawal->risiko_jatuh = $request->risiko_jatuh;
        $assesmenawal->pemeriksaan_fisik = $request->pemeriksaan_fisik;
        $assesmenawal->user_id = $request->user_id;
        $assesmenawal->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $assesmenawal);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $assesmenawal = AssesmenAwal::find($request->id);

        if ($assesmenawal == null) return null;

        return $assesmenawal;
    }
}
