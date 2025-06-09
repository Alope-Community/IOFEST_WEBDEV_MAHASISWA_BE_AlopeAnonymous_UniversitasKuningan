<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'point'];

    public function programRelawan()
    {
        return $this->hasMany(ProgramRelawan::class);
    }

    public function donasi()
    {
        return $this->hasMany(ProgramDonasi::class);
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function testimoniRatings()
    {
        return $this->hasMany(TestimoniRating::class);
    }

    public function komentarForum()
    {
        return $this->hasMany(KomentarForum::class);
    }

    public function blogArtikel()
    {
        return $this->hasMany(BlogArtikel::class);
    }

    public function poinHistories(): HasMany
    {
        return $this->hasMany(UserPoinHistory::class);
    }
    public function tambahPoin(int $jumlah, string $aktivitas, string $keterangan = null): void
    {
        $this->increment('point', $jumlah);

        $this->poinHistories()->create([
            'aktivitas' => $aktivitas,
            'point' => $jumlah,
            'keterangan' => $keterangan,
        ]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        logger('Panel ID: ' . $panel->getId());
        logger('User role: ' . $this->role);

        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'komunitas') {
            return $this->role === 'komunitas';
        }

        return false;
    }

}
