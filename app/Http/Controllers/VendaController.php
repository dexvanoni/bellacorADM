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
        $vendas = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    ->where('pago', "S")
                    ->get();
        $inicio = $request->inicio;
        $fim = $request->fim;

        $fat_bruto = $vendas->sum('valor_pago');
        $fat_liquido = $fat_bruto-$vendas->sum('custo');

        return view('vendas.relatorio', compact('vendas', 'inicio', 'fim', 'fat_bruto', 'fat_liquido'));
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
        $vendas = Venda::create($request->all());
        
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
