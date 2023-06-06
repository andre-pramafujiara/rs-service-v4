<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;
use App\Http\Helper;

class ScreeningController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Screening::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'risiko_jatuh' => 'required|exists:jatuh,id',
            'dicubitus' => 'required|exists:dicubitus,id',
            'batuk' => 'required|exists:batuk,id',
            'gizi' => 'required|exists:gizi,id',
            'user_id' => 'required|integer',
        ]);

        $screening = Screening::create([
            'risiko_jatuh' => $request->risiko_jatuh,
            'dicubitus' => $request->dicubitus,
            'batuk' => $request->batuk,
            'gizi' => $request->gizi,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $screening);
    }

    public function destroy(Request $request)
    {
        $screening = $this->getData($request);

        if ($screening == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $screening->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $screening->deleted_at]);
    }

    public function show(Request $request)
    {
        $screening = $this->getData($request);

        if ($screening == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $screening);
    }

    public function update(Request $request)
    {
        $screening = $this->getData($request);
        $this->validate($request, [
            'risiko_jatuh' => 'required|exists:jatuh,id',
            'dicubitus' => 'required|exists:dicubitus,id',
            'batuk' => 'required|exists:batuk,id',
            'gizi' => 'required|exists:gizi,id',
            'user_id' => 'required|integer',
        ]);

        if ($screening == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $screening->risiko_jatuh = $request->risiko_jatuh;
        $screening->dicubitus = $request->dicubitus;
        $screening->batuk = $request->batuk;
        $screening->gizi = $request->gizi;
        $screening->user_id = $request->user_id;
        $screening->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $screening);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $screening = Screening::find($request->id);

        if ($screening == null) return null;

        return $screening;
    }
}
