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
       <label for="item">Item</label>
      <select id="item" class="form-control" name="item">
        <option>Selecione...</option>
        <option value="CANECA PORCELANA 325ml BRANCA ORCA">CANECA PORCELANA 325ml BRANCA ORCA</option>
        <option value="CANECA PORCELANA 325ml COR INTERNA ORCA">CANECA PORCELANA 325ml COR INTERNA ORCA</option>
        <option value="CANECA PORCELANA 325ml COR INTERNA COM COLHER">CANECA PORCELANA 325ml COR INTERNA COM COLHER</option>
        <option value="CANECA PORCELANA 325ml COR INTERNA ALÇA BOLA">CANECA PORCELANA 325ml COR INTERNA ALÇA BOLA</option>
        <option value="CANECA PORCELANA 300ml COR INTERNA QUADRADA">CANECA PORCELANA 300ml COR INTERNA QUADRADA</option>
        <option value="CANECA PORCELANA 325ml COLORIDA COM TARJA LIVE">CANECA PORCELANA 325ml COLORIDA COM TARJA LIVE </option>
        <option value="CANECA MÁGICA COLORIDA 325ml">CANECA MÁGICA COLORIDA 325ml</option>
        <option value="CANECA CHOPP VIDRO JATEADO 450ml ORCA">CANECA CHOPP VIDRO JATEADO 450ml ORCA</option>
        <option value="CANECA CHOPP VIDRO JATEADO 325ml ORCA">CANECA CHOPP VIDRO JATEADO 325ml ORCA</option>
        <option value="CANECA CHOPP VIDRO LISO 450ml">CANECA CHOPP VIDRO LISO 450ml</option>
        <option value="CANECA CHOPP VIDRO LISO 325ml">CANECA CHOPP VIDRO LISO 325ml</option>
        <option value="CANECA ALUMÍNIO 350ml">CANECA ALUMÍNIO 350ml</option>
        <option value="CANECA ALUMÍNIO 450ml">CANECA ALUMÍNIO 450ml</option>
        <option value="CANECA ALUMÍNIO 500ml">CANECA ALUMÍNIO 500ml</option>
        <option value="CANECA ALUMÍNIO 650ml">CANECA ALUMÍNIO 650ml</option>
        <option value="CANECA ALUMÍNIO 750ml">CANECA ALUMÍNIO 750ml</option>
        <option value="CANECA ALUMÍNIO 850ml">CANECA ALUMÍNIO 850ml</option>
        <option value="CANECA ALUMÍNIO BRANCA 450ml">CANECA ALUMÍNIO BRANCA 450ml</option>
        <option value="CANECA ALUMÍNIO BRANCA 500ml">CANECA ALUMÍNIO BRANCA 500ml</option>
        <option value="CANECA ALUMÍNIO BRANCA 650ml">CANECA ALUMÍNIO BRANCA 650ml</option>
        <option value="CANECA ALUMÍNIO BRANCA 750ml">CANECA ALUMÍNIO BRANCA 750ml</option>
        <option value="CANECA ALUMÍNIO BRANCA 850ml">CANECA ALUMÍNIO BRANCA 850ml</option>
        <option value="SQUEEZE ALUMÍNIO TAMPA BOLA 500ml">SQUEEZE ALUMÍNIO TAMPA BOLA 500ml</option>
        <option value="SQUEEZE ALUMÍNIO BRANCA TAMPA BOLA 500ml">SQUEEZE ALUMÍNIO BRANCA TAMPA BOLA 500ml</option>
        <option value="TECIDO 100% POLIÉSTER BRANCO KG">TECIDO 100 POLIÉSTER BRANCO KG</option>
        <option value="TECIDO 100% POLIÉSTER COLORIDO KG">TECIDO 100 POLIÉSTER COLORIDO KG</option>
        <option value="TECIDO 96%/4% POL/ELAST BRANCO ALLURE KG">TECIDO 96-4 POL-ELAST BRANCO ALLURE KG</option>
        <option value="TECIDO 96%/4% POL/ELAST COLORIDO ALLURE KG">TECIDO 96-4 POL-ELAST COLORIDO ALLURE KG</option>
        <option value="TECIDO PV BRANCO KG">TECIDO PV BRANCO KG</option>
        <option value="TECIDO PV COLORIDO KG">TECIDO PV COLORIDO KG</option>
        <option value="TECIDO PA BRANCO KG">TECIDO PA BRANCO KG</option>
        <option value="TECIDO PA COLORIDO KG">TECIDO PA COLORIDO KG</option>
        <option value="RIBANA BRANCA KG">RIBANA BRANCA KG</option>
        <option value="RIBANA COLORIDA KG">RIBANA COLORIDA KG</option>
        <option value="BODY INFANTIL Suedine BRANCO Tam: RN">BODY INFANTIL Suedine BRANCO Tam: RN</option>
        <option value="CAMISETA PP Tam. P LISA">CAMISETA PP Tam. P LISA</option>
      </select>
    </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="quantidade">Quantidade</label>
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
  
</script>
@endsection