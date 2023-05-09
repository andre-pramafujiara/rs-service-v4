<?php

namespace App\Http\Controllers;

use App\Models\Penanggungjawab;
use Illuminate\Http\Request;
use App\Http\Helper;

class PenanggungjawabController extends Controller
{
    use Helper;

    public function index(Request $request)
    {
        //return $this->responseFormatterWithMeta($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Asuransi::select('id', 'name', 'kode_rs', 'kode_bpjs')->orderBy('created_at', 'desc')->cursorPaginate($request->input('per_page', 15)));
    }

    public function list()
    {
       // return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Asuransi::select('id', 'name')->orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_penjaw' => 'required|string',
            'alamat_pen_jaw' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'keluran' => 'required|string',
            'rw' => 'required|string',
            'rt' => 'required|string',
            'kode_pos' => 'required|string',
            'negara' => 'required|string',
            'tlp_pen_jaw' => 'required|string',
            'hub_pas' => 'required|string',
            'user_id' => 'required|integer',
        ]);


        $penjaw = Penanggungjawab::create([
            'nama_penjaw' => $request->nama_penjaw,
            'alamat_penjaw' => $request->alamat_penjaw,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'keluran' => $request->keluran,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'kode_pos' => $request->kode_pos,
            'negara' => $request->negara,
            'tlp_penjaw' => $request->tlp_penjaw,
            'hub_pas' => $request->hub_pas,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $penjaw);
    }

    public function destroy(Request $request)
    {
        $bbl = $this->getData($request);

        if ($bbl == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $bbl->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $bbl->deleted_at]);
    }

    public function show(Request $request)
    {
        $bbl = $this->getData($request);

        if ($bbl == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $bbl);
    }

    public function update(Request $request)
    {
        $penjaw = $this->getData($request);
        $this->validate($request, [
            'nama_penjaw' => 'required|string',
            'alamat_pen_jaw' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'keluran' => 'required|string',
            'rw' => 'required|string',
            'rt' => 'required|string',
            'kode_pos' => 'required|string',
            'negara' => 'required|string',
            'tlp_pen_jaw' => 'required|string',
            'hub_pas' => 'required|string',
            'user_id' => 'required|integer',
        ]);


        $penjaw->update([
            'nama_penjaw' => $request->nama_penjaw,
            'alamat_penjaw' => $request->alamat_penjaw,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'keluran' => $request->keluran,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'kode_pos' => $request->kode_pos,
            'negara' => $request->negara,
            'tlp_penjaw' => $request->tlp_penjaw,
            'hub_pas' => $request->hub_pas,
            'user_id' => $request->user_id,
        ]);

        $penjaw->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $penjaw);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $penjaw = Penanggungjawab::find($request->id);

        if ($penjaw == null) return null;

        return $penjaw;
    }
}
?>