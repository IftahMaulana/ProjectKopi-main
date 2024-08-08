<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = [
        'sku',
        'nama_product',
        'type',
        'kategory',
        'harga',
        'discount',
        'quantity',
        'quantity_out',
        'foto',
        'deskripsi',
        'is_active',
    ];

    public function getInboundDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
    // public function product()
    // {
    //     return $this->hasOne(tblCart::class, 'id_barang', 'id');
    // }
}
