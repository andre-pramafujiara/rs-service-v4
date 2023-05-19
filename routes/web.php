<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Controller;
use App\Http\Controllers\PoliklinikController;
use Illuminate\Support\Facades\Route;
use Laravel\Lumen\Routing\Router;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'after'], function () use ($router) {
    $router->group(['prefix' => 'poliklinik'], function () use ($router) {
        $router->get('/',  [
            'as' => 'poliklinik.index', 'uses' => 'PoliklinikController@index'
        ]);

        $router->get('/list',  [
            'as' => 'poliklinik.list', 'uses' => 'PoliklinikController@list'
        ]);

        $router->get('/show',  [
            'as' => 'poliklinik.show', 'uses' => 'PoliklinikController@show', 'middleware' => 'api:poliklinik:show'
        ]);

        $router->post('/',  [
            'as' => 'poliklinik.store', 'uses' => 'PoliklinikController@store', 'middleware' => 'api:poliklinik:store,poliklinik:all'
        ]);

        $router->delete('/',  [
            'as' => 'poliklinik.destroy', 'uses' => 'PoliklinikController@destroy', 'middleware' => 'api:poliklinik:destroy'
        ]);

        $router->patch('/',  [
            'as' => 'poliklinik.update', 'uses' => 'PoliklinikController@update', 'middleware' => 'api:poliklinik:update'
        ]);

        $router->get('/search',  [
            'as' => 'poliklinik.search', 'uses' => 'PoliklinikController@search', 'middleware' => 'api:poliklinik:all'
        ]);
    });
    
    $router->group(['prefix' => 'pasien'], function () use ($router) {
        $router->get('/', [
            'as' => 'pasien.index', 'uses' => 'PasienController@index', 'middleware' => 'api:pasien:all'
        ]);

        $router->get('/show', [
            'as' => 'pasien.show', 'uses' => 'PasienController@show', 'middleware' => 'api:pasien:show'
        ]);

        $router->post('/', [
            'as' => 'pasien.store', 'uses' => 'PasienController@store', 'middleware' => 'api:pasien:store'
        ]);

        $router->delete('/', [
            'as' => 'pasien.destroy', 'uses' => 'PasienController@destroy', 'middleware' => 'api:pasien:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pasien.update', 'uses' => 'PasienController@update', 'middleware' => 'api:pasien:update'
        ]);

        $router->get('/search', [
            'as' => 'pasien.search', 'uses' => 'PasienController@search'
        ]);
    });

    $router->group(['prefix' => 'vclaim'], function () use ($router) {
        $router->post('/peserta/nik', [
            'as' => 'vclaim.peserta.nik', 'uses' => 'VclaimController@PesertaByNIK', 'middleware' => 'api:pasien:store'
        ]);
    });

    $router->group(['prefix' => 'triase'], function () use ($router) {
        $router->get('/', [
            'as' => 'triase.index', 'uses' => 'TriaseController@index', 'middleware' => 'api:triase:all'
        ]);

        $router->get('/show', [
            'as' => 'triase.show', 'uses' => 'TriaseController@show', 'middleware' => 'api:triase:show'
        ]);

        $router->post('/', [
            'as' => 'triase.store', 'uses' => 'TriaseController@store', 'middleware' => 'api:triase:store'
        ]);

        $router->delete('/', [
            'as' => 'triase.destroy', 'uses' => 'TriaseController@destroy', 'middleware' => 'api:triase:destroy'
        ]);

        $router->patch('/', [
            'as' => 'triase.update', 'uses' => 'TriaseController@update', 'middleware' => 'api:triase:update'
        ]);
    });

    $router->group(['prefix' => 'spesialis'], function() use($router){
        $router->get('/', [
            'as' => 'specialist.index', 'uses' => 'SpecialistController@index', 'middleware' => 'api:spesialis:all'
        ]);

        $router->get('/show', [
            'as' => 'specialist.show', 'uses' => 'SpecialistController@show', 'middleware' => 'api:spesialis:show'
        ]);

        $router->post('/', [
            'as' => 'specialist.store', 'uses' => 'SpecialistController@store', 'middleware' => 'api:spesialis:store'
        ]);

        $router->delete('/', [
            'as' => 'specialist.destroy', 'uses' => 'SpecialistController@destroy', 'middleware' => 'api:spesialis:destroy'
        ]);

        $router->patch('/', [
            'as' => 'specialist.update', 'uses' => 'SpecialistController@update', 'middleware' => 'api:spesialis:update'
        ]);
    });

    $router->group(['prefix' => 'laboratorium'], function() use($router){
        $router->get('/', [
            'as' => 'laboratorium.index', 'uses' => 'LaboratoriumController@index', 'middleware' => 'api:laboratorium:all'
        ]);

        $router->get('/show', [
            'as' => 'laboratorium.show', 'uses' => 'LaboratoriumController@show', 'middleware' => 'api:laboratorium:show'
        ]);

        $router->post('/', [
            'as' => 'laboratorium.store', 'uses' => 'LaboratoriumController@store', 'middleware' => 'api:laboratorium:store'
        ]);

        $router->delete('/', [
            'as' => 'laboratorium.destroy', 'uses' => 'LaboratoriumController@destroy', 'middleware' => 'api:laboratorium:destroy'
        ]);

        $router->patch('/', [
            'as' => 'laboratorium.update', 'uses' => 'LaboratoriumController@update', 'middleware' => 'api:laboratorium:update'
        ]);
        $router->get('/search', [
            'as' => 'laboratorium.search', 'uses' => 'LaboratoriumController@search', 'middleware' => 'api:laboratorium:all'
        ]);
    });
    
    $router->group(['prefix' => 'bangsal'], function() use($router){
        $router->get('/', [
            'as' => 'bangsal.index', 'uses' => 'BangsalController@index', 'middleware' => 'api:bangsal:all'
        ]);

        $router->get('/show', [
            'as' => 'bangsal.show', 'uses' => 'BangsalController@show', 'middleware' => 'api:bangsal:show'
        ]);

        $router->post('/', [
            'as' => 'bangsal.store', 'uses' => 'BangsalController@store', 'middleware' => 'api:bangsal:store'
        ]);

        $router->delete('/', [
            'as' => 'bangsal.destroy', 'uses' => 'BangsalController@destroy', 'middleware' => 'api:bangsal:destroy'
        ]);

        $router->patch('/', [
            'as' => 'bangsal.update', 'uses' => 'BangsalController@update', 'middleware' => 'api:bangsal:update'
        ]);
    });

    $router->group(['prefix' => 'kelaskamar'], function() use($router){
        $router->get('/', [
            'as' => 'kelaskamar.index', 'uses' => 'KelasKamarController@index', 'middleware' => 'api:kelaskamar:all'
        ]);

        $router->get('/show', [
            'as' => 'kelaskamar.show', 'uses' => 'KelasKamarController@show', 'middleware' => 'api:kelaskamar:show'
        ]);

        $router->post('/', [
            'as' => 'kelaskamar.store', 'uses' => 'KelasKamarController@store', 'middleware' => 'api:kelaskamar:store'
        ]);

        $router->delete('/', [
            'as' => 'kelaskamar.destroy', 'uses' => 'KelasKamarController@destroy', 'middleware' => 'api:kelaskamar:destroy'
        ]);

        $router->patch('/', [
            'as' => 'kelaskamar.update', 'uses' => 'KelasKamarController@update', 'middleware' => 'api:kelaskamar:update'
        ]);
    });

    $router->group(['prefix' => 'radiologi'], function() use($router){
        $router->get('/', [
            'as' => 'radiologi.index', 'uses' => 'RadiologiController@index', 'middleware' => 'api:radiologi:all'
        ]);

        $router->get('/show', [
            'as' => 'radiologi.show', 'uses' => 'RadiologiController@show', 'middleware' => 'api:radiologi:show'
        ]);

        $router->post('/', [
            'as' => 'radiologi.store', 'uses' => 'RadiologiController@store', 'middleware' => 'api:radiologi:store'
        ]);

        $router->delete('/', [
            'as' => 'radiologi.destroy', 'uses' => 'RadiologiController@destroy', 'middleware' => 'api:radiologi:destroy'
        ]);

        $router->patch('/', [
            'as' => 'radiologi.update', 'uses' => 'RadiologiController@update', 'middleware' => 'api:radiologi:update'
        ]);

        $router->get('/search', [
            'as' => 'radiologi.search', 'uses' => 'RadiologiController@search', 'middleware' => 'api:radiologi:all'
        ]);
    });
    
    $router->group(['prefix' => 'kamar'], function() use($router){
        $router->get('/', [
            'as' => 'kamar.index', 'uses' => 'KamarController@index', 'middleware' => 'api:kamar:all'
        ]);

        $router->get('/show', [
            'as' => 'kamar.show', 'uses' => 'KamarController@show', 'middleware' => 'api:kamar:show'
        ]);

        $router->post('/', [
            'as' => 'kamar.store', 'uses' => 'KamarController@store', 'middleware' => 'api:kamar:store'
        ]);

        $router->delete('/', [
            'as' => 'kamar.destroy', 'uses' => 'KamarController@destroy', 'middleware' => 'api:kamar:destroy'
        ]);

        $router->patch('/', [
            'as' => 'kamar.update', 'uses' => 'KamarController@update', 'middleware' => 'api:kamar:update'
        ]);
    });

    $router->group(['prefix' => 'agama'], function() use($router){
        $router->get('/', [
            'as' => 'agama.index', 'uses' => 'AgamaController@index', 'middleware' => 'api:agama:all'
        ]);

        $router->get('/list', [
            'as' => 'agama.list', 'uses' => 'AgamaController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'agama.show', 'uses' => 'AgamaController@show', 'middleware' => 'api:agama:show'
        ]);

        $router->post('/', [
            'as' => 'agama.store', 'uses' => 'AgamaController@store', 'middleware' => 'api:agama:store'
        ]);

        $router->delete('/', [
            'as' => 'agama.destroy', 'uses' => 'AgamaController@destroy', 'middleware' => 'api:agama:destroy'
        ]);

        $router->patch('/', [
            'as' => 'agama.update', 'uses' => 'AgamaController@update', 'middleware' => 'api:agama:update'
        ]);
    });

    $router->group(['prefix' => 'pendidikan'], function() use($router){
        $router->get('/', [
            'as' => 'pendidikan.index', 'uses' => 'PendidikanController@index', 'middleware' => 'api:pendidikan:all'
        ]);

        $router->get('/list', [
            'as' => 'pendidikan.list', 'uses' => 'PendidikanController@list', 'middleware' => 'api:pendidikan:all'
        ]);

        $router->get('/show', [
            'as' => 'pendidikan.show', 'uses' => 'PendidikanController@show', 'middleware' => 'api:pendidikan:show'
        ]);

        $router->post('/', [
            'as' => 'pendidikan.store', 'uses' => 'PendidikanController@store', 'middleware' => 'api:pendidikan:store'
        ]);

        $router->delete('/', [
            'as' => 'pendidikan.destroy', 'uses' => 'PendidikanController@destroy', 'middleware' => 'api:pendidikan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pendidikan.update', 'uses' => 'PendidikanController@update', 'middleware' => 'api:pendidikan:update'
        ]);
    });

    $router->group(['prefix' => 'penyakit'], function() use($router){
        $router->get('/', [
            'as' => 'penyakit.index', 'uses' => 'PenyakitController@index', 'middleware' => 'api:penyakit:all'
        ]);

        $router->get('/show', [
            'as' => 'penyakit.show', 'uses' => 'PenyakitController@show', 'middleware' => 'api:penyakit:show'
        ]);

        $router->post('/', [
            'as' => 'penyakit.store', 'uses' => 'PenyakitController@store', 'middleware' => 'api:penyakit:store'
        ]);

        $router->delete('/', [
            'as' => 'penyakit.destroy', 'uses' => 'PenyakitController@destroy', 'middleware' => 'api:penyakit:destroy'
        ]);

        $router->patch('/', [
            'as' => 'penyakit.update', 'uses' => 'PenyakitController@update', 'middleware' => 'api:penyakit:update'
        ]);
    });

    $router->group(['prefix' => 'unit'], function() use($router){
        $router->get('/', [
            'as' => 'unit.index', 'uses' => 'UnitController@index', 'middleware' => 'api:unit:all'
        ]);

        $router->get('/show', [
            'as' => 'unit.show', 'uses' => 'UnitController@show', 'middleware' => 'api:unit:show'
        ]);

        $router->post('/', [
            'as' => 'unit.store', 'uses' => 'UnitController@store', 'middleware' => 'api:unit:store'
        ]);

        $router->delete('/', [
            'as' => 'unit.destroy', 'uses' => 'UnitController@destroy', 'middleware' => 'api:unit:destroy'
        ]);

        $router->patch('/', [
            'as' => 'unit.update', 'uses' => 'UnitController@update', 'middleware' => 'api:unit:update'
        ]);
    });

    $router->group(['prefix' => 'supplier'], function() use($router){
        $router->get('/', [
            'as' => 'supplier.index', 'uses' => 'SupplierController@index', 'middleware' => 'api:supplier:all'
        ]);

        $router->get('/show', [
            'as' => 'supplier.show', 'uses' => 'SupplierController@show', 'middleware' => 'api:supplier:show'
        ]);

        $router->post('/', [
            'as' => 'supplier.store', 'uses' => 'SupplierController@store', 'middleware' => 'api:supplier:store'
        ]);

        $router->delete('/', [
            'as' => 'supplier.destroy', 'uses' => 'SupplierController@destroy', 'middleware' => 'api:supplier:destroy'
        ]);

        $router->patch('/', [
            'as' => 'supplier.update', 'uses' => 'SupplierController@update', 'middleware' => 'api:supplier:update'
        ]);
    });
    
    $router->group(['prefix' => 'pekerjaan'], function() use($router){
        $router->get('/', [
            'as' => 'pekerjaan.index', 'uses' => 'PekerjaanController@index', 'middleware' => 'api:pekerjaan:all'
        ]);

        $router->get('/list', [
            'as' => 'pekerjaan.list', 'uses' => 'PekerjaanController@list'
        ]);

        $router->get('/show', [
            'as' => 'pekerjaan.show', 'uses' => 'PekerjaanController@show', 'middleware' => 'api:pekerjaan:show'
        ]);

        $router->post('/', [
            'as' => 'pekerjaan.store', 'uses' => 'PekerjaanController@store', 'middleware' => 'api:pekerjaan:store'
        ]);

        $router->delete('/', [
            'as' => 'pekerjaan.destroy', 'uses' => 'PekerjaanController@destroy', 'middleware' => 'api:pekerjaan:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pekerjaan.update', 'uses' => 'PekerjaanController@update', 'middleware' => 'api:pekerjaan:update'
        ]);
    });

    $router->group(['prefix' => 'asuransi'], function() use($router){
        $router->get('/', [
            'as' => 'provinsi.index', 'uses' => 'AsuransiController@index', 'middleware' => 'api:asuransi:all'
        ]);

        $router->get('/show', [
            'as' => 'asuransi.show', 'uses' => 'AsuransiController@show', 'middleware' => 'api:asuransi:show'
        ]);

        $router->post('/', [
            'as' => 'asuransi.store', 'uses' => 'AsuransiController@store', 'middleware' => 'api:asuransi:store'
        ]);

        $router->delete('/', [
            'as' => 'asuransi.destroy', 'uses' => 'AsuransiController@destroy', 'middleware' => 'api:asuransi:destroy'
        ]);

        $router->patch('/', [
            'as' => 'asuransi.update', 'uses' => 'AsuransiController@update', 'middleware' => 'api:asuransi:update'
        ]);

        $router->get('/list', [
            'as' => 'asuransi.list', 'uses' => 'AsuransiController@list', 'middleware' => 'api:pasien:store'
        ]);
    });
    $router->group(['prefix' => 'suku'], function() use($router){
        $router->get('/', [
            'as' => 'suku.index', 'uses' => 'SukuController@index', 'middleware' => 'api:suku:all'
        ]);

        $router->get('/list', [
            'as' => 'suku.list', 'uses' => 'SukuController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'suku.show', 'uses' => 'SukuController@show', 'middleware' => 'api:suku:show'
        ]);

        $router->post('/', [
            'as' => 'suku.store', 'uses' => 'SukuController@store', 'middleware' => 'api:suku:store'
        ]);

        $router->delete('/', [
            'as' => 'suku.destroy', 'uses' => 'SukuController@destroy', 'middleware' => 'api:suku:destroy'
        ]);

        $router->patch('/', [
            'as' => 'suku.update', 'uses' => 'SukuController@update', 'middleware' => 'api:suku:update'
        ]);
    });
    $router->group(['prefix' => 'bahasa'], function() use($router){
        $router->get('/', [
            'as' => 'bahasa.index', 'uses' => 'BahasaController@index', 'middleware' => 'api:bahasa:all'
        ]);

        $router->get('/list', [
            'as' => 'bahasa.list', 'uses' => 'BahasaController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'bahasa.show', 'uses' => 'BahasaController@show', 'middleware' => 'api:bahasa:show'
        ]);

        $router->post('/', [
            'as' => 'bahasa.store', 'uses' => 'BahasaController@store', 'middleware' => 'api:bahasa:store'
        ]);

        $router->delete('/', [
            'as' => 'bahasa.destroy', 'uses' => 'BahasaController@destroy', 'middleware' => 'api:bahasa:destroy'
        ]);

        $router->patch('/', [
            'as' => 'bahasa.update', 'uses' => 'BahasaController@update', 'middleware' => 'api:bahasa:update'
        ]);
    });


    $router->group(['prefix' => 'temp'], function() use ($router) {
        $router->get('/dokter/list', [
            'as' => 'temp.dokter.list', 'uses' => 'TempDokterController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/search/pasien/no-rm', [
            'as' => 'temp.pasien.search', 'uses' => 'PasienController@tempSearchByNoRM', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/kamar/list', [
            'as' => 'temp.kamar.list', 'uses' => 'KamarController@tempKamarList', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/kelas/list', [
            'as' => 'temp.kelas.list', 'uses' => 'KamarController@tempKelasList', 'middleware' => 'api:pasien:store'
        ]);
    });

    $router->group(['prefix' => 'rawat'], function() use ($router) {
        $router->get('/jalan', [
            'as' => 'temp.rawat.jalan.index', 'uses' => 'RawatJalanController@index', 'middleware' => 'api:pasien:store'
        ]);
        $router->get('/jalan/list', [
            'as' => 'temp.rawat.jalan.list', 'uses' => 'RawatJalanController@list', 'middleware' => 'api:pasien:store'
        ]);
        $router->post('/jalan', [
            'as' => 'temp.rawat.jalan.store', 'uses' => 'RawatJalanController@store', 'middleware' => 'api:pasien:store'
        ]);
        $router->get('/inap', [
            'as' => 'temp.rawat.inap.index', 'uses' => 'RawatInapController@index', 'middleware' => 'api:pasien:store'
        ]);
        $router->post('/inap', [
            'as' => 'temp.rawat.inap.store', 'uses' => 'RawatInapController@store', 'middleware' => 'api:pasien:store'
        ]);
    });

    $router->group(['prefix' => 'ugd'], function() use ($router) {
        $router->get('/', [
            'as' => 'temp.ugd.index', 'uses' => 'RawatJalanController@index', 'middleware' => 'api:pasien:store'
        ]);
        $router->get('/list', [
            'as' => 'temp.ugd.list', 'uses' => 'RawatJalanController@list', 'middleware' => 'api:pasien:store'
        ]);
        $router->post('/', [
            'as' => 'temp.ugd.store', 'uses' => 'RawatJalanController@store', 'middleware' => 'api:pasien:store'
        ]);
        $router->get('/inap', [
            'as' => 'temp.ugd.inap.index', 'uses' => 'RawatInapController@index', 'middleware' => 'api:pasien:store'
        ]);
        $router->post('/inap', [
            'as' => 'temp.rawat.inap.store', 'uses' => 'RawatInapController@store', 'middleware' => 'api:pasien:store'
        ]);
    });

    $router->group(['prefix' => 'ugd'], function() use($router){
        $router->get('/', [
            'as' => 'ugd.index', 'uses' => 'UgdController@index', 'middleware' => 'api:ugd:all'
        ]);

        $router->get('/list', [
            'as' => 'ugd.list', 'uses' => 'UgdController@list', 'middleware' => 'api:pasien:store'
        ]);

        $router->get('/show', [
            'as' => 'ugd.show', 'uses' => 'UgdController@show', 'middleware' => 'api:ugd:show'
        ]);

        $router->post('/', [
            'as' => 'ugd.store', 'uses' => 'UgdController@store', 'middleware' => 'api:ugd:store'
        ]);

        $router->delete('/', [
            'as' => 'ugd.destroy', 'uses' => 'UgdController@destroy', 'middleware' => 'api:ugd:destroy'
        ]);

        $router->patch('/', [
            'as' => 'ugd.update', 'uses' => 'UgdController@update', 'middleware' => 'api:ugd:update'
        ]);
    });

    $router->group(['prefix' => 'penanggungjawab'], function() use($router){
        $router->get('/', [
            'as' => 'penanggungjawab.index', 'uses' => 'PenanggungjawabController@index', 'middleware' => 'api:penanggungjawab:all'
        ]);

        $router->get('/list', [
            'as' => 'penanggungjawab.list', 'uses' => 'PenanggungjawabController@list', 'middleware' => 'api:penanggungjawab:store'
        ]);

        $router->get('/show', [
            'as' => 'penanggungjawab.show', 'uses' => 'PenanggungjawabController@show', 'middleware' => 'api:penanggungjawab:show'
        ]);

        $router->post('/', [
            'as' => 'penanggungjawab.store', 'uses' => 'PenanggungjawabController@store', 'middleware' => 'api:penanggungjawab:store'
        ]);

        $router->delete('/', [
            'as' => 'penanggungjawab.destroy', 'uses' => 'PenanggungjawabController@destroy', 'middleware' => 'api:penanggungjawab:destroy'
        ]);

        $router->patch('/', [
            'as' => 'penanggungjawab.update', 'uses' => 'PenanggungjawabController@update', 'middleware' => 'api:penanggungjawab:update'
        ]);
    });

    $router->group(['prefix' => 'pengantar'], function() use($router){
        $router->get('/', [
            'as' => 'pengantar.index', 'uses' => 'PengantarController@index', 'middleware' => 'api:pengantar:all'
        ]);

        $router->get('/list', [
            'as' => 'pengantar.list', 'uses' => 'PengantarController@list', 'middleware' => 'api:pengantar:store'
        ]);

        $router->get('/show', [
            'as' => 'pengantar.show', 'uses' => 'PengantarController@show', 'middleware' => 'api:pengantar:show'
        ]);

        $router->post('/', [
            'as' => 'pengantar.store', 'uses' => 'PengantarController@store', 'middleware' => 'api:pengantar:store'
        ]);

        $router->delete('/', [
            'as' => 'pengantar.destroy', 'uses' => 'PengantarController@destroy', 'middleware' => 'api:pengantar:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pengantar.update', 'uses' => 'PengantarController@update', 'middleware' => 'api:pengantar:update'
        ]);
    });

    $router->group(['prefix' => 'bbl'], function() use($router){
        $router->get('/', [
            'as' => 'bbl.index', 'uses' => 'BblController@index', 'middleware' => 'api:bbl:all'
        ]);

        $router->get('/list', [
            'as' => 'bbl.list', 'uses' => 'BblController@list', 'middleware' => 'api:bbl:store'
        ]);

        $router->get('/show', [
            'as' => 'bbl.show', 'uses' => 'BblController@show', 'middleware' => 'api:bbl:show'
        ]);

        $router->post('/', [
            'as' => 'bbl.store', 'uses' => 'BblController@store', 'middleware' => 'api:bbl:store'
        ]);

        $router->delete('/', [
            'as' => 'bbl.destroy', 'uses' => 'BblController@destroy', 'middleware' => 'api:bbl:destroy'
        ]);

        $router->patch('/', [
            'as' => 'bbl.update', 'uses' => 'BblController@update', 'middleware' => 'api:bbl:update'
        ]);
    });

    $router->group(['prefix' => 'pasienb'], function() use($router){
        $router->get('/', [
            'as' => 'pasienb.index', 'uses' => 'PasienbController@index', 'middleware' => 'api:pasienb:all'
        ]);

        $router->get('/list', [
            'as' => 'pasienb.list', 'uses' => 'PasienbController@list', 'middleware' => 'api:pasienb:store'
        ]);

        $router->get('/show', [
            'as' => 'pasienb.show', 'uses' => 'PasienbController@show', 'middleware' => 'api:pasienb:show'
        ]);

        $router->post('/', [
            'as' => 'pasienb.store', 'uses' => 'PasienbController@store', 'middleware' => 'api:pasienb:store'
        ]);

        $router->delete('/', [
            'as' => 'pasienb.destroy', 'uses' => 'PasienbController@destroy', 'middleware' => 'api:pasienb:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pasienb.update', 'uses' => 'PasienbController@update', 'middleware' => 'api:pasienb:update'
        ]);
    });

    $router->group(['prefix' => 'antrian'], function() use($router){
        $router->get('/', [
            'as' => 'antrian.index', 'uses' => 'AntrianUgdController@index', 'middleware' => 'api:antrianugd:all'
        ]);

        $router->get('/list', [
            'as' => 'antrian.ambilantrian', 'uses' => 'AntrianUgdController@list', 'middleware' => 'api:antrianugd:store'
        ]);

        $router->get('/list', [
            'as' => 'antrian.bukaantrian', 'uses' => 'AntrianUgdController@list', 'middleware' => 'api:antrianugd:store'
        ]);

        $router->get('/show', [
            'as' => 'pasienb.show', 'uses' => 'PasienbController@show', 'middleware' => 'api:pasienb:show'
        ]);

        $router->post('/', [
            'as' => 'pasienb.store', 'uses' => 'PasienbController@store', 'middleware' => 'api:pasienb:store'
        ]);

        $router->delete('/', [
            'as' => 'pasienb.destroy', 'uses' => 'PasienbController@destroy', 'middleware' => 'api:pasienb:destroy'
        ]);

        $router->patch('/', [
            'as' => 'pasienb.update', 'uses' => 'PasienbController@update', 'middleware' => 'api:pasienb:update'
        ]);
    });
    
});
