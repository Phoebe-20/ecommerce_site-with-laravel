@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper" style="min-height: 2080.32px;">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Color</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('color') }}" class="btn btn-danger float-end">Back</a>
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
                      <form action="" method="POST">
                        @csrf

                          <div class="card-body">
                            <div class="form-group">    
                                <label>Name</label>
                                <input type="text" class="form-control" required name="name" value="{{ old('name', $getRecord->name) }}" placeholder="Enter Color Name">
                                @error('name')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                          </div>
                          <div class="card-body">
                            <div class="form-group">    
                              <label>Code</label>
                              <input type="color" class="form-control" required value="{{ old('code', $getRecord->code) }}" name="code" placeholder="Example : (URL)">
                              @error('code')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="form-group">    
                              <label>Status</label>
                              <select name="status" class="from-control" required>
                                <option {{ (old('status', $getRecord->status) == 0) ? 'selected' : '' }} value="0">Active</option>
                                <option {{ (old('status', $getRecord->status) == 1) ? 'selected' : '' }} value="1">Inactive</option>
                              </select>
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