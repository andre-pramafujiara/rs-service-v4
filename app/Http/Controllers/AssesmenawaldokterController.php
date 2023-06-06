<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\AssesmenAwalDokterUgd;

class AssesmenawaldokterugdController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], AssesmenAwalDokterUgd::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'anamnesis' => 'required|exists:anamnesis,id',
            'pemeriksaan_fisik' => 'required|exists:pemeriksaanfisik,id',
            'pemeriksaan_penunjang' => 'required|exists:pemeriksaanpenunjang,id',
            'diagnosis' => 'required|exists:diagnosis,id',
            'terapi' => 'required|exists:terapi,id',
            'user_id' => 'required|integer',
        ]);

        $assesmenawal = AssesmenAwalDokterUgd::create([
            'anamnesis' => $request->anamnesis,
            'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
            'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
            'diagnosis' => $request->diagnosis,
            'terapi' => $request->terapi,
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
            'anamnesis' => 'required|exists:anamnesis,id',
            'pemeriksaan_fisik' => 'required|exists:pemeriksaanfisik,id',
            'pemeriksaan_penunjang' => 'required|exists:pemeriksaanpenunjang,id',
            'diagnosis' => 'required|exists:diagnosis,id',
            'terapi' => 'required|exists:terapi,id',
            'user_id' => 'required|integer',
        ]);

        if ($assesmenawal == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $assesmenawal->anamnesis = $request->anamnesis;
        $assesmenawal->pemeriksaan_fisik = $request->pemeriksaan_fisik;
        $assesmenawal->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;
        $assesmenawal->diagnosis = $request->diagnosis;
        $assesmenawal->terapi = $request->terapi;
        $assesmenawal->user_id = $request->user_id;
        $assesmenawal->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $assesmenawal);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $assesmenawal = AssesmenAwalDokterUgd::find($request->id);

        if ($assesmenawal == null) return null;

        return $assesmenawal;
    }
}
