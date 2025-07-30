<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use \KartuKeluarga;

class Customer extends Model
{
    use Notifiable;

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
        return $this->belongsToMany(KartuKeluarga::class, 'kartu_keluarga_anggota', 'customer_id', 'kartu_keluarga_id')
            ->withPivot('hubungan')
            ->withTimestamps();
    }

    public function kkDikepalai()
    {
        return $this->hasOne(KartuKeluarga::class, 'kepala_keluarga_id', 'uuid');
    }
}
