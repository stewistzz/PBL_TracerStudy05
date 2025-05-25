<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesiModel extends Model
{
    protected $table = 'profesi';
    protected $primaryKey = 'profesi_id';
    protected $fillable = ['nama_profesi', 'kategori_id'];

    // Relasi: Satu profesi terkait satu kategori
    public function kategoriProfesi()
    {
        return $this->belongsTo(KategoriProfesiModel::class, 'kategori_id', 'kategori_id');
    }

    // Relasi: Satu profesi punya banyak tracer study
    public function tracerStudies()
    {
        return $this->hasMany(TracerStudyModel::class, 'profesi_id', 'profesi_id');
    }
}
