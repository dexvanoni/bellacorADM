@extends('template')
@section('titulo')
LISTA DE VENDAS
@endsection
@section('content')

<div class="row">
    <div class="col">
        <center><h4>LISTA DE VENDAS 
        	<a title="NOVA VENDA" href="{{ route('vendas.create') }}" class="badge badge-primary">+<i class="fas fa-money-bill-alt"></i></a>
         <a title="RELATÓRIO" href="{{ route('vendas.rela') }}" class="badge badge-warning"><i class="fas fa-file-alt"></i></a></h4></center>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
      <?php 
                // Force locale
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');


        // Create Carbon date
        $dt = Carbon\Carbon::now();
        
        //$mes = Carbon\Carbon::now();
      ?>
        <center><h6>RELATÓRIO DO MÊS - {{$dt->formatLocalized('%B de %Y')}}</h6></center>
    </div>
</div>
<?php
  $data = Carbon\Carbon::now();
  $mes = $data->month;
  
  $custo_bruto = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->sum('custo');

  $fat_bruto = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->sum('valor_pago');

  

$a1 = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->where('pago', 'S')
    ->sum('valor_pago');
$a2 = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->where('pago', 'S')
    ->sum('custo');
  $fat_liquido = $a1-$a2;


    $custo_liquido = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->where('pago', 'S')
    ->sum('custo');

    $ar = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->where('pago', 'N')
    ->where('valor_entrada', '==', '0')
    ->sum('valor_pago');

    $entrada_nao_pago = DB::table('vendas')
                        ->whereMonth('created_at', $mes)
                        ->where('pago', 'N')
                        ->where('valor_entrada', '!=', '0')
                        ->sum('valor_entrada');

    $entrada_nao_pago_val = DB::table('vendas')
                        ->whereMonth('created_at', $mes)
                        ->where('pago', 'N')
                        ->where('valor_entrada', '!=', '0')
                        ->sum('valor_pago');


    $tot = $entrada_nao_pago_val-$entrada_nao_pago;
    $a_receber = $ar+$tot;

    $qtn_a_fazer = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->where('situacao', 'Agendado')
    ->sum('quantidade');

    $qtn_feitos = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->where('situacao', 'Realizado')
    ->sum('quantidade');

    $agendado = DB::table('vendas')
    ->whereMonth('created_at', $mes)
    ->where('situacao', 'Agendado')->count();

    $clientes = App\Cliente::all();


?>
<div style="border: solid">
<div class="row">
  <div class="col">
    <label>Faturamento Bruto: R$ {{number_format((float)$fat_bruto, 2, '.', '') }}</label>
  </div>
  <div class="col">
    <label>Faturamento Líquido: R$ {{number_format((float)$fat_liquido, 2, '.', '') }}</label>
  </div>
  <div class="col">
    <label>Custo Bruto: R$ {{number_format((float)$custo_bruto, 2, '.', '') }}</label>
  </div>
  <div class="col">
    <label>Custo Líquido: R$ {{number_format((float)$custo_liquido, 2, '.', '') }}</label>

  </div>
</div>

<div class="row">
  <div class="col">
    <label>A RECEBER: R$ {{number_format((float)$a_receber, 2, '.', '') }}</label>
  </div>
  <div class="col">
    <label>Itens a fazer: {{$qtn_a_fazer}}</label>
  </div>
  <div class="col">
    <label>Trabalhos realizados: {{$qtn_feitos}}</label>
  </div>
  <div class="col">
    <label>Pedidos agendados: {{$agendado}}</label>
  </div>
</div>
</div>
    
