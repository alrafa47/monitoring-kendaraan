@extends('layout.index')
@section('title', 'Tahun Ajaran')
@section('judul', 'Tahun Ajaran')
@section('content')

<div class="card">
    <div class="card-header">
      Tahun Ajaran
    </div>
    <div class="card-body">
        @if (session('pesan'))
            <div class="alert alert-{{ session('pesan')->status}} ">
                {{ session('pesan')->message }}
            </div>
        @endif
        <form action={{route('tahunajaran.store')}} method="POST">
            @method('post')
            @csrf
            <div class="form-group">
              <label for="exampleInputEmail1">Tahun Ajaran</label>
              <input type="text" class="form-control" name="Tahun_Ajaran">
              @error('Tahun_Ajaran')
              <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
            <label for="text">Status </label>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" name="Status" class="custom-control-input" value="aktif">
                <label class="custom-control-label" for="customRadio1">Aktif</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="customRadio2" name="Status" class="custom-control-input" value="tidakaktif">
                <label class="custom-control-label" for="customRadio2">Tidak Aktif</label>
                @error('Status')
                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
    </div>
  </div>

  <div class="card">
    <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Tahun Ajaran</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @forelse ( $data as $item)
                <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$item->tahun_ajaran}}</td>
                <td>{{$item->status}}</td>
                <td>
                    <div class="d-flex">
                    <form action={{route('tahunajaran.destroy', ['id'=>$item->id])}} method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">hapus</button>
                    </form>
                    <a class="btn btn-warning" href={{route('tahunajaran.edit', ['id'=>$item->id])}}>ubah
                    </a>
                    </div>
                </td>
              </tr>
            @empty
            <th colspan="4">{{"Tidak Ada Data"}}</th>
            @endforelse

        </tbody>
      </table>
</div>

  @endsection
