<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanModel extends Model
{
    protected $table = 'pertanyaan';
    protected $primaryKey = 'pertanyaan_id';
    protected $keyType = 'string';
    protected $fillable = ['isi_pertanyaan', 'role_target', 'jenis_pertanyaan', 'created_by','kode_kategori'];

    // Relasi: Satu pertanyaan terkait satu kategori
    public function kategoriPertanyaan()
    {
        return $this->belongsTo(KategoriPertanyaanModel::class, 'kode_kategori', 'kode_kategori');
    }

    // Relasi: Satu pertanyaan punya banyak opsi
    // public function opsiPilihan()
    // {
    //     return $this->hasMany(OpsiPilihanModel::class, 'pertanyaan_id', 'kode_kategori');
    // }

    // Relasi: Satu pertanyaan punya banyak jawaban alumni
    public function jawabanAlumni()
    {
        return $this->hasMany(JawabanAlumniModel::class, 'kode_kategori', 'kode_kategori');
    }

    // Relasi: Satu pertanyaan punya banyak jawaban atasan
   /* public function jawabanPengguna()
    {
        return $this->hasMany(JawabanPenggunaModel::class, 'kode_kategori', 'kode_kategori');
    }*/

    public function admin()
    {
        return $this->belongsTo(AdminModel::class, 'created_by', 'admin_id');
    }
}