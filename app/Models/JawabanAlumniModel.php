<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanAlumniModel extends Model
{
    protected $table = 'jawaban_alumni';
    protected $primaryKey = 'jawaban_id';
    protected $fillable = ['alumni_id', 'kode_pertanyaan', 'opsi_id'];

    // Relasi: Satu jawaban terkait satu alumni
    public function alumni()
    {
        return $this->belongsTo(AlumniModel::class, 'alumni_id', 'alumni_id');
    }

    // Relasi: Satu jawaban terkait satu pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanModel::class, 'kode_pertanyaan', 'kode_pertanyaan');
    }

    // Relasi: Satu jawaban terkait satu opsi
    public function opsiPilihan()
    {
        return $this->belongsTo(OpsiPilihanModel::class, 'opsi_id', 'opsi_id');
    }
}