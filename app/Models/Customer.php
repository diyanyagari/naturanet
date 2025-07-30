<?php

namespace App\Models;

use App\Models\KartuKeluarga as ModelsKartuKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use \KartuKeluarga;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use Notifiable, HasApiTokens;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'username',
        'jenis_customer',
        'nik',
        'name',
        'password',
        'no_kk',
        'no_hp',
    ];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function kkAnggota()
    {
        return $this->belongsToMany(ModelsKartuKeluarga::class, 'kartu_keluarga_anggota', 'customer_id', 'kartu_keluarga_id')
            ->withPivot('hubungan')
            ->withTimestamps();
    }

    public function kkDikepalai()
    {
        return $this->hasOne(ModelsKartuKeluarga::class, 'kepala_keluarga_id', 'uuid');
    }
}
