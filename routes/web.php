<?php

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

use App\Http\Controllers\InstitutesController;

// Princpal
Route::get('/', [InstitutesController::class, 'index']);
Route::get('/suporte', [InstitutesController::class, 'suporte']);
Route::get('/dashboard', [InstitutesController::class, 'dashboard'])->middleware('auth');
Route::get('/gerenciar', [InstitutesController::class, 'gerenciar'])->middleware('auth');
Route::get('/config', [InstitutesController::class, 'config'])->middleware('auth');

// Instituição
Route::get('/criar', [InstitutesController::class, 'criar'])->middleware('auth');
Route::post('/criarInstitutes', [InstitutesController::class, 'criarInstitutes'])->middleware('auth');
Route::get('/instituicao/{id}', [InstitutesController::class, 'mostrar'])->middleware('auth');
Route::delete('/instituicao/{id}', [InstitutesController::class, 'deletar'])->middleware('auth');
Route::get('/instituicao/edit/{id}', [InstitutesController::class, 'editar'])->middleware('auth');
Route::put('/instituicao/update/{id}', [InstitutesController::class, 'update'])->middleware('auth');
Route::post('/doar', [InstitutesController::class, 'doar'])->middleware('auth');
Route::get('/instituicao/{id}/codeDoar', [InstitutesController::class, 'codeDoar'])->middleware('auth');
Route::get('/instituicao/{id}/estatistica', [InstitutesController::class, 'estatistica'])->middleware('auth');

// Perfil
Route::get('/perfil/{id}', [InstitutesController::class, 'perfil'])->middleware('auth');

// Categoria
Route::get('/categoria/{id}', [InstitutesController::class, 'categoria'])->middleware('auth');

// Pesquisa
Route::get('/pesquisa', [InstitutesController::class, 'pesquisar_institutes'])->middleware('auth');
Route::get('/pesquisa/pessoas', [InstitutesController::class, 'pesquisar_pessoas'])->middleware('auth');
Route::get('/pesquisa/postsusers', [InstitutesController::class, 'pesquisar_posts_users'])->middleware('auth');
Route::get('/pesquisa/postsinstitutes', [InstitutesController::class, 'pesquisar_posts_institutes'])->middleware('auth');
Route::get('/pesquisa/campanha', [InstitutesController::class, 'pesquisar_campanha'])->middleware('auth');

// Posts
Route::post('/post_user', [InstitutesController::class, 'post_user'])->middleware('auth');
Route::post('/post_institute/{id}', [InstitutesController::class, 'post_institute'])->middleware('auth');
Route::delete('/post_delete/{id}', [InstitutesController::class, 'post_delete'])->middleware('auth');
Route::delete('/post_user_delete/{id}', [InstitutesController::class, 'post_user_delete'])->middleware('auth');
Route::post('/report_post_user/{id}', [InstitutesController::class, 'report_post_user'])->middleware('auth');
Route::post('/report_post_institute/{id}', [InstitutesController::class, 'report_post_institute'])->middleware('auth');

// E-mail embutido
Route::get('/caixa_entrada', [InstitutesController::class, 'caixa_entrada'])->middleware('auth');
Route::post('/enviar_mensagem/{id}', [InstitutesController::class, 'enviar_mensagem'])->middleware('auth');
Route::delete('/delete_message/{id}', [InstitutesController::class, 'deletar_mensagem'])->middleware('auth');
Route::delete('/delete_all_message', [InstitutesController::class, 'deletar_todas_mensagens'])->middleware('auth');

// Campanhas
Route::get('/criar_campanha', [InstitutesController::class, 'criar_campanha'])->middleware('auth');
Route::get('/campanha/{id}', [InstitutesController::class, 'show_campanha'])->middleware('auth');
Route::post('/post_campanha', [InstitutesController::class, 'post_campanha'])->middleware('auth');
Route::delete('/campanha/{id}', [InstitutesController::class, 'delete_campanha'])->middleware('auth');
Route::get('/campanha/edit/{id}', [InstitutesController::class, 'editar_campanha'])->middleware('auth');
Route::put('/campanha/update/{id}', [InstitutesController::class, 'update_campanha'])->middleware('auth');
Route::post('/doarCampanha', [InstitutesController::class, 'doarCampanha'])->middleware('auth');
Route::get('/campanha/{id}/codeDoarCampanha', [InstitutesController::class, 'codeDoarCampanha'])->middleware('auth');
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/

