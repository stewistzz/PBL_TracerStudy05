<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PertanyaanModel extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $primaryKey = 'pertanyaan_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['kode_kategori', 'isi_pertanyaan', 'role_target', 'jenis_pertanyaan', 'created_by'];

    public function kategoriPertanyaan()
    {
        return $this->belongsTo(KategoriPertanyaanModel::class, 'kode_kategori', 'kode_kategori');
    }

    public function opsiPilihan()
    {
        return $this->hasMany(OpsiPilihanModel::class, 'pertanyaan_id', 'pertanyaan_id');
    }

    public function jawabanAlumni()
    {
        return $this->hasMany(JawabanAlumniModel::class, 'pertanyaan_id', 'pertanyaan_id');
    }

    public function jawabanPengguna()
    {
        return $this->hasMany(JawabanPenggunaModel::class, 'pertanyaan_id', 'pertanyaan_id');
    }

 public function admin()
{
    return $this->belongsTo(AdminModel::class, 'created_by', 'admin_id'); // Sesuaikan dengan model dan kolom
}
}