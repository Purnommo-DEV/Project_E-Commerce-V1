<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'pesanan';
    protected $guarded = ['id'];

    public function relasi_user(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function relasi_alamat_pengiriman(){
        return $this->belongsTo(Alamat::class, 'alamat_pengiriman_id', 'id');
    }

    public function relasi_pesanan_status(){
        return $this->hasOne(PesananStatus::class);
    }
}
