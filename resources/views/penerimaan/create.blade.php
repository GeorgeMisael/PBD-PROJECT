<x-app-layout title="Penerimaan Barang">
    <x-slot:breadcrumb>
      Penerimaan Barang
    </x-slot:breadcrumb>

    <x-slot:heading>
      Penerimaan Barang untuk Pengadaan ID: {{ $idPengadaan }}
    </x-slot:heading>

    <div class="card-body">
      <div class="row">
        <h5 class="card-title">Penerimaan Barang</h5>

        <!-- Tampilkan Pesan Error Jika Ada -->
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Tampilkan Pesan Success Jika Ada -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama Barang</th>
              <th>Jumlah Pesan</th>
              <th>Total Diterima</th>
              <th>Sisa</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($barangPengadaan as $barang)
            <tr>
              <td>{{ $barang->nama_barang }}</td>
              <td>{{ $barang->jumlah_pesan }}</td>
              <td>{{ $barang->total_terima ?? 0 }}</td>
              <td>{{ $barang->sisa }}</td>
              <td>
                <button
                  class="btn btn-primary btn-sm terima-barang-btn"
                  data-idbarang="{{ $barang->idbarang }}"
                  data-namabarang="{{ $barang->nama_barang }}"
                  data-sisa="{{ $barang->sisa }}"
                  data-hargasatuan="{{ $barang->harga }}"
                  data-bs-toggle="modal"
                  data-bs-target="#addPenerimaanModal">
                  Terima
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        <!-- History Penerimaan -->
        <h5 class="mt-5">History Penerimaan</h5>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID Penerimaan</th>
              <th>Tanggal Penerimaan</th>
              <th>Nama Barang</th>
              <th>Jumlah Terima</th>
              <th>Harga Satuan</th>
              <th>Sub Total</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($historyPenerimaan as $history)
            <tr>
              <td>{{ $history->idpenerimaan }}</td>
              <td>{{ $history->created_at }}</td>
              <td>{{ $history->nama_barang }}</td>
              <td>{{ $history->jumlah_terima }}</td>
              <td>{{ number_format($history->harga_satuan_terima, 0, ',', '.') }}</td>
              <td>{{ number_format($history->sub_total_terima, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">Belum ada penerimaan untuk pengadaan ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-grid gap-2 mt-3">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addPenerimaanModal">Tambah Penerimaan</button>
      </div>
    </div>

    <!-- Modal Tambah Penerimaan -->
    <div class="modal fade" id="addPenerimaanModal" tabindex="-1" aria-labelledby="addPenerimaanModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPenerimaanModalLabel">Tambah Penerimaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="penerimaanForm" action="{{ route('penerimaan.store') }}" method="POST">
              @csrf
              <input type="hidden" name="id_pengadaan" value="{{ $idPengadaan }}">
              <input type="hidden" name="detail_penerimaan[idbarang]" id="idbarang">
              <div class="mb-3">
                <label for="namaBarang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="namaBarang" readonly>
              </div>
              <div class="mb-3">
                <label for="jumlahSisa" class="form-label">Jumlah Sisa</label>
                <input type="number" class="form-control" id="jumlahSisa" readonly>
              </div>
              <div class="mb-3">
                <label for="jumlahTerima" class="form-label">Jumlah Terima</label>
                <input type="number" class="form-control" id="jumlahTerima" name="detail_penerimaan[jumlah_terima]" min="1">
                @error('detail_penerimaan.jumlah_terima')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="hargaSatuan" class="form-label">Harga Satuan</label>
                <input type="number" class="form-control" id="hargaSatuan" name="detail_penerimaan[harga_satuan]" readonly>
              </div>
              <div class="mb-3">
                <label for="iduser" class="form-label">ID User</label>
                <input type="number" class="form-control" id="iduser" name="iduser" value="{{ old('iduser') }}">
                @error('iduser')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" form="penerimaanForm" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.terima-barang-btn').forEach(function (button) {
          button.addEventListener('click', function () {
            const idbarang = button.getAttribute('data-idbarang');
            const namabarang = button.getAttribute('data-namabarang');
            const sisa = button.getAttribute('data-sisa');
            const hargaSatuan = button.getAttribute('data-hargasatuan');

            document.getElementById('idbarang').value = idbarang;
            document.getElementById('namaBarang').value = namabarang;
            document.getElementById('jumlahSisa').value = sisa;
            document.getElementById('hargaSatuan').value = hargaSatuan;
            document.getElementById('jumlahTerima').setAttribute('max', sisa);
          });
        });
      });
    </script>
</x-app-layout>
