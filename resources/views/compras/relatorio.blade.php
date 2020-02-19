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
    <div class="col-4">
    <div class="form-group">
      <label for="inicio">Início</label>
      <input type="date" class="form-control" id="inicio" name="inicio">
      </div>
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="fim">Fim</label>
      <input type="date" class="form-control" id="fim" name="fim">
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
@isset($compras)
<table class="display nowrap" id="rela_vendas" style="font-size: 12px">
        <thead>
          <tr >Datas Pesquisadas: {{date('d/m/Y', strtotime($inicio))}} a {{date('d/m/Y', strtotime($fim))}}</tr>
          <center><tr>
            <th style="text-align: center;">Produto</th>
            <th style="text-align: center;">Qtn</th>
            <th style="text-align: center;">Cliente</th>
            <th style="text-align: center;">Valor</th>
            <th style="text-align: center;">Pedido</th>
            <th style="text-align: center;">Entrega</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($compras as $i)
            <center><tr>
              <td style="width: 25%; text-align: center;">
                {{$i->produto}}
              </td>
              <td style="width: 5%; text-align: center;" >
                {{$i->quantidade}}
              </td>
              <td style="width: 15%; text-align: center;" >{{$i->cliente}}</td>
              <td style="width: 10%; text-align: center;" >R$ {{$i->valor_pago}}</td>
              <td style="width: 10%; text-align: center;" >{{date('d/m/Y', strtotime($i->created_at))}}</td>
              <td style="width: 10%; text-align: center;" >{{date('d/m/Y', strtotime($i->entrega))}}</td>
            </tr></center>
          @endforeach
        </tbody>
      </table>
@endisset
@endsection