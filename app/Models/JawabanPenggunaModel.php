<?php

namespace App\Models;
use App\Models\AlumniModel;
use App\Models\OpsiPilihanModel;
use App\Models\PenggunaLulusanModel;
use App\Models\PertanyaanModel;
use Illuminate\Database\Eloquent\Model;

class JawabanPenggunaModel extends Model
{
    protected $table = 'jawaban_pengguna';
    protected $primaryKey = 'jawaban_id';
    //protected $fillable = ['pengguna_id', 'kode_pertanyaan', 'opsi_id'];
    protected $fillable = ['pengguna_id', 'alumni_id', 'pertanyaan_id', 'jawaban', 'tanggal'];

    // Relasi: Satu jawaban terkait satu atasan
    public function pengguna()
    {
        return $this->belongsTo(PenggunaLulusanModel::class, 'pengguna_id', 'pengguna_id');
    }

    // Relasi: Satu jawaban terkait satu pertanyaan
   /* public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanModel::class, 'kode_pertanyaan', 'kode_pertanyaan');
    } */

    public function pertanyaan()
{
    return $this->belongsTo(PertanyaanModel::class, 'pertanyaan_id', 'pertanyaan_id');
}
    
    // Relasi: Satu jawaban terkait satu opsi
    public function opsiPilihan()
    {
        return $this->belongsTo(OpsiPilihanModel::class, 'opsi_id', 'opsi_id');
    }

    public function alumni()
{
    return $this->belongsTo(AlumniModel::class, 'alumni_id', 'alumni_id');
}
}