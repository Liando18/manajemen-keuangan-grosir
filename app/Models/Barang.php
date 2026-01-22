<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['kategori_id', 'satuan_id', 'nama', 'harga'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function stok()
    {
        return $this->hasOne(Stok::class, 'barang_id');
    }

    public function pembelianItem()
    {
        return $this->hasMany(PembelianItem::class, 'barang_id');
    }

    public function penjualanItem()
    {
        return $this->hasMany(PenjualanItem::class, 'barang_id');
    }
}
