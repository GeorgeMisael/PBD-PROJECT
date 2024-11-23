<x-app-layout title="Satuan">
  <x-slot:breadcrumb>
    Satuan
  </x-slot:breadcrumb>
  <x-slot:heading>
    Data Vendor
  </x-slot:heading>

  <a href="{{ route('satuan.create') }}" class="btn btn-primary">Tambah Data</a>
  <a href="{{ route('satuan.inactive.list') }}" >Satuan Non Aktif</a>
  
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
          <th scope="col">Nama Satuan</th>
          <th scope="col">Status</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($satuans as $satuan)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $satuan->nama_satuan }}</td>
            <td>
                <span class="badge bg-success">Aktif</span>
            </td>
            <td>
                <a href="{{ route('satuan.inactive', $satuan->idsatuan) }}" class="btn btn-outline-danger">Non Aktifkan</a>
            </td>
        </tr>
        @endforeach
    </tbody>    
    </table>
    <!-- End Table with hoverable rows -->

  </div>
</x-app-layout>