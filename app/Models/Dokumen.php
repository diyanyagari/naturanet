<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Dokumen extends Model
{
    use HasUuids;

    protected $table = 'dokumen';

    protected $fillable = [
        'nama',
        'public_id',
        'secure_url',
        'ukuran',
        'format',
    ];
}
