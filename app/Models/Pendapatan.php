<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $table = 'pendapatan';
    protected $fillable = ['sumber', 'pembayaran', 'bukti', 'jumlah', 'keterangan'];
}
