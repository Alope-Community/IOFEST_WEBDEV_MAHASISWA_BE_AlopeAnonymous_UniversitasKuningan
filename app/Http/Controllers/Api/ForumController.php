<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ForumDiskusi;
use App\Models\KomentarForum;

class ForumController extends Controller
{
public function index(Request $request)
{
    $limit = $request->input('limit', 10);
    $search = $request->input('search');

    $query = ForumDiskusi::with([
        'user',
        'komentars' => function ($q) {
            $q->latest('tanggal_komentar')->limit(1)->with('user');
        }
    ])->orderBy('tanggal_dibuat', 'desc');

    // Jika ada pencarian berdasarkan judul atau konten
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', '%' . $search . '%')
              ->orWhere('konten', 'like', '%' . $search . '%');
        });
    }

    $forums = $query->paginate($limit);

    return response()->json([
        'status' => 'success',
        'message' => 'List forum berhasil diambil.',
        'data' => $forums->items(),
        'meta' => [
            'current_page' => $forums->currentPage(),
            'last_page' => $forums->lastPage(),
            'per_page' => $forums->perPage(),
            'total' => $forums->total(),
        ],
    ]);
}

    public function show($id)
    {
        $forum = ForumDiskusi::with(['user', 'komentars.user'])
            ->find($id);

        if (! $forum) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forum tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail forum berhasil diambil.',
            'data' => $forum
        ]);
    }

    public function store(Request $request, $forum_id)
    {
        $request->validate([
            'komentar' => 'required|string'
        ]);

        $forum = ForumDiskusi::find($forum_id);
        if (! $forum) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forum tidak ditemukan.'
            ], 404);
        }

        $komentar = KomentarForum::create([
            'forum_id' => $forum_id,
            'user_id' => $request->user()->id,
            'komentar' => $request->komentar,
            'tanggal_komentar' => now(),
        ]);

        $request->user()->tambahPoin(2, 'komentar_forum', 'Memberikan komentar di forum diskusi');

        return response()->json([
            'status' => 'success',
            'message' => 'Komentar berhasil ditambahkan.',
            'data' => $komentar->load('user')
        ], 201);
    }
}
