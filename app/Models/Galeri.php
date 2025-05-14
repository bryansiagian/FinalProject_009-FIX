<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $fillable =
    [
        'nama_gambar',
        'path',
        'deskripsi',
        'user_id', // Tambahkan user_id ke fillable
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}