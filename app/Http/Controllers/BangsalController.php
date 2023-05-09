<?php

namespace App\Http\Controllers;

use App\Models\Bangsal;
use Illuminate\Http\Request;
use App\Http\Helper;

class BangsalController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Bangsal::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer',
        ]);

        $bangsal = Bangsal::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'description' => $request->input('description', ''),
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $bangsal);
    }

    public function destroy(Request $request)
    {
        $bangsal = $this->getData($request);

        if ($bangsal == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $bangsal->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $bangsal->deleted_at]);
    }

    public function show(Request $request)
    {
        $bangsal = $this->getData($request);

        if ($bangsal == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $bangsal);
    }

    public function update(Request $request)
    {
        $bangsal = $this->getData($request);
        $this->validate($request, [
            'name' => 'required',
            'user_id' => 'required|integer'
        ]);

        if ($bangsal == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $bangsal->name = $request->name;
        $bangsal->user_id = $request->user_id;
        $bangsal->description = $request->input('description', '');
        $bangsal->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $bangsal);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $bangsal = Bangsal::find($request->id);

        if ($bangsal == null) return null;

        return $bangsal;
    }
}
