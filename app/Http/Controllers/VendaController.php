<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use App\Insumo;
use App\Cliente;
use App\Compra;
use App\Produto;
use Carbon\Carbon;
use App\Retroativo;

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

    public function recibo_conjunto(Request $request)
    {
      $ids = explode(',', $request->dados);
      $itens = collect([]);
      foreach ($ids as $key => $value) {
        $vendas = Venda::find($value);
        $itens->push($vendas);
      }

      //echo $itens->sum('valor_pago');
      //dd($itens);
      //exit;
      
        return view('vendas.recibo_venda_conjunta', compact('itens'));
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
                    //->where('pago', "S")
                    ->get();

     $vendas_p = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    ->where('pago', "S")
                    ->get();

    $vendas_np = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    ->where('pago', "N")
                    ->get();

              $conta = $vendas->count();
        } else {
            $vendas = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    //->where('pago', "S")
                    ->where('tipo', $request->tipo)
                    ->get();

    $vendas_p = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    ->where('pago', "S")
                    ->get();

    $vendas_np = DB::table('vendas')
                    ->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])
                    ->where('situacao', "Realizado")
                    ->where('pago', "N")
                    ->get();

            $conta = $vendas->count();
        }
               
        $inicio = $request->inicio;
        $fim = $request->fim;
        $tp = $request->tipo;

        
  $fat_bruto = $vendas->sum('valor_pago');
  $pagos = $vendas_p->sum('valor_pago');


        $fat_liquido = $pagos-$vendas->sum('custo');
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

        $estoque_zero = DB::table('produtos')
                        ->where('estoque', '<=', '0')
                        ->get();

        //dd($estoque_zero);
        //exit;
        foreach ($estoque_zero as $e) {

          DB::table('produtos')->delete($e->id);
        }
            
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

$custo_zero = DB::table('produtos')
                      ->where('id', $request->produto)
                      ->get();
      //dd($custo_zero);
      //exit;

$prod = Produto::find($request->produto);

 $media = $prod->valor_custo;


$este = Produto::find($request->produto);

