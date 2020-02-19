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

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    public function adicionar($i, $q, $v)
    {
        $nome_produto = $i;
        $qtn = $q;
        $valor = $v;

        $insumos = DB::table('insumos')->where('insumo', $nome_produto)->get();
        //$produtos = DB::table('produtos')->where('produto', $nome_produto)->get();

        /*if ($produtos->isEmpty()) {
            $produto = new Produto;
            $produto->produto = $nome_produto;
            $produto->valor_custo = $valor/$qtn;
            $produto->un = "Unidade";
            $produto->valor_venda = ($valor/$qtn)*2;
            $produto->tipo = "SUBLIMAÇÃO";
            $produto->quem_comprou = "EMPRESA";
            $produto->estoque = $qtn;
            $produto->save();
        }
        */
        if ($insumos->isEmpty()) {
            $insumo = new Insumo;
            $insumo->insumo = $nome_produto;
            $insumo->save();
        } 
        return view('produtos.create', compact('nome_produto', 'qtn', 'valor'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produtos.create');
    }

    public function add($i)
    {
        $produto = Produto::find($i);

        DB::table('produtos')
        ->where('id', $i)
            ->update(['estoque' => $produto->estoque+1]);

        return redirect()->action('ProdutoController@index');
    }

    public function add_dez($i)
    {
        $produto = Produto::find($i);

        DB::table('produtos')
        ->where('id', $i)
            ->update(['estoque' => $produto->estoque+10]);

        return redirect()->action('ProdutoController@index');
    }

    public function add_vinte($i)
    {
        $produto = Produto::find($i);

        DB::table('produtos')
        ->where('id', $i)
            ->update(['estoque' => $produto->estoque+20]);

        return redirect()->action('ProdutoController@index');
    }

    public function add_trinta($i)
    {
        $produto = Produto::find($i);

        DB::table('produtos')
        ->where('id', $i)
            ->update(['estoque' => $produto->estoque+30]);

        return redirect()->action('ProdutoController@index');
    }

    public function add_compra($i, $q)
    {
        $produto = DB::table('produtos')
        ->where('produto', $i)->first();

        DB::table('produtos')
        ->where('produto', $i)
            ->update(['estoque' => $produto->estoque+$q]);

        DB::table('compras')
        ->where('item', $i)
            ->update(['add_estoque_produto' => 'S']);

        return redirect()->action('CompraController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produtos = Produto::create($request->all());
            if($request->add_estoque_produto == 'S'){
                DB::table('compras')
                        ->where('item', $request->produto)
                        ->update(['add_estoque_produto' => 'S']);
                        return redirect()->action('CompraController@index');
            }                        
        return redirect()->action('ProdutoController@index');
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
        $produtos = Produto::find($id);
        return view('produtos.edit',compact('produtos'));
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

        $produtos  = Produto::findOrFail($id);
        $data = $request->all();
        $produtos->fill($data)->save();
        
        return redirect()->action('ProdutoController@index')
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
