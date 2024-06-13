<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\Frontend\DiscountCodeController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProductController as ProductFront;
use App\Http\Controllers\Frontend\ShippingChargesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;









/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*------Admin and commercial Login Routes-----*/
Route::get('admin', [AuthController::class, 'login_admin']);
Route::post('admin', [AuthController::class, 'auth_login_admin']);

/*------Admin and commercial Logout Route-----*/
Route::get('admin/logout', [AuthController::class, 'logout_admin']);



Route::group(['middleware' => ['admin']], function() {

    /*------Dashboard Routes-----*/
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    
    /*------Permissions Routes-----*/
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    /*------Roles Routes-----*/
    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

    /*------Users Routes-----*/
    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

    /*------Category Routes-----*/
    Route::resource('category', CategoryController::class)->except('show');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('category/edit/{id}', [CategoryController::class, 'update']);
    Route::get('category/delete/{id}', [CategoryController::class, 'destroy']);

    /*------Sub Category Routes-----*/
    Route::resource('subcategory', SubCategoryController::class)->except('show');
    Route::get('subcategory/edit/{id}', [SubCategoryController::class, 'edit']);
    Route::post('subcategory/edit/{id}', [SubCategoryController::class, 'update']);
    Route::get('subcategory/delete/{id}', [SubCategoryController::class, 'destroy']);

    Route::post('get_subcategory', [SubCategoryController::class, 'get_subcategory']);

    /*------Brand Routes-----*/
    Route::resource('brand', BrandController::class);
    Route::get('brand/edit/{id}', [BrandController::class, 'edit']);
    Route::post('brand/edit/{id}', [BrandController::class, 'update']);
    Route::get('brand/delete/{id}', [BrandController::class, 'destroy']);
    
    /*------Color Routes-----*/
    Route::resource('color', ColorController::class);
    Route::get('color/edit/{id}', [ColorController::class, 'edit']);
    Route::post('color/edit/{id}', [ColorController::class, 'update']);
    Route::get('color/delete/{id}', [ColorController::class, 'destroy']);
    
    /*------Product Routes-----*/
    Route::resource('product', ProductController::class)->except('show');
    Route::get('product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('product/edit/{id}', [ProductController::class, 'update']);
    Route::get('product/delete/{id}', [ProductController::class, 'destroy']);

    Route::get('product/image_delete/{id}', [ProductController::class, 'image_delete']);
    Route::post('product_image_sortable', [ProductController::class, 'product_image_sortable']);

    /*------Discount Routes-----*/
    Route::resource('discount_code', DiscountCodeController::class);
    Route::get('discount_code/edit/{id}', [DiscountCodeController::class, 'edit']);
    Route::post('discount_code/edit/{id}', [DiscountCodeController::class, 'update']);
    Route::get('discount_code/delete/{id}', [DiscountCodeController::class, 'destroy']);

    /*------Shipping Charges Routes-----*/
    Route::resource('shipping_charges', ShippingChargesController::class);
    Route::get('shipping_charges/edit/{id}', [ShippingChargesController::class, 'edit']);
    Route::post('shipping_charges/edit/{id}', [ShippingChargesController::class, 'update']);
    Route::get('shipping_charges/delete/{id}', [ShippingChargesController::class, 'destroy']);
 

});

/*------Home Frontend Route-----*/
Route::get('/', [HomeController::class, 'home']);

/*------User Login, Register, Activate-Email, Forgot-password, Reset-token Routes-----*/
Route::post('auth_register', [AuthController::class, 'auth_register']);
Route::post('auth_login', [AuthController::class, 'auth_login']);
Route::get('activate/{id}', [AuthController::class, 'activate_email']);
Route::get('forgot-password', [AuthController::class, 'forgot_password']);
Route::post('forgot-password', [AuthController::class, 'auth_forgot_password']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'auth_reset']);


//------ Cart Routes-----
Route::get('cart', [PaymentController::class, 'cart']);

Route::get('checkout', [PaymentController::class, 'checkout']);
Route::post('checkout/apply_discount_code', [PaymentController::class, 'apply_discount_code']);
Route::post('checkout/place_order', [PaymentController::class, 'place_order']);
Route::get('checkout/payment', [PaymentController::class, 'checkout_payment']);
Route::get('paypal/success-payment', [PaymentController::class, 'paypal_success_payment']);
Route::get('stripe/payment-success', [PaymentController::class, 'stripe_success_payment']);

Route::post('update_cart', [PaymentController::class, 'update_cart']);
Route::get('cart/delete/{id}', [PaymentController::class, 'cart_delete']);
Route::post('frontend/product/add-to-cart', [PaymentController::class, 'add_to_cart']);

//------Search, filter, listing Product Routes-----
Route::get('search', [ProductFront::class, 'getProductSearch']);
Route::post('get_filter_product_ajax', [ProductFront::class, 'getFilterProductAjax']);
Route::get('{category?}/{subcategory?}', [ProductFront::class, 'getCategory']);


/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/


