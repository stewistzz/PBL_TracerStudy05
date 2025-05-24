<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProfesiModel extends Model
{
    protected $table = 'kategori_profesi';
    protected $primaryKey = 'kategori_id';
    protected $fillable = ['nama_kategori'];

    // Relasi: Satu kategori punya banyak profesi
    public function profesi()
    {
        return $this->hasMany(ProfesiModel::class, 'kategori_id', 'kategori_id');
    }

    // Relasi: Satu kategori punya banyak tracer study
    public function tracerStudies()
    {
        return $this->hasMany(TracerStudyModel::class, 'kategori_profesi_id', 'kategori_id');
    }
}
