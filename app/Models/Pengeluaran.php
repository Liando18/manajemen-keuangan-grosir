<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    protected $fillable = ['sumber', 'pembayaran', 'bukti', 'jumlah', 'keterangan'];
}
