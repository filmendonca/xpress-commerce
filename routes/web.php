<?php

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

//Página home da aplicação
Route::get('/', 'HomeController@index')->name('/');

//---------------------Produto-----------------------//

//Página de produtos; o name() é usado para aceder através de {{route()}}
Route::get('products', 'ProductController@index')->name('products');

//Route para pesquisar um produto por texto
Route::get('search', 'ProductController@search')->name('search');

//Route para pesquisar um produto por atributos
Route::get('searchAtt', 'ProductController@searchAttribute')->name('searchAttribute');

//Página de produto individual
Route::get('products/{product}', 'ProductController@show')->name('products.show');

//------------------------------------------------------//


//---------------------Utilizador-----------------------//

//Perfil
//Route::get('profile', 'UserController@show');

//Route::get('login', 'AuthController@postLogin');

//Route::get('logout', 'AuthController@logout');

//------------------------------------------------------//


//Cria as routes relacionadas com a autenticação
Auth::routes(['verify' => true]);

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

//Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//O utilizador está autenticado e verificado
Route::middleware('auth', 'verified')->group(function(){

    //--------------------Produto CRUD--------------------//

    //Página que mostra o formulário para adicionar um novo produto
    Route::get('add_product', 'ProductController@add')->name('add_product');

    //Esta route guarda o produto na base de dados
    Route::post('store_product', 'ProductController@store')->name('store_product');

    //Página para editar dados de um produto
    Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit');

    //Esta route edita e guarda o produto na base de dados
    Route::post('products/{id}/update_product', 'ProductController@update')->name('products.update_product');

    //Route para apagar um produto
    Route::get('products/{product}/delete', 'ProductController@delete')->name('products.delete');

    //------------------------------------------------------//

    //-----------------------Perfil-------------------------//

    //Mostrar perfil
    Route::get('profile', 'UserController@show')->name('profile');

    //Página para editar dados do utilizador
    Route::get('profile/edit', 'UserController@edit')->name('profile.edit');

    //Esta route edita e guarda o nome e o avatar do utilizador
    Route::post('profile/update_profile', 'UserController@update')->name('profile.update');

    //Página para mudar de password
    Route::get('profile/change_password', 'UserController@passwordView')->name('change_password');

    //Atualiza a password
    Route::post('profile/change_password/update', 'UserController@changePassword')->name('change_password.update');

    //Página para mudar de email
    Route::get('profile/change_email', 'UserController@emailView')->name('change_email');

    //Atualiza o email
    Route::post('profile/change_email/update', 'UserController@changeEmail')->name('change_email.update');

    //---------------------Comentário-----------------------//

    //Guarda o comentário na base de dados
    Route::post('products/{id}/store_comment', 'CommentController@store')->name('comments.add');

    //Página para editar dados de um comentário
    Route::get('products/{id}/edit_comment/{commentId}', 'CommentController@edit')->name('comments.edit');

    //Esta route edita e guarda o comentário na base de dados
    Route::post('products/{id}/edit_comment/{commentId}/update_comment', 'CommentController@update')->name('comments.update');

    //Route para apagar um comentário
    Route::get('products/{id}/delete_comment/{commentId}', 'CommentController@delete')->name('comments.delete');

    //------------------------------------------------------//

    //---------------------Carrinho-------------------------//

    //Página que mostra os itens que estão no carrinho
    Route::get('cart', 'ShoppingController@index')->name('cart');

    //Adiciona um item ao carrinho
    Route::get('cart/add/{id}', 'ShoppingController@add')->name('cart.add');

    //Atualiza um item do carrinho
    Route::get('cart/update/{id}', 'ShoppingController@updateQty')->name('cart.update');

    //Adiciona um item ao carrinho a partir do menu dos produtos
    Route::get('cart/menu/add/{id}', 'ShoppingController@menuAdd')->name('cart.menu.add');

    //Página que mostra o checkout
    Route::get('cart/checkout', 'ShoppingController@checkout')->name('cart.checkout');

    //Trata do "pagamento" dos produtos
    Route::post('cart/checkout', 'ShoppingController@purchase')->name('cart.checkout');

    //Apaga um item do carrinho
    Route::get('cart/delete/{id}', 'ShoppingController@delete')->name('cart.delete');

    //------------------------------------------------------//

});

//O utilizador é um administrador
Route::middleware('admin')->group(function(){

    //Página do dashboard
    Route::get('dashboard', 'AdminController@index')->name('dashboard');

    //---------------------Categoria------------------------//

    //Página que mostra as categorias existentes
    Route::get('category', 'CategoriesController@index')->name('category');

    //Página para adicionar uma nova categoria
    Route::get('category/add', 'CategoriesController@add')->name('category.add');

    //Guarda a categoria na base de dados
    Route::post('category/store', 'CategoriesController@store')->name('category.store');

    //Página para editar dados de uma categoria
    Route::get('category/edit/{id}', 'CategoriesController@edit')->name('category.edit');

    //Edita e guarda a categoria na base de dados
    Route::post('category/update/{id}', 'CategoriesController@update')->name('category.update');

    //Apaga uma categoria
    Route::get('category/delete/{id}', 'CategoriesController@delete')->name('category.delete');

    //------------------------------------------------------//

    //----------------Modificar utilizadores----------------//

    //Página que mostra os utilizadores existentes
    Route::get('users', 'AdminController@users')->name('users');

    //Torna um utilizador escolhido em administrador
    Route::get('users/turn_admin/{id}', 'AdminController@turnAdmin')->name('users.turn_admin');

    //------------------------------------------------------//

});


//Route::redirect('localhost', '/~charlize/home', 302);