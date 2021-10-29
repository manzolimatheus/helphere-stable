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
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OthersController;


// Principal
Route::get('/', [PrincipalController::class, 'index']);
Route::get('/suporte', [PrincipalController::class, 'suporte']);
Route::get('/dashboard', [PrincipalController::class, 'dashboard'])->middleware('auth');
Route::get('/gerenciar', [PrincipalController::class, 'gerenciar'])->middleware('auth');
Route::get('/config', [PrincipalController::class, 'config'])->middleware('auth');

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
Route::get('/perfil/{id}', [OthersController::class, 'perfil'])->middleware('auth');

// Categoria
Route::get('/categoria/{id}', [OthersController::class, 'categoria'])->middleware('auth');

// Pesquisa
Route::get('/pesquisa', [PesquisaController::class, 'pesquisar_institutes'])->middleware('auth');
Route::get('/pesquisa/pessoas', [PesquisaController::class, 'pesquisar_pessoas'])->middleware('auth');
Route::get('/pesquisa/postsusers', [PesquisaController::class, 'pesquisar_posts_users'])->middleware('auth');
Route::get('/pesquisa/postsinstitutes', [PesquisaController::class, 'pesquisar_posts_institutes'])->middleware('auth');
Route::get('/pesquisa/campanha', [PesquisaController::class, 'pesquisar_campanha'])->middleware('auth');

// Posts
Route::post('/post_user', [PostsController::class, 'post_user'])->middleware('auth');
Route::post('/post_institute/{id}', [PostsController::class, 'post_institute'])->middleware('auth');
Route::delete('/post_delete/{id}', [PostsController::class, 'post_delete'])->middleware('auth');
Route::delete('/post_user_delete/{id}', [PostsController::class, 'post_user_delete'])->middleware('auth');
Route::post('/report_post_user/{id}', [PostsController::class, 'report_post_user'])->middleware('auth');
Route::post('/report_post_institute/{id}', [PostsController::class, 'report_post_institute'])->middleware('auth');

// E-mail embutido
Route::get('/caixa_entrada', [EmailController::class, 'caixa_entrada'])->middleware('auth');
Route::post('/enviar_mensagem/{id}', [EmailController::class, 'enviar_mensagem'])->middleware('auth');
Route::delete('/delete_message/{id}', [EmailController::class, 'deletar_mensagem'])->middleware('auth');
Route::delete('/delete_all_message', [EmailController::class, 'deletar_todas_mensagens'])->middleware('auth');

// Campanhas
Route::get('/criar_campanha', [CampaignsController::class, 'criar_campanha'])->middleware('auth');
Route::get('/campanha/{id}', [CampaignsController::class, 'show_campanha'])->middleware('auth');
Route::post('/post_campanha', [CampaignsController::class, 'post_campanha'])->middleware('auth');
Route::delete('/campanha/{id}', [CampaignsController::class, 'delete_campanha'])->middleware('auth');
Route::get('/campanha/edit/{id}', [CampaignsController::class, 'editar_campanha'])->middleware('auth');
Route::put('/campanha/update/{id}', [CampaignsController::class, 'update_campanha'])->middleware('auth');
Route::post('/doarCampanha', [CampaignsController::class, 'doarCampanha'])->middleware('auth');
Route::get('/campanha/{id}/codeDoarCampanha', [CampaignsController::class, 'codeDoarCampanha'])->middleware('auth');
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/
