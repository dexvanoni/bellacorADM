@extends('template')

@section('content')
<div class="container" style="width: 900px">
  <form action="{{ route('compras.store') }}" method="POST">
     @csrf
    <div class="row">
        <div class="col">
            <center><h4>NOVA COMPRA</h4></center>
        </div>
    </div>
    <hr>
<div class="row">
  <div class="col">
    <div class="form-group">
       <label for="item" style="float: left;">Item</label>
        <select id="item" class="form-control" name="item" onchange="mostraCampo(this);">
          <option>Selecione...</option>
          <?php $insumos = DB::table('insumos')->orderBy('insumo')->get();?>
          @foreach($insumos as $i)
            <option value="{{$i->insumo}}">{{$i->insumo}}</option>
          @endforeach
          <option value="OUTRA">OUTRA</option>
        </select>
         <input type="text" class="form-control" style="margin-top: 10px" name="outrainst" id="outrainst" style="display: none;">
    </div>
  </div>
  <div class="col-1">
    <div class="form-group">
      <label for="quantidade">Qtn</label>
      <input type="text" class="form-control" id="quantidade" name="quantidade">
      </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="valor_pago">Valor Pago</label>
      <input type="text" class="form-control" id="valor_pago" name="valor_pago">
      </div>
  </div>
</div>
<div class="row">
  <div class="col-1">
    <div class="form-group">
      <label for="num_parcelas">Parcelas</label>
      <input type="text" class="form-control" id="num_parcelas" name="num_parcelas">
      </div>
  </div>
     <div class="col-3">
    <div class="form-group">
       <label for="forma_pagamento">Forma de Pagamento</label>
      <select id="forma_pagamento" class="form-control" name="forma_pagamento">
        <option>Selecione...</option>
        <option value="DINHEIRO">DINHEIRO</option>
        <option value="CARTÃO DÉBITO">CARTÃO DÉBITO</option>
        <option value="CARTÃO CRÉDITO">CARTÃO CRÉDITO</option>
      </select>
    </div>
  </div>
<div class="col-5">
    <div class="form-group">
      <label for="fornecedor">Fornecedor</label>
      <input type="text" class="form-control" id="fornecedor" name="fornecedor">
      </div>
  </div>
   <div class="col-3">
    <div class="form-group">
       <label for="quem_pagou">Quem Pagou</label>
      <select id="quem_pagou" class="form-control" name="quem_pagou">
        <option>Selecione...</option>
        <option value="DENIS">DENIS</option>
        <option value="FABIANA">FABIANA</option>
        <option value="EMPRESA">EMPRESA</option>
      </select>
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
</div>
<script type="text/javascript">
  
  $( document ).ready(function() {
    $('#outrainst').hide();
   });
  
  function mostraCampo(obj) {
  var select = document.getElementById('item');
  var txt = document.getElementById("outrainst");
  if (select.value == "OUTRA") {
            document.getElementById("outrainst").style.display = "block";
            var troca = document.getElementById("item");
            troca.setAttribute("name", "");
            txt.setAttribute("name", "item");

        } else {
            document.getElementById("outrainst").style.display = "none";
            var troca = document.getElementById("item");
            troca.setAttribute("name", "item");
            txt.setAttribute("name", "");
        }
}
</script>
@endsection