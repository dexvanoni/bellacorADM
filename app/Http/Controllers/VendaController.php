<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use App\Insumo;
use App\Cliente;
use App\Compra;
use App\Produto;
use Carbon\Carbon;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = Venda::all();
        return view('vendas.index', compact('vendas'));
    }

    public function rela()
    {
        
        //$compras = Compra::all();
        
        return view('vendas.relatorio');
    }

    public function pagou($i)
    {
        $vendas = Venda::find($i);

        DB::table('vendas')
        ->where('id', $i)
            ->update(['pago' => 'S']);

        return redirect()->action('VendaController@index');
    }

    public function pesquisa(Request $request)
    {
        if ($request->tipo == 'GERAL') {
            $vendas = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    ->where('pago', "S")
                    ->get();
                $conta = $vendas->count();
        } else {
            $vendas = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    ->where('pago', "S")
                    ->where('tipo', $request->tipo)
                    ->get();
            $conta = $vendas->count();
        }
               
        $inicio = $request->inicio;
        $fim = $request->fim;
        $tp = $request->tipo;

        $fat_bruto = $vendas->sum('valor_pago');
        $fat_liquido = $fat_bruto-$vendas->sum('custo');
        //dd($vendas);
        //exit;
        return view('vendas.relatorio', compact('vendas', 'inicio', 'fim', 'fat_bruto', 'fat_liquido', 'tp', 'conta'));
    }

    public function cancelar($i)
    {
        $vendas = Venda::find($i);
        
        $estoque = DB::table('produtos')->where('produto', $vendas->produto)->get();

        DB::table('produtos')
        ->where('produto', $vendas->produto)
            ->update(['estoque' => $estoque[0]->estoque+$vendas->quantidade]);

        $vendas->delete();
        return redirect()->action('VendaController@index');
    }

    public function realizado($i)
    {
        $vendas = Venda::find($i);
        DB::table('vendas')
        ->where('id', $i)
            ->update(['situacao' => 'Realizado']);
        return redirect()->action('VendaController@index');
    }

    public function recibo($i)
    {
        $vendas = Venda::find($i);
        return view('vendas.recibo_venda', compact('vendas'));
        //return redirect()->action('VendaController@index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            
        return view('vendas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $total_valor = DB::table('compras')->where('item', $request->produto)->sum('valor_pago');
              $total_itens = DB::table('compras')->where('item', $request->produto)->sum('quantidade');
              
              if ($total_valor != 0) {
                $media = $total_valor/$total_itens;
              } else {
                $media = 'Este produto não foi adquirido';
              }

        if (!is_null($request->q)) {
            $pecas = $request->q;
        } else {
            $pecas = 0;
        }
        
        $vendas = new Venda;
        $vendas->produto = $request->produto;
        $vendas->quantidade = $request->quantidade;
        $vendas->valor_pago = $request->valor_pago;
        $vendas->dt_entrega = $request->dt_entrega;
        $vendas->num_parcelas = $request->num_parcelas;
        $vendas->forma_pagamento = $request->forma_pagamento;
        $vendas->valor_entrada = $request->valor_entrada;
        $vendas->pago = $request->pago;
        $vendas->tipo = $request->tipo;
        $vendas->cliente = $request->cliente;
        $vendas->situacao = $request->situacao;
        $vendas->entrega = $request->entrega;
        if (is_null($request->q)) {
            $vendas->custo = ($request->custo+$media)*$vendas->quantidade;
            } else {
                $vendas->custo = ($request->custo*$pecas)+($media*$vendas->quantidade);
            }
        $vendas->obs = $request->obs;
        $vendas->save();
        //$vendas = Venda::create($request->all());
        
        if (!is_null($request->rua)) {
            $cliente = new Cliente;
            $cliente->nome = $request->cliente;
            $cliente->contato = $request->contato;
            $cliente->doc = $request->doc;
            $cliente->rua = $request->rua;
            $cliente->numero = $request->numero;
            $cliente->bairro = $request->bairro;
            $cliente->save();      
        }
        
       $estoque = DB::table('produtos')->where('produto', $request->produto)->get();

        DB::table('produtos')
        ->where('produto', $request->produto)
            ->update(['estoque' => $estoque[0]->estoque-$request->quantidade]);

        return redirect()->action('VendaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
