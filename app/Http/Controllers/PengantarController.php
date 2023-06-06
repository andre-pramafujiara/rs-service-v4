<?php

namespace App\Http\Controllers;

use App\Models\Pengantar;
use Illuminate\Http\Request;
use App\Http\Helper;

class PengantarController extends Controller
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
            'nama_peng' => 'required|string',
            'alamat_peng' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'keluran' => 'required|string',
            'rw' => 'required|string',
            'rt' => 'required|string',
            'kode_pos' => 'required|string',
            'negara' => 'required|string',
            'tlp_peng' => 'required|string',
            'user_id' => 'required|integer',
        ]);


        $peng = Pengantar::create([
            'nama_peeng' => $request->nama_peng,
            'alamat_peng' => $request->alamat_peng,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'keluran' => $request->keluran,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'kode_pos' => $request->kode_pos,
            'negara' => $request->negara,
            'tlp_peng' => $request->tlp_peng,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $peng);
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
        $peng = $this->getData($request);
        $this->validate($request, [
            'nama_peng' => 'required|string',
            'alamat_peng' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'keluran' => 'required|string',
            'rw' => 'required|string',
            'rt' => 'required|string',
            'kode_pos' => 'required|string',
            'negara' => 'required|string',
            'tlp_peng' => 'required|string',
            'hub_pas' => 'required|string',
            'user_id' => 'required|integer',
        ]);


        $peng->update([
            'nama_peng' => $request->nama_peng,
            'alamat_peng' => $request->alamat_peng,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'keluran' => $request->keluran,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'kode_pos' => $request->kode_pos,
            'negara' => $request->negara,
            'tlp_peng' => $request->tlp_peng,
            'user_id' => $request->user_id,
        ]);

        $peng->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $peng);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $peng = Pengantar::find($request->id);

        if ($peng == null) return null;

        return $peng;
    }
}
?>