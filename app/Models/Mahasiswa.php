<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model; //Model Eloquen
use App\Models\Kelas;


class Mahasiswa extends Model
{
    protected $table='mahasiswa'; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswa
    // protected $primaryKey = 'id_mahasiswa'; // Memanggil isi DB Dengan primarykey
    protected $primaryKey = 'nim'; // Memanggil isi DB Dengan primarykey

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
protected $fillable = [
    'nim',
    'nama',
    'kelas',
    'jurusan',
    'Jenis_kelamin',
    'Email',
    'Alamat',
    'Tanggal_lahir',
    'kelas_id',
    'Foto',
 ];

 
 public function kelas()
 {
     return $this->belongsTo(Kelas::class);
     
 }

 public function mahasiswa_matakuliah()
    {
        return $this->belongsToMany(Mahasiswa_MataKuliah::class, 'matakuliah_id');
    }
}
