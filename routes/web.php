<?php
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

*/

// BOTH BELOW  METHODS ARE USED WIHOUT THE USE OF CONTROLLERS 
//all listings can be routed as follows

/*
Route::get('/listings',function(){

return view('listings',[
            
                'listings' => Listing::all() 
]);
});

// single listings can be roruted as follows  done as follows 

Route::get('/listing/{listing}',function(Listing $listing){  
            return view ('listing',[
            'listing' => $listing 
            ]);

*/



//All listings 
Route::get('/listings',[ListingController::class,'index']);

// single listings 

Route::get('/listing/{listing}',[ListingController::class,'show']  );

//show createte form 
Route::get('/listings/create',[ListingController::class,'create'] )->middleware('auth');


//store listings data

Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

//show  edit form

Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//Edit submit to Update 
Route::put('/listing/{listing}',[ListingController::class,'update'])->middleware('auth');

//delete the listings 
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');

// show register/create form 
Route::get('/register',[UserController::class,'create'])->middleware('guest');


//create a new user 
Route::post('/users',[UserController::class,'store']);



// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');


// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('auth');


// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');















