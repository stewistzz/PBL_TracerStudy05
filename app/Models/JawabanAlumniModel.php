<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanAlumniModel extends Model
{
    protected $table = 'jawaban_alumni';
    protected $primaryKey = 'jawaban_id';
    
    // Update $fillable sesuai dengan migration
    protected $fillable = [
        'alumni_id', 
        'pertanyaan_id',  // <- Ganti dari 'kode_pertanyaan'
        'jawaban',        // <- Tambahkan ini
        'tanggal'         // <- Tambahkan ini
    ];

    // Relasi: Satu jawaban terkait satu alumni
    public function alumni()
    {
        return $this->belongsTo(AlumniModel::class, 'alumni_id', 'alumni_id');
    }

    // Relasi: Satu jawaban terkait satu pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanModel::class, 'pertanyaan_id', 'pertanyaan_id');
    }
}