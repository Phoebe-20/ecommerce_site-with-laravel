@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Product</h1>
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
                      <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                          <div class="card-body">
                            <div class="row">

                              <div class="col-md-6">
                                <div class="form-group">    
                                  <label>Title</label>
                                  <input type="text" class="form-control" required name="title" value="{{ old('title', $product->title) }}" placeholder="Enter Product Title">
                                  @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">    
                                  <label>SKU</label>
                                  <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Enter SKU">
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
                                    @foreach ($getCategory as $category )
                                      <option {{ ($product->category_id == $category->id) ? 'selected' : ''  }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                              
                              <div class="col-md-6">
                                <div class="form-group">    
                                  <label>Sub Category</label>
                                  <select name="subcategory_id" id="getSubCategory"  class="form-control" >
                                    <option value="">Select</option>
                                    @foreach ($getSubCategory as $subcategory )
                                      <option {{ ($product->subcategory_id == $subcategory->id) ? 'selected' : ''  }} value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">    
                                  <label>Brand</label>
                                  <select name="brand_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach ($getBrand as $brand )
                                      <option {{ ($product->brand_id == $brand->id) ? 'selected' : ''  }} value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                                      @php
                                        $checked = '';
                                      @endphp
                                    
                                      @foreach ($product->getColor as $pcolor)
                                        @if ($pcolor->color_id == $color->id)                                       
                                          @php
                                            $checked = 'checked';
                                          @endphp 
                                        @endif
                                      @endforeach
                                      <div>
                                        <label><input {{ $checked }} type="checkbox" name='color_id[]' value="{{ $color->id }}">{{ $color->name }}</label>
                                      </div>    
                                    @endforeach
                                </div>
                              </div>
                            </div>

                            <hr>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">    
                                  <label>Size</label>
                                  <div>
                                    <table class="table table-striped">
                                      <thead>
                                        <tr>
                                          <th>Name</th>
                                          <th>Price ($) </th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody id="AppendSize">

                                        @php
                                          $i_s = 1;
                                        @endphp
                                        @foreach ($product->getSize as $size)
                                          <tr id="DeleteSize{{ $i_s }}">
                                            <td>
                                              <input type="text" value="{{ $size->name }}" name="size[{{ $i_s }}][name]" placeholder="Name" class="form-control">
                                            </td>
                                            <td>
                                              <input type="text" value="{{ $size->price }}" name="size[{{ $i_s }}][price]" placeholder="Price" class="form-control">
                                            </td>
                                            <td>
                                              <button type="button" id="" class="btn btn-danger DeleteSize">Delete</button>
                                            </td>
                                          </tr>  
                                        @endforeach

                                        @php
                                          $i_s = 1;
                                        @endphp
                                        <tr>
                                          <td>
                                            <input type="text" name="size[100][name]" placeholder="Name" class="form-control">
                                          </td>
                                          <td>
                                            <input type="text" name="size[100][price]" placeholder="Price" class="form-control">
                                          </td>
                                          <td>
                                            <button type="button" class="btn btn-primary AddSize">Add</button>
                                          </td>
                                        </tr>  
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <hr>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">    
                                  <label>Image</label>
                                  <input type="file" name="image[]" class="form-control" multiple accept="image/*" style="padding: 3px;" >                              
                              </div>
                              </div>
                            </div>   
                            
                            @if (!empty($product->getImage->count()))
                              <div class="row" id="sortable">
                                @foreach ($product->getImage as $image)
                                  @if (!empty($image->getLogo()))
                                    <div class="col-mx-1 sortable_image" id="{{ $image->id }}" style="text-align: center;">
                                      <img style="width: 90%; height: 90px" src="{{ $image->getLogo() }}">                       
                                      <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('product/image_delete/'.$image->id) }}" style="margin-top: 10px;" class="btn btn-danger btn-sm">Delete</a>               
                                    </div>                                  
                                  @endif   
                                @endforeach
                              </div>
                            @endif

                            <hr>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">    
                                  <label>Description</label>
                                  <textarea class="from-control editor" name="description" placeholder="Description">{{ $product->description}}</textarea>
                                </div>
                              </div>
                            </div>  
                            
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">    
                                  <label>Additional Information</label>
                                  <textarea class="from-control editor" name="additional_info" placeholder="Additional Information">{{ $product->additional_info}}</textarea>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">    
                                  <label>Shipping & Returns</label>
                                  <textarea class="from-control editor" name="shipping_returns" placeholder="Shipping and Returns">{{ $product->shipping_returns}}</textarea>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                              <div class="form-group">    
                                <label>Status</label>
                                <select name="status" class="from-control" required>
                                  <option {{ ( $product->status == 0) ? 'selected' : '' }} value="0">Active</option>
                                  <option {{ ( $product->status == 1) ? 'selected' : '' }} value="1">Inactive</option>
                                </select>
                              </div>
                              </div>
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
<!--<script src="{{ url('public/assets/plugins/summernote/summernote-bs4.min.js') }}"></script> -->

<script src="{{ url('public/assets/dist/js/pages/dashboard3.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> 

<script type="text/javascript">

  // Sortable images function
  $(document).ready(function() {
    $( "#sortable" ).sortable({
      update : function (event, ui) {
        var photo_id = new Array();
        $('.sortable_image').each(function() {
          var id = $(this).attr('id');
          photo_id.push(id);
        });

        $.ajax({
          type : "POST",
          url : "{{ url('product_image_sortable') }}",
          data : {
              'photo_id' : photo_id,
              "_token" : "{{ csrf_token() }}"
          },
          dataType : "json",
          success : function(data) {
            
          },
          error: function (data){

          }
        });
      }
    });
  } );

  // Configuration de Summernote Editor
  tinymce.init({
        selector: '.editor',
        height: 200,
        menubar: false,
        plugins: [
          'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
          'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
          'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
      });

  var i = 100;
  $('body').delegate('.AddSize', 'click', function(){
          var html = '<tr id="DeleteSize'+i+'">\n\
                        <td>\n\
                          <input type="text" name="size['+i+'][name]" placeholder="Name" class="form-control">\n\
                        </td>\n\
                        <td>\n\
                          <input type="text" name="size['+i+'][price]" placeholder="Price" class="form-control">\n\
                        </td>\n\
                        <td>\n\
                          <button type="button" id="'+i+'" class="btn btn-danger DeleteSize">Delete</button>\n\
                        </td>\n\
                      </tr>';
          
          i++;
          $('#AppendSize').append(html);

  });

  
  $('body').delegate('.DeleteSize', 'click', function(){
      var id = $(this).attr('id');
      $('#DeleteSize'+id).remove();
  });

  
  $('body').delegate('#ChangeCategory', 'change', function(e){
    var id = $(this).val();
    $.ajax({
      type : "POST",
      url : "{{ url('get_subcategory') }}",
      data : {
          'id' : id,
          "_token" : "{{ csrf_token() }}"
      },
      dataType : "json",
      success : function(data) {
        $('#getSubCategory').html(data.html);
      },
      error: function (data){

      }
    });
  });
</script>
@endsection