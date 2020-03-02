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
