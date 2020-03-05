@extends('template')

@section('titulo')
    Tela Inicial - BellaCor
@endsection
@section('content')
                  <div class="row justify-content-md-center">
                    <div class="col-10 col-offset-1">
                        
                        <center><img src="/imagens/bellacor.jpeg" width="300px" height="100px"></a></center>    
                        <br>
                        
                        <?php

                            $dt = Carbon\Carbon::now();
                            $dia = 05;
                            $virada = Carbon\Carbon::create($dt->year, $dt->month, $dia, 23, 59, 59);

                            $hoje = Carbon\Carbon::now()->format('Y-m-d');
                            $dia_virada = Carbon\Carbon::create($dt->year, $dt->month, $dia)->format('Y-m-d');
                            $dia_antes_virada = $virada->subDay(1)->format('Y-m-d');

                            //echo $hoje." - ".$dia_virada;
                            
                       ?>
                        @if($hoje == $dia_virada)
                          <hr>
                            <center><h5 style="color: red">HOJE É DIA DE FECHAMENTO DE CAIXA E ATUALIZAÇÃO DOS VALORES DE ESTOQUE!</h5></center>
                            <center><a href="{{route('relatorio_completo')}}">Gerar Relatório Completo</a></center>
                          @endif
                        <hr>
                                               <!--<table class="table table-striped table-bordered table-condensed table-hover">
                        <tbody>
                            <tr class="success">
                                <td>Total de Vendas deste mês</td>
                                <td>R$ {{$vendas->sum('valor_pago')}}</td>
                            </tr>
                            <tr class="active">
                                <td>Lucro LÍQUIDO</td>
                                <td>R$ {{$lucro_liq}}</td>
                            </tr>
                            <tr class="danger">
                                <td>GASTOS</td>
                                <td>R$ {{$total_compras}}</td>
                            </tr>
                            <tr class="warning">
                                <td>Em caixa</td>
                                <td>R$ {{$vendas_realizadas->sum('valor_pago')}}</td>
                            </tr>
                            <tr class="info">
                                <td>Itens Vendidos - REALIZADOS</td>
                                <td>{{$vendas_realizadas->sum('quantidade')}}</td>
                            </tr>
                            <tr class="danger">
                                <td>Itens Vendidos - AGENDADOS</td>
                                <td>{{$vendas_agendadas->sum('quantidade')}}</td>
                            </tr>
                            <tr class="success">
                                <td>A Receber</td>
                                <td>{{$vendas_agendadas->sum('valor_pago')}}</td>
                            </tr>
                        </tbody>
                    </table>-->
                    @if($vendas_agendadas->isNotEmpty())
            <center><h2>ENTREGAS PREVISTAS PARA ESTE MÊS</h2></center>  
       <table class="display nowrap" id="lista_vendas" style="font-size: 12px; width: 100%">
        <thead>
          <center><tr>
            <th style="text-align: center;">Produtos</th>
            <th style="text-align: center;">Qtn</th>
            <th style="text-align: center;">Cliente</th>
            <th style="text-align: center;">Data Entrega</th>
            <th style="text-align: center;">Pago?</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($vendas_agendadas as $i)
            <center><tr>
              <td style="width: 30%; text-align: center;" >{{$i->produto}}</td>
              <td style="width: 5%; text-align: center;" >
                {{$i->quantidade}}
                <?php $prod = DB::table('produtos')->where('produto', $i->produto)->sum('estoque')?>
                @if($prod <= 0 && $i->situacao == 'Agendado')
                  <i title="Este produto já está com estoque zerado ou negativo. Adquira mais deste item para concluir esta venda! Estoque: {{$prod}}" class="fas fa-exclamation-circle" style="color: red"></i>
                @endif
              </td>
              <td style="width: 10%; text-align: center;" >
                {{$i->cliente}}
                <?php $contato = DB::table('clientes')->where('nome', $i->cliente)->get();?>
                @if($contato->isNotEmpty())
                <i title="<?php 
                    foreach ($contato as $cont) {
                      echo $cont->contato;
                    }
                  ?>" class="fas fa-mobile-alt"></i>
                @endif
              </td>
              <?php 
                  $hj = Carbon\Carbon::today('America/Campo_Grande');
                  $am = Carbon\Carbon::tomorrow('America/Campo_Grande');
                  $on = Carbon\Carbon::yesterday('America/Campo_Grande');
                  $entregar = $i->dt_entrega.' 00:00:00';
              ?>
              <td style="width: 10%; text-align: center" >
                {{date('d/m/Y', strtotime($i->dt_entrega))}}
                @if($entregar == $am)
                    <i title="ENTREGA AGENDADA PARA AMANHÃ!!" class="fas fa-calendar-times pisca2"></i>
                @endif
                @if($entregar <= $on)
                    <i title="ENTREGA ATRASADA!!" class="fas fa-exclamation-triangle pisca"></i>
                @endif
                @if($entregar == $hj)
                    <i title="ENTREGAR HOJE!!" class="fas fa-calendar-check pisca3"></i>
                @endif
              </td>
              <td style="width: 5%; text-align: center;" >
                @if($i->pago = 'N')
                  <i title="Compra não paga!" class="fas fa-exclamation-triangle" style="color: red"></i>
                  @else
                  <i class="fas fa-check-double" style="color: green"></i>
                @endif
              </td>
        </tr></center>
          @endforeach
        </tbody>
      </table>

      @else
        <center><h3>NÃO EXISTEM PEDIDOS AGENDADOS PARA ENTREGA</h3></center>


      @endif
                </div>
            </div>

@endsection