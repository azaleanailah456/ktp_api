<?php

namespace App\Http\Controllers;

use App\Models\Ktp;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class KtpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        $limit = $request->limit;
        $ktp = Ktp::where('nama', 'LIKE', '%' .$search. '%')->limit($limit)->get();

        if ($ktp) {
            return ApiFormatter::createAPI(200, 'succes', $ktp);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|min:3',
                'nik' => 'required|numeric',
                'JK' => 'required',
                'AK' => 'required|numeric',
                'alamat' => 'required',
                'status' => 'required',
                'tanggal_lahir' => 'required',
            ]);

            $ktp = Ktp::create([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'JK' => $request->JK,
                'AK' => $request->AK,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'tanggal_lahir' => \Carbon\Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
            ]);
            $hasilTambahData = Ktp::where('id', $ktp->id)->first();
            if ($hasilTambahData) {
                return ApiFormatter::createAPI(200, 'succes', $ktp);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch(Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $ktp = Ktp::find($id);
            if ($ktp) {
                return ApiFormatter::createAPI(200, 'succes', $ktp);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ktp $Ktp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try { 
            $request->validate([
                'nama' => 'required|min:3',
                'nik' => 'required|numeric',
                'JK' => 'required',
                'AK' => 'required|numeric',
                'alamat' => 'required',
                'status' => 'required',
                'tanggal_lahir' => 'required',
            ]);
            $ktp = Ktp::find($id);
            
            $ktp->update([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'JK' => $request->JK,
                'AK' => $request->AK,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'tanggal_lahir' => \Carbon\Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
            ]);
            $dataTerbaru =  Ktp::where('id', $ktp->id)->first();
            if ($dataTerbaru) {
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $ktp = Ktp::find($id);

            $cekBerhasil = $ktp->delete();
            if ($cekBerhasil) {
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $ktp = Ktp::onlyTrashed()->get();

            if ($ktp) {
                return ApiFormatter::createAPI(200, 'success', $ktp);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $ktp = Ktp::onlyTrashed()->where('id', $id);

            $ktp->restore();
            $dataKembali = Ktp::where('id', $id)->first();
            if ($dataKembali
            ) {
                return ApiFormatter::createAPI(200, 'success', $dataKembali);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $ktp = Ktp::onlyTrashed()->where('id', $id);

            $proses = $ktp->forceDelete();
                return ApiFormatter::createAPI(200, 'success', 'Berhasil hapus permanent!');
        }catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}
