<x-app-layout title="Barang">
  <x-slot:breadcrumb>
    Barang
  </x-slot:breadcrumb>
  <x-slot:heading>
    Data Barang
  </x-slot:heading>

  <a href="{{ route('barang.create') }}" class="btn btn-primary">Tambah Data</a>
  <a href="{{ route('barang.inactivelist') }}" >Data non aktif</a>

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
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>ID Satuan</th>
                <th>Status</th>
                <th>Harga</th>
                <th>Stok Terbaru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
            <tr>
                <td>{{ $barang->idbarang }}</td>
                <td>{{ $barang->nama }}</td>
                <td>{{ $barang->jenis }}</td>
                <td>{{ $barang->idsatuan }}</td>
                <td>{{ $barang->status }}</td>
                <td>{{ number_format($barang->harga, 0, ',', '.') }}</td>
                <td>{{ $barang->stock ?? 0 }}</td>

                    <td>
                        <a href="{{ route('barang.edit', $barang->idbarang) }}" class="btn btn-sm btn-success">Edit</a>
                        <form action="{{ route('barang.destroy', $barang->idbarang) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Delete</button>
                        </form>
                      </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- End Table with hoverable rows -->

  </div>
</x-app-layout>
