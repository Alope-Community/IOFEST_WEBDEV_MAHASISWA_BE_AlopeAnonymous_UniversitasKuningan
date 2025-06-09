<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\RelawanPeserta;
use App\Models\DonasiPeserta;

class AuthController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan.',
            ], 401);
        }

        $riwayatRelawan = RelawanPeserta::with('programRelawan')
                            ->where('user_id', $user->id)
                            ->get();
        $riwayatDonasi = DonasiPeserta::with('programDonasi')
                            ->where('user_id', $user->id)
                            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Profile berhasil diambil!',
            'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'created_at' => $user->created_at->format('Y-m-d'),
                        'point' => $user->point ?? 0,
                    ],
            'riwayat_relawan' => $riwayatRelawan->map(function ($item) {
                    return [
                            'judul' => $item->programRelawan->nama_program ?? '-',
                            'sudah_berdonasi' => false, // Kalau ingin cek dari riwayat, bisa tambahkan logika
                            'tanggal_mulai' => $item->programRelawan->tanggal_mulai ?? null,
                            'tanggal_selesai' => $item->programRelawan->tanggal_selesai ?? null,
                        ];
                    }),

            'riwayat_donasi' => $riwayatDonasi->map(function ($item) {
                    return [
                            'judul' => $item->programDonasi->nama_program ?? '-',
                            'bergabung' => true,
                            'tanggal_mulai' => $item->programDonasi->tanggal_mulai ?? null,
                            'tanggal_selesai' => $item->programDonasi->tanggal_selesai ?? null,
                            'sertifikat' => $item->sertifikat_url ?? null,
                        ];
                    }),
        ]);
    }
    // REGISTER
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (User::where('email', $validated['email'])->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email sudah digunakan',
            ], 409);
        }

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Buat token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    
    // LOGIN
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where('email', $validated['email'])->first();
        
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah',
            ], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil',
        ]);
    }
}
