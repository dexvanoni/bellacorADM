@extends('template')
@section('titulo')
RELATÓRIO DE COMPRAS
@endsection
@section('content')
<div class="row">
    <div class="col">
        <center><h4>RELATÓRIO DE COMPRAS</h4></center>
    </div>
</div>
<hr>
<form action="{{ route('compras.pesquisa') }}" method="POST">
  @csrf
<div class="row justify-content-md-center">
    <div class="col-3">
    <div class="form-group">
      <label for="inicio">Início</label>
      <input type="date" class="form-control" id="inicio" name="inicio">
      </div>
  </div>
  <div class="col-3">
    <div class="form-group">
      <label for="fim">Fim</label>
      <input type="date" class="form-control" id="fim" name="fim">
      </div>
  </div>
    <div class="col-3">
    <div class="form-group">
       <label for="tipo">Tipo</label>
        <select id="tipo" class="form-control" name="tipo">
          <option>Selecione...</option>
          <option value="SUBLIMAÇÃO">SUBLIMAÇÃO</option>
          <option value="TRANSFER">TRANSFER</option>
          <option value="BORDADO">BORDADO</option>
          <option value="GERAL">GERAL</option>
        </select>
    </div>
  </div>
</div>
<div class="row justify-content-md-center">
  <div class="col-md-auto">
    <button type="submit" class="btn btn-success">PESQUISAR</button>
  </div>
</div>
</form>
<hr>
<!--TABELA COM O RELATÓRIO-->
@isset($vendas)
  @if($vendas->isNotEmpty())
<table class="display nowrap" id="rela_compras" style="font-size: 12px">
        <thead>
          <tr >Datas Pesquisadas: {{date('d/m/Y', strtotime($inicio))}} a {{date('d/m/Y', strtotime($fim))}}</tr>
          <center><tr>
            <th style="text-align: center;">Material</th>
            <th style="text-align: center;">Qtn</th>
            <th style="text-align: center;">Valor</th>
            <th style="text-align: center;">Fornecedor</th>
            <th style="text-align: center;">Pagador</th>
            <th style="text-align: center;">Dt. Compra</th>
            <th style="text-align: center;">Tipo</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($vendas as $i)
            <center><tr>
              <td style="width: 25%; text-align: center;">
                {{$i->item}}
              </td>
              <td style="width: 5%; text-align: center;" >
                {{$i->quantidade}}
              </td>
              <td style="width: 15%; text-align: center;" >R$ {{$i->valor_pago}}</td>
              <td style="width: 7%; text-align: center;" >
                {{$i->fornecedor}}
              </td>
              <td style="width: 10%; text-align: center;" >{{$i->quem_pagou}}</td>
              <td style="width: 10%; text-align: center;" >{{date('d/m/Y', strtotime($i->created_at))}}</td>
              <td style="width: 10%; text-align: center;" >{{$i->tipo}}</td>
            </tr></center>
          @endforeach
        </tbody>
      </table>


<script type="text/javascript">
  $(document).ready(function(){
  // Relatório de vendas
             var printCounter = 0;
             var data_i = "<?php echo date('d/m/Y', strtotime($inicio)); ?>";
             var data_f = "<?php echo date('d/m/Y', strtotime($fim)); ?>";
             var tipo = "<?php echo $tp; ?>";
             var total = "<?php echo $total_compras; ?>";
             var empresa = "<?php echo $empresa; ?>";
             var denis = "<?php echo $denis; ?>";
             var renato = "<?php echo $renato; ?>";
             var ct = "<?php echo $conta; ?>";
             var dt = "<?php 
                // Force locale
                date_default_timezone_set('America/Sao_Paulo');
                setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
                setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');


                // Create Carbon date
                $dt = Carbon\Carbon::now();
                
                //$mes = Carbon\Carbon::now();
              ?>";
              var dat = "<?php echo $dt->formatLocalized('%d de %B de %Y'); ?>";
              var quem = "<?php echo Auth::user()->name;?>";
                          // Append a caption to the table before the DataTables initialisation
            //$('#rela_vendas').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');

             $('#rela_compras').DataTable( {
              dom: 'Bfrtip',
                  buttons: [
            {
                extend: 'pdfHtml5',
                messageBottom: '\n\n\n\n\n\nRelatório impresso em '+dat+' por '+quem,
                messageTop: 
                    'Datas Pesquisadas: '+data_i+'  e '+data_f+'\nValor Bruto Gasto: R$ '+total+'\n Tipo de trabalho: '+tipo+'\n Número de compras: '+ct+'\nValor gasto por EMPRESA: R$ '+empresa+'\nValor gasto por DENIS/FABIANA: R$ '+denis+'\nValor gasto por RENATO: R$ '+renato,
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
                'colvis',
            ],
              "scrollY":        "300px",
                "scrollCollapse": true,
            } );

});
</script>

@else
<tr >Datas Pesquisadas: {{date('d/m/Y', strtotime($inicio))}} a {{date('d/m/Y', strtotime($fim))}}</tr>
<h3>NÃO EXISTE RELATÓRIO PARA ESTA PESQUISA</h3>
@endif
@endisset
@endsection