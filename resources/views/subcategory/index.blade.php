@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">

        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sub Category</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('subcategory/create') }}" class="btn btn-primary">Add Sub Category</a>
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
                <h3 class="card-title">Sub Category List</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Category</th>
                      <th>Sub Category</th>
                      <th>Slug</th>
                      <th>Status</th>
                      <th>Create_by</th>
                      <th>Created_at</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getRecord as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->category_name }}</td>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->slug }}</td>
                      <td>{{ ($value->status == 0) ? 'Active' : 'Inactive'}}</td>
                      <td>{{ $value->create_by_name }}</td>
                      <td>{{ date('d-m-y', strtotime($value->created_at)) }}</td>
                        
                      <td>
                        <a href="{{ url('subcategory/edit/'.$value->id) }}" class="btn btn-success">Edit</a>
                        <a href="{{ url('subcategory/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
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