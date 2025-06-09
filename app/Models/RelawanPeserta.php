<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelawanPeserta extends Model
{
    protected $fillable = ['user_id', 'program_relawan_id', 'no_hp', 'motivasi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programRelawan()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }
    
    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'program_id', 'program_relawan_id')
                    ->whereColumn('user_id', 'user_id');
    }

}
