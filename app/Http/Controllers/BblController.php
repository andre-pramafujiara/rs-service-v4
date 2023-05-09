<?php

namespace App\Http\Controllers;

use App\Models\Bbl;
use Illuminate\Http\Request;
use App\Http\Helper;
use Carbon\Carbon;

class BblController extends Controller
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
            'name_bayi' => 'required|string',
            'nik_ibu_kandung' => 'required|string',
            'no_rm' => 'required|string',
            'tgl_lahir_bayi' => 'required|date',
            'jam_lahir_bayi' => 'required|time',
            'jk_bayi' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        //jam otomatis
        $time = Carbon::parse($request->jam_triase);
        // tanggal automatis
        $request->merge(['tanggal_triase' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $bbl = Bbl::create([
            'nama_bayi' => $request->nama_bayi,
            'nik_ibu_kandung' => $request->nik_ibu_kandung,
            'no_rm' => $request->no_rm,
            'tgl_lahir_bayi' => $request->tgl_lahir_bayi,
            'jam_lahir_bayi' => $time->toTimeString(),
            'jk_bayi' => $request->jk_bayi,
            'user_id' => $request->user_id,
        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $bbl);
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
        $bbl = $this->getData($request);
        $this->validate($request, [
            'name_bayi' => 'required|string',
            'nik_ibu_kandung' => 'required|string',
            'no_rm' => 'required|string',
            'tgl_lahir_bayi' => 'required|date',
            'jam_lahir_bayi' => 'required|time',
            'jk_bayi' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        //jam otomatis
        $time = Carbon::parse($request->jam_triase);
        // tanggal automatis
        $request->merge(['tanggal_bbl' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);


        $bbl->update([
            'nama_bayi' => $request->nama_bayi,
            'nik_ibu_kandung' => $request->nik_ibu_kandung,
            'no_rm' => $request->no_rm,
            'tgl_lahir_bayi' => $request->tgl_lahir_bayi,
            'jam_lahir_bayi' => $time->toTimeString(),
            'jk_bayi' => $request->jk_bayi,
            'user_id' => $request->user_id,
        ]);

        $bbl->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $bbl);
    }
    
    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $bbl = Bbl::find($request->id);

        if ($bbl == null) return null;

        return $bbl;
    }
}
?>