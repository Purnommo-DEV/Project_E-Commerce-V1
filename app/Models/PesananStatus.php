<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananStatus extends Model
{
    use HasFactory;
    protected $table = 'pesanan_status';
    protected $guarded = ['id'];

    public function relasi_status_master(){
        return $this->belongsTo(PesananStatusMaster::class, 'status_pesanan_id', 'id');
    }
}
