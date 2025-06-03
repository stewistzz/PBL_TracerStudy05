<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JawabanPenggunaModel;


class DataPenggunaModel extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'pengguna_lulusan';

    // Menentukan primary key secara eksplisit
    protected $primaryKey = 'pengguna_id';

    // Atribut yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'nama',
        'instansi',
        'jabatan',
        'no_hp',
        'email',
    ];

    // modifikasi
    public function jawaban()
    {
        return $this->hasMany(JawabanPenggunaModel::class, 'pengguna_id', 'pengguna_id');
    }
}
