<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MuridController extends Controller
{
    public function list()
    {
        try {
            $murid = Murid::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data murid', $murid);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $murid = Murid::find($id);
            if (!$murid) return api_failed('Data murid tidak ditemukan');
            return api_success('Berhasil mengambil data murid', $murid);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'nis' => 'required|unique:murid',
                'nama' => 'required|max:255',
                'email' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'no_hp' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'password' => 'required|min:8'
            ];

            $messages = [
                'nis.required' => 'NIS masih kosong',
                'nis.unique' => 'NIS sudah terdaftar',
                'nama.required' => 'Nama masih kosong',
                'email.required' => 'Email masih kosong',
                'email.unique' => 'Email sudah terdaftar',
                'no_hp.required' => 'No HP masih kosong',
                'no_hp.unique' => 'No HP sudah terdaftar',
                'password.required' => 'Password masih kosong',
                'password.min' => 'Password minimal 8 karakter',
            ];

            if ($request->id_kelas) {
                $rules['id_kelas'] = 'required|exists:kelas,id';
                $messages['id_kelas.required'] = 'Kelas masih kosong';
                $messages['id_kelas.exists'] = 'Kelas tidak ditemukan';
            }

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $create = [
                'nis' => $request->nis,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
            ];
            if ($request->id_kelas) {
                $create['id_kelas'] = $request->id_kelas;
            }
            Murid::create($create);
            return api_success('Berhasil tambah data murid');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'nis' => 'required|unique:murid,nis,' . $request->id,
                'email' => 'required|max:255|unique:guru,email,' . $request->id . '|unique:murid,email,' . $request->id . '|unique:ortu,email,' . $request->id,
                'no_hp' => 'required|max:255|unique:guru,no_hp,' . $request->id . '|unique:murid,no_hp,' . $request->id . '|unique:ortu,no_hp,' . $request->id,
            ];
            $messages = [
                'nis.required' => 'NIS masih kosong',
                'nis.unique' => 'NIS sudah terdaftar',
                'email.required' => 'Email masih kosong',
                'email.unique' => 'Email sudah terdaftar',
                'no_hp.required' => 'No HP masih kosong',
                'no_hp.unique' => 'No HP sudah terdaftar',
            ];
            if ($request->id_kelas) {
                $rules['id_kelas'] = 'required|exists:kelas,id';
                $messages['id_kelas.required'] = 'Kelas masih kosong';
                $messages['id_kelas.exists'] = 'Kelas tidak ditemukan';
            }
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $murid = Murid::find($id);
            if (!$murid) return api_failed('Data murid tidak ditemukan');
            $update = [
                'nis' => $request->nis,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ];
            if ($request->id_kelas) {
                $update['id_kelas'] = $request->id_kelas;
            }
            if ($request->password) {
                $update['password'] = Hash::make($request->password);
            }
            $murid->update($update);
            return api_success('Berhasil ubah data murid');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $murid = Murid::find($request->id);
            if (!$murid) return api_failed('Data murid tidak ditemukan');
            $murid->active = !$murid->active;
            $murid->save();
            return api_success('Berhasil mengubah status murid');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $murid = Murid::find($id);
            if (!$murid) return api_failed('Data murid tidak ditemukan');
            $murid->delete();
            return api_success('Berhasil hapus data murid');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}