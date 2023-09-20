<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananStatusMaster extends Model
{
    use HasFactory;
    protected $table = 'pesanan_status_master';
    protected $guarded = ['id'];
}
