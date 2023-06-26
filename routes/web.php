<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Eligibility\EligibilityController;
use App\Http\Controllers\Saved\SavedController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/auth/login', [AuthController::class, 'loginPost'])->name('loginPost');
Route::post('/auth/register', [AuthController::class, 'registerPost'])->name('registerPost');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/post', [PostController::class, 'index'])->name('post');
Route::get('/post/show/{id}', [PostController::class, 'show'])->name('postShow');
Route::get('/post/add', [PostController::class, 'create'])->name('postCreate');
Route::post('/post/add', [PostController::class, 'store'])->name('postStore');
Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('postEdit');
Route::post('/post/edit/{id}', [PostController::class, 'update'])->name('postUpdate');
Route::delete('/post/delete/{id}', [PostController::class, 'delete'])->name('postDelete');

Route::get('/eligibility', [EligibilityController::class, 'index'])->name('eligibility');
Route::get('/eligibility/criterias', [EligibilityController::class, 'criterias'])->name('eligibility.criterias');
Route::post('/eligibility/criterias', [EligibilityController::class, 'storeCriteria'])->name('eligibility.criterias.store');
Route::get('/eligibility/criteria/{id}', [EligibilityController::class, 'showCriteria'])->name('eligibility.criterias.show');
Route::patch('/eligibility/criteria/{id}', [EligibilityController::class, 'editCriteria'])->name('eligibility.criterias.update');
Route::delete('/eligibility/criteria/{id}', [EligibilityController::class, 'deleteCriteria'])->name('eligibility.criterias.delete');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::post('/category', [CategoryController::class, 'store'])->name('categoryStore');
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('categoryShow');
Route::patch('/category/{id}', [CategoryController::class, 'edit'])->name('categoryEdit');
Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('categoryDelete');

Route::get('/saved', [SavedController::class, 'index'])->name('saved');
Route::get('/saved/store/{id}', [SavedController::class, 'store'])->name('savedStore');
Route::get('/saved/delete/{id}', [SavedController::class, 'delete'])->name('savedDelete');
