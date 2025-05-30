<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OpsiPilihanModel extends Model
{
    protected $table = 'opsi_pilihan';
    protected $primaryKey = 'opsi_id';
    protected $fillable = ['pertanyaan_id', 'teks_opsi', 'nilai'];

    // Relasi: Satu opsi terkait satu pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanModel::class, 'pertanyaan_id', 'kode_pertanyaan');
    }

    // Relasi: Satu opsi punya banyak jawaban alumni
    public function jawabanAlumni()
    {
        return $this->hasMany(JawabanAlumniModel::class, 'opsi_id', 'opsi_id');
    }

    // Relasi: Satu opsi punya banyak jawaban atasan
    public function jawabanPengguna()
    {
        return $this->hasMany(JawabanPenggunaModel::class, 'opsi_id', 'opsi_id');
    }
}