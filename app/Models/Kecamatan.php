<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'indonesia_districts';
    protected $guarded = ['id'];

    public function relasi_kota(){
        return $this->belongsTo(Kota::class, 'city_code', 'code');
    }
}
