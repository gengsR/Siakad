@extends('mahasiswa.layout')
@section('content')
<div class="container">
    <div class="justify-content-center align-items-center">
        <div class="d-flex justify-content-center mt-1">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
        <div class="d-flex justify-content-center my-3">
            <h1 class="text-center">KARTU HASIL STUDI (KHS)</h1>
        </div>
        <a class="btn btn-success float-right" href="{{ route('cetak', $mahasiswa->nim) }}"> Cetak KHS</a>
        <div class="row">
            <ul class="" style="list-style-type: none;">
                <li><b>Nama : </b>{{$mahasiswa->nama}}</li>
                <li><b>Nim : </b>{{$mahasiswa->nim}}</li>
                <li><b>Kelas : </b>{{$mahasiswa->kelas->nama_kelas}}</li>
            </ul>
        </div>

        <table class="table table-bordered">
            <thead>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Nilai Angka</th>
                <th>Nilai Huruf</th>
            </thead>
            <tbody>
                @foreach ($matakuliah as $mk)
                <tr>
                    <td>
                        {{$mk->matakuliah->nama_matkul}}
                    </td>
                    <td>
                        {{$mk->matakuliah->sks}}
                    </td>
                    <td>
                        {{$mk->matakuliah->semester}}
                    </td>
                    <td>
                        {{$mk ->nilai_angka}}
                    </td>
                    <td>
                        {{$mk ->nilai_huruf}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-success" href="{{ route('mahasiswa.index') }}">Kembali</a>
    </div>
</div>