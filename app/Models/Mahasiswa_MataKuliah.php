<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa_MataKuliah extends Model
{
    use HasFactory;
    protected $table='mahasiswa_matakuliah';

    protected $fillable = [
        'Mahasiswa_id',
        'Matakuliah_id',
        'Nilai_angka',
        'Nilai_huruf',
    ];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'mahasiswa_id','id_mahasiswa');
    }

    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class,'matakuliah_id');
    }
    
}
