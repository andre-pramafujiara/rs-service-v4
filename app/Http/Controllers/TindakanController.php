<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tindakan;
use App\Http\Helper;
use Carbon\Carbon;

class TindakanController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], Tindakan::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_tindakan' => 'required|string|max:255',
            'petugas_yang_melaksanakan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|string|max:255',
            'waktu_mulai_tindakan' => 'required|string|max:255',
            'waktu_selesai_tindakan' => 'required|string|max:255',
            'alat_medis_yang_digunakan' => 'required|string|max:255',
            'BMHP' => 'required|string|max:255',
            'petugas_yang_melaksanakan' => 'required|string|max:255',

        ]);

       //jam otomatis
       $time1 = Carbon::parse($request->waktu_mulai_tindakan);
       $time2 = Carbon::parse($request->waktu_selesai_tindakan);
       // tanggal Triase
       $request->merge(['tanggal_pelaksanaan' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);

        $Tindakan = Tindakan::create([
            'nama_tindakan' => $request->nama_tindakan,
            'petugas_yang_melaksanakan' => $request->petugas_yang_melaksanakan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'waktu_mulai_tindakan' => $time1->toTimeString(),
            'waktu_selesai_tindakan' => $time2->toTimeString(),
            'alat_medis_yang_digunakan' => $request->alat_medis_yang_digunakan,
            'BMHP' => $request->BMHP,

        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $Tindakan);
    }

    public function destroy(Request $request)
    {
        $Tindakan = $this->getData($request);

        if ($Tindakan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $Tindakan->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $Tindakan->deleted_at]);
    }

    public function show(Request $request)
    {
        $Tindakan = $this->getData($request);

        if ($Tindakan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $Tindakan);
    }

    public function update(Request $request)
    {
        $Tindakan = $this->getData($request);
        $this->validate($request, [
            'nama_tindakan' => 'required|string|max:255',
            'petugas_yang_melaksanakan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|string|max:255',
            'waktu_mulai_tindakan' => 'required|string|max:255',
            'waktu_selesai_tindakan' => 'required|string|max:255',
            'alat_medis_yang_digunakan' => 'required|string|max:255',
            'BMHP' => 'required|string|max:255',
           
        ]);

        if ($Tindakan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        //jam otomatis
        $time1 = Carbon::parse($request->waktu_mulai_tindakan);
        $time2 = Carbon::parse($request->waktu_selesai_tindakan);
        // tanggal Triase
        $request->merge(['tanggal_pelaksanaan' => Carbon::now('Asia/Jakarta')->format('Y-m-d')]);
 
        $Tindakan->update([
            'nama_tindakan' => $request->nama_tindakan,
            'petugas_yang_melaksanakan' => $request->petugas_yang_melaksanakan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'waktu_mulai_tindakan' => $time1->toTimeString(),
            'waktu_selesai_tindakan' => $time2->toTimeString(),
            'alat_medis_yang_digunakan' => $request->alat_medis_yang_digunakan,
            'BMHP' => $request->BMHP,
        ]);
        $Tindakan->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $Tindakan);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $Tindakan = Tindakan::find($request->id);

        if ($Tindakan == null) return null;

        return $Tindakan;
    }
}