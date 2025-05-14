<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontak';
    protected $fillable = ['alamat', 'telepon', 'email', 'peta', 'user_id']; // Hapus is_active dan tambahkan user_id

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}