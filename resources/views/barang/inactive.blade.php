<x-app-layout title="Barang">
  <x-slot:breadcrumb>
    Barang
  </x-slot:breadcrumb>
  <x-slot:heading>
    Data Barang
  </x-slot:heading>
  
  <div class="card-body">
    <h5 class="card-title">Table Data Role</h5>
    
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

    <!-- Table with hoverable rows -->
    <table id="myTable" class="table table-hover">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Jenis Barang</th>
          <th scope="col">Nama Barang</th>
          <th scope="col">Harga</th>
          <th scope="col">Satuan</th>
          <th scope="col">Status</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ( $barangs as $barang )
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $barang->jenis }}</td>
          <td>{{ $barang->nama_barang }}</td>
          <td>{{ $barang->harga }}</td>
          <td>{{ $barang->nama_satuan }}</td>
          <td>
            <span class="badge bg-danger">Non Aktif</span>
        </td>
          <td>
            <a href="{{ route('barang.edit', $barang->idbarang) }}" class="btn btn-outline-warning">Edit</a>
            <a href="{{ route('barang.active', $barang->idbarang) }}" class="btn btn-outline-success">Aktifkan</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <a href="{{ route('barang') }}" class="btn btn-danger">Kembali</a>
  </div>
</x-app-layout>