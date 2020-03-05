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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('produtos', 'ProdutoController')->middleware('auth');
Route::resource('compras', 'CompraController')->middleware('auth');
Route::resource('insumos', 'InsumoController')->middleware('auth');
Route::resource('clientes', 'ClienteController')->middleware('auth');
Route::resource('fornecedores', 'FornecedorController')->middleware('auth');
Route::resource('vendas', 'VendaController')->middleware('auth');


Route::get('/produtos/{i}/add', 'ProdutoController@add')->name('produtos.add')->middleware('auth');
Route::get('/produtos/{i}/add_dez', 'ProdutoController@add_dez')->name('produtos.add_dez')->middleware('auth');
Route::get('/produtos/{i}/add_vinte', 'ProdutoController@add_vinte')->name('produtos.add_vinte')->middleware('auth');
Route::get('/produtos/{i}/add_trinta', 'ProdutoController@add_trinta')->name('produtos.add_trinta')->middleware('auth');

Route::get('/produtos/{i}/{q}/add_compra', 'ProdutoController@add_compra')->name('produtos.add_compra')->middleware('auth');
Route::get('/produtos/{i}/{q}/{v}/adicionar', 'ProdutoController@adicionar')->name('produtos.adicionar')->middleware('auth');

Route::get('/vendas/{i}/pagou', 'VendaController@pagou')->name('vendas.pagou')->middleware('auth');
Route::get('/vendas/{i}/cancelar', 'VendaController@cancelar')->name('vendas.cancelar')->middleware('auth');
Route::get('/vendas/{i}/realizado', 'VendaController@realizado')->name('vendas.realizado')->middleware('auth');
Route::get('/vendas/{i}/recibo', 'VendaController@recibo')->name('vendas.recibo')->middleware('auth');

Route::get('compras_rela', 'CompraController@rela')->name('compras.rela')->middleware('auth');
Route::POST('compras_pesquisa', 'CompraController@pesquisa')->name('compras.pesquisa')->middleware('auth');

Route::get('vendas_rela', 'VendaController@rela')->name('vendas.rela')->middleware('auth');
Route::POST('vendas_pesquisa', 'VendaController@pesquisa')->name('vendas.pesquisa')->middleware('auth');

Route::POST('vendas_recibo_conjunto', 'VendaController@recibo_conjunto')->name('vendas.recibo_conjunto')->middleware('auth');

Route::get('relatorio_completo', 'VendaController@relatorio_completo')->name('relatorio_completo')->middleware('auth');