<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function list()
    {
        try {
            $guru = Guru::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data guru', $guru);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $guru = Guru::find($id);
            if (!$guru) return api_failed('Data guru tidak ditemukan');
            return api_success('Berhasil mengambil data guru', $guru);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'nip' => 'required|unique:admin|unique:guru',
                'nama' => 'required|max:255',
                'email' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'no_hp' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'password' => 'required|min:8'
            ];

            $messages = [
                'nip.required' => 'NIP masih kosong',
                'nip.unique' => 'NIP sudah terdaftar',
                'nama.required' => 'Nama masih kosong',
                'email.required' => 'Email masih kosong',
                'email.unique' => 'Email sudah terdaftar',
                'no_hp.required' => 'No HP masih kosong',
                'no_hp.unique' => 'No HP sudah terdaftar',
                'password.required' => 'Password masih kosong',
                'password.min' => 'Password minimal 8 karakter',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            Guru::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
            ]);
            return api_success('Berhasil tambah data guru');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'nip' => 'required|unique:admin,nip,' . $id . '|unique:guru,nip,' . $id,
                'email' => 'required|max:255|unique:guru,email,' . $id . '|unique:murid,email,' . $id . '|unique:ortu,email,' . $id,
                'no_hp' => 'required|max:255|unique:guru,no_hp,' . $id . '|unique:murid,no_hp,' . $id . '|unique:ortu,no_hp,' . $id,
            ];
            $messages = [
                'nip.required' => 'NIP masih kosong',
                'nip.unique' => 'NIP sudah terdaftar',
                'email.required' => 'Email masih kosong',
                'email.unique' => 'Email sudah terdaftar',
                'no_hp.required' => 'No HP masih kosong',
                'no_hp.unique' => 'No HP sudah terdaftar',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $guru = Guru::find($id);
            if (!$guru) return api_failed('Data guru tidak ditemukan');
            $update = [
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ];
            if ($request->password) {
                $update['password'] = Hash::make($request->password);
            }
            $guru->update($update);
            return api_success('Berhasil ubah data guru');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $guru = Guru::find($request->id);
            if (!$guru) return api_failed('Data guru tidak ditemukan');
            $guru->active = !$guru->active;
            $guru->save();
            return api_success('Berhasil mengubah status guru');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $guru = Guru::find($id);
            if (!$guru) return api_failed('Data guru tidak ditemukan');
            $guru->delete();
            return api_success('Berhasil hapus data guru');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
