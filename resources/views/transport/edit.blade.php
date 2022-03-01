@extends('layout.index')
@section('title', 'Transport')
@section('content')

    <div class="card">
        <div class="card-header">
            Edit Transport
        </div>
        <div class="card-body">
            @if (session('pesan'))
                <div class="alert alert-{{ session('pesan')->status }} ">
                    {{ session('pesan')->message }}
                </div>
            @endif
            <form action={{ route('transport.update', $transport) }} method="POST">
                @method('put')
                @csrf
                <div class="form-group">
                    <label>Merk</label>
                    <input type="text" class="form-control" name="merk" value="{{ old('merk', $transport->merk) }}">
                    @error('merk')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Warna</label>
                    <input type="text" class="form-control" name="warna" value="{{ old('warna', $transport->warna) }}">
                    @error('warna')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Konsumsi Bensin</label>
                    <input type="number" class="form-control" name="konsumsi_bbm"
                        value="{{ old('konsumsi_bbm', $transport->konsumsi_bbm) }}">
                    @error('konsumsi_bbm')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Jadwal Service</label>
                    <input type="date" class="form-control" name="jadwal_service"
                        value="{{ old('jadwal_service', $transport->jadwal_service) }}">
                    @error('jadwal_service')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>

@endsection
