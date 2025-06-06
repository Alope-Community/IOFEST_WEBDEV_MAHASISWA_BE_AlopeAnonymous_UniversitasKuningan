<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramRelawan;
use App\Models\RelawanPeserta;

class programRelawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request('limit', 10);
        $search = request('search');
        
        $query = ProgramRelawan::withCount('pesertas');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_program', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $relawans = $query->paginate($limit);

        $data = [
            'status' => 'success',
            'message' => 'Data Program Relawan berhasil diambil',
            'data' => $relawans->getCollection()->transform(function ($relawan) {
                return [
                    'id' => $relawan->id,
                    'title' => $relawan->nama_program,
                    'description' => $relawan->deskripsi,
                    'start_date' => $relawan->tanggal_mulai,
                    'image_url' => $relawan->gambar,
                    'jumlah_peserta' => $relawan->pesertas_count,
                ];
            }),
            'meta' => [
                'current_page' => $relawans->currentPage(),
                'last_page' => $relawans->lastPage(),
                'per_page' => $relawans->perPage(),
                'total' => $relawans->total(),
            ],
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_relawan_id' => 'required|exists:program_relawans,id',
        ]);

        $userId = $request->user()->id;

        $alreadyRegistered = RelawanPeserta::where('user_id', $userId)
            ->where('program_relawan_id', $request->program_relawan_id)
            ->exists();

        if ($alreadyRegistered) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamu sudah terdaftar dalam program relawan ini.',
            ], 409);
        }

        $peserta = RelawanPeserta::create([
            'user_id' => $userId,
            'program_relawan_id' => $request->program_relawan_id,
            'no_hp' => $request->no_hp,
            'motivasi' => $request->motivasi,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran relawan berhasil.',
            'data' => $peserta,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $relawan = ProgramRelawan::with(['pesertas.user'])->find($id);
        
        if (!$relawan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Program Relawan tersebut tidak ditemukan!',
            ], 404);
        }

        $pesertas = $relawan->pesertas->map(function ($peserta) {
            return [
                'id' => $peserta->id,
                'user_id' => $peserta->user_id,
                'user_name' => $peserta->user->name ?? null,
                'tanggal_bergabung' => $peserta->created_at,
            ];
        });

        $data = [
                'id' => $relawan->id,
                'title' => $relawan->nama_program,
                'category' => $relawan->category,
                'description' => $relawan->deskripsi,
                'status' => $relawan->status,
                'tanggal_mulai' => $relawan->tanggal_mulai,
                'tanggal_selesai' => $relawan->tanggal_selesai,
                'gambar' => $relawan->gambar,
                'pesertas' => $pesertas,
            ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data Program Relawan tersebut berhasil di ambil!',
            'data' => $data,
        ], 200);
    }
}
