<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramRelawan;
use App\Models\RelawanPeserta;
use Carbon\Carbon;

class programRelawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Carbon::setLocale('id');
        $limit = request('limit', 10);
        $search = request('search');
        
        $query = ProgramRelawan::withCount('pesertas');

        if ($search) {
            $query->where('nama_program', 'like', '%' . $search . '%');
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
                    'start_date' => Carbon::parse($relawan->tanggal_mulai)->translatedFormat('d F Y'),
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

        $request->user()->tambahPoin(5, 'Program_Relawan', 'Berpartisipasi dalam Program Relawan');

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
        Carbon::setLocale('id');
        $relawan = ProgramRelawan::with(['pesertas.user', 'testimoniRatings.user'])->find($id);
        
        if (!$relawan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Program Relawan tersebut tidak ditemukan!',
            ], 404);
        }

        $testimoni = $relawan->testimoniRatings()
            ->paginate(10)
            ->through(function ($item) {
                return [
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'user_name' => $item->user->name ?? null,
                    'pesan' => $item->pesan,
                    'rating' => $item->rating,
                    'tanggal' => $item->created_at,
                ];
            });

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
                'tanggal_mulai' => Carbon::parse($relawan->tanggal_mulai)->translatedFormat('d F Y'),
                'tanggal_selesai' => Carbon::parse($relawan->tanggal_selesai)->translatedFormat('d F Y'),
                'kontak' => $relawan->kontak,
                'gambar' => $relawan->gambar,
                'pesertas' => $pesertas,
                'testimoni' => $testimoni,
            ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data Program Relawan tersebut berhasil di ambil!',
            'data' => $data,
        ], 200);
    }
}
