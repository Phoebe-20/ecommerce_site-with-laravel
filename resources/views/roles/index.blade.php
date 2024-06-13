@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper" style="min-height: 2080.32px;">
    <section class="content-header">
      <div class="container-fluid">

        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Roles</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('roles/create') }}" class="btn btn-primary">Add New Role</a>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Roles List</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach ($roles as $role)

                        <tr>
                          <td>{{ $role->id }}</td>
                          <td>{{ $role->name }}</td>
                          <td>
                            <a href="{{ url('roles/'.$role->id.'/give-permissions') }}" class="btn btn-warning">
                                Add / Edit Role Permission
                            </a>
                            <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success mx-2">Edit</a>
                            <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-danger mx-2">Delete</a>
                            
                          </td>
                        </tr>
                        
                        @endforeach

                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection


@section('script')
<script src="{{ url('public/assets/dist/js/pages/dashboard3.js') }}"></script>
@endsection