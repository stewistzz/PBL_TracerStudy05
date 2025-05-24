<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstansiModel extends Model
{
    protected $table = 'instansi';
    protected $primaryKey = 'instansi_id';
    protected $fillable = ['nama_instansi', 'jenis_instansi', 'skala', 'lokasi'];

    // Relasi: Satu instansi punya banyak tracer study
    public function tracerStudies()
    {
        return $this->hasMany(TracerStudyModel::class, 'instansi_id', 'instansi_id');
    }
}