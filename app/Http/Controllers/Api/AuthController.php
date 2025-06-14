<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\RelawanPeserta;
use App\Models\DonasiPeserta;
use App\Models\Sertifikat;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function isAuth(Request $request){
        $isAuth= User::where('remember_token', $request->token)->count();

        return response()->json($isAuth);
    }

public function profile(Request $request)
{
    Carbon::setLocale('id');
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User tidak ditemukan.',
        ], 401);
    }

    $riwayatRelawan = RelawanPeserta::with(['programRelawan'])
        ->where('user_id', $user->id)
        ->get();

    $certificates= [];

    for ($i=0; $i < count($riwayatRelawan); $i++) { 
        $sertifikat = Sertifikat::where('program_id', $riwayatRelawan[$i]->programRelawan->id)->first();

        $certificates[$i] = $sertifikat?->sertifikat_url;
    }

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
            'created_at' => Carbon::parse($user->created_at)->translatedFormat('d F Y'),
            'point' => $user->point ?? 0,
        ],
        'riwayat_relawan' => $riwayatRelawan->map(function ($item, $index) use ($certificates) {
            $program = $item->programRelawan;
            $sertifikat = $item->sertifikat;

            return [
                'judul' => $program->nama_program ?? '-',
                'tanggal_bergabung' => Carbon::parse($item->created_at)->translatedFormat('d F Y'),
                'tanggal_mulai' => optional($program->tanggal_mulai)->translatedFormat('d F Y'),
                'tanggal_selesai' => optional($program->tanggal_selesai)->translatedFormat('d F Y'),
                'sertifikat_url' => $certificates[$index],
            ];
        }),
        'riwayat_donasi' => $riwayatDonasi->map(function ($item) {
            return [
                'judul' => $item->programDonasi->nama_program ?? '-',
                'tanggal_donasi' => Carbon::parse($item->created_at)->translatedFormat('d F Y'),
                'tanggal_mulai' => optional($item->programDonasi->tanggal_mulai)->translatedFormat('d F Y'),
                'tanggal_selesai' => optional($item->programDonasi->tanggal_selesai)->translatedFormat('d F Y'),
            ];
        }),
    ]);
}

    // REGISTER
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'user',
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

        $user->update([
            "remember_token" => $token
        ]);

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
