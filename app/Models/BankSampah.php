<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BankSampah extends Model
{
    protected $table = 'bank_sampah';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nama', 'alamat'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