$request->produto = $prod->produto;

            /*$total_valor = DB::table('compras')->where('item', $request->produto)->sum('valor_pago');
              $total_itens = DB::table('compras')->where('item', $request->produto)->sum('quantidade');
              
              if ($total_valor != 0) {
                $media = $total_valor/$total_itens;
              } else {
                $media = 'Este produto não foi adquirido';
              }*/



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
          if($custo_zero[0]->valor_custo != 0){
            $vendas->custo = ($request->custo+$media)*$vendas->quantidade;
          }else{
            $vendas->custo = $request->custo*$vendas->quantidade;
          }
        } else {
          if($custo_zero[0]->valor_custo != 0){
            $vendas->custo = ($request->custo*$pecas)+($media*$vendas->quantidade);
          }else{
            $vendas->custo = $request->custo*$vendas->quantidade;
          }
          
        }
        $vendas->obs = $request->obs;
        $vendas->save();
        
        
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
        
       $estoque = DB::table('produtos')->where('id', $este->id)->get();
       
        DB::table('produtos')
        ->where('id', $este->id)
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

    public function relatorio_completo(){

      // Create Carbon date
        $dt = Carbon::now();
        $mes = $dt->formatLocalized('%B de %Y');
        
        //$mes = Carbon\Carbon::now();
        $dia = '15';
        $virada = Carbon::create($dt->year, $dt->month, $dia, 23, 59, 59);
        $hoje = Carbon::now()->format('Y-m-d');
        $dia_virada = Carbon::create($dt->year, $dt->month, $dia);
        $dia_antes_virada = $virada->subDay(1)->format('Y-m-d');
        $dia_mes_anterior = $dia_virada->subMonth();

        $sobra = $dt->month.'/'.$dt->year;




      $vendas = DB::table('vendas')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                ->where('pago', 'S')
                ->where('tipo', 'SUBLIMAÇÃO')
                ->get();
      $vendas_naop = DB::table('vendas')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                ->where('tipo', 'SUBLIMAÇÃO')
                ->get();

      $compras_denis = DB::table('compras')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                ->where('quem_pagou', 'DENIS')
                ->where('tipo', 'SUBLIMAÇÃO')
                ->get();

      $compras_fabiana = DB::table('compras')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                ->where('quem_pagou', 'FABIANA')
                ->where('tipo', 'SUBLIMAÇÃO')
                ->get();

      $compras_renato = DB::table('compras')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                ->where('quem_pagou', 'RENATO')
                ->where('tipo', 'SUBLIMAÇÃO')
                ->get();

      $compras_empresa = DB::table('compras')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                ->where('quem_pagou', 'EMPRESA')
                ->where('tipo', 'SUBLIMAÇÃO')
                ->get();
      
      $todas_compras = DB::table('compras')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                //->where('quem_pagou', 'EMPRESA')
                //->sum('valor_pago')
                ->where('tipo', 'SUBLIMAÇÃO')
                ->get();           

      $todas_compras_pessoas = DB::table('compras')
                ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                 ->where(function ($query) {
                      $query->where('tipo', '=', 'SUBLIMAÇÃO')
                      ->whereIn('quem_pagou', ['DENIS', 'RENATO', 'FABIANA']);
                    })->get();


      //$divisao = ($vendas->sum('valor_pago')-$todas_compras_pessoas->sum('valor_pago'))/3;

      if (!is_null($vendas_naop)) {
        $custo_bruto = $vendas_naop->sum('custo');
      } else {
        $custo_bruto = 0;
      }

      if(!is_null($vendas)){
        $custo_liquido = $vendas->sum('custo');
        $faturamento_bruto = $vendas->sum('valor_pago');
      } else {
        $custo_liquido = 0;
        $faturamento_bruto = 0;
      }

      if ($faturamento_bruto > 0) {
        $faturamento_liquido = $faturamento_bruto-$todas_compras->sum('valor_pago');
      } else {
        $faturamento_liquido = 0;
      }

      if ($faturamento_bruto > 0 && $faturamento_liquido > 0) {
       $porcentagem = ($faturamento_liquido/$faturamento_bruto)*100;
      } else {
        $porcentagem = 0;
      }

      if (!is_null($todas_compras)) {
        $total_compras = $todas_compras->sum('valor_pago');
      } else {
        $total_compras = 0;
      }

      if (!is_null($todas_compras)) {
        $gastos_denis = $compras_denis->sum('valor_pago');
        $gastos_fabiana = $compras_fabiana->sum('valor_pago');
        $gastos_renato = $compras_renato->sum('valor_pago');
        $gastos_empresa = $compras_empresa->sum('valor_pago');
      } else {
        $gastos_denis = 0;
        $gastos_fabiana = 0;
        $gastos_renato = 0;
        $gastos_empresa = 0;
      }

      /*$retroativo_denis = DB::table('retroativo')
                          ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                          ->where('quem', 'DENIS')
                          ->get();
      $retroativo_fabiana = DB::table('retroativo')
                          ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                          ->where('quem', 'FABIANA')
                          ->get();
      $retroativo_renato = DB::table('retroativo')
                          ->whereBetween('created_at', [$dia_mes_anterior." 00:00:00", $virada])
                          ->where('quem', 'RENATO')
                          ->get();*/

                          //echo $retroativo_denis;
                          //exit;                          

      if ($faturamento_bruto > 0) {

        $dividir = $vendas->sum('valor_pago')-$gastos_empresa-$gastos_denis-$gastos_fabiana-$gastos_renato;


        //$divisao = $faturamento_liquido/3;
        $p_denis = ($dividir/3)+$gastos_denis;
        $p_fabiana = ($dividir/3)+$gastos_fabiana;
        $p_renato = ($dividir/3)+$gastos_renato;

/*
        $estemes = $dt->month;

        $mespassado = $estemes-1;
        
        if ($retroativo_denis->isNotEmpty()) {
            $saldo_denis = Carbon::parse($retroativo_denis[0]->created_at);
            $mes_saldo_denis = $saldo_denis->month;
              if ($retroativo_denis->isNotEmpty() && $mes_saldo_denis = $mespassado) {
                $p_denis = $divisao+$gastos_denis+$retroativo_denis[0]->valor;
              }else{
                $p_denis = $divisao+$gastos_denis;
              }
        } else {
            $p_denis = $divisao+$gastos_denis;
        }

        if ($retroativo_fabiana->isNotEmpty()) {
            $saldo_fabiana = Carbon::parse($retroativo_fabiana[0]->created_at);
            $mes_saldo_fabiana = $saldo_fabiana->month;
              if ($retroativo_fabiana->isNotEmpty() && $mes_saldo_fabiana = $mespassado) {
                $p_fabiana = $divisao+$gastos_fabiana+$retroativo_fabiana[0]->valor;
              }else{
                $p_fabiana = $divisao+$gastos_fabiana;
              }
        } else {
            $p_fabiana = $divisao+$gastos_fabiana;
        }

        if ($retroativo_renato->isNotEmpty()) {
            $saldo_renato = Carbon::parse($retroativo_renato[0]->created_at);
            $mes_saldo_renato = $saldo_renato->month;
              if ($retroativo_renato->isNotEmpty() && $mes_saldo_renato = $mespassado) {
                $p_renato = $divisao+$gastos_renato+$retroativo_renato[0]->valor;
              }else{
                $p_renato = $divisao+$gastos_renato;
              }
            
            } else {
              $p_renato = $divisao+$gastos_renato;
            }*/
        } else {
          $p_denis = 0;
          $p_fabiana = 0;
          $p_renato = 0;
        }
        

      if ($p_denis <= $gastos_denis  ) {
        $ret_denis = $gastos_denis-$p_denis;
          /*if ($retroativo_denis->isEmpty()) {
            $retroativo = new Retroativo;
            $retroativo->quem = 'DENIS';
            $retroativo->valor = $pagar_denis;
            $retroativo->save();
          }*/
      } else {
        $ret_denis = 0;
      }

      if ($p_fabiana <= $gastos_fabiana ) {
        $ret_fabiana = $gastos_fabiana-$p_fabiana;
          /*if ($retroativo_fabiana->isEmpty()) {
            $retroativo_f = new Retroativo;
            $retroativo_f->quem = 'FABIANA';
            $retroativo_f->valor = $pagar_fabiana;
            $retroativo_f->save();
          }*/
      } else {
        $ret_fabiana = 0;
      }

      if ($p_renato <= $gastos_renato ) {
        $ret_renato = $gastos_renato-$p_renato;
          /*if ($retroativo_renato->isEmpty()) {
            $retroativo_r = new Retroativo;
            $retroativo_r->quem = 'RENATO';
            $retroativo_r->valor = $pagar_renato;
            $retroativo_r->save();
          }*/
      } else {
        $ret_renato = 0;
      }
      
         //echo $pagar_denis;
      //exit;
            
     return view('relatorio_completo', compact('virada','dia_mes_anterior','faturamento_bruto','faturamento_liquido','porcentagem','custo_liquido','custo_bruto','total_compras','gastos_denis','gastos_fabiana','gastos_renato','gastos_empresa', 'p_denis', 'p_fabiana', 'p_renato', 'ret_denis', 'ret_fabiana', 'ret_renato' ));
    }
}
