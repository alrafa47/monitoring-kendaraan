@extends('layout.index')
@section('title', 'Karyawan')
@section('content')

    <div class="card">
        <div class="card-header">
            Edit Karyawan
        </div>
        <div class="card-body">
            @if (session('pesan'))
                <div class="alert alert-{{ session('pesan')->status }} ">
                    {{ session('pesan')->message }}
                </div>
            @endif
            <form action={{ route('employee.update', $employee) }} method="POST">
                @method('put')
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="nama" value="{{ old('nama', $employee->nama) }}">
                    @error('nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Telp</label>
                    <input type="text" class="form-control" name="telp" value="{{ old('telp', $employee->telp) }}">
                    @error('telp')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" name="alamat"
                        value="{{ old('alamat', $employee->alamat) }}">
                    @error('alamat')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>

@endsection
