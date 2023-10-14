<?php

use App\Http\Controllers\Others\ArtisanController;
use App\Http\Controllers\PseudoName\PseudoNameController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Trackers\Prayer\SubscriptionController;
use App\Http\Controllers\Trackers\Prayer\DailyController;
use App\Http\Controllers\Trackers\Prayer\HistoryController;
use App\Http\Controllers\Trackers\Prayer\LeaderboardController;
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
Route::view('/', 'dashboard')->middleware('auth')->name('dashboard');

Route::group([
  'prefix' => '/pseudo-names',
  'name' => 'pseudo_names.',
  'controller' => PseudoNameController::class
], function () {
  Route::get('/available', 'available')->name('available');
});

Route::controller(UserController::class)->group(function () {
  Route::middleware('guest')->group(function () {
    Route::name('register.')->group(function () {
      Route::view('/register', 'users.register')->name('show');
      Route::post('/users', 'store')->name('store');
    });

    Route::name('login.')->group(function () {
      Route::get('/login', 'login')->name('show');
      Route::post('/users/authenticate', 'authenticate')->name('store');
    });
  });

  Route::middleware('auth')->group(function () {
    Route::get('/logout', 'destroy')->name('logout');
    Route::name('edit_profile.')->group(function () {
      Route::get('/edit-profile', 'showEditProfile')->name('show');
      Route::put('/edit-profile', 'editProfile')->name('update');
    });
  });
});

Route::group(['middleware' => 'auth', 'prefix' => '/trackers'], function () {
  // prayer tracker
  Route::group([
    'prefix' => '/prayer',
    'namespace' => 'Trackers\\Prayer',
  ], function () {
    Route::middleware('validate_prayer_tracker_subscription')->group(function () {
      Route::name('prayer_tracker_daily.')->group(function () {
        Route::get('daily/{date}', [DailyController::class, 'show'])->name('show');
        Route::put('daily/{date}', [DailyController::class, 'update'])->name('update');
      });

      Route::name('prayer_tracker_leaderboard.')->group(function () {
        Route::get('leaderboard', [LeaderboardController::class, 'index'])->name('index');
      });

      Route::name('prayer_tracker_history.')->group(function () {
        Route::get('history/{year}/{month}', [HistoryController::class, 'index'])->name('index');
      });

      Route::name('unsubscribe_to_prayer_tracker.')->group(function () {
        Route::view('unsubscribe', 'trackers.prayer.unsubscribe')->name('show');
        Route::put('unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('update');
      });
    });

    Route::middleware('validate_prayer_tracker_unsubscription')->group(function () {
      Route::name('subscribe_to_prayer_tracker.')->group(function () {
        Route::view('subscribe', 'trackers.prayer.subscribe')->name('show');
        Route::put('subscribe', [SubscriptionController::class, 'subscribe'])->name('update');
      });
    });
  });
});

Route::group([
  'middleware' => 'artisan',
  'prefix' => '/artisan',
  'controller' => ArtisanController::class
], function () {
  Route::get('/migrate', 'migrate');
  Route::get('/seed', 'seed');
  Route::get('/migrate-and-seed', 'migrateAndSeed');
  Route::get('/storage-link', 'storageLink');
});
