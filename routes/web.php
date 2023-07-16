<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Eligibility\AlternativeController;
use App\Http\Controllers\Eligibility\CalculateController;
use App\Http\Controllers\Eligibility\CriteriaController;
use App\Http\Controllers\Eligibility\EligibilityController;
use App\Http\Controllers\Eligibility\ResultController;
use App\Http\Controllers\Eligibility\SubCriteriaController;
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

Route::get('/eligibility/criterias', [CriteriaController::class, 'index'])->name('eligibility.criterias');
Route::post('/eligibility/criterias', [CriteriaController::class, 'store'])->name('eligibility.criterias.store');
Route::get('/eligibility/criteria/{id}', [CriteriaController::class, 'show'])->name('eligibility.criterias.show');
Route::patch('/eligibility/criteria/{id}', [CriteriaController::class, 'edit'])->name('eligibility.criterias.update');
Route::delete('/eligibility/criteria/{id}', [CriteriaController::class, 'delete'])->name('eligibility.criterias.delete');

Route::get('/eligibility/criterias/sub/{id}', [SubCriteriaController::class, 'index'])->name('eligibility.criterias.sub');
Route::post('/eligibility/criterias/sub/{id}', [SubCriteriaController::class, 'store'])->name('eligibility.criterias.sub.store');
Route::get('/eligibility/criteria/sub/{id}', [SubCriteriaController::class, 'show'])->name('eligibility.criterias.sub.show');
Route::patch('/eligibility/criteria/sub/{id}', [SubCriteriaController::class, 'edit'])->name('eligibility.criterias.sub.update');
Route::delete('/eligibility/criteria/sub/{id}', [SubCriteriaController::class, 'delete'])->name('eligibility.criterias.sub.delete');

Route::get('/eligibility/alternatives', [AlternativeController::class, 'index'])->name('eligibility.alternatives');
Route::post('/eligibility/alternatives', [AlternativeController::class, 'store'])->name('eligibility.alternatives.store');
Route::get('/eligibility/alternative/score/{id}', [AlternativeController::class, 'showAlternativeScore'])->name('eligibility.alternatives.score');
Route::get('/eligibility/alternative/show/{id}', [AlternativeController::class, 'show'])->name('eligibility.alternatives.show');
Route::patch('/eligibility/alternative/score/edit/{id}', [AlternativeController::class, 'editScores'])->name('eligibility.alternatives.score.update');
Route::patch('/eligibility/alternative/edit/{id}', [AlternativeController::class, 'edit'])->name('eligibility.alternatives.update');
Route::delete('/eligibility/alternative/delete/{id}', [AlternativeController::class, 'delete'])->name('eligibility.alternatives.delete');

Route::get('/eligibility/calculate', [CalculateController::class, 'index'])->name('eligibility.calculate');

Route::get('/eligibility/results', [ResultController::class, 'index'])->name('eligibility.results');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::post('/category', [CategoryController::class, 'store'])->name('categoryStore');
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('categoryShow');
Route::patch('/category/{id}', [CategoryController::class, 'edit'])->name('categoryEdit');
Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('categoryDelete');

Route::get('/saved', [SavedController::class, 'index'])->name('saved');
Route::get('/saved/store/{id}', [SavedController::class, 'store'])->name('savedStore');
Route::get('/saved/delete/{id}', [SavedController::class, 'delete'])->name('savedDelete');
