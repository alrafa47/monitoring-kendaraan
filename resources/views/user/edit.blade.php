@extends('layout.index')
@section('title', 'User')
@section('content')

    <div class="card">
        <div class="card-header">
            Edit User
        </div>
        <div class="card-body">
            @if (session('pesan'))
                <div class="alert alert-{{ session('pesan')->status }} ">
                    {{ session('pesan')->message }}
                </div>
            @endif
            <form action={{ route('user.update', $user) }} method="POST">
                @method('put')
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                    @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Role</label>
                    {{ $user->role }}
                    <select name="role" class="form-control">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kabag_umum" {{ $user->role == 'kabag_umum' ? 'selected' : '' }}>Kepala Bagian Umum
                        </option>
                        <option value="kabag_pegawai" {{ $user->role == 'kabag_pegawai' ? 'selected' : '' }}>Kepala
                            Bagian Kepegawaian</option>
                    </select>
                    @error('role')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>

@endsection
