<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Users/Index')->name('users.index');
Route::inertia('/users/create', 'Users/Create')->name('users.create');