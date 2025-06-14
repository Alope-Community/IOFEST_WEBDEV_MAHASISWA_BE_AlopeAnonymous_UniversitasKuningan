<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RelawanPeserta;
use App\Models\TestimoniRating;

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use App\Models\ProgramRelawan;
use App\Models\User;
use App\Models\Sertifikat;
use Carbon\Carbon;

class TestimoniRatingController extends Controller
{
    public function generateSertifikat($user, $programId)
    {
        Carbon::setLocale('id');
        $program = ProgramRelawan::findOrFail($programId);

        // Buat nomor sertifikat
        $nomorSertifikat = 'PN-' . now()->format('Ymd') . '-' . $user->id . '-' . $programId;

        // Inisialisasi PDF
        $pdf = new Fpdi();
        $pdf->AddPage('L'); // Landscape

        // Ambil template PDF
        $templatePath = storage_path('app/public/templates/template-sertifikat.pdf');
        $pageCount = $pdf->setSourceFile($templatePath);
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0, 297); // A4 Landscape width

        // Atur font
        $pdf->SetFont('Arial', '', 24);
        $pdf->SetTextColor(50, 50, 50); // Abu gelap

        // Nama peserta (tengah)
        $pdf->SetXY(50, 79);
        $pdf->Cell(200, 10, $user->name, 0, 0, 'C');

        // Judul program
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(50, 118);
        $pdf->Cell(200, 10, $program->nama_program, 0, 0, 'C');

        // Tanggal program
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(50, 127);
        $tanggalPelaksanaan = Carbon::parse($program->tanggal_mulai)->translatedFormat('d F Y');
        $pdf->Cell(200, 10, $tanggalPelaksanaan, 0, 0, 'C');

        // Nomor sertifikat (pojok bawah)
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(50, 30);
        $pdf->Cell(200, 10, 'No. Sertifikat: ' . $nomorSertifikat, 0, 0, 'C');

        // Simpan file PDF
        $filename = 'sertifikat_' . $user->name . '_' . $program->nama_program . '.pdf';
        $filePath = 'sertifikat/' . $filename;
        $pdf->Output(storage_path('app/public/' . $filePath), 'F');

        // Simpan ke database
        Sertifikat::updateOrCreate([
            'user_id' => $user->id,
            'program_id' => $programId,
            'sertifikat_url' => 'storage/' . $filePath,
        ], [
            'tanggal_diterbitkan' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
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

        $this->generateSertifikat($user, $validated['program_relawan_id']);

        return response()->json([
            'status' => 'success',
            'message' => 'Testimoni berhasil ditambahkan.',
            'data' => $testimoni,
        ], 201);
    }
}
