<?php

namespace App\Http\Controllers;

use App\Models\Asuransi;
use Illuminate\Http\Request;
use App\Http\Helper;

class AsuransiController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Asuransi::select('id', 'name', 'kode_rs', 'kode_bpjs')->orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Asuransi::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'kode_rs' => 'required|string',
            'kode_bpjs' => 'nullable|string',
            'user_id' => 'required|integer',
        ]);

        $asuransi = Asuransi::create([
            'name' => $request->name,
            'kode_rs' => $request->kode_rs,
            'kode_bpjs' => $request->kode_bpjs,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $asuransi);
    }

    public function destroy(Request $request)
    {
        $asuransi = $this->getData($request);

        if ($asuransi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $asuransi->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $asuransi->deleted_at]);
    }

    public function show(Request $request)
    {
        $asuransi = $this->getData($request);

        if ($asuransi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $asuransi);
    }

    public function update(Request $request)
    {
        $asuransi = $this->getData($request);
        $this->validate($request, [
            'name' => 'required|string',
            'kode_rs' => 'required|string',
            'kode_bpjs' => 'nullable|string',
            'user_id' => 'required|integer',
        ]);

        if ($asuransi == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $asuransi->update([
            'name' => $request->name,
            'kode_rs' => $request->kode_rs,
            'kode_bpjs' => $request->kode_bpjs,
            'user_id' => $request->user_id
        ]);

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $asuransi);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $asuransi = Asuransi::find($request->id);

        if ($asuransi == null) return null;

        return $asuransi;
    }
}
?>