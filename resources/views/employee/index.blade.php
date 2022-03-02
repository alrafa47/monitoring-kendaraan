@extends('layout.index')
@section('title', 'Karyawan')
@section('content')

    @can('is-admin')
        <div class="card">
            <div class="card-header">
                <h3>
                    Data Karyawan
                </h3>
            </div>
            <div class="card-body">
                @if (session('pesan'))
                    <div class="alert alert-{{ session('pesan')->status }} ">
                        {{ session('pesan')->message }}
                    </div>
                @endif
                <form action={{ route('employee.store') }} method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama">
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Telp</label>
                        <input type="text" class="form-control" name="telp">
                        @error('telp')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat">
                        @error('alamat')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <h3>
                List Karyawan
            </h3>
        </div>
        <div class="card-body">
            <form action="/employee" method="GET">
                <div class="input-group">
                    <input class="form-control" type="text" name="search" placeholder="Cari User berdasarkan nama"
                        value="{{ old('search') }}">
                    <div class="input-group-append">
                        <input type="submit" class="btn btn-primary" value="CARI">
                    </div>
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telp</th>
                        <th>Alamat</th>
                        @can('is-admin')
                            <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <td>{{ $loop->iteration + $employees->firstItem() - 1 }}</td>
                            <td>{{ $employee->nama }}</td>
                            <td>{{ $employee->telp }}</td>
                            <td>{{ $employee->alamat }}</td>
                            @can('is-admin')
                                <td>
                                    <div class="d-flex">
                                        <form action={{ route('employee.destroy', $employee) }} method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger">hapus</button>
                                        </form>
                                        <a class="btn btn-warning" href={{ route('employee.edit', $employee) }}>ubah
                                        </a>
                                        <a class="btn btn-primary" href={{ route('employee.show', $employee) }}>Detail
                                        </a>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                Tidak ada Data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="float-right mt-2">
                {{ $employees->links() }}
            </div>
        </div>
    </div>


@endsection
