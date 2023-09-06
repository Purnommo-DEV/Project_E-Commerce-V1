<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alamat extends Model
{
    use HasFactory;
    protected $table = 'alamat';
    protected $guarded = ['id'];

    public static function func_alamat_engguna(){
        $alamat_pengguna = Alamat::where([
            'users_id' => Auth::user()->id,
            'alamat_utama' => 1
            ])->first();
        return $alamat_pengguna;
    }
    public function relasi_user(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function relasi_provinsi(){
        return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id');
    }
    public function relasi_kota(){
        return $this->belongsTo(Kota::class, 'kota_id', 'id');
    }
}