<hr>
<table class="display nowrap" id="lista_vendas" style="font-size: 12px; width: 100%">
        <thead>
          <center><tr>
            <th style="text-align: center;">

              <form action="{{ route('vendas.recibo_conjunto')}}" method="POST">
                 @csrf
                 
                <input type="hidden" name="dados" id="dados" value="">
              <a id="recibos" title="GERAR RELATÓRIO CONJUNTO" class="badge badge-primary"><i class="fab fa-readme"></i></a>
              <button type="submit" id="recibo_conjunto" title="ENVIAR RELATÓRIO CONJUNTO" class="badge badge-warning"><i class="fab fa-readme"></i></button>
              </form>
                    
            </th>
            <th style="text-align: center;">Produtos</th>
            <th style="text-align: center;">Qtn</th>
            <th style="text-align: center;">Cliente</th>
            <th style="text-align: center;">Valor Pago</th>
            <!--<th style="text-align: center;">Forma pg</th>-->
            <!--<th style="text-align: center;">Parcelas</th>-->
            <!--<th style="text-align: center;">Val. Entrada</th>-->
            <!--<th style="text-align: center;">Entregador?</th>-->
            <th style="text-align: center;">Data Entrega</th>
            <th style="text-align: center;">Situação</th>
            <th style="text-align: center;">Pago?</th>
            <!--<th style="text-align: center;">Custo de Produção</th>-->
            <!--<th style="text-align: center;">Data do Pedido</th>-->
            <th style="text-align: center;">Ações</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($vendas as $i)
            <center><tr>
              <td style="width: 3%; text-align: center;" >
                @if($i->situacao == 'Realizado' && $i->pago == 'S')
                  <input type="checkbox" value="{{$i->id}}" id="check_recibo" name="check_recibo">
                @endif
              </td>
              <td style="width: 30%; text-align: center;" title="{{$i->obs}}">
                <?php 
                  $media_pago = DB::table('compras')
                                  ->where('item', $i->produto)
                                  ->sum('valor_pago');
                  $media_quant = DB::table('compras')
                                  ->where('item', $i->produto)
                                  ->sum('quantidade');
                  if(!is_null($media_pago)){
                    $media_custo = $media_pago/$media_quant;
                  }else{
                    $media_custo = 0;
                  }
                ?>
                @if($media_custo != 0)
                  @if($i->custo < $media_custo)
                    <i title="Este produto foi vendido com estoque já pago em compra anterior." class="fas fa-exclamation-circle" style="color: red"></i>
                  @endif
                @endif
                {{$i->produto}}
              </td>
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
              <td style="width: 5%; text-align: center;" >
                R$ {{$i->valor_pago}}
                @if($i->valor_entrada != 0 && $i->pago == 'N')
                  <i title="Este cliente pagou entrada de R$ {{$i->valor_entrada}}&#013COBRAR R$ {{$i->valor_pago-$i->valor_entrada}}" class="fas fa-exclamation-circle" style="color: green"></i>
                @endif
                @if($i->pago == 'S')
                  <i title="Custo TOTAL: R$ {{$i->custo}}&#013Lucro Líquido: R$ {{$i->valor_pago-$i->custo}}" class="fas fa-vote-yea" style="color: black"></i>
                @endif
              </td>
              <!--<td style="width: 15%; text-align: center;" >{{$i->forma_pagamento}}</td>-->
              <!--<td style="width: 5%; text-align: center;" >{{$i->num_parcelas}}</td>-->
              <!--<td style="width: 5%; text-align: center;" >R$ {{$i->valor_entrada}}</td>-->
              <!--<td style="width: 5%; text-align: center;" >
              @if($i->entrega == 'N')
                  <i class="fas fa-thumbs-down" style="color: red"></i>
                  @else
                  <i class="fas fa-thumbs-up" style="color: green"></i>
                @endif
              </td>-->
              <td style="width: 10%; text-align: center;" >{{date('d/m/Y', strtotime($i->dt_entrega))}}</td>
              <td style="width: 15%; text-align: center;" >
                @if($i->situacao == 'Agendado')
                  <a title="REALIZADO" href="{{ route('vendas.realizado', ['i' => $i->id]) }}" class="badge badge-success" onclick="return confirm('\nEsta venda foi REALIZADA?'); return false;"><i class="fab fa-amazon-pay"></i></a>
                @endif
                {{$i->situacao}}
              </td>
              <td style="width: 5%; text-align: center;" >
                @if($i->pago == 'N')
                  
                  <i title="Compra não paga!" class="fas fa-exclamation-triangle" style="color: red"></i>
                  <a title="PAGOU" href="{{ route('vendas.pagou', ['i' => $i->id]) }}" class="badge badge-success" onclick="return confirm('\nEsta venda foi realmente PAGA?'); return false;"><i class="fas fa-hand-holding-usd"></i></a>
                  @else
                  <i class="fas fa-check-double" style="color: green"></i>
                @endif
              </td>
              <!--<td style="width: 15%; text-align: center;" >{{$i->custo}}</td>-->
              <!--<td style="width: 15%; text-align: center;" >{{date('d/m/Y', strtotime($i->created_at))}}</td>-->
              <td style="width: 20%; text-align: center; font-size: 14px" >

                      <a title="Editar" href="{{ route('vendas.edit', ['i' => $i->id]) }}" class="badge badge-success"><i class="fas fa-edit"></i></a>
                     
                      @if($i->situacao == 'Realizado' && $i->pago == 'S')
                        <a title="Gerar RECIBO" href="{{ route('vendas.recibo', ['i' => $i->id]) }}" class="badge badge-info"><i class="fas fa-file-alt"></i></a>
                      @endif
                      

                      <a title="Cancelar Venda" href="{{ route('vendas.cancelar', ['i' => $i->id]) }}" class="badge badge-danger" onclick="return confirm('\nDeseja CANCELAR esta venda?'); return false;"><i class="fas fa-user-times"></i></a>


                      <!--<form action="{{ route('compras.destroy', ['i' => $i->id]) }}" onsubmit="return confirm('\nTem certeza que deseja excluir este PRODUTO?'); return false;" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="badge badge-primary"><i class="fas fa-trash"></i></button>
                      </form>-->
              </td>
            </tr></center>
          @endforeach
        </tbody>
      </table>
      <script type="text/javascript">
        $( document ).ready(function() {
          $('#recibo_conjunto').hide();
        });

                  //var ids = new Array();
                      $('#recibos').on('click', function() { 
                          var array = []; 
                          $("input:checkbox[name=check_recibo]:checked").each(function() { 
                              array.push($(this).val());
                              //alert(array); 
                              console.log(array);
                               $('#recibo_conjunto').show();
                          });
                          
                          $('#dados').val(array);
                          //$('input:hidden[name=dados]').val(array);
                          

                      });

      </script>
@endsection
