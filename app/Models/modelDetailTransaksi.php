<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelDetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksis';
    public $timestamps = true;
    protected $fillable = [
        'code_transaksi',
        'id_barang',
        'qty',
        'price',
        'status',
    ];


    public function product()
    {
        return $this->belongsTo(product::class, 'id_barang');
    }
}
