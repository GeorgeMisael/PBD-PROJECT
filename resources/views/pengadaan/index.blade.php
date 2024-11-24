<x-app-layout title="Pengadaan">
  <x-slot:breadcrumb>
    Pengadaan
  </x-slot:breadcrumb>
  
  <x-slot:heading>
    Data Pengadaan
  </x-slot:heading>

  <div class="card-body">
    <div class="row">
      <h5 class="card-title">Pengadaan Baru</h5>
      
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
  
      <form action="" method="post">
        @csrf
        <div class="row mb-3">
          <label for="idrole" class="col-sm-2 col-form-label">Barang</label>
          <div class="col-sm-10">
            <select name="idrole" id="idrole" class="form-select">
              <option value="" selected>Pilih barang</option>
              @foreach ($barangs as $barang)
                <option value="{{ $barang->idbarang }}">
                  {{ $barang->nama }} : {{ $barang->harga }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <label for="nama" class="col-sm-2 col-form-label">Jumlah</label>
          <div class="col-sm-10">
            <input type="text" name="nama" id="nama" class="form-control">
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form>
    </div>

    <div class="row">
      <table id="myTable" class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Harga</th>
            <th scope="col">Satuan</th>
            <th scope="col">Sub Total</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Celana</td>
            <td>70.000</td>
            <td>pcs</td>
            <td>500.000.000</td>
            <td>
              <a href="" class="btn btn-outline-warning">Edit</a>
              <a href="" class="btn btn-outline-danger">Hapus</a>
            </td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Celana</td>
            <td>70.000</td>
            <td>pcs</td>
            <td>500.000.000</td>
            <td>
              <a href="" class="btn btn-outline-warning">Edit</a>
              <a href="" class="btn btn-outline-danger">Hapus</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>