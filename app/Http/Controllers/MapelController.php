<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use Exception;
use Illuminate\Support\Facades\Validator;

class MapelController extends Controller
{
    public function list()
    {
        try {
            $mapel = Mapel::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data mapel', $mapel);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $mapel = Mapel::find($id);
            if (!$mapel) return api_failed('Data mapel tidak ditemukan');
            return api_success('Berhasil mengambil data mapel', $mapel);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'nama' => 'required|max:255|unique:mapel',
                'jam_masuk' => 'required',
                'jam_keluar' => 'required',
                'deskripsi' => 'max:255',
            ];
            $messages = [
                'nama.required' => 'Mapel masih kosong',
                'nama.unique' => 'Mapel sudah ada',
                'jam_masuk.required' => 'Jam masuk masih kosong',
                'jam_keluar.required' => 'Jam keluar masih kosong',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            Mapel::create([
                'nama' => $request->nama,
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
                'deskripsi' => $request->deskripsi,
            ]);
            return api_success('Berhasil tambah data mapel');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'nama' => 'required|max:255|unique:mapel,nama,' . $id,
                'jam_masuk' => 'required',
                'jam_keluar' => 'required',
                'deskripsi' => 'max:255',
            ];
            $messages = [
                'nama.required' => 'Mapel masih kosong',
                'nama.unique' => 'Mapel sudah ada',
                'jam_masuk.required' => 'Jam masuk masih kosong',
                'jam_keluar.required' => 'Jam keluar masih kosong',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $mapel = Mapel::find($id);
            if (!$mapel) return api_failed('Data mapel tidak ditemukan');
            $update = [
                'nama' => $request->nama,
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
                'deskripsi' => $request->deskripsi,
            ];
            $mapel->update($update);
            return api_success('Berhasil ubah data mapel');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $mapel = Mapel::find($request->id);
            if (!$mapel) return api_failed('Data mapel tidak ditemukan');
            $mapel->active = !$mapel->active;
            $mapel->save();
            return api_success('Berhasil mengubah status mapel');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $mapel = Mapel::find($id);
            if (!$mapel) return api_failed('Data mapel tidak ditemukan');
            $mapel->delete();
            return api_success('Berhasil hapus data mapel');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
