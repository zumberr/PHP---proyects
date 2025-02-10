<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::group(['prefix' => 'shows'], function() {


    Route::get('/show-details/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'animeDetails'])->name('anime.details');
    Route::post('/insert-comments/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'insertComments'])->name('anime.insert.comments');
    //following
    Route::post('/follow/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'follow'])->name('anime.follow');


    //episodes
    Route::get('/anime-watching/{show_id}/{episode_id}', [App\Http\Controllers\Anime\AnimeController::class, 'animeWatching'])->name('anime.watching');


    //categories
    Route::get('/category/{category_name}', [App\Http\Controllers\Anime\AnimeController::class, 'category'])->name('anime.category');

    //search shows
    Route::any('/search', [App\Http\Controllers\Anime\AnimeController::class, 'searchShows'])->name('anime.search.shows');


});





//users 'users followed shows'
Route::get('users/followed-shows', [App\Http\Controllers\Users\UsersController::class, 'followedShows'])->name('users.followed.shows')->middleware('auth:web');



//admin panel
Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login')->middleware('check.for.auth');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {

    Route::get('/index', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard');


    //admins
    Route::get('/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'allAdmins'])->name('admins.all');
    Route::get('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('admins.create');
    Route::post('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('admins.store');


    //shows
    Route::get('/all-shows', [App\Http\Controllers\Admins\AdminsController::class, 'allShows'])->name('shows.all');
    Route::get('/create-shows', [App\Http\Controllers\Admins\AdminsController::class, 'createShows'])->name('shows.create');
    Route::post('/create-shows', [App\Http\Controllers\Admins\AdminsController::class, 'storeeShows'])->name('shows.store');
    Route::get('/delete-shows/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteShows'])->name('shows.delete');

    //genres
    Route::get('/all-genres', [App\Http\Controllers\Admins\AdminsController::class, 'allGenres'])->name('genres.all');
    Route::get('/delete-genres/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteGenres'])->name('genres.delete');
    Route::get('/create-genres', [App\Http\Controllers\Admins\AdminsController::class, 'createGenres'])->name('genres.create');
    Route::post('/create-genres', [App\Http\Controllers\Admins\AdminsController::class, 'storeGenres'])->name('genres.store');


    //episodes
    Route::get('/all-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'allEpisodes'])->name('episodes.all');

    Route::get('/create-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'createEpisode'])->name('episode.create');
    Route::post('/create-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'storeEpisode'])->name('episode.store');

    Route::get('/delete-episodes/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteEpisodes'])->name('episodes.delete');





});
