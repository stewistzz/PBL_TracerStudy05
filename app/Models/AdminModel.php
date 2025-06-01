<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    protected $fillable = ['user_id', 'nama', 'email'];

    // Relasi: Satu admin terkait satu user
    public function user()
    {
        return $this->belongsTo(UsersModel::class, 'user_id', 'id');
    }
}