<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Helper;

class UnitController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Unit::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
        ]);

        $unit = Unit::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $unit);
    }

    public function destroy(Request $request)
    {
        $unit = $this->getData($request);

        if ($unit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $unit->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $unit->deleted_at]);
    }

    public function show(Request $request)
    {
        $unit = $this->getData($request);

        if ($unit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $unit);
    }

    public function update(Request $request)
    {
        $unit = $this->getData($request);
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer'
        ]);

        if ($unit == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $unit->name = $request->name;
        $unit->user_id = $request->user_id;
        $unit->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $unit);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $unit = Unit::find($request->id);

        if ($unit == null) return null;

        return $unit;
    }
}
