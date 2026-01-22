<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
    protected $fillable = ['nama', 'singkatan', 'keterangan'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'satuan_id');
    }
}
