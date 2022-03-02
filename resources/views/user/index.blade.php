@extends('layout.index')
@section('title', 'user')
@section('content')
    @can('is-admin')
        <div class="card">
            <div class="card-header">
                <h3>
                    Data user
                </h3>
            </div>
            <div class="card-body">
                @if (session('pesan'))
                    <div class="alert alert-{{ session('pesan')->status }} ">
                        {{ session('pesan')->message }}
                    </div>
                @endif
                <form action={{ route('user.store') }} method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name">
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email">
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                        @error('password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="kabag_umum">Kepala Bagian Umum</option>
                            <option value="kabag_pegawai">Kepala Bagian Kepegawaian</option>
                        </select>
                        @error('role')
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
                List user
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        @can('is-admin')
                            <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            @can('is-admin')
                                <td>
                                    <div class="d-flex">
                                        <form action={{ route('user.destroy', $user) }} method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger">hapus</button>
                                        </form>
                                        <a class="btn btn-warning" href={{ route('user.edit', $user) }}>ubah
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
                {{ $users->links() }}
            </div>
        </div>
    </div>


@endsection
