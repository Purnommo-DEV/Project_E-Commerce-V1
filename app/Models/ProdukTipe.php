<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukTipe extends Model
{
    use HasFactory;
    protected $table = 'produk_tipe';
    protected $guarded = ['id'];
}
