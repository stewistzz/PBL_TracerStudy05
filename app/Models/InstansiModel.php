<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstansiModel extends Model
{
    use HasFactory;
    
    protected $table = 'instansi';
    protected $primaryKey = 'instansi_id';
    
    // DIPERBAIKI: Tambahkan 'alamat' dan 'no_telpon' ke dalam fillable
    protected $fillable = [
        'nama_instansi', 
        'jenis_instansi', 
        'skala', 
        'lokasi',
        'alamat',
        'no_hp'
    ];
    
    // Relasi: Satu instansi punya banyak tracer study
    public function tracerStudies()
    {
        return $this->hasMany(TracerStudyModel::class, 'instansi_id', 'instansi_id');
    }
}