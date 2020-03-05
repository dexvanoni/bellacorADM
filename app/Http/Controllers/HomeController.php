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
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            //ZERA ESTOQUE DIA 05 DE CADA MÊS

            $duplicados = DB::table('produtos')->get();

            $dt = Carbon::now();
            $dia = 05;
            $virada = Carbon::create($dt->year, $dt->month, $dia, 23, 59, 59);

            
            $hoje = Carbon::now()->format('Y-m-d');
            $dia_virada = Carbon::create($dt->year, $dt->month, $dia);
            $dia_antes_virada = $virada->subDay(1)->format('Y-m-d');
            //echo $dt." - ".$dia." - ".$virada;

           if ($duplicados->isNotEmpty()) {
                foreach ($duplicados as $d) {
                    if ($d->created_at <= $virada && $dt >= $virada && $d->estoque > 0) {
                    DB::table('produtos')
                       ->where('id', $d->id)
                       ->update(['valor_custo' => 0]);
                    //echo "alterar valor para zero";
                    }elseif($d->created_at <= $virada && $dt >= $virada && $d->estoque <= 0){
                    DB::table('produtos')
                       ->where('id', $d->id)
                        ->delete(); 
                      echo "deletar";
                    }
                }
            }
            //--------------------------------------------------------
           
    // INSERE NA TABELA DE CUSTOS A ENERGIA E A NET TODO DIA 04 DO MÊS
           // echo $hoje.' - '.$dia_virada.' - '.$dia_antes_virada;

           if ($hoje >= $dia_antes_virada) {
                $energia = DB::table('compras')
                           ->where('item', 'CONSUMO DE ENERGIA')
                           ->whereMonth('created_at', $dt->month)
                           ->get();

                $internet = DB::table('compras')
                           ->where('item', 'INTERNET')
                           ->whereMonth('created_at', $dt->month)
                           ->get();

                if ($energia->isEmpty()) {
                    $custos = new Compra;
                    $custos->item = 'CONSUMO DE ENERGIA';
                    $custos->quantidade = 1;
                    $custos->valor_pago = 150.55;
                    $custos->num_parcelas = 1;
                    $custos->fornecedor = 'ENERGISA';
                    $custos->quem_pagou = 'DENIS';
                    $custos->forma_pagamento = 'DINHEIRO';
                    $custos->tipo = 'SUBLIMAÇÃO';
                    $custos->save();
                }

                if ($internet->isEmpty()) {
                    $custos_net = new Compra;
                    $custos_net->item = 'INTERNET';
                    $custos_net->quantidade = 1;
                    $custos_net->valor_pago = 41.19;
                    $custos_net->num_parcelas = 1;
                    $custos_net->fornecedor = 'NET';
                    $custos_net->quem_pagou = 'DENIS';
                    $custos_net->forma_pagamento = 'DINHEIRO';
                    $custos_net->tipo = 'SUBLIMAÇÃO';
                    $custos_net->save();
                }
                
            }          

        $estemes = Carbon::now()->month;

        $vendas = DB::table('vendas')
            ->whereMonth('created_at', $estemes)
            ->get();
        
        $vendas_realizadas = DB::table('vendas')
            ->whereMonth('created_at', $estemes)
            ->where('situacao', '=', 'Realizado')
            ->get();

        $liquido = DB::table('vendas')
            ->whereMonth('created_at', $estemes)
            ->where('pago', 'S')
            ->get();

        $saldo = $liquido->sum('valor_pago');

        $custos = $liquido->sum('custo');

        $lucro_liq = $saldo-$custos;

        $vendas_agendadas = DB::table('vendas')
            //->whereMonth('created_at', $estemes)
            ->whereMonth('dt_entrega', $estemes)
            ->where('situacao', '=', 'Agendado')
            ->get();

        $total_compras = DB::table('compras')
            ->whereMonth('created_at', $estemes)
            ->sum('valor_pago');

            //dd($vendas);
            //exit;

            
        return view('home', compact('vendas', 'vendas_realizadas', 'vendas_agendadas', 'liquido', 'lucro_liq', 'total_compras'));
    }
}
