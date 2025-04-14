<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontak';
    protected $fillable = ['alamat', 'telepon', 'email', 'peta', 'is_active'];

    // Mendapatkan record yang aktif
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }
}
