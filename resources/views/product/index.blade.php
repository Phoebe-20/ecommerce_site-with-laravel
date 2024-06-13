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
            <h1>Product</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('product/create') }}" class="btn btn-primary">Add New Product</a>
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
                <h3 class="card-title">Product List</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead  style="font-size: 12px ;">
                    <tr>
                      <th>#</th>
                      <th>Title</th>                    
                      <th>Status</th>
                      <th>Create_by</th>
                      <th>Created_at</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody style="font-size: 12px ;">
                   @foreach ($getRecord as $value)
                     <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->title}}</td>
                      <td>{{ ($value->status == 0) ? 'Active' : 'Inactive'}}</td>
                      <td>{{ $value->created_by_name }}</td>
                      <td>{{ date('d-m-y', strtotime($value->created_at)) }}</td>
                      <td>
                        <a  style="font-size: 10px ;" href="{{ url('product/edit/'.$value->id) }}" class="btn btn-success">Edit</a>
                        <a style="font-size: 10px ;" href="{{ url('product/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
                      </td>
                     </tr>
                   @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: rigth;">
                  {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))
                    ->links() !!}
                </div>
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