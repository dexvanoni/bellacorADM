@extends('template')

@section('content')
<div class="container" style="width: 900px">
  <form action="{{ route('clientes.store') }}" method="POST">
     @csrf
    <div class="row">
        <div class="col">
            <center><h4>NOVO CLIENTE</h4></center>
        </div>
    </div>
    <hr>
<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" class="form-control" id="produto" name="nome">
      </div>
  </div>
  <div class="col">
    <div class="form-group">
      <label for="doc">CPF/CNPJ</label>
      <input type="text" class="form-control" id="doc" name="doc">
      </div>
  </div>
  <div class="col">
    <div class="form-group">
      <label for="contato">Contato</label>
      <input type="text" class="form-control" id="contato" name="contato">
      </div>
  </div>
</div>

<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="rua">Endereço</label>
      <input type="text" class="form-control" id="rua" name="rua">
      </div>
  </div>
<div class="col-2">
    <div class="form-group">
      <label for="numero">Número</label>
      <input type="text" class="form-control" id="numero" name="numero">
      </div>
  </div>
<div class="col-4">
    <div class="form-group">
      <label for="bairro">Bairro</label>
      <input type="text" class="form-control" id="bairro" name="bairro">
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