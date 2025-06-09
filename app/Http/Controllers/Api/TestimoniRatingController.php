<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RelawanPeserta;
use App\Models\TestimoniRating;

class TestimoniRatingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_relawan_id' => 'required|exists:program_relawans,id',
            'pesan' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = $request->user();

        $terdaftar = RelawanPeserta::where('user_id', $user->id)
            ->where('program_relawan_id', $validated['program_relawan_id'])
            ->exists();

        if (!$terdaftar) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamu belum mengikuti program ini.',
            ], 403);
        }

        $request->user()->tambahPoin(10, 'Program_Relawan', 'Berpartisipasi dalam Program Relawan');

        $testimoni = TestimoniRating::create([
            'user_id' => $user->id,
            'program_relawan_id' => $validated['program_relawan_id'],
            'pesan' => $validated['pesan'],
            'rating' => $validated['rating'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Testimoni berhasil ditambahkan.',
            'data' => $testimoni,
        ], 201);
    }
}
