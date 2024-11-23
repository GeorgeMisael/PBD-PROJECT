<x-app-layout title="Tambah Vendor">
  <x-slot:breadcrumb>
    Tambah Vendor
  </x-slot:breadcrumb>
  <x-slot:heading>
    Tambah Vendor Baru
  </x-slot:heading>

  <div class="card-body">
    <h5 class="card-title">Masukkan Data Vendor Baru</h5>

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
    <form action="{{ route('vendor.store') }}" method="post">
      @csrf
      <div class="row mb-3">
        <label for="nama_vendor" class="col-sm-2 col-form-label">Nama Vendor</label>
        <div class="col-sm-10">
          <input type="text" name="nama_vendor" id="nama_vendor" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="badan_hukum" class="col-sm-2 col-form-label">Badan Hukum</label>
        <div class="col-sm-10">
          <input type="text" name="badan_hukum" id="badan_hukum" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="status" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
          <input type="number" name="status" id="status" class="form-control">
        </div>
      </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form><!-- End Horizontal Form -->

    <a href="{{ route('vendor') }}" class="btn btn-danger">Kembali</a>

  </div>

  </div>
</x-app-layout>