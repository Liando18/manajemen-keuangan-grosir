<?php

// app/Models/Akun.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun';
    protected $fillable = ['email', 'password', 'nama', 'role'];
    protected $hidden = ['password'];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'kasir_id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'kasir_id');
    }
}
