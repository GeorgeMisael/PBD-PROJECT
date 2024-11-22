<x-app-layout title="Tambah Vendor">
  <x-slot:breadcrumb>
    Tambah Vendor
  </x-slot:breadcrumb>
  <x-slot:heading>
    Tambah Vendor Baru
  </x-slot:heading>

  <div class="card-body">
    <h5 class="card-title">Masukkan Data Pengguna Baru</h5>

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
    <form action="" method="post">
      @csrf
      <div class="row mb-3">
        <label for="username" class="col-sm-2 col-form-label">Nama Role</label>
        <div class="col-sm-10">
          <input type="text" name="username" id="username" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="password" class="col-sm-2 col-form-label">Nama Role</label>
        <div class="col-sm-10">
          <input type="text" name="password" id="password" class="form-control">
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form><!-- End Horizontal Form -->

  </div>

  </div>
</x-app-layout>