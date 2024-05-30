<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function list()
    {
        try {
            $admin = Admin::orderBy('id', 'DESC')->get();
            return api_success('Berhasil mengambil data admin', $admin);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function get(Request $request)
    {
        try {
            $id = $request->route('id');
            $admin = Admin::find($id);
            if (!$admin) return api_failed('Data admin tidak ditemukan');
            return api_success('Berhasil mengambil data admin', $admin);
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
            Admin::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
            ]);
            return api_success('Berhasil tambah data admin');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->route('id');
            $rules = [
                'nip' => 'required|unique:admin,nip,' . $request->id . '|unique:guru,nip,' . $request->id,
                'email' => 'required|max:255|unique:guru,email,' . $request->id . '|unique:murid,email,' . $request->id . '|unique:ortu,email,' . $request->id,
                'no_hp' => 'required|max:255|unique:guru,no_hp,' . $request->id . '|unique:murid,no_hp,' . $request->id . '|unique:ortu,no_hp,' . $request->id,
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
            $admin = Admin::find($id);
            if (!$admin) return api_failed('Data admin tidak ditemukan');
            $update = [
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ];
            if ($request->password) {
                $update['password'] = Hash::make($request->password);
            }
            $admin->update($update);
            return api_success('Berhasil ubah data admin');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function inactive(Request $request)
    {
        try {
            $id = $request->route('id');
            $admin = Admin::find($request->id);
            if (!$admin) return api_failed('Data admin tidak ditemukan');
            $admin->active = !$admin->active;
            $admin->save();
            return api_success('Berhasil mengubah status admin');
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $admin = Admin::find($id);
            if (!$admin) return api_failed('Data admin tidak ditemukan');
            $admin->delete();
            return api_success('Berhasil hapus data admin');
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
