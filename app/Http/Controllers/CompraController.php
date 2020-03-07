<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use App\Insumo;
use App\Cliente;
use App\Compra;
use Carbon\Carbon;
use App\Produto;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        $compras = Compra::all();
        $insumos = Insumo::all();
        return view('compras.index', compact('compras', 'produtos', 'insumos'));
    }

    public function rela()
    {
        
        //$compras = Compra::all();
        
        return view('compras.relatorio');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compras.create');
    }

    public function add($i)
    {
        $compras = Compra::find($i);

        DB::table('compras')
        ->where('id', $i)
            ->update(['estoque' => $produto->estoque+1]);

        return redirect()->action('CompraController@index');
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pesquisa(Request $request)
    {
        if ($request->tipo == 'GERAL') {
            $vendas = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->get();

            $empresa = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('quem_pagou', 'EMPRESA')
                    ->sum('valor_pago');
            $denis = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('quem_pagou', 'DENIS')
                    ->sum('valor_pago');
            $renato = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('quem_pagou', 'RENATO')
                    ->sum('valor_pago');
                
            $conta = $vendas->count();
                
        } else {
            $vendas = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('tipo', $request->tipo)
                    ->get();

            $empresa = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('quem_pagou', 'EMPRESA')
                    ->sum('valor_pago');
            $denis = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('quem_pagou', 'DENIS')
                    ->sum('valor_pago');
            $renato = DB::table('compras')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('quem_pagou', 'RENATO')
                    ->sum('valor_pago');

            $conta = $vendas->count();
        }
               
        $inicio = $request->inicio;
        $fim = $request->fim;
        $tp = $request->tipo;

        $total_compras = $vendas->sum('valor_pago');
        
        return view('compras.relatorio', compact('vendas', 'inicio', 'fim', 'tp', 'conta', 'total_compras', 'empresa', 'denis', 'renato'));
    }
    
    public function store(Request $request)
    {
        $compras = Compra::create($request->all());
        $produto = DB::table('produtos')
                    ->where('produto', $request->item)->get();
        
        if ($produto->isNotEmpty()) {
            
            //NOVA REGRA - AO FAZER A COMPRA O ITEM É ADICIONADO NO CATÁLOGO DE PRODUTOS COMO UM NOVO PRODUTO.
            // FAZER COM QUE TODO DIA 05 DE CADA MÊS O VALOR DE CUSTO DOS PRODUTOS EM ESTOQUE  SEJA ZERADO.
        
            DB::table('produtos')
            ->where('produto', $request->item)
            ->update(['obs' => 'DUP']);
            
           //SE NA COMPRA EXISTE O MESMO PRODUTO - SÓ AUMENTAR O ESTOQUE 
            //DB::table('produtos')
            // ->where('produto', $request->item)
             //   ->update(['estoque' => $produto[0]->estoque+$request->quantidade]);

            //DB::table('compras')
            //    ->where('item', $request->item)
             //   ->update(['add_estoque_produto' => 'S']);

        }

            $produtos = new Produto;
            $produtos->produto = $request->item;
            $produtos->un = 'UN';
            $produtos->valor_venda = ($request->valor_pago/$request->quantidade)*2;
            $produtos->valor_custo = $request->valor_pago/$request->quantidade;
            $produtos->obs = '';
            $produtos->tipo = $request->tipo;
            $produtos->quem_comprou = $request->quem_pagou;
            $produtos->estoque = $request->quantidade;
            $produtos->save();


        // FAZ A VERIFICAÇÃO DO ESTOQUE E ALTERA OS VALORES CONFORME A DATA

            $duplicados = DB::table('produtos')
                            ->where('obs', 'DUP')
                            ->get();

            $dt = Carbon::now();
            $dia = 05;
            $virada = Carbon::create($dt->year, $dt->month, $dia, 00, 00, 00);        

           if ($duplicados->isNotEmpty()) {
                foreach ($duplicados as $d) {
                    if ($d->created_at <= $virada && $dt >= $virada && $d->estoque > 0) {
                    DB::table('produtos')
                        ->where('id', $d->id)
                        ->update(['valor_custo' => 0]);
                    }elseif($d->created_at <= $virada && $dt >= $virada && $d->estoque <= 0){
                    DB::table('produtos')
                        ->where('id', $d->id)
                        ->delete(); 
                    }
                }
            }             
        // -----------------------------------------------------------------
               
        return redirect()->action('CompraController@index');
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
        $compras = Compra::find($id);
        return view('compras.edit',compact('compras'));
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

        $compras  = Compra::findOrFail($id);
        $data = $request->all();
        $compras->fill($data)->save();
        
        return redirect()->action('CompraController@index')
                ->with('success','Parâmetros atualizados com sucesso');
                        
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
