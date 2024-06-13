@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper" style="min-height: 2080.32px;">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Category</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('subcategory') }}" class="btn btn-danger float-end">Back</a>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                  @include('admin.layouts._message')
                    <div class="card card-primary">
                        <form action="{{ url('subcategory') }}" method="POST">
                          @csrf


                            <div class="card-body">
                              <div class="form-group">    
                                <label>Category Name</label>
                                <select name="category_id" class="form-control">
                                  <option value="">Select</option>
                                    @foreach ($getCategory as $value)
                                      <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                  </select>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">    
                                <label>Sub Category Name</label>
                                  <input type="text" class="form-control" required name="name" placeholder="Enter Sub Category Name">
                                  @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">    
                                <label>Slug</label>
                                <input type="text" class="form-control" required name="slug" placeholder="Example : (URL)">
                                @error('slug')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">    
                                <label>Status</label>
                                <select name="status" class="from-control" required>
                                  <option {{ (old('status') == 0) ? 'selected' : '' }} value="0">Active</option>
                                  <option {{ (old('status') == 1) ? 'selected' : '' }} value="1">Inactive</option>
                                </select>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">    
                                <label>Meta title</label>
                                <input type="text" class="form-control" required name="meta_title" placeholder="Meta title">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">    
                                <label> Meta Description</label>
                                <input type="text" class="form-control" required name="meta_description" placeholder="Meta Description">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">    
                                <label> Meta Keywords</label>
                                <input type="text" class="form-control" required name="meta_keywords" placeholder="Meta Keywords">
                              </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
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
@endsection