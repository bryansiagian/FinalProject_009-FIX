<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangKami extends Model
{
    use HasFactory;

    protected $table = 'tentang_kami';
    protected $fillable = ['nama_toko', 'alamat', 'sejarah', 'deskripsi', 'is_active'];

    // Mendapatkan record yang aktif
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }
}
