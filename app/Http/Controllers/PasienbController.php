<?php

namespace App\Http\Controllers;

use App\Models\Penanggungjawab;
use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\Pengantar;
use App\Models\Bbl;
use App\Models\Pasienb;

class PasienbController extends Controller
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
            'nama_pas_td' => 'required|string',
            'perkiraan_umur' => 'required|string',
            'lokasi_temu' => 'required|string',
            'tgl_temu' => 'required|date',
            'penjaw_id' => 'required|string',
            'peng_id' => 'required|string',
            'bbl_id' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $penjaw = Penanggungjawab::where('id', $request->penanggungjawab)->first();
        $pengantar = Pengantar::where('id', $request->pengantar)->first();
        $bbl = Bbl::where('id', $request->bbl)->first();


        $pasienb = Pasienb::create([
            'nama_pas_td' => $request->nama_pas_td,
            'perkiraan_umur' => $request->perkiraan_umur,
            'lokasi_temu' => $request->lokasi_temu,
            'tgl_temu' => $request->tgl_temu,
            'penjaw_id' => $request->penjaw_id,
            'peng_id' => $request->peng_id,
            'bbl_id' => $request->bbl_id,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $pasienb);
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
        $pasienb = $this->getData($request);
        $this->validate($request, [
            'nama_pas_td' => 'required|string',
            'perkiraan_umur' => 'required|string',
            'lokasi_temu' => 'required|string',
            'tgl_temu' => 'required|date',
            'penjaw_id' => 'required|string',
            'peng_id' => 'required|string',
            'bbl_id' => 'required|string',
            'user_id' => 'required|integer',
        ]);


        $pasienb->update([
            'nama_pas_td' => $request->nama_pas_td,
            'perkiraan_umur' => $request->perkiraan_umur,
            'lokasi_temu' => $request->lokasi_temu,
            'tgl_temu' => $request->tgl_temu,
            'penjaw_id' => $request->penjaw_id,
            'peng_id' => $request->peng_id,
            'bbl_id' => $request->bbl_id,
            'user_id' => $request->user_id,
        ]);

        $pasienb->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $pasienb);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $pasienb = Pasienb::find($request->id);

        if ($pasienb == null) return null;

        return $pasienb;
    }
}
?>