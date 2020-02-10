@extends('template')

@section('content')
<div class="container" style="width: 900px">
  <form action="{{ route('produtos.update',$produtos->id) }}" method="POST">
     @csrf
     @method('PUT')

    <div class="row">
        <div class="col">
            <center><h4>EDIÇÃO DE PRODUTO</h4></center>
        </div>
    </div>
    <hr>
<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="produto">Produto</label>
      <input type="text" class="form-control" id="produto" name="produto" value="{{$produtos->produto}}" readonly="readonly">
      </div>
  </div>
</div>
<div class="row">
  <div class="col">
      <div class="form-group">
        <label for="obs">Observações sobre o Produto</label>
        <textarea class="form-control" id="obs" rows="3" name="obs">{{$produtos->obs}}</textarea>
      </div>
  </div>
</div>
<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="estoque">Estoque Disponível</label>
      <input type="text" class="form-control" id="estoque" name="estoque" value="{{$produtos->estoque}}">
      </div>
  </div>
   <div class="col-2">
    <div class="form-group">
       <label for="un">Unidade</label>
      <select id="unidade" class="form-control" name="un">
        <option value="Unidade" <?php if($produtos->un == "Unidade") echo "selected";?>>Unidade</option>
        <option value="Pacote" <?php if($produtos->un == "Pacote") echo "selected";?>>Pacote</option>
        <option value="Caixa" <?php if($produtos->un == "Caixa") echo "selected";?>>Caixa</option>
        <option value="Litro" <?php if($produtos->un == "Litro") echo "selected";?>>Litro</option>
        <option value="Metro" <?php if($produtos->un == "Metro") echo "selected";?>>Metro</option>
      </select>
    </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="valor_venda">Valor de Venda</label>
      <input type="text" class="form-control" id="valor_venda" name="valor_venda" value="{{$produtos->valor_venda}}">
      </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="valor_custo">Valor de Custo</label>
      <input type="text" class="form-control" id="valor_custo" name="valor_custo" value="{{$produtos->valor_custo}}">
      </div>
  </div>
  <div class="col-3">
    <div class="form-group">
       <label for="tipo">Tipo</label>
      <select id="tipo" class="form-control" name="tipo">
        <option value="SUBLIMAÇÃO" <?php if($produtos->tipo == "SUBLIMAÇÃO") echo "selected";?>>SUBLIMAÇÃO</option>
        <option value="TRANSFER" <?php if($produtos->tipo == "TRANSFER") echo "selected";?>>TRANSFER</option>
        <option value="BORDADO" <?php if($produtos->tipo == "BORDADO") echo "selected";?>>BORDADO</option>
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
@endsection