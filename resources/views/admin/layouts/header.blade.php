<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

   
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="{{ url('public/assets/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="{{ url('public/assets/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="{{ url('public/assets/dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
x          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
x      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      
    </ul>
</nav>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="brand-link" style="text-align: center;">
      <img src="{{ url('public/assets/dist/img/logo.png') }}">
      <span class="brand-text"></span>
    </div>

    <div class="sidebar">
      
      <div class="user-panel mt-3 pb-2 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('public/assets/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>


      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        
         
          <!-- Si l'admin réussi l'authentification il est redirigé vers son espace 'dashboard'  -->
          @if(Auth::user()->is_admin == 1 | 2) 
          <li class="nav-item">
            <a href="{{ url('admin/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard      
                </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                    Admin Management
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ url('roles') }}" class="nav-link @if(Request::segment(1) == 'roles') active @endif">
                            <i class="fas fa-bomb nav-icon"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('permissions') }}" class="nav-link @if(Request::segment(1) == 'permissions') active @endif">
                            <i class="fas fa-bomb nav-icon"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ url('users') }}" class="nav-link @if(Request::segment(1) == 'users') active @endif">
                        <i class="fas fa-users-cog nav-icon"></i>
                        <p>Users</p>
                      </a>
                    </li> 
              </ul>
          </li>

          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                   Commercial Management
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ url('category') }}" class="nav-link @if(Request::segment(1) == 'category') active @endif">
                            <i class="fas fa-list-alt nav-icon"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ url('subcategory') }}" class="nav-link @if(Request::segment(1) == 'subcategory') active @endif">
                            <i class="fas fa-list-alt nav-icon"></i>
                            <p>Sub Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('product') }}" class="nav-link @if(Request::segment(1) == 'product') active @endif">
                            <i class="fas fa-bicycle nav-icon"></i>
                            <p>Product</p>
                        </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ url('brand') }}" class="nav-link @if(Request::segment(1) == 'brand') active @endif">
                        <i class="fas fa-anchor nav-icon"></i>
                        <p>Brand</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ url('color') }}" class="nav-link @if(Request::segment(1) == 'color') active @endif">
                        <i class="fas fa-anchor nav-icon"></i>
                        <p>Color</p>
                      </a>
                    </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ url('discount_code') }}" class="nav-link @if(Request::segment(1) == 'discount_code') active @endif">
                <i class="nav-icon fas fa-cogs"></i>
                <p> Discount Code </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('shipping_charges') }}" class="nav-link @if(Request::segment(1) == 'shipping_charges') active @endif">
                <i class="nav-icon fas fa-cogs"></i>
                <p> Shipping Charge </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Profile
                </p>
            </a>
          </li>
          @endif

         
          <li class="nav-item">
            <a href="{{ url('admin/logout') }}" class="nav-link ">
            <i class="nav-icon fas fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</aside>
