<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 't003_mahasiswa';
    protected $fillable = ['user_id', 'nim', 'nama', 'angkatan', 'email', 'foto'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mahasiswa_id');
    }
}
