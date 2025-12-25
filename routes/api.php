<?php

use App\Models\User;
use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BossController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ConversationController;

Route::post('/users/register' , [UserController::class , 'register']);

Route::post('/users/login' , [UserController::class, 'login']);

Route::patch('/users/{user}/' , [UserController::class , 'update'])->middleware('auth:sanctum');

Route::get('/users/{users}' , [UserController::class, 'get_user'])->middleware('auth:sanctum');

Route::post('/documents/create' , [DocumentController::class , 'create_document'])->middleware('auth:sanctum');

Route::get('/documents/{document}' , [DocumentController::class, 'get_document'])->middleware('auth:sanctum');

Route::delete('/documents/{document}' , [DocumentController::class, 'delete_document'])->middleware('auth:sanctum');

Route::post('/documents/{document}/accept-admin' , [AdminController::class , 'accept_admin'])->middleware('auth:sanctum');
Route::post('/documents/{document}/reject-admin' , [AdminController::class, 'reject_admin'])->middleware('auth:sanctum');
Route::get('/documents/{document}' , [AdminController::class, 'get_document'])->middleware('auth:sanctum');

Route::post('/documents/{document}/accept-manager' , [ManagerController::class , 'accept_manager'])->middleware('auth:sanctum');
Route::post('/documents/{document}/reject-manager' , [ManagerController::class, 'reject_manager'])->middleware('auth:sanctum');
Route::get('/documents/{document}' , [ManagerController::class, 'get_document'])->middleware('auth:sanctum');

Route::post('/documents/{document}/accept-boss' , [BossController::class , 'accept_boss'])->middleware('auth:sanctum');
Route::post('/documents/{document}/reject-boss' , [BossController::class, 'reject_boss'])->middleware('auth:sanctum');
Route::get('/documents/{document}' , [BossController::class, 'get_document'])->middleware('auth:sanctum');


Route::get('/messages/{user}', [ConversationController::class, 'receive_message'])->middleware(['auth:sanctum']);
Route::post('/messages/{user}', [ConversationController::class, 'send_message'])->middleware('auth:sanctum');