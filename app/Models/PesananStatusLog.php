<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananStatusLog extends Model
{
    use HasFactory;
    protected $table = 'pesanan_status_log';
    protected $guarded = ['id'];

    public function relasi_pesanan(){
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'uuid');
    }

    public function relasi_status_master(){
        return $this->belongsTo(PesananStatusMaster::class, 'status_pesanan_id', 'id');
    }
}
