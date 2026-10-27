<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 't003_nilai';
    protected $fillable = ['mahasiswa_id', 'matakuliah_id', 'nilai_angka', 'nilai_huruf'];

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }
}

