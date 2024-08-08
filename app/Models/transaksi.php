<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksis';
    public $timestamps = true;
    protected $fillable = [
        'code_transaksi',
        'user_id',
        'total_qty',
        'total_harga',
        'nama_customer',
        'alamat',
        'no_tlp',
        'ekspedisi',
        'status',
        
    ];
    protected $hidden;

    public function detailTransaksi()
    {
        return $this->hasMany(modelDetailTransaksi::class, 'code_transaksi', 'code_transaksi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    

    
    
}
