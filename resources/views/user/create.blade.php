<x-app-layout title="Tambah User">
  <x-slot:breadcrumb>
    Tambah User
  </x-slot:breadcrumb>
  <x-slot:heading>
    Tambah User Baru
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
    <form action="{{ route('user.store') }}" method="post">
      @csrf
      <div class="row mb-3">
        <label for="username" class="col-sm-2 col-form-label">Nama Role</label>
        <div class="col-sm-10">
          <input type="text" name="username" id="username" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="text" name="password" id="password" class="form-control">
        </div>
      </div>
      <!-- Select Role -->
      <div class="row mb-3">
        <label for="idrole" class="col-sm-2 col-form-label">Role</label>
        <div class="col-sm-10">
          <select name="idrole" id="idrole" class="form-select" aria-label="Pilih role parent">
            <option value="" selected>Pilih Role</option>
            @foreach ($roles as $role)
              <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form><!-- End Horizontal Form -->

    <a href="{{ route('user') }}" class="btn btn-danger">Kembali</a>

  </div>

  </div>
</x-app-layout>