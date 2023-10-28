<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'idartikel',
        'idkomen',
        'aksi',
        'nama',
        'tglkomen',
        'statuskomen',
        'komentar',
    ];
}
