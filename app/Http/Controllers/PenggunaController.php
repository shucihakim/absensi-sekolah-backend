<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Murid;
use App\Models\Ortu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    public function list()
    {
        try {
            $admin = Admin::orderBy('id', 'DESC')->get();
            $admin->each(function ($item) {
                $item->role = 'admin';
                $item->identity = $item->nip;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $guru = Guru::orderBy('id', 'DESC')->get();
            $guru->each(function ($item) {
                $item->role = 'guru';
                $item->identity = $item->nip;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $murid = Murid::orderBy('id', 'DESC')->get();
            $murid->each(function ($item) {
                $item->role = 'murid';
                $item->identity = $item->nis;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $ortu = Ortu::orderBy('id', 'DESC')->get();
            $ortu->each(function ($item) {
                $item->role = 'ortu';
                $item->identity = $item->no_hp;
                $item->imageUrl = $item->gambar ?  profilePath($item->gambar) : textAvatar($item->nama);
            });
            $data = array_merge($admin->toArray(), $guru->toArray(), $murid->toArray(), $ortu->toArray());
            usort($data, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
            return api_success('Berhasil mengambil data pengguna', $data);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                'role' => 'required|in:admin,guru,murid,ortu',
                'nama' => 'required|max:255',
                'email' => 'required|email|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'no_hp' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'password' => 'required|confirmed|min:8'
            ];

            $messages = [
                'role.required' => 'Akses akun harus diisi',
                'nama.required' => 'Nama masih kosong',
                'email.required' => 'Email masih kosong',
                'email.unique' => 'Email sudah terdaftar',
                'email.email' => 'Alamat email tidak valid',
                'no_hp.required' => 'No HP masih kosong',
                'no_hp.unique' => 'No HP sudah terdaftar',
                'password.required' => 'Password masih kosong',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sama.',
            ];

            if ($request->role == 'admin') {
                $rules['nip'] = 'required|max:255|unique:admin|unique:guru';
                $messages['nip.required'] = 'NIP masih kosong';
                $messages['nip.unique'] = 'NIP sudah terdaftar';
            } else if ($request->role == 'guru') {
                $rules['nip'] = 'required|max:255|unique:admin|unique:guru';
                $messages['nip.required'] = 'NIP masih kosong';
                $messages['nip.unique'] = 'NIP sudah terdaftar';
            } else if ($request->role == 'murid') {
                $rules['nis'] = 'required|max:255|unique:murid';
                $messages['nis.required'] = 'NIS masih kosong';
                $messages['nis.unique'] = 'NIS sudah terdaftar';
            }

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }

            switch ($request->role) {
                case 'admin':
                    $user = Admin::create([
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'password' => Hash::make($request->password),
                    ]);
                    break;

                case 'guru':
                    $user = Guru::create([
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'verified' => 1,
                        'password' => Hash::make($request->password),
                    ]);
                    break;

                case 'murid':
                    $user = Murid::create([
                        'nis' => $request->nis,
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'verified' => 1,
                        'password' => Hash::make($request->password),
                    ]);
                    break;

                case 'ortu':
                    $user = Ortu::create([
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'verified' => 1,
                        'password' => Hash::make($request->password),
                    ]);
                    break;

                default:
                    # code...
                    break;
            }

            return api_success('Berhasil menambahkan pengguna.', $user);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function update(Request $request) {
        try {
            $token_data = (object) $request->tokenData;
            $id = $token_data->id;
            $rules = [
                'nama' => 'required|max:255',
                'email' => 'required|max:255|unique:guru,email,' . $id . '|unique:murid,email,' . $id . '|unique:ortu,email,' . $id,
                'no_hp' => 'required|max:255|unique:guru,no_hp,' . $id . '|unique:murid,no_hp,' . $id . '|unique:ortu,no_hp,' . $id,
            ];
            $messages = [
                'nama.required' => 'Nama masih kosong',
                'email.required' => 'Email masih kosong',
                'email.unique' => 'Email sudah terdaftar',
                'no_hp.required' => 'No HP masih kosong',
                'no_hp.unique' => 'No HP sudah terdaftar',
            ];

            if ($request->role == 'admin') {
                $rules['nip'] = 'required|max:255|unique:guru,nip,' . $id . '|unique:admin,nip,' . $id;
                $messages['nip.required'] = 'NIP masih kosong';
                $messages['nip.unique'] = 'NIP sudah terdaftar';
            } else if ($request->role == 'guru') {
                $rules['nip'] = 'required|max:255|unique:guru,nip,' . $id . '|unique:admin,nip,' . $id;
                $messages['nip.required'] = 'NIP masih kosong';
                $messages['nip.unique'] = 'NIP sudah terdaftar';
            } else if ($request->role == 'murid') {
                $rules['nis'] = 'required|max:255|unique:murid,nis,' . $id;
                $messages['nis.required'] = 'NIS masih kosong';
                $messages['nis.unique'] = 'NIS sudah terdaftar';
            }


            if ($request->password) {
                $rules['password'] = 'required|confirmed|min:8';
                $messages['password.required'] = 'Password masih kosong';
                $messages['password.min'] = 'Password minimal 8 karakter';
                $messages['password.confirmed'] = 'Konfirmasi password tidak sama.';
            }

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }

            $user = null;
            if ($token_data->type == 'admin') {
                $user = Admin::find($id);
            } else if ($token_data->type == 'guru') {
                $user = Guru::find($id);
            } else if ($token_data->type == 'murid') {
                $user = Murid::find($id);
            } else if ($token_data->type == 'ortu') {
                $user = Ortu::find($id);
            }

            if (!$user) return api_failed('Data pengguna tidak ditemukan');

            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $user->type = $token_data->type;
            $user->gambar = $user->gambar ? profilePath($user->gambar) : textAvatar($user->nama);

            return api_success('Berhasil mengubah data pengguna', $user);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function upload_picture(Request $request)
    {
        try {
            $data = $request->all();
            $rules = [
                'file' => 'required|image',
            ];
            $messages = [
                'file.required' => 'Form file tidak boleh kosong.',
                'file.image' => 'Hanya bisa upload gambar.',
            ];
            Validator::make($data, $rules, $messages)->validate();

            $token_data = (object) $request->tokenData;
            if ($token_data->type == 'admin') {
                $user = Admin::find($token_data->id);
            } else if ($token_data->type == 'guru') {
                $user = Guru::find($token_data->id);
            } else if ($token_data->type == 'murid') {
                $user = Murid::find($token_data->id);
            } else if ($token_data->type == 'ortu') {
                $user = Ortu::find($token_data->id);
            } else {
                return api_failed('Role tidak ditemukan');
            }

            $file = $request->file('file');
            $target_upload = 'profiles';
            $filename = Str::uuid() . "." . $file->getClientOriginalExtension();
            $file->move($target_upload, $filename);

            if ($user->gambar) {
                File::delete($target_upload . '/' . $user->gambar);
            }

            $user->gambar = $filename;
            $user->save();

            $data = [
                'filename' => $filename,
                'image' => profilePath($filename),
                'mimetype' => $file->getClientMimeType(),
            ];

            return api_success('Berhasil mengubah gambar', $data);
        } catch (ValidationException $e) {
            return api_failed($e->getMessage());
        } catch (\Exception $e) {
            return api_error($e);
        }
    }

    public function delete_picture(Request $request) {
        try {
            $token_data = (object) $request->tokenData;
            if ($token_data->type == 'admin') {
                $user = Admin::find($token_data->id);
            } else if ($token_data->type == 'guru') {
                $user = Guru::find($token_data->id);
            } else if ($token_data->type == 'murid') {
                $user = Murid::find($token_data->id);
            } else if ($token_data->type == 'ortu') {
                $user = Ortu::find($token_data->id);
            } else {
                return api_failed('Role tidak ditemukan');
            }

            if ($user->gambar) {
                File::delete('profiles/' . $user->gambar);
                $user->gambar = null;
                $user->save();
            }

            $data = [
                'image' => textAvatar($user->nama),
            ];

            return api_success('Berhasil menghapus gambar', $data);
        } catch (Exception $e) {
            return api_error($e);
        }
    }
}
