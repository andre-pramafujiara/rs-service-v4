<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;
use App\Http\Helper;

class SpecialistController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Specialist::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
        ]);

        $specialist = Specialist::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $specialist);
    }

    public function destroy(Request $request)
    {
        $specialist = $this->getData($request);

        if ($specialist == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $specialist->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $specialist->deleted_at]);
    }

    public function show(Request $request)
    {
        $specialist = $this->getData($request);

        if ($specialist == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $specialist);
    }

    public function update(Request $request)
    {
        $specialist = $this->getData($request);
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
        ]);

        if ($specialist == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $specialist->name = $request->name;
        $specialist->user_id = $request->user_id;
        $specialist->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $specialist);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $specialist = Specialist::find($request->id);

        if ($specialist == null) return null;

        return $specialist;
    }
}
