<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogArtikel extends Model
{
    protected $fillable = ['judul', 'lokasi', 'konten', 'user_id', 'tanggal_diterbitkan', 'gambar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
