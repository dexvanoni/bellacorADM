@extends('template')

@section('estilo')
td{
	font-size: 12px;
}
@endsection

@section('titulo')
<?php 
                // Force locale
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');


        // Create Carbon date
        $dt = Carbon\Carbon::now();
        $mes = $dt->formatLocalized('%B de %Y');
        
        //$mes = Carbon\Carbon::now();
       // $dia = 10;
       // $virada = Carbon\Carbon::create($dt->year, $dt->month, $dia, 23, 59, 59);
       // $hoje = Carbon\Carbon::now()->format('Y-m-d');
        //$dia_virada = Carbon\Carbon::create($dt->year, $dt->month, $dia)->format('Y-m-d');
        //$dia_antes_virada = $virada->subDay(1)->format('Y-m-d');

      ?>
RELATÓRIO COMPLETO DO MÊS DE {{strtoupper($mes)}}
@endsection
@section('content')
<div class="row">
    <div class="col">
        <center><h4>RELATÓRIO COMPLETO DO MÊS DE {{strtoupper($dt->formatLocalized('%B de %Y'))}}</h4></center>
        <center><h6>De {{date('d/m/Y', strtotime($dia_mes_anterior))}} a {{date('d/m/Y', strtotime($virada))}}</h6></center>
    </div>
</div>
<hr>
<div class="row"><h4>SUBLIMAÇÃO</h4></div>

<div class="row">
	<div class="col-3">
		<h6>Faturamento</h6>
		<table border="1" >
		    <tr>
		        <td>BRUTO EM VENDAS</td>
		        <td>R$ {{$faturamento_bruto}}</td>
		    </tr>
		    <tr>
		        <td>LÍQUIDO EM VENDAS</td>
		        <td>R$ {{$faturamento_liquido}}</td>
		    </tr>
		    <tr>
		        <td>PORC. DE LUCRO</td>
		        <td>{{round($porcentagem, 2)}}%</td>
		    </tr>
		</table>
	</div>
	<div class="col-3">
		<h6>Gastos Gerais</h6>
		<table border="1">
		    <tr>
		        <td>CUSTO LÍQUIDO EM VENDAS</td>
		        <td>R$ {{$custo_liquido}}</td>
		    </tr>
		    <tr>
		        <td>CUSTO BRUTO GERAL</td>
		        <td>R$ {{$custo_bruto}}</td>
		    </tr>
		    <tr>
		        <td>TOTAL EM COMPRAS</td>
		        <td>R$ {{$total_compras}}</td>
		    </tr>
		</table>
	</div>
	<div class="col-3">
		<h6>Gastos por pessoa e empresa</h6>
		<table border="1">
			<tr>
		        <td>DENIS</td>
		        <td>R$ {{$gastos_denis}}</td>
		    </tr>
		    <tr>
		        <td>FABIANA</td>
		        <td>R$ {{$gastos_fabiana}}</td>
		    </tr>
		    <tr>
		        <td>RENATO</td>
		        <td>R$ {{$gastos_renato}}</td>
		    </tr>
		    <tr>
		        <td>EMPRESA</td>
		        <td>R$ {{$gastos_empresa}}</td>
		    </tr>
		</table>	
	</div>
	<div class="col-3">
		<h6>RECEBIMENTOS</h6>
		<table border="1">
			<tr>
		        <td>DENIS</td>
		        <td>R$ {{$p_denis}}</td>
		    </tr>
		    <tr>
		        <td>FABIANA</td>
		        <td>R$ {{$p_fabiana}}</td>
		    </tr>
		    <tr>
		        <td>RENATO</td>
		        <td>R$ {{$p_renato}}</td>
		    </tr>
		</table>	
	</div>

	</div>


@endsection