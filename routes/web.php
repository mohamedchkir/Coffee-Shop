<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckUserController;
use App\Http\Controllers\Frontend\FrontMealsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function ()
{
    $Meals = DB::table('meals')->get();
    return view('welcome',compact('Meals'));
}

);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/admin/meals', function ()
    {
        return view('admin.meals.index');
    })->name('list');

    Route::resource('meals', MealController::class);

});

Route::get('/users',[CheckUserController::class,'checkRole'])->middleware('auth');


require __DIR__ . '/auth.php';
