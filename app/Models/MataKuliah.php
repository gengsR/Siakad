<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $table='matakuliah';

    protected $fillable=[
        'id',
        'nama_matkul',
        'sks',
        'jam',
        'semester',
    ];

    public function mahasiswa_matakuliah()
    {
        return $this->belongsToMany(Mahasiswa_MataKuliah::class, 'matakuliah_id');
    }
}
