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
  
      <form action="{{ route('pengadaan.store') }}" method="post">
        @csrf
        <div class="row mb-3">
          <label for="idbarang" class="col-sm-2 col-form-label">Barang</label>
          <div class="col-sm-10">
            <select name="idbarang" id="idbarang" class="form-select">
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
          <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
          <div class="col-sm-10">
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1">
          </div>
        </div>
      
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form>
      
    </div>

    <!-- Tampilkan Data Pengadaan -->
    <div class="row mt-4">
      <table id="myTable" class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Sub Total</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($dataPengadaan))
            @foreach ($dataPengadaan as $index => $item)
              <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $item['nama_barang'] }}</td>
                <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                <td>{{ $item['jumlah'] }}</td>
                <td>{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                <td>
                  <a href="" class="btn btn-outline-warning">Edit</a>
                  <a href="{{ route('pengadaan.destroy', $index) }}" class="btn btn-outline-danger">Hapus</a>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>

    <div class="d-grid gap-2 mt-3">
      <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#pengadaanModal">Pengadaan Baru</button>
    </div>

    {{-- Table Pengadaan --}}
    @if(!empty($pengadaans))
    <div class="row mt-4">
      <table id="myTable2" class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal Pengadaan</th>
            <th scope="col">Vendor</th>
            <th scope="col">Sub Total</th>
            <th scope="col">PPN</th>
            <th scope="col">Total</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pengadaans as $pengadaan)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $pengadaan->timestamp }}</td>
              <td>{{ $pengadaan->nama_vendor }}</td>
              <td>{{ $pengadaan->subtotal_nilai }}</td>
              <td>{{ $pengadaan->ppn }}</td>
              <td>{{ $pengadaan->total_nilai }}</td>
              <td>
                <a href="" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#detailPengadaanModal">Proses</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

    <!-- Floating Form -->
    {{-- Pertama --}}
    <div id="pengadaanModal" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Lengkapi Data Pengadaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('pengadaan.complete') }}" method="post">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="vendor_idvendor" class="form-label">Vendor</label>
                <select name="vendor_idvendor" id="vendor_idvendor" class="form-select">
                  <option value="" selected>Pilih vendor</option>
                  @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->idvendor }}">{{ $vendor->nama_vendor }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Selesai</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Kedua --}}
    <div id="detailPengadaanModal" class="modal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Penerimaan Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('penerimaan') }}" method="POST">
            @csrf
            <input type="hidden" name="idpengadaan" value="{{ $pengadaan->idpengadaan ?? '' }}">
        
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailPengadaans as $index => $detailPengadaan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detailPengadaan->idbarang }}</td>
                        <td>{{ $detailPengadaan->harga_satuan }}</td>
                        <td>
                            <input type="number" name="barang[{{ $index }}][jumlah]" value="{{ $detailPengadaan->jumlah }}" min="1" class="form-control">
                            <input type="hidden" name="barang[{{ $index }}][idbarang]" value="{{ $detailPengadaan->idbarang }}">
                            <input type="hidden" name="barang[{{ $index }}][harga_satuan]" value="{{ $detailPengadaan->harga_satuan }}">
                        </td>
                        <td>{{ $detailPengadaan->sub_total }}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        
        </div>
      </div>
    </div>
</x-app-layout>