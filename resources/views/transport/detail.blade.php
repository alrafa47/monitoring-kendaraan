@extends('layout.index')
@section('title', 'Detail Karyawan')
@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Karyawan</h3>
                </div>
                <div class="card-body">
                    <h5>Nama</h5>
                    <h5 class="font-weight-bold">{{ $employee->nama }}</h5>
                    <h5>Alamat</h5>
                    <h5 class="font-weight-bold">{{ $employee->alamat }}</h5>
                    <h5>Telp</h5>
                    <h5 class="font-weight-bold">{{ $employee->telp }}</h5>
                </div>
                <div class="card-footer">
                    <a class="btn btn-warning" href={{ route('employee.edit', $employee) }}>ubah Data Karyawan
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Rekap Penggunaan Transportasi
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tipe Mobil(warna)</th>
                                <th>Tanggal Keluar</th>
                                <th>Tanggal Kembali</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employee->rentals as $rent)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rent->car->merk . "({$loop->iteration->car->warna})" }}</td>
                                    <td>{{ $rent->tgl_keluar }}</td>
                                    <td>{{ $rent->tgl_kembali }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        Tidak ada Data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
