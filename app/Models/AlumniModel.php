<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniModel extends Model
{
    use HasFactory;
    
    protected $table = 'alumni';
    protected $primaryKey = 'alumni_id';
    
    // DIPERBAIKI: Tambahkan semua field yang ada di database
    protected $fillable = [
        'user_id', 
        'nama', 
        'nim', 
        'email', 
        'no_hp', 
        'program_studi', 
        'tahun_lulus'
    ];
    
    // Cast untuk date
    protected $casts = [
        'tahun_lulus' => 'date'
    ];
    
    // Relasi: Satu alumni terkait satu user
 public function user()
{
    return $this->belongsTo(UsersModel::class, 'user_id', 'user_id'); // awalnya user_id -> id, tapi salah. harusnya user_id -> user_id
}

    
    // Relasi: Satu alumni punya banyak tracer study
    public function tracerStudies()
    {
        return $this->hasMany(TracerStudyModel::class, 'alumni_id', 'alumni_id');
    }
    
    // Relasi: Alumni terkait banyak atasan (many-to-many)
    public function penggunaLulusan()
    {
        return $this->belongsToMany(PenggunaLulusanModel::class, 'alumni_pengguna_lulusan', 'alumni_id', 'pengguna_id');
    }
    
    // Relasi: Satu alumni punya banyak jawaban
    public function jawabanAlumni()
    {
        return $this->hasMany(JawabanAlumniModel::class, 'alumni_id', 'alumni_id');
    }
}