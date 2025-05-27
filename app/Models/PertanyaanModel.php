<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanModel extends Model
{
    protected $table = 'pertanyaan';
    protected $primaryKey = 'kode_pertanyaan';
    protected $keyType = 'string';
    protected $fillable = ['kode_kategori', 'teks_pertanyaan', 'role_target'];

    // Relasi: Satu pertanyaan terkait satu kategori
    public function kategoriPertanyaan()
    {
        return $this->belongsTo(KategoriPertanyaanModel::class, 'kode_kategori', 'kode_kategori');
    }

    // Relasi: Satu pertanyaan punya banyak opsi
    public function opsiPilihan()
    {
        return $this->hasMany(OpsiPilihanModel::class, 'pertanyaan_id', 'kode_pertanyaan');
    }

    // Relasi: Satu pertanyaan punya banyak jawaban alumni
    public function jawabanAlumni()
    {
        return $this->hasMany(JawabanAlumniModel::class, 'kode_pertanyaan', 'kode_pertanyaan');
    }

    // Relasi: Satu pertanyaan punya banyak jawaban atasan
   /* public function jawabanPengguna()
    {
        return $this->hasMany(JawabanPenggunaModel::class, 'kode_pertanyaan', 'kode_pertanyaan');
    }*/
}