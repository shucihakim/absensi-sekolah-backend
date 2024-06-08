<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function detail_sekolah()
    {
        try {
            $sekolah = Sekolah::first();
            return api_success('Berhasil mengambil data sekolah', $sekolah);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update_sekolah(Request $request)
    {
        try {
            $rules = [
                'nama' => 'required',
                'deskripsi' => 'required',
                'id_semester_aktif' => 'required',
                'garis_lintang' => 'required',
                'garis_bujur' => 'required',
                'alamat' => 'required',
            ];

            $messages = [
                'nama.required' => 'Nama sekolah masih kosong',
                'deskripsi.required' => 'Deskripsi masih kosong',
                'id_semester_aktif.required' => 'Semester aktif masih kosong',
                'garis_lintang.required' => 'Alamat masih kosong (1)',
                'garis_bujur.required' => 'Alamat masih kosong (2)',
                'alamat.required' => 'Alamat masih kosong (3)',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $sekolah = Sekolah::first();
            if ($sekolah) {
                $sekolah->update([
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'id_semester_aktif' => $request->id_semester_aktif,
                ]);
            } else {
                Sekolah::create([
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'id_semester_aktif' => $request->id_semester_aktif,
                ]);
            }
            return api_success('Berhasil mengubah data sekolah', $sekolah);
        } catch (Exception $e) {
            return api_error($e);
        }
    }
    
    public function update_lokasi(Request $request)
    {
        try {
            $rules = [
                'garis_lintang' => 'required',
                'garis_bujur' => 'required',
                'alamat' => 'required',
                'jarak' => 'required',
            ];

            $messages = [
                'garis_lintang.required' => 'Alamat masih kosong (1)',
                'garis_bujur.required' => 'Alamat masih kosong (2)',
                'alamat.required' => 'Alamat masih kosong (3)',
                'jarak.required' => 'Alamat masih kosong (4)',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $sekolah = Sekolah::first();
            if ($sekolah) {
                $sekolah->update([
                    'garis_lintang' => $request->garis_lintang,
                    'garis_bujur' => $request->garis_bujur,
                    'alamat' => $request->alamat,
                    'jarak' => $request->jarak,
                ]);
            } else {
                Sekolah::create([
                    'nama' => "",
                    'deskripsi' => "",
                    'id_semester_aktif' => 0,
                    'garis_lintang' => $request->garis_lintang,
                    'garis_bujur' => $request->garis_bujur,
                    'alamat' => $request->alamat,
                    'jarak' => $request->jarak,
                ]);
            }
            return api_success('Berhasil mengubah data sekolah', $sekolah);
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
