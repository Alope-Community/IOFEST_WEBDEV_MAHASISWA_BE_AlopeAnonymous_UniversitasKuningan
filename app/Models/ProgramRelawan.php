<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramRelawan extends Model
{
    protected $fillable = ['nama_program', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class);
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class);
    }

    public function testimoniRatings()
    {
        return $this->hasMany(TestimoniRating::class);
    }

    public function forumDiskusi()
    {
        return $this->hasMany(ForumDiskusi::class);
    }

    public function kalenderKegiatan()
    {
        return $this->hasMany(KalenderKegiatan::class);
    }

    public function grupRelawan()
    {
        return $this->hasMany(GrupRelawan::class);
    }

    public function statistikLaporan()
    {
        return $this->hasMany(StatistikLaporan::class);
    }

    public function galeri()
    {
        return $this->hasMany(Galeri::class);
    }
}
