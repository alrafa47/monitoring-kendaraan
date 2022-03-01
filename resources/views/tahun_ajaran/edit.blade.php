@extends('layout.index')
@section('title', 'Tahun Ajaran')
@section('judul', 'Tahun Ajaran')
@section('content')

<div class="card">
    <div class="card-header">
      Edit Tahun Ajaran
    </div>
    <div class="card-body">
        @if (session('pesan'))
            <div class="alert alert-{{ session('pesan')->status}} ">
                {{ session('pesan')->message }}
            </div>
        @endif
        <form action={{route('tahunajaran.update', ['id'=>$tahun_ajaran->id])}} method="POST">
            @method('put')
            @csrf
            <div class="form-group">
              <label for="exampleInputEmail1">Tahun Ajaran</label>
              <input type="text" class="form-control" name="Tahun_Ajaran" value="{{old('Tahun_Ajaran', $tahun_ajaran->tahun_ajaran)}}">
              @error('Tahun_Ajaran')
              <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group">
            <label for="text">Status </label>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" name="Status" class="custom-control-input" value="aktif" {{ ($tahun_ajaran->status == 'aktif')?  'checked' : ''}}>
                <label class="custom-control-label" for="customRadio1">Aktif</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="customRadio2" name="Status" class="custom-control-input" value="tidakaktif" {{ ($tahun_ajaran->status == 'tidakaktif')?  'checked' : ''}}>
                <label class="custom-control-label" for="customRadio2">Tidak Aktif</label>
                @error('Status')
                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Ubah</button>
          </form>
    </div>
  </div>

  @endsection
