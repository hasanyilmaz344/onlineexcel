<?php

use App\Http\Controllers\CellController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SheetController;
use App\Models\sheet;
use Illuminate\Support\Facades\Route;

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
//mainpage
Route::get('/', [FileController::class, 'getallfiles'])->name('getallfiles');


Route::get('/thefile', [SheetController::class, 'thefile'])->name('thefile');
Route::get('/createfile', [FileController::class, 'createfile'])->name('createfile');
Route::get('/deletefile', [FileController::class, 'deletefile'])->name('deletefile');
Route::get('/updatecell', [CellController::class, 'updatecell'])->name('updatecell');
Route::get('/getsheetbyid', [SheetController::class, 'getsheetbyid'])->name('getsheetbyid');
Route::get('/newsheet', [SheetController::class, 'newsheet'])->name('newsheet');

//
Route::get('/columnadd', [CellController::class, 'columnadd'])->name('columnadd');
Route::get('/rowadd', [CellController::class, 'rowadd'])->name('rowadd');
Route::get('/removecolumn', [CellController::class, 'removecolumn'])->name('removecolumn');
Route::get('/removerow', [CellController::class, 'removerow'])->name('removerow');


Route::get('/deneme',function(){
    return view('deneme');
});