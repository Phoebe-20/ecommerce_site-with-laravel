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
                        <h4> Role : {{ $role->name }}</h4>
                    </div>
                    <div class="col-sm-6" style="text-align: right"> 
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
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
                            <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                              @csrf
                              @method('PUT')
    
                                <div class="card-body">
                                    <div class="form-group"> 

                                        @error('permission')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror 

                                        <h3>Permissions</h3>

                                        <div class="col-md-2">
                                            
                                            @foreach ( $permissions as $permission)
                                            <div class="row">
                                                <input 
                                                    type="checkbox" 
                                                    name="permission[]" 
                                                    value="{{ $permission->name }}" 
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked':''}}
                                                />
                                                {{ $permission->name }}
                                            </div>
                                            @endforeach
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
<script src="{{ url('public/assets/dist/js/pages/dashboard3.js') }}"></script>