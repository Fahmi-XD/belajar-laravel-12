<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Log;

class AdminController extends Controller
{
    public function create(Request $request) {
        try {
            $request->validate([
                'nama' => 'required|string|min:8|max:25',
                'username' => 'required|string|min:6|max:15|unique:admin_models,username',
                'email' => 'required|string|unique:admin_models,email',
                'password' => 'required|string|min:8|max:25',
            ]);

            $user = AdminModel::create([
                'nama'=> $request->nama,
                'username'=> $request->username,
                'email'=> $request->email,
                'password' => Hash::make($request->password),
                'token' => ''
            ]);

            $token = $user->createToken('email')->plainTextToken;

            $user->update([
                'token' => $token
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Admin ditambahkan',
                'token' => $token
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang diinput tidak valid!',
                'error' => $e->errors()
            ], 500);
        }
    }

    public function index() {
        $admin = AdminModel::all();
        if ($admin->count() == 0) {
            return response()->json([
                'success' => true,
                'message' => 'Belum ada admin yang daftar.',
                'result' => $admin
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sukses mendapatkan data list admin',
            'result' => $admin
        ]);
    }

    public function loginPost(Request $request) {
        try {
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string|min:8|max:25',
            ]);

            $admin = AdminModel::where('email', $request->email)->first();

            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password tidak valid!'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login sukses, mengalihkan ke dashboard...',
                'token' => $admin->token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang di input tidak valid!',
                'error' => $e->errors()
            ], 400);
        }
    }

    public function logout(Request $request) {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        Log::info('Token bearer: '. $token);

        $user = AdminModel::where('token', $token)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil logout dari akun dengan email ' + $user->email
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Akun tidak ditemukan'
        ], 400);
    }
}
