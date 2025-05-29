<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PenggunaLulusanModel extends Model
{
    protected $table = 'pengguna_lulusan';
    protected $primaryKey = 'pengguna_id';
    protected $fillable = ['nama', 'instansi', 'jabatan', 'email', 'no_hp'];

    // Relasi: Atasan terkait banyak alumni (many-to-many)
    public function alumni()
    {
        return $this->belongsToMany(AlumniModel::class, 'alumni_pengguna_lulusan', 'pengguna_id', 'alumni_id');
    }

    // Relasi: Satu atasan punya banyak token survei
    public function surveyTokens()
    {
        return $this->hasMany(SurveyTokenModel::class, 'pengguna_id', 'pengguna_id');
    }

    // Relasi: Satu atasan punya banyak jawaban
    public function jawabanPengguna()
    {
        return $this->hasMany(JawabanPenggunaModel::class, 'pengguna_id', 'pengguna_id');
    }
}