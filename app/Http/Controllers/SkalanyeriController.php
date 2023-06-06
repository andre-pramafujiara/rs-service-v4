<?php

namespace App\Http\Controllers;

use App\Models\AssesmenNyeri;
use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\SkalaNyeri;

class SkalanyeriController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], SkalaNyeri::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nr_scale' => 'required|string',
            'bp_scale' => 'required|string',
            'nip_scale' => 'required|string',
            'va_scale' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $assesmennyeri = SkalaNyeri::create([
            'nr_scale' => $request->nr_scale,
            'bp_scale' => $request->bp_scale,
            'nip_scale' => $request->nip_scale,
            'va_scale' => $request->va_scale,
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
            'nr_scale' => 'required|string',
            'bp_scale' => 'required|string',
            'nip_scale' => 'required|string',
            'va_scale' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($assesmennyeri == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $assesmennyeri->name = $request->name;
        $assesmennyeri->bp_scale = $request->bp_scale;
        $assesmennyeri->nip_scale = $request->nip_scale;
        $assesmennyeri->va_scale = $request->va_scale;
        $assesmennyeri->user_id = $request->user_id;
        $assesmennyeri->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $assesmennyeri);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $assesmennyeri = SkalaNyeri::find($request->id);

        if ($assesmennyeri == null) return null;

        return $assesmennyeri;
    }
}
