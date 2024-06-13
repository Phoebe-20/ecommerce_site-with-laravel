@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')

  <div class="content-wrapper" style="min-height: 2080.32px;">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update User</h1>
          </div>
          <div class="col-sm-6" style="text-align: right">
            <a href="{{ url('users') }}" class="btn btn-danger float-end">Back</a>
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
                        <form action="{{ url ('users/'.$user->id) }}" method="POST">
                          @csrf
                          @method('patch')
                          
                            <div class="card-body">
                                <div class="form-group">    
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Enter User Name" required>
                                    @error('name')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">    
                                  <label>Email</label>
                                  <input type="text" class="form-control" name="email" readonly value="{{ $user->email }}" placeholder="Enter User Email" required>
                              </div>
                          </div>
                          <div class="card-body">
                            <div class="form-group">    
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" placeholder="Enter User Password" required>
                                @error('password')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-body">
                          <div class="form-group">    
                              <label for="roles" class="form-label">Roles</label>
                              <select name="roles[]" class="form-control multiple" multiple>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                  <option 
                                        value="{{ $role }}"
                                        {{ in_array($role, $userRoles) ? 'selected':''}}
                                  >
                                        {{ $role }}
                                  </option>
                                @endforeach
                              </select>
                              @error('role')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror
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