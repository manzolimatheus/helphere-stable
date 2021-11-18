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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request; 


// Principal
Route::get('/', [PrincipalController::class, 'index']);
Route::get('/suporte', [PrincipalController::class, 'suporte']);
Route::get('/dashboard', [PrincipalController::class, 'dashboard'])->middleware('auth', 'verified');
Route::get('/gerenciar', [PrincipalController::class, 'gerenciar'])->middleware('auth', 'verified');
Route::get('/config', [PrincipalController::class, 'config'])->middleware('auth', 'verified');

// Verificação de Email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Depois de ter verificado o email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Reenviando email de verificação!
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
  
    return back()->with('msg', 'Link de verificação enviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Instituição
Route::get('/criar', [InstitutesController::class, 'criar'])->middleware('auth', 'verified');
Route::post('/criarInstitutes', [InstitutesController::class, 'criarInstitutes'])->middleware('auth', 'verified');
Route::get('/instituicao/{id}', [InstitutesController::class, 'mostrar'])->middleware('auth', 'verified');
Route::delete('/instituicao/{id}', [InstitutesController::class, 'deletar'])->middleware('auth', 'verified');
Route::get('/instituicao/edit/{id}', [InstitutesController::class, 'editar'])->middleware('auth', 'verified');
Route::put('/instituicao/update/{id}', [InstitutesController::class, 'update'])->middleware('auth', 'verified');
Route::post('/doar', [InstitutesController::class, 'doar'])->middleware('auth');
Route::get('/instituicao/{id}/codeDoar', [InstitutesController::class, 'codeDoar'])->middleware('auth', 'verified');
Route::get('/instituicao/{id}/estatistica', [InstitutesController::class, 'estatistica'])->middleware('auth', 'verified');

// Perfil
Route::get('/perfil/{id}', [OthersController::class, 'perfil'])->middleware('auth', 'verified');

// Categoria
Route::get('/categoria/{id}', [OthersController::class, 'categoria'])->middleware('auth', 'verified');

// Pesquisa
Route::get('/pesquisa', [PesquisaController::class, 'pesquisar_institutes'])->middleware('auth', 'verified');
Route::get('/pesquisa/pessoas', [PesquisaController::class, 'pesquisar_pessoas'])->middleware('auth', 'verified');
Route::get('/pesquisa/postsusers', [PesquisaController::class, 'pesquisar_posts_users'])->middleware('auth', 'verified');
Route::get('/pesquisa/postsinstitutes', [PesquisaController::class, 'pesquisar_posts_institutes'])->middleware('auth', 'verified');
Route::get('/pesquisa/campanha', [PesquisaController::class, 'pesquisar_campanha'])->middleware('auth', 'verified');

// Posts
Route::post('/post_user', [PostsController::class, 'post_user'])->middleware('auth', 'verified');
Route::post('/post_institute/{id}', [PostsController::class, 'post_institute'])->middleware('auth', 'verified');
Route::delete('/post_delete/{id}', [PostsController::class, 'post_delete'])->middleware('auth', 'verified');
Route::delete('/post_user_delete/{id}', [PostsController::class, 'post_user_delete'])->middleware('auth', 'verified');
Route::post('/report_post_user/{id}', [PostsController::class, 'report_post_user'])->middleware('auth', 'verified');
Route::post('/report_post_institute/{id}', [PostsController::class, 'report_post_institute'])->middleware('auth', 'verified');

// E-mail embutido
Route::get('/caixa_entrada', [EmailController::class, 'caixa_entrada'])->middleware('auth', 'verified');
Route::post('/enviar_mensagem/{id}', [EmailController::class, 'enviar_mensagem'])->middleware('auth', 'verified');
Route::delete('/delete_message/{id}', [EmailController::class, 'deletar_mensagem'])->middleware('auth', 'verified');
Route::delete('/delete_all_message', [EmailController::class, 'deletar_todas_mensagens'])->middleware('auth', 'verified');

// Campanhas
Route::get('/criar_campanha', [CampaignsController::class, 'criar_campanha'])->middleware('auth', 'verified');
Route::get('/campanha/{id}', [CampaignsController::class, 'show_campanha'])->middleware('auth', 'verified');
Route::post('/post_campanha', [CampaignsController::class, 'post_campanha'])->middleware('auth', 'verified');
Route::delete('/campanha/{id}', [CampaignsController::class, 'delete_campanha'])->middleware('auth', 'verified');
Route::get('/campanha/edit/{id}', [CampaignsController::class, 'editar_campanha'])->middleware('auth', 'verified');
Route::put('/campanha/update/{id}', [CampaignsController::class, 'update_campanha'])->middleware('auth', 'verified');
Route::post('/doarCampanha', [CampaignsController::class, 'doarCampanha'])->middleware('auth', 'verified');
Route::get('/campanha/{id}/codeDoarCampanha', [CampaignsController::class, 'codeDoarCampanha'])->middleware('auth', 'verified');
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
