<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class TracerStudyModel extends Model
{
    protected $table = 'tracer_study';
    protected $primaryKey = 'tracer_id';
    protected $fillable = [
        'alumni_id', 'instansi_id', 'kategori_profesi_id', 'profesi_id',
        'nama_atasan_langsung', 'email_atasan_langsung', 'jabatan_atasan_langsung',
        'no_hp_atasan_langsung', 'tanggal_pengisian', 'tanggal_pertama_kerja',
        'tanggal_mulai_kerja_instansi_saat_ini', 'status'
    ];

    // Relasi: Satu tracer study terkait satu alumni
    public function alumni()
    {
        return $this->belongsTo(AlumniModel::class, 'alumni_id', 'alumni_id');
    }

    // Relasi: Satu tracer study terkait satu instansi
    public function instansi()
    {
        return $this->belongsTo(InstansiModel::class, 'instansi_id', 'instansi_id');
    }

    // Relasi: Satu tracer study terkait satu kategori profesi
    public function kategoriProfesi()
    {
        return $this->belongsTo(KategoriProfesiModel::class, 'kategori_profesi_id', 'kategori_id');
    }

    // Relasi: Satu tracer study terkait satu profesi
    public function profesi()
    {
        return $this->belongsTo(ProfesiModel::class, 'profesi_id', 'profesi_id');
    }
}
