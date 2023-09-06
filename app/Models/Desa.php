<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $table = 'indonesia_villages';
    protected $guarded = ['id'];

    public function relasi_kecamatan(){
        return $this->belongsTo(Kecamatan::class, 'district_code', 'code');
    }
}
