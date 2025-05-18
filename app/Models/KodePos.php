<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodePos extends Model
{
    use HasFactory;

    protected $table = 'kode_pos';
    protected $fillable = ['kode_pos', 'user_id', 'updated_by', 'ongkos_kirim'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relasi ke user yang membuat kode pos
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by'); // Relasi ke user yang terakhir update
    }
}