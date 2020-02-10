@extends('template')

@section('content')
<div class="container" style="width: 900px">
  <form action="{{ route('compras.update',$compras->id) }}" method="POST">
     @csrf
     @method('PUT')
    <div class="row">
        <div class="col">
            <center><h4>EDIÇÃO DE COMPRA</h4></center>
        </div>
    </div>
    <hr>
<div class="row">
  <div class="col">
    <div class="form-group">
       <div class="form-group">
      <label for="item">Item</label>
      <input type="text" class="form-control" id="item" name="item" value="{{$compras->item}}" readonly="readonly" >
    </div>
    </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="quantidade">Quantidade</label>
      <input type="text" class="form-control" id="quantidade" name="quantidade" value="{{$compras->quantidade}}">
    </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="valor_pago">Valor Pago</label>
      <input type="text" class="form-control" id="valor_pago" name="valor_pago" value="{{$compras->valor_pago}}">
      </div>
  </div>
</div>

<div class="row">
  <div class="col-1">
    <div class="form-group">
      <label for="num_parcelas">Parcelas</label>
      <input type="text" class="form-control" id="num_parcelas" name="num_parcelas" value="{{$compras->num_parcelas}}">
      </div>
  </div>
     <div class="col-3">
    <div class="form-group">
       <label for="forma_pagamento">Forma de Pagamento</label>
      <select id="forma_pagamento" class="form-control" name="forma_pagamento">
        <option>Selecione...</option>
        <option value="DINHEIRO" <?php if($compras->forma_pagamento == 'DINHEIRO'){echo "selected";}?>>DINHEIRO</option>
        <option value="CARTÃO DÉBITO" <?php if($compras->forma_pagamento == 'CARTÃO DÉBITO'){echo "selected";}?>>CARTÃO DÉBITO</option>
        <option value="CARTÃO CRÉDITO" <?php if($compras->forma_pagamento == 'CARTÃO CRÉDITO'){echo "selected";}?>>CARTÃO CRÉDITO</option>
      </select>
    </div>
  </div>
<div class="col-5">
    <div class="form-group">
      <label for="fornecedor">Fornecedor</label>
      <input type="text" class="form-control" id="fornecedor" name="fornecedor" value="{{$compras->fornecedor}}">
      </div>
  </div>
   <div class="col-3">
    <div class="form-group">
       <label for="quem_pagou">Quem Pagou</label>
      <select id="quem_pagou" class="form-control" name="quem_pagou">
        <option>Selecione...</option>
        <option value="DENIS" <?php if($compras->quem_pagou == 'DENIS'){echo "selected";}?>>DENIS</option>
        <option value="FABIANA" <?php if($compras->quem_pagou == 'FABIANA'){echo "selected";}?>>FABIANA</option>
        <option value="EMPRESA" <?php if($compras->quem_pagou == 'EMPRESA'){echo "selected";}?>>EMPRESA</option>
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
  
</script>
@endsection