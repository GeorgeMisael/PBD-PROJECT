<x-app-layout title="Role">
  <x-slot:breadcrumb>
    Role
  </x-slot:breadcrumb>
  <x-slot:heading>
    Data Role
  </x-slot:heading>

  <a href="{{ route('role.create') }}" class="btn btn-primary">Tambah Data</a>

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
          <th scope="col">Nama Role</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ( $roles as $role )
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $role->nama_role }}</td>
          <td>
            <a href="{{ route('role.destroy', $role->idrole) }}" class="btn btn-outline-danger">Hapus</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <!-- End Table with hoverable rows -->

  </div>
</x-app-layout>