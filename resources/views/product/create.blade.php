@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper" style="min-height: 2080.32px;">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Product</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('product') }}" class="btn btn-danger float-end">Back</a>
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
                        <form action="{{ url('product') }}" method="POST">
                          @csrf

                            <div class="card-body">
                              <div class="row">

                                <div class="col-md-6">
                                  <div class="form-group">    
                                    <label>Title</label>
                                    <input type="text" class="form-control" required name="title" placeholder="Enter Product Title">
                                    @error('title')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                  </div>
                                </div>
  
                                <div class="col-md-6">
                                  <div class="form-group">    
                                    <label>SKU</label>
                                    <input type="text" class="form-control" name="sku"  placeholder="Enter SKU">
                                    @error('sku')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                  </div>
                                </div>
  
                                <div class="col-md-6">
                                  <div class="form-group">    
                                    <label>Category</label>
                                    <select name="category_id" id="ChangeCategory" class="form-control" required>
                                      <option value="">Select</option>
                                      @foreach ($getCategory as $value )
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
  
                                
                                <div class="col-md-6">
                                  <div class="form-group">    
                                    <label>Sub Category</label>
                                    <select name="subcategory_id" id="getSubCategory"  class="form-control" >
                                      <option value="">Select</option>
                                      @foreach ($getSubCategory as $value )
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
  
                                <div class="col-md-6">
                                  <div class="form-group">    
                                    <label>Brand</label>
                                    <select name="brand_id" class="form-control" required>
                                      <option value="">Select</option>
                                      @foreach ($getBrand as $value )
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
  
                                <div class="col-md-3">
                                  <div class="form-group">    
                                    <label>Price ($) </label>
                                      <input type="text" class="form-control" name="price" placeholder="Price" required value="{{ !empty( $product->price) ?  $product->price : '' }}">
                                  </div>
                                </div>
    
                                <div class="col-md-3">
                                  <div class="form-group">    
                                    <label>Old Price ($) </label>
                                    <input type="text" class="form-control" name="old_price" placeholder="Old Price" required value="{{ !empty( $product->old_price) ?  $product->old_price : '' }}">
                                  </div>
                                </div>
                              </div>

                              <hr>

                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">    
                                    <label>Color</label>
                                      @foreach ($getColor as $color)
                                        <div>
                                          <label><input type="checkbox" name='color_id[]' value="{{ $color->id }}">{{ $color->name }}</label>
                                        </div>    
                                      @endforeach
                                  </div>
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