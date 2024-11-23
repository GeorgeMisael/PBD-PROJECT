<x-app-layout title="Edit Satuan">
  <x-slot:breadcrumb>
    Edit
  </x-slot:breadcrumb>
  <x-slot:heading>
    Edit Data Satuan
  </x-slot:heading>

  <div class="card-body">
    <h5 class="card-title">Masukkan Data Satuan</h5>

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
    <form action="{{ route('satuan.update', $satuans->idsatuan) }}" method="post">
      @csrf
      <div class="row mb-3">
        <label for="nama_satuan" class="col-sm-2 col-form-label">Nama Satuan</label>
        <div class="col-sm-10">
          <input type="text" name="nama_satuan" id="nama_satuan" value="{{ $satuans->nama_satuan }}" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="status" class="col-sm-2 col-form-label">Badan Hukum</label>
        <div class="col-sm-10">
          <input type="text" name="status" id="status" value="{{ $satuans->status }}" class="form-control">
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form><!-- End Horizontal Form -->

  </div>
</x-app-layout>
