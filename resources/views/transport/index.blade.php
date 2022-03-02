@extends('layout.index')
@section('title', 'Transport')
@section('content')

    @can('is-admin')
        <div class="card">
            <div class="card-header">
                <h3>
                    Data Inventaris Mobil
                </h3>
            </div>
            <div class="card-body">
                @if (session('pesan'))
                    <div class="alert alert-{{ session('pesan')->status }} ">
                        {{ session('pesan')->message }}
                    </div>
                @endif
                <form action={{ route('transport.store') }} method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Merk</label>
                        <input type="text" class="form-control" name="merk">
                        @error('merk')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Warna</label>
                        <input type="text" class="form-control" name="warna">
                        @error('warna')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Konsumsi Bensin</label>
                        <input type="number" class="form-control" name="konsumsi_bbm">
                        @error('konsumsi_bbm')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Jadwal Service</label>
                        <input type="date" class="form-control" name="jadwal_service">
                        @error('jadwal_service')
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
                List transport
            </h3>
        </div>
        <div class="card-body">
            <form action="/transport" method="GET">
                <div class="input-group">
                    <input class="form-control" type="text" name="search" placeholder="Cari Mobil berdasarkan merk"
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
                        <th>Merk</th>
                        <th>Warna</th>
                        <th>Konsumsi Bensin</th>
                        <th>Jadwal Service</th>
                        @can('is-admin')
                            <th>Action</th>
                        @endcan

                    </tr>
                </thead>
                <tbody>
                    @forelse ($transports as $transport)
                        <tr>
                            <td>{{ $loop->iteration + $transports->firstItem() - 1 }}</td>
                            <td>{{ $transport->merk }}</td>
                            <td>{{ $transport->warna }}</td>
                            <td>{{ $transport->konsumsi_bbm . ' liter' }}</td>
                            <td>{{ $transport->jadwal_service }}</td>
                            @can('is-admin')
                                <td>
                                    <div class="d-flex">
                                        <form action={{ route('transport.destroy', $transport) }} method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger">hapus</button>
                                        </form>
                                        <a class="btn btn-warning" href={{ route('transport.edit', $transport) }}>ubah
                                        </a>
                                        {{-- <a class="btn btn-primary" href={{ route('transport.show', $transport) }}>Detail --}}
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
                {{ $transports->links() }}
            </div>
        </div>
    </div>


@endsection
