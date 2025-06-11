<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahDesa extends Model
{
    use HasFactory;

    protected $table = 'wilayah_desa';
    protected $fillable = ['nama', 'ongkos_kirim', 'tersedia_delivery', 'kode_pos'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}