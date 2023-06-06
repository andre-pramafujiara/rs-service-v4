<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tindakan;
use App\Http\Helper;
use App\Models\MembuatPernyataan;
use Carbon\Carbon;

class MembuatpernyataanController extends Controller
{
    use Helper;

    public function index()
    {
        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], MembuatPernyataan::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'dokter_memberi_penjelasan' => 'required|string|max:255',
            'pasien_keluarga_menerima' => 'required|string|max:255',
            'saksi_1' => 'required|string|max:255',
            'saksi_2' => 'required|string|max:255',
        ]);

        $membuatpernyataan = MembuatPernyataan::create([
            'id' => $request->id,
            'dokter_memberi_penjelasan' => $request->dokter_memberi_penjelasan,
            'pasien_keluarga_menerima' => $request->pasien_keluarga_menerima,
            'saksi_1' => $request->saksi_1,
            'saksi_2' => $request->saksi_2,

        ]);

        return $this->responseFormatter($this->httpCode['StatusCreated'], $this->httpMessage['StatusCreated'], $membuatpernyataan);
    }

    public function destroy(Request $request)
    {
        $membuatpernyataan = $this->getData($request);

        if ($membuatpernyataan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $membuatpernyataan->delete();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], ["deleted_at" => $membuatpernyataan->deleted_at]);
    }

    public function show(Request $request)
    {
        $membuatpernyataan = $this->getData($request);

        if ($membuatpernyataan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $membuatpernyataan);
    }

    public function update(Request $request)
    {
        $membuatpernyataan = $this->getData($request);
        $this->validate($request, [
            'id' => 'required|integer',
            'dokter_memberi_penjelasan' => 'required|string|max:255',
            'pasien_keluarga_menerima' => 'required|string|max:255',
            'saksi_1' => 'required|string|max:255',
            'saksi_2' => 'required|string|max:255',
           
        ]);

        if ($membuatpernyataan == null) return $this->errorResponseFormatter($this->httpCode['StatusUnprocessableEntity'], "Data Not Found");

        $membuatpernyataan->update([
            'id' => $request->id,
            'dokter_memberi_penjelasan' => $request->dokter_memberi_penjelasan,
            'pasien_keluarga_menerima' => $request->pasien_keluarga_menerima,
            'saksi_1' => $request->saksi_1,
            'saksi_2' => $request->saksi_2,
        ]);
        $membuatpernyataan->save();

        return $this->responseFormatter($this->httpCode['StatusOK'], $this->httpMessage['StatusOK'], $membuatpernyataan);
    }

    protected function getData($request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
        ]);

        $membuatpernyataan = MembuatPernyataan::find($request->id);

        if ($membuatpernyataan == null) return null;

        return $membuatpernyataan;
    }
}