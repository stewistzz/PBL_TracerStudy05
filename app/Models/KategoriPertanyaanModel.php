<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPertanyaanModel extends Model
{
    protected $table = 'kategori_pertanyaan';
    protected $primaryKey = 'kode_kategori';
    protected $keyType = 'string';
    protected $fillable = ['nama_kategori'];

    // Relasi: Satu kategori punya banyak pertanyaan
    public function pertanyaans()
    {
        return $this->hasMany(PertanyaanModel::class, 'kode_kategori', 'kode_kategori');
    }
}