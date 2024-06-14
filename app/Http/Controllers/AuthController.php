<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Murid;
use App\Models\Ortu;

use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $rules = [
                'type' => 'required|in:admin,guru,murid,ortu',
                'nama' => 'required|max:255',
                'email' => 'required|email|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'no_hp' => 'required|max:255|unique:admin|unique:guru|unique:murid|unique:ortu',
                'password' => 'required|confirmed|min:8'
            ];

            $messages = [
                'type.required' => 'Akses akun harus diisi',
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

            if ($request->type == 'admin') {
                $rules['nip'] = 'required|max:255|unique:admin|unique:guru';
                $messages['nip.required'] = 'NIP masih kosong';
                $messages['nip.unique'] = 'NIP sudah terdaftar';
            } else if ($request->type == 'guru') {
                $rules['nip'] = 'required|max:255|unique:admin|unique:guru';
                $messages['nip.required'] = 'NIP masih kosong';
                $messages['nip.unique'] = 'NIP sudah terdaftar';
            } else if ($request->type == 'murid') {
                $rules['nis'] = 'required|max:255|unique:murid';
                $messages['nis.required'] = 'NIS masih kosong';
                $messages['nis.unique'] = 'NIS sudah terdaftar';
            }

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }

            $token = generateJWT([
                'name' => $request->nama,
                'email' => $request->email,
                'type' => $request->type,
            ]);
            $mailable = new Mailable();
            $mailable
                ->from(env('MAIL_FROM_ADDRESS', 'verify@sman12-luwu.my.id'))
                ->to($request->email)
                ->subject('Verifikasi Register')
                ->html('
                <h1>Verifikasi Register</h1>
                <p>Halo <b>' . $request->nama . '</b>! Silahkan klik link berikut untuk verifikasi akun anda</p>
                <a href="' . route('auth.verify', ['token' => $token]) . '">Verifikasi</a>
            ');
            $result = Mail::send($mailable);

            if (!$result) return api_failed('Gagal mengirim email verifikasi', ['email' => $request->email]);

            switch ($request->type) {
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
                        'password' => Hash::make($request->password),
                    ]);
                    break;

                case 'murid':
                    $user = Murid::create([
                        'nis' => $request->nis,
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'password' => Hash::make($request->password),
                    ]);
                    break;

                case 'ortu':
                    $user = Ortu::create([
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'password' => Hash::make($request->password),
                    ]);
                    break;

                default:
                    # code...
                    break;
            }

            return api_success('Berhasil register, silahkan cek email untuk verifikasi, dan juga cek folder spam jika tidak masuk di inbox', $user);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function login(Request $request)
    {
        try {
            $rules = [
                'account' => 'required',
                'password' => 'required'
            ];

            $messages = [
                'account.required' => 'Mohon isi identitas akun anda',
                'password.required' => 'Password masih kosong',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return api_failed($validator->errors()->first());
            }

            $account = $request->input('account');

            $admin = Admin::where('nip', $account)
                ->orWhere('email', $account)
                ->orWhere('no_hp', $account)
                ->first();
            if ($admin) {
                $user = $admin;
                $type = 'admin';
            }

            $guru = Guru::where('nip', $account)
                ->orWhere('email', $account)
                ->orWhere('no_hp', $account)
                ->first();
            if ($guru) {
                if ($guru->verified == 0) return api_failed('Akun anda belum diverifikasi');
                $user = $guru;
                $type = 'guru';
            }

            $murid = Murid::where('nis', $account)
                ->orWhere('email', $account)
                ->orWhere('no_hp', $account)
                ->first();
            if ($murid) {
                if ($murid->verified == 0) return api_failed('Akun anda belum diverifikasi');
                $user = $murid;
                $type = 'murid';
            }

            $ortu = Ortu::where('email', $account)
                ->orWhere('no_hp', $account)
                ->first();
            if ($ortu) {
                if ($ortu->verified == 0) return api_failed('Akun anda belum diverifikasi');
                $user = $ortu;
                $type = 'ortu';
            }

            if (empty($user)) {
                return api_failed('Akun yang anda masukan tidak valid');
            }

            if ($type == 'admin') {
                $attempt = Auth::guard('admin')->attempt([
                    'email' => $user->email,
                    'password' => $request->input('password')
                ]);
            } else if ($type == 'guru') {
                $attempt = Auth::guard('guru')->attempt([
                    'email' => $user->email,
                    'password' => $request->input('password')
                ]);
            } else if ($type == 'murid') {
                $attempt = Auth::guard('murid')->attempt([
                    'email' => $user->email,
                    'password' => $request->input('password')
                ]);
            } else if ($type == 'ortu') {
                $attempt = Auth::guard('ortu')->attempt([
                    'email' => $user->email,
                    'password' => $request->input('password')
                ]);
            }

            if (empty($attempt)) {
                return api_failed('Kata sandi yang anda masukan salah!');
            } else {
                $user->gambar = $user->gambar ? profilePath($user->gambar) : textAvatar($user->nama);
                $payload = $user->toArray();
                $payload['type'] = $type;
                $token = generateJWT($payload);
                return api_success('Login berhasil', [
                    'data' => $payload,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]);
            }
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function verify(Request $request)
    {
        try {
            $token = $request->query('token');
            if (!$token) return view('verification', ['success' => false, 'message' => 'Token verifikasi tidak ada']);
            $tokenData = decodeJWT($token);

            switch ($tokenData->type) {
                case 'admin':
                    $user = Admin::where('email', $tokenData->email)->first();
                    break;

                case 'guru':
                    $user = Guru::where('email', $tokenData->email)->first();
                    break;

                case 'murid':
                    $user = Murid::where('email', $tokenData->email)->first();
                    break;

                case 'ortu':
                    $user = Ortu::where('email', $tokenData->email)->first();
                    break;

                default:
                    # code...
                    break;
            }

            if (isset($user)) {
                $user->update(['verified' => 1]);
            } else {
                return view('verification', ['success' => false, 'message' => 'User tidak ditemukan']);
            }

            return view('verification', ['success' => true, 'message' => 'Silahkan masuk ke aplikasi anda.']);
        } catch (SignatureInvalidException $e) {
            return view('verification', ['success' => false, 'message' => 'Token verifikasi tidak valid']);
        } catch (ExpiredException $e) {
            return view('verification', ['success' => false, 'message' => 'Token verifikasi sudah tidak berlaku']);
        } catch (Exception $e) {
            return api_error($e);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return api_success('Logout berhasil');
    }
}
