@extends('layout.index')
@section('title', 'Rental')
@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                Data Rental
            </h3>
        </div>
        <div class="card-body">
            @if (session('pesan'))
                <div class="alert alert-{{ session('pesan')->status }} ">
                    {{ session('pesan')->message }}
                </div>
            @endif
            <form action={{ route('rental.store') }} method="POST">
                @csrf
                <div class="form-group">
                    <label>Driver</label>
                    <select name="driver" class="form-control">
                        @forelse ($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->nama }}</option>
                        @empty
                            <option value="">Belum ada Driver Terdaftar</option>
                        @endforelse
                    </select>
                    @error('driver')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Mobil</label>
                    <select name="transport" class="form-control">
                        @forelse ($transports as $transport)
                            <option value="{{ $transport->id }}">{{ "$transport->merk ({$transport->warna})" }}</option>
                        @empty
                            <option value="">Belum ada Kendaraan Terdaftar</option>
                        @endforelse
                    </select>
                    @error('transport')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>
                List rental
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Driver</th>
                        <th>Merk Mobil (warna)</th>
                        <th>Acc kabag Kepegawaian</th>
                        <th>Acc kabag Umum</th>
                        <th>Tanggal Keluar</th>
                        <th>Tanggal Masuk</th>
                        @can('is-admin')
                            <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rentals as $rental)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rental->employee->nama }}</td>
                            <td>{{ "{$rental->transport->merk} ({$rental->transport->warna})" }}</td>
                            <td>
                                @can('is-kabag_pegawai')
                                    @if ($rental->acc_divisi_kepegawaian)
                                        {{ "disetujui pada {$rental->acc_divisi_kepegawaian}" }}
                                    @else
                                        <form action={{ route('rental.acc', $rental) }} method="POST">
                                            @csrf
                                            <button class="btn btn-success">Acc</button>
                                        </form>
                                    @endif
                                @else
                                    {{ $rental->acc_divisi_kepegawaian ? "disetujui pada {$rental->acc_divisi_kepegawaian}" : 'Belum Disetujui' }}
                                @endcan
                            </td>
                            <td>
                                @can('is-kabag_umum')
                                    @if ($rental->acc_divisi_umum)
                                        {{ "disetujui pada {$rental->acc_divisi_umum}" }}
                                    @else
                                        <form action={{ route('rental.acc', $rental) }} method="POST">
                                            @csrf
                                            <button class="btn btn-success">Acc</button>
                                        </form>
                                    @endif
                                @else
                                    {{ $rental->acc_divisi_umum ? "disetujui pada {$rental->acc_divisi_umum}" : 'Belum Disetujui' }}
                                </td>
                            @endcan
                            <td>{{ $rental->tgl_keluar ?? '-' }}</td>
                            <td>{{ $rental->tgl_kembali ?? '-' }}</td>
                            @can('is-admin')
                                <td>
                                    <div class="d-flex">
                                        <form action={{ route('rental.destroy', $rental) }} method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger">hapus</button>
                                        </form>
                                        <a class="btn btn-warning" href={{ route('rental.edit', $rental) }}>ubah
                                        </a>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                Tidak ada Data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@endsection
