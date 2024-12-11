<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    protected $table = 'coa';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'header_akun',
        'saldo',
    ];

    /**
     * Get the COA details for a company (header_akun = 1).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getCoaDetailPerusahaan()
    {
        return self::where('header_akun', 1)->get();
    }
}
