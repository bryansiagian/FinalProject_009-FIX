<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangKami extends Model
{
    use HasFactory;

    protected $table = 'tentang_kami';
    protected $fillable = ['nama_toko', 'alamat', 'sejarah', 'deskripsi', 'user_id']; // Hapus is_active dan tambahkan user_id

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}