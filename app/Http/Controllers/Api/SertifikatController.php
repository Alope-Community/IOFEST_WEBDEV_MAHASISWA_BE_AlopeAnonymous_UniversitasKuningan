<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\ProgramRelawan;
use App\Models\Sertifikat;
use Carbon\Carbon;

class SertifikatController extends Controller
{
    public function show(Request $request)
    {
        Carbon::setLocale('id');
        $userId = $request->user()->id;
        $program = ProgramRelawan::findOrFail($programId);

        // Buat nomor sertifikat
        $nomorSertifikat = 'PN-' . now()->format('Ymd') . '-' . $userId . '-' . $programId;

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
        $filename = 'sertifikat_' . $userId . '_' . $programId . '.pdf';
        $filePath = 'sertifikat/' . $filename;
        $pdf->Output(storage_path('app/public/' . $filePath), 'F');

        // Simpan ke database
        Sertifikat::updateOrCreate([
            'user_id' => $userId,
            'program_id' => $programId,
            'sertifikat_url' => asset('storage/' . $filePath),
        ], [
            'tanggal_diterbitkan' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Sertifikat berhasil dibuat',
            'download_url' => asset('storage/' . $filePath),
        ]);
    }
}
