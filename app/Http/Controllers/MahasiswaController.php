<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
 {
    //yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
    $mahasiswa = Mahasiswa::with('kelas')->get();
    $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
    return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);
   //   if (request('search')) {
   //    $paginate = Mahasiswa::where('nim', 'like', '%' . request('search') . '%')
   //        ->orwhere('nim', 'like', '%' . request('search') . '%')
   //        ->orwhere('nama', 'like', '%' . request('search') . '%')
   //        ->orwhere('kelas', 'like', '%' . request('search') . '%')
   //        ->orwhere('jurusan', 'like', '%' . request('search') . '%')
   //        ->orwhere('Jenis_kelamin', 'like', '%' . request('search') . '%')
   //        ->orwhere('Email', 'like', '%' . request('search') . '%')
   //        ->orwhere('alamat', 'like', '%' . request('search') . '%')
   //        ->orwhere('Tanggal_lahir', 'like', '%' . request('search') . '%')
   //        ->orwhere('jurusan', 'like', '%' . request('search') . '%')->paginate(5);
   //    return view('mahasiswa.index', ['paginate' => $paginate]);
//   } else {
//       //fungsi eloquent menampilkan data menggunakan pagination
//       $mahasiswa = Mahasiswa::all(); // Mengambil semua isi tabel
//       $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(5);
//       return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
// }
 }
    public function create()
 {
    $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
    return view('mahasiswa.create',['kelas'=> $kelas]);
 }
    public function store(Request $request)
 {
   if ($request->file('foto')) {
      $image_name = $request->file('foto')->store('fotos', 'public');
  } else {
      $image_name = 'default.jpg';
  }
    //melakukan validasi data
    $request->validate([
      'Nim' => 'required',
      'Nama' => 'required',
      'Kelas' => 'required',
      'Jurusan' => 'required',
      'Jenis_kelamin' => 'required',
      'Email' => 'required',
      'Alamat' => 'required',
      'Tanggal_lahir' => 'required',
      
  ]);
        $Mahasiswa = new Mahasiswa;
        $Mahasiswa->nim = $request->get('Nim');
        $Mahasiswa->nama = $request->get('Nama');
        $Mahasiswa->jurusan = $request->get('Jurusan');
        $Mahasiswa->kelas_id = $request->get('Kelas');
        $Mahasiswa->Jenis_kelamin = $request->get('Jenis_kelamin');
        $Mahasiswa->Email = $request->get('Email');
        $Mahasiswa->Alamat = $request->get('Alamat');
        $Mahasiswa->Tanggal_lahir = $request->get('Tanggal_lahir');
        $Mahasiswa->Foto = $image_name;
        $Mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $Mahasiswa->kelas()->associate($kelas);
        $Mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success','Mahasiswa Berhasil Ditambahakan');
   //   //fungsi eloquent untuk menambah data
   //  Mahasiswa::create($request->all());

   //  //jika data berhasil ditambahkan, akan kembali ke halaman utama
   //  return redirect()->route('mahasiswa.index')
   //  ->with('success', 'Mahasiswa Berhasil Ditambahkan');
 }
     public function show($nim)
 {
     //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
     $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();

     return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
   //  $Mahasiswa = Mahasiswa::where('nim', $nim)->first();
   //   return view('mahasiswa.detail', compact('Mahasiswa'));
 }
    public function edit($nim)
 {
    //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
    $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
    $kelas = Kelas::all(); //mendapatkan dari tabel kelas
    return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
 }
     public function update(Request $request, $nim)
 {
    //melakukan validasi data
     $request->validate([
      'Nim' => 'required',
      'Nama' => 'required',
      'Kelas' => 'required',
      'Jurusan' => 'required',
      'Jenis_kelamin' => 'required',
      'Email' => 'required',
      'Alamat' => 'required',
      'Tanggal_lahir' => 'required',
 ]);
    //fungsi eloquent untuk mengupdate data inputan kita
    $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
    if ($Mahasiswa->foto && file_exists(storage_path('app/public/' . $Mahasiswa->foto))) {
      Storage::delete('public/' . $Mahasiswa->foto);  
  }
  $image_name = $request->file('foto')->store('fotos', 'public');
    $Mahasiswa->nim = $request->get('Nim');
    $Mahasiswa->nama = $request->get('Nama');
    $Mahasiswa->kelas_id = $request->get('Kelas');
    $Mahasiswa->jurusan = $request->get('Jurusan');
    $Mahasiswa->Jenis_kelamin = $request->get('Jenis_kelamin');
    $Mahasiswa->Email = $request->get('Email');
    $Mahasiswa->Alamat = $request->get('Alamat');
    $Mahasiswa->Tanggal_lahir = $request->get('Tanggal_lahir');
    $Mahasiswa->Foto = $image_name;
    $Mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('Kelas');

    //fungsi eloquent untuk menambah data dengan relasi belongsTo
    $Mahasiswa->kelas()->associate($kelas);
    $Mahasiswa->save();

    //jika data berhasil ditambahkan, akan kembali ke halaman utama
    return redirect()->route('mahasiswa.index')
    ->with('success','Mahasiswa Berhasil Ditambahakan');
   
  
 }
    public function destroy( $nim)
 {
    //fungsi eloquent untuk menghapus data
    Mahasiswa::where('nim', $nim)->delete();
    return redirect()->route('mahasiswa.index')
   ->with('success','Mahasiswa Berhasil Dihapus');
 }
 
 public function nilai($nim)
 {
     $mhs = Mahasiswa::with('kelas')->where("nim", $nim)->first();
     $matkul = Mahasiswa_Matakuliah::with("matakuliah")->where("mahasiswa_id", ($mhs -> id_mahasiswa))->get();
     return view('mahasiswa.nilai', ['mahasiswa' => $mhs,'matakuliah'=>$matkul]);
 }
 public function cetak($nim)
 {
   $mhs = Mahasiswa::with('kelas')->where("nim", $nim)->first();
   $matkul = Mahasiswa_Matakuliah::with("matakuliah")->where("mahasiswa_id", ($mhs -> id_mahasiswa))->get();
   // $matkul = Mahasiswa_Matakuliah::where('matakuliah_id', ($mhs -> id_mahasiswa))->first();
   $pdf = PDF::loadview('mahasiswa.cetak', ['mahasiswa' => $mhs,'matakuliah'=>$matkul]);
   return $pdf->stream();

}
 
};
    