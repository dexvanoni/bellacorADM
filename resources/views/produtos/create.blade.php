@extends('template')

@section('content')
<div class="container" style="width: 900px">
  <form action="{{ route('produtos.store') }}" method="POST">
     @csrf
    <div class="row">
        <div class="col">
            <center><h4>NOVO PRODUTO</h4></center>
        </div>
    </div>
    <hr>
<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="produto">Produto</label>
      <input type="text" class="form-control" id="produto" name="produto" value="<?php if(isset($nome_produto)){ echo $nome_produto;}?>" <?php if(isset($nome_produto)){ echo "readonly";}?>>
      </div>
  </div>
</div>
<div class="row">
  <div class="col">
      <div class="form-group">
        <label for="obs">Observações sobre o Produto</label>
        <textarea class="form-control" id="obs" rows="3" name="obs"></textarea>
      </div>
  </div>
</div>
<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="estoque">Estoque Disponível</label>
      <input type="text" class="form-control" id="estoque" name="estoque" value="<?php if(isset($qtn)){ echo $qtn;}?>" <?php if(isset($qtn)){ echo "readonly";}?>>
      </div>
  </div>
   <div class="col-2">
    <div class="form-group">
       <label for="un">Unidade</label>
      <select id="unidade" class="form-control" name="un">
        <option>Selecione...</option>
        <option value="Unidade">Unidade</option>
        <option value="Pacote">Pacote</option>
        <option value="Caixa">Caixa</option>
        <option value="Litro">Litro</option>
        <option value="Metro">Metro</option>
      </select>
    </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="valor_venda">Valor de Venda</label>
      <input type="text" class="form-control" id="valor_venda" name="valor_venda">
      </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="valor_custo">Valor de Custo</label>
      <input type="text" class="form-control" id="valor_custo" name="valor_custo" value="<?php if(isset($nome_produto)){ echo "R$ ".$valor/$qtn;}?>">
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
      </select>
    </div>
  </div>
</div>
<input type="hidden" name="quem_comprou" value="EMPRESA">
<input type="hidden" name="add_estoque_produto" value="<?php if(isset($nome_produto)){ echo "S";}else{ echo "N";}?>">
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