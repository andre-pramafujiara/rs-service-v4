<?php

namespace App\Http\Controllers;

use App\Models\Pemulangan;
use Illuminate\Http\Request;
use App\Http\Helper;

class PemulanganController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pemulangan::orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Pemulangan::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kondisi' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $pemulangan = Pemulangan::create([
            'nama_kondisi' => $request->nama_kondisi,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $pemulangan);
    }

    public function destroy(Request $request)
    {
        $pemulangan = $this->getData($request);

        if ($pemulangan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $pemulangan->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $pemulangan->deleted_at]);
    }

    public function show(Request $request)
    {
        $pemulangan = $this->getData($request);

        if ($pemulangan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pemulangan);
    }

    public function update(Request $request)
    {
        $pemulangan = $this->getData($request);
        $this->validate($request, [
            'nama_kondisi' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $pemulangan->update([
            'nama_kondisi' => $request->nama_kondisi,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pemulangan);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $pemulangan = Pemulangan::find($request->id);

        if ($pemulangan == null) return null;

        return $pemulangan;
    }
}
?>