<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Diagnosis;
use App\Models\Triase;
use Carbon\Carbon;

class DiagnosisController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Diagnosis::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'diagnosis_masuk' => 'required|string|max:255',
            'diagnosis_banding' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        $diagnosis = Diagnosis::create([
            'diagnosis_masuk' => $request->diagnosis_masuk,
            'diagnosis_banding' => $request->diagnosis_banding,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $diagnosis);
    }

    public function destroy(Request $request)
    {
        $diagnosis = $this->getData($request);

        if ($diagnosis == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $diagnosis->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $diagnosis->deleted_at]);
    }

    public function show(Request $request)
    {
        $diagnosis = $this->getData($request);

        if ($diagnosis == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $diagnosis);
    }

    public function update(Request $request)
    {
        $diagnosis = $this->getData($request);
        $this->validate($request, [
            'diagnosis_masuk' => 'required|string|max:255',
            'diagnosis_banding' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($diagnosis == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");


        $diagnosis->update([
            'diagnosis_masuk' => $request->diagnosis_masuk,
            'diagnosis_banding' => $request->diagnosis_banding,
            'user_id' => $request->user_id,
        ]);
        $diagnosis->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $diagnosis);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $diagnosis = Diagnosis::find($request->id);

        if ($diagnosis == null) return null;

        return $diagnosis;
    }
}
