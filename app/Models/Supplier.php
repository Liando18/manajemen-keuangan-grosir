<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable = ['nama', 'kontak', 'alamat'];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }

    public function hutang()
    {
        return $this->hasMany(Hutang::class, 'supplier_id');
    }
}
