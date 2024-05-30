<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ortu;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrtuController extends Controller
{
    public function list()
    {
        try {
            $ortu = Ortu::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data ortu', $ortu);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $ortu = Ortu::find($id);
            if (!$ortu) return api_failed('Data ortu tidak ditemukan');
            return api_success('Berhasil mengambil data ortu', $ortu);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'nama' => 'required|max:255',
                'email' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'no_hp' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'password' => 'required|min:8'
            ];

            $messages = [
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
            Ortu::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
            ]);
            return api_success('Berhasil tambah data ortu');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'email' => 'required|max:255|unique:guru,email,' . $request->id . '|unique:murid,email,' . $request->id . '|unique:ortu,email,' . $request->id,
                'no_hp' => 'required|max:255|unique:guru,no_hp,' . $request->id . '|unique:murid,no_hp,' . $request->id . '|unique:ortu,no_hp,' . $request->id,
            ];
            $messages = [
                'email.required' => 'Email masih kosong',
                'email.unique' => 'Email sudah terdaftar',
                'no_hp.required' => 'No HP masih kosong',
                'no_hp.unique' => 'No HP sudah terdaftar',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }
            $ortu = Ortu::find($id);
            if (!$ortu) return api_failed('Data ortu tidak ditemukan');
            $update = [
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ];
            if ($request->password) {
                $update['password'] = Hash::make($request->password);
            }
            $ortu->update($update);
            return api_success('Berhasil ubah data ortu');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $ortu = Ortu::find($request->id);
            if (!$ortu) return api_failed('Data ortu tidak ditemukan');
            $ortu->active = !$ortu->active;
            $ortu->save();
            return api_success('Berhasil mengubah status ortu');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $ortu = Ortu::find($id);
            if (!$ortu) return api_failed('Data ortu tidak ditemukan');
            $ortu->delete();
            return api_success('Berhasil hapus data ortu');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
