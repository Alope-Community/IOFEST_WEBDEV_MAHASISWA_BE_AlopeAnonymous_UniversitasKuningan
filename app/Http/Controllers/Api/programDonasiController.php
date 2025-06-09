<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramDonasi;
use App\Models\DonasiPeserta;
use App\Models\User;

class programDonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request('limit', 10);
        $search = request('search');
        
        $query = ProgramDonasi::withCount('pesertas');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_program', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $donasis = $query->paginate($limit);

        $data = [
            'status' => 'success',
            'message' => 'Data Program Donasi berhasil diambil',
            'data' => $donasis->getCollection()->transform(function ($donasi) {
                return [
                    'id' => $donasi->id,
                    'title' => $donasi->nama_program,
                    'description' => $donasi->deskripsi,
                    'start_date' => $donasi->tanggal_mulai,
                    'image_url' => $donasi->gambar,
                    'jumlah_pendonasi' => $donasi->pesertas_count,
                ];
            }),
            'meta' => [
                'current_page' => $donasis->currentPage(),
                'last_page' => $donasis->lastPage(),
                'per_page' => $donasis->perPage(),
                'total' => $donasis->total(),
            ],
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_donasi_id' => 'required|integer',
            'nominal' => 'required|numeric',
            'ucapan' => 'nullable|string|max:255',
        ]);

        // Cek user dari token (jika pakai sanctum)
        $user = $request->user();

        if (!$user || !User::find($user->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan.',
            ], 404);
        }

        // Cek apakah program donasi ada
        $program = ProgramDonasi::find($validated['program_donasi_id']);
        if (!$program) {
            return response()->json([
                'status' => 'error',
                'message' => 'Program donasi tidak ditemukan.',
            ], 404);
        }

        // Simpan donasi
        $donasi = DonasiPeserta::create([
            'user_id' => $user->id,
            'program_donasi_id' => $validated['program_donasi_id'],
            'nominal' => $validated['nominal'],
            'ucapan' => $validated['ucapan'] ?? null,
        ]);

        $request->user()->tambahPoin(5, 'Program_Donasi', 'Berpartisipasi dalam Program Berdonasi');

        return response()->json([
            'status' => 'success',
            'message' => 'Donasi berhasil didaftarkan.',
            'data' => $donasi,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
                $donasi = ProgramDonasi::with(['pesertas.user'])->find($id);
        
        if (!$donasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Program Donasi tersebut tidak ditemukan!',
            ], 404);
        }

        $pesertas = $donasi->pesertas->map(function ($peserta) {
            return [
                'id' => $peserta->id,
                'user_id' => $peserta->user_id,
                'user_name' => $peserta->user->name ?? null,
                'nominal' => $peserta->nominal,
                'ucapan' => $peserta->ucapan,
                'tanggal_berdonasi' => $peserta->created_at,
            ];
        });

        $data = [
                'id' => $donasi->id,
                'title' => $donasi->nama_program,
                'category' => $donasi->category,
                'description' => $donasi->deskripsi,
                'status' => $donasi->status,
                'tanggal_mulai' => $donasi->tanggal_mulai,
                'tanggal_selesai' => $donasi->tanggal_selesai,
                'gambar' => $donasi->gambar,
                'pendonasi' => $pesertas,
            ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data Program Relawan tersebut berhasil di ambil!',
            'data' => $data,
        ], 200);
    }
}
