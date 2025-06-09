<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogArtikel;

class BlogArtikelController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search');

        $query = BlogArtikel::with('user')->orderBy('tanggal_diterbitkan', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('konten', 'like', '%' . $search . '%')
                ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        $artikels = $query->paginate($limit);

        $data = [
            'status' => 'success',
            'message' => 'Data artikel berhasil diambil',
            'data' => $artikels->getCollection()->transform(function ($artikel) {
                return [
                    'id' => $artikel->id,
                    'judul' => $artikel->judul,
                    'lokasi' => $artikel->lokasi,
                    'konten' => \Str::limit(strip_tags($artikel->konten), 100),
                    'penulis' => $artikel->user->name ?? null,
                    'tanggal_diterbitkan' => $artikel->tanggal_diterbitkan,
                    'gambar' => $artikel->gambar,
                ];
            }),
            'meta' => [
                'current_page' => $artikels->currentPage(),
                'last_page' => $artikels->lastPage(),
                'per_page' => $artikels->perPage(),
                'total' => $artikels->total(),
            ],
        ];

        return response()->json($data);
    }

    public function show($id)
    {
        $artikel = BlogArtikel::with('user')->find($id);

        if (! $artikel) {
            return response()->json([
                'status' => 'error',
                'message' => 'Artikel tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail artikel berhasil diambil.',
            'data' => [
                'id' => $artikel->id,
                'judul' => $artikel->judul,
                'lokasi' => $artikel->lokasi,
                'konten' => $artikel->konten,
                'penulis' => $artikel->user->name ?? null,
                'tanggal_diterbitkan' => $artikel->tanggal_diterbitkan,
                'gambar' => $artikel->gambar,
            ],
        ]);
    }
}
