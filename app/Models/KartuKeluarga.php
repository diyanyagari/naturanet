<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Customer;

class KartuKeluarga extends Model
{
    use HasUuids;

    protected $table = 'kartu_keluarga';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['uuid', 'no_kk', 'kepala_keluarga_id'];

    public function anggota(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'kartu_keluarga_anggota', 'kartu_keluarga_id', 'customer_id')
            ->withPivot('hubungan')
            ->withTimestamps();
    }

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Customer::class, 'kepala_keluarga_id', 'uuid');
    }
}
