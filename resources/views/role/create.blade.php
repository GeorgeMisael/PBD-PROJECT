<x-app-layout title="Role">
  <x-slot:breadcrumb>
    Role
  </x-slot:breadcrumb>
  <x-slot:heading>
    Data Role
  </x-slot:heading>

  <div class="card-body">
    <h5 class="card-title">Horizontal Form</h5>

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
    <form action="{{ route('role.store') }}" method="post">
      @csrf
      <div class="row mb-3">
        <label for="nama_role" class="col-sm-2 col-form-label">Nama Role</label>
        <div class="col-sm-10">
          <input type="text" name="nama_role" id="nama_role" class="form-control">
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