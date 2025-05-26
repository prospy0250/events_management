<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;

/**
 * Declaration of routes for the event management system API
 * 
 * @author Kamon A. M. Prosper-Adrien SOURABIE <mandelasourabie@gmail.com>
 */

// Auth
Route::post('/register', [AuthController::class, 'register']); // permits to register a new user
Route::post('/login', [AuthController::class, 'login']); // permits to login 

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); //permits to logout
    Route::get('/user/profile', [UserController::class, 'show']); // permits to see the user profile information
    Route::put('/user/profile', [UserController::class, 'update']); //permits to modify user profile information
    
    Route::post('/events/create', [EventController::class, 'create']); // permits to create a new event (only for admins)
    Route::get('/events', [EventController::class, 'index']); // permits to get all the events available
    Route::get('/events/{id}', [EventController::class, 'show']); //permits to display a specific event
    Route::put('/events/{id}', [EventController::class, 'update']); //permits to modify information of a specific event 
    Route::delete('/events/{id}', [EventController::class, 'destroy']); // permits to delete a specific event (only for admins)
   
    Route::post('/events/{id}/book', [ReservationController::class, 'book']); //enables a user to do reservation of nb places for an event
    Route::get('/user/reservations', [ReservationController::class, 'myReservations']); //enables a user to get all the reservations he did
    Route::delete('/user/reservations/{id}', [ReservationController::class, 'cancel']); //enables a user to cancel a reservation
    Route::get('/events/{id}/reservations', [ReservationController::class, 'getReservationsByEvent']); //allows only admins to list the reservations for a specific event

});




