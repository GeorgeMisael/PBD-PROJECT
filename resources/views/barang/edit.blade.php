<x-app-layout title="Tambah Barang">
  <x-slot:breadcrumb>
    Tambah Barang
  </x-slot:breadcrumb>
  <x-slot:heading>
    Tambah Barang Baru
  </x-slot:heading>

  <div class="card-body">
    <h5 class="card-title">Masukkan Data Barang Baru</h5>

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <!-- Horizontal Form -->
    <form action="{{ route('barang.update', $barang->idbarang) }}" method="post">
      @csrf
      <div class="row mb-3">
        <label for="jenis" class="col-sm-2 col-form-label">Jenis Barang</label>
        <div class="col-sm-10">
          <input type="text" name="jenis" id="jenis" value="{{ $barang->jenis }}" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="nama" class="col-sm-2 col-form-label">Nama Barang</label>
        <div class="col-sm-10">
          <input type="text" name="nama" id="nama" value="{{ $barang->nama }}" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="harga" class="col-sm-2 col-form-label">Harga Barang</label>
        <div class="col-sm-10">
          <input type="text" name="harga" id="harga" value="{{ $barang->harga }}" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="idsatuan" class="col-sm-2 col-form-label">Satuan</label>
        <div class="col-sm-10">
          <select name="idsatuan" id="idsatuan" class="form-select" aria-label="Pilih role parent">
            <option value="" selected>Pilih Satuan</option>
            @foreach ($satuans as $satuan)
            <option value="{{ $satuan->idsatuan }}">{{ $satuan->nama_satuan }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <label for="status" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
          <select name="status" id="status" class="form-select" aria-label="Pilih role parent">
            @if ($barang->status == 1)
            <option value="1">Aktif</option>
            <option value="0">Non Aktif</option>
            @elseif ($barang->status == 0)
            <option value="0">Non Aktif</option>
            <option value="1">Aktif</option>
            @endif
          </select>
        </div>
      </div>
      {{-- <div class="row mb-3">
        <label for="status" class="col-sm-2 col-form-label">Status Barang</label>
        <div class="col-sm-10">
          <input type="text" name="status" id="status" class="form-control">
        </div>
      </div> --}}
      
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form>
    <!-- End Horizontal Form -->

    <a href="{{ route('barang') }}" class="btn btn-danger">Kembali</a>

  </div>

  </div>
</x-app-layout>