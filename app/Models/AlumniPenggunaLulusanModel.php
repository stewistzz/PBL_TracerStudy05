<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniPenggunaLulusanModel extends Model
{
    protected $table = 'alumni_pengguna_lulusan';
    protected $primaryKey = 'id';
    protected $fillable = ['pengguna_id', 'alumni_id'];

    // Relasi: Pivot tidak perlu relasi tambahan
    public function alumni()
    {
        return $this->belongsTo(AlumniModel::class, 'alumni_id', 'alumni_id');
    }

    public function penggunaLulusan()
    {
        return $this->belongsTo(PenggunaLulusanModel::class, 'pengguna_id', 'pengguna_id');
    }
}