@extends('template')

@section('content')
<div class="container" style="width: 900px">
  <form action="{{ route('clientes.update',$clientes->id) }}" method="POST">
     @csrf
     @method('PUT')
    <div class="row">
        <div class="col">
            <center><h4>EDIÇÃO DE CLIENTE</h4></center>
        </div>
    </div>
    <hr>
<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" class="form-control" id="produto" name="nome" value="{{$clientes->nome}}">
      </div>
  </div>
  <div class="col">
    <div class="form-group">
      <label for="doc">CPF/CNPJ</label>
      <input type="text" class="form-control" id="doc" name="doc" value="{{$clientes->doc}}">
      </div>
  </div>
  <div class="col">
    <div class="form-group">
      <label for="contato">Contato</label>
      <input type="text" class="form-control" id="contato" name="contato" value="{{$clientes->contato}}">
      </div>
  </div>
</div>

<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="rua">Endereço</label>
      <input type="text" class="form-control" id="rua" name="rua" value="{{$clientes->rua}}">
      </div>
  </div>
<div class="col-2">
    <div class="form-group">
      <label for="numero">Número</label>
      <input type="text" class="form-control" id="numero" name="numero" value="{{$clientes->numero}}">
      </div>
  </div>
<div class="col-4">
    <div class="form-group">
      <label for="bairro">Bairro</label>
      <input type="text" class="form-control" id="bairro" name="bairro" value="{{$clientes->bairro}}">
      </div>
  </div>
</div>

<hr>
<div class="row justify-content-md-center">
  <div class="col-md-auto">
    <button type="submit" class="btn btn-success">SALVAR</button>
  </div>
</div>

</form>

<hr>
    <div class="row">
        <div class="col">
            <center><h4>COMPRAS DESTE CLIENTE</h4></center>
        </div>
    </div>
    <hr>
    <?php $vendas = DB::table('vendas')->where('cliente', $clientes->nome)->get()?>
    <table class="display nowrap" id="lista_det_clientes">
        <thead>
          <center><tr>
            <th style="text-align: center;">Produto</th>
            <th style="text-align: center;">Quantidade</th>
            <th style="text-align: center;">Valor</th>
            <th style="text-align: center;">Situação</th>
            <th style="text-align: center;">PG</th>
            <th style="text-align: center;">Dt Pedido</th>
            <th style="text-align: center;">Dt Entrega</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($vendas as $i)
            <center><tr>
              <td style="width: 25%; text-align: center;" >{{$i->produto}}</td>
              <td style="width: 15%; text-align: center;" >{{$i->quantidade}}</td>
              <td style="width: 15%; text-align: center;" >R$ {{$i->valor_pago}}</td>
              <td style="width: 15%; text-align: center;" >R$ {{$i->situacao}}</td>
              <td style="width: 15%; text-align: center;" >
                @if($i->pago == 'N')
                  <i class="fab fa-creative-commons-nc" style="color: red"></i>
                  <label style="display: none">Não</label>
                  @else
                  <i class="fas fa-hand-holding-usd" style="color: green"></i>
                  <label style="display: none">Sim</label>
                @endif
              </td>
              <td style="width: 30%; text-align: center;" >{{date('d/m/Y', strtotime($i->created_at))}}</td>
              <td style="width: 10%; text-align: center;" >{{date('d/m/Y', strtotime($i->dt_entrega))}}</td>
            </tr></center>
          @endforeach
        </tbody>
      </table>
</div>
<script type="text/javascript">
  
</script>
@endsection