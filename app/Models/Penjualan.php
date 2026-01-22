<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $fillable = ['pembayaran', 'bukti', 'total'];

    public function penjualanItem()
    {
        return $this->hasMany(PenjualanItem::class, 'penjualan_id');
    }

    public function piutang()
    {
        return $this->hasOne(Piutang::class, 'penjualan_id');
    }
}
