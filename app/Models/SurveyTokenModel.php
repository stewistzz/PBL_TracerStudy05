<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyTokenModel extends Model
{
    protected $table = 'survey_tokens';
    protected $primaryKey = 'token_id';
    protected $fillable = ['pengguna_id', 'alumni_id', 'token', 'expires_at', 'used'];

    // Relasi: Satu token terkait satu atasan
    public function pengguna()
    {
        return $this->belongsTo(PenggunaLulusanModel::class, 'pengguna_id', 'pengguna_id');
    }

    // tambah relasi ke alumni (memudahkan akses data alumni terkait)
    public function alumni()
{
    return $this->belongsTo(AlumniModel::class, 'alumni_id', 'alumni_id');
}
}