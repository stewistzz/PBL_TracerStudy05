<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UsersModel extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    // Relasi ke admin
    public function admin()
    {
        return $this->hasOne(AdminModel::class, 'user_id', 'user_id');
    }

    // Relasi ke alumni
    public function alumni()
    {
        return $this->hasOne(AlumniModel::class, 'user_id', 'user_id');
    }

    // Cek role user (sesuai enum di database)
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}