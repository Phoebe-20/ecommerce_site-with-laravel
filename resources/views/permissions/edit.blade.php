@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper" style="min-height: 2080.32px;">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Permissions</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('permissions') }}" class="btn btn-danger float-end">Back</a>
          </div>
          
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                      @include('admin.layouts._message')
                        <form action="{{ url('permissions/'.$permission->id) }}" method="POST">
                          @csrf
                          @method('patch')

                            <div class="card-body">
                                <div class="form-group">    
                                    <label>Permission Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $permission->name }}" placeholder="Enter Permission Name">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
               </div>
           </div>
        </div>
      </section>
  </div>

@endsection


@section('script')
<script src="{{ url('public/assets/dist/js/pages/dashboard3.js') }}"></script>