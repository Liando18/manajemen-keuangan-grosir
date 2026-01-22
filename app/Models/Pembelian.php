<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $fillable = ['supplier_id', 'pembayaran', 'bukti', 'total'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function pembelianItem()
    {
        return $this->hasMany(PembelianItem::class, 'pembelian_id');
    }

    public function hutang()
    {
        return $this->hasOne(Hutang::class, 'pembelian_id');
    }
}
