@extends('template')

@section('content')
<div class="container" style="width: 900px">
  <form action="{{ route('vendas.store') }}" method="POST">
     @csrf
    <div class="row">
        <div class="col">
            <center><h4>NOVA VENDA</h4></center>
        </div>
    </div>
    <hr>
<div class="row">
  <div class="col-5">
    <div class="form-group">
       <label for="produto">Produto</label>
      <select id="produto" class="form-control" name="produto" required onchange="qtn(this);">
        <option>Selecione...</option>
        <?php 
          $insumos = DB::table('produtos')->orderBy('produto')->get();
        ?>
        @foreach($insumos as $i)
          <option value="{{$i->produto}}" label="
              <?php
              if ($i->obs != 'DUP'){

                $total_valor = DB::table('compras')
                              ->where('item', $i->produto)
                              ->sum('valor_pago');
                $total_itens = DB::table('compras')
                              ->where('item', $i->produto)
                              ->sum('quantidade');
                  if ($total_valor != 0) {
                    $media = $total_valor/$total_itens;
                  } else {
                    $media = 'Este produto não foi adquirido';
                  }

              } else {

                         // Force locale
                /*date_default_timezone_set('America/Sao_Paulo');
                setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
                setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');*/


                // Create Carbon date
                $dt = Carbon\Carbon::now();
                
                $data_compra = $i->created_at;
                
                //$limite = $dt->year.'-'.$dt->month.'-05';
                $dia = 05;
                $limite = Carbon\Carbon::create($dt->year, $dt->month, 05, 00, 00, 00);
                //$lim = $limite->toDateString();
                //$comp = $data_compra->toDateString();

                if ($limite > $data_compra){
                  $media = 0;
                }
                
              }
            ?>

            "> 
            @if ($i->obs == 'DUP')
                  (DUP)
            @endif
            {{$i->produto.' (Est.: '.$i->estoque.' - Custo Un.: '}} {{round($media, 2).')'}}
          </option>
        @endforeach
      </select>
    </div>
  </div>
  <input type="hidden" name="duplicado" >
  <div class="col-2">
    <div class="form-group">
      <label for="quantidade">Quantidade</label>
      <input type="text" class="form-control" id="quantidade" name="quantidade" required>
      </div>
  </div>
  <div class="col-2">
    <div class="form-group">
      <label for="valor_pago">Valor de Venda</label>
      <input type="text" class="form-control" id="valor_pago" name="valor_pago" required>
      </div>
  </div>
  <div class="col">
    <div class="form-group">
       <label for="dt_entrega">Data para entrega</label>
      <input type="date" class="form-control" id="dt_entrega" name="dt_entrega" required>
    </div>
  </div>
</div>

<!--SE MARCAR TECIDO NO PRODUTO-->
<div name="quant" id="quant" style="display: none; border: solid; padding: 10px">
  <!--<h6 style="color: red">COLOCAR A QUANTIDADE EM KG QUE SERÁ USADO PARA FAZER TODAS AS PEÇAS</h6>-->
  <div class="row">
    <div class="col">
    <div class="form-group">
      <input type="text" class="form-control" id="q" name="q" placeholder="Digite o número de peças feitas com a quantidade de tecido adquirido.">
      </div>
  </div>
  </div>  



</div>
<div class="row">
  <div class="col-1">
    <div class="form-group">
      <label for="num_parcelas">Parcelas</label>
      <input type="text" class="form-control" id="num_parcelas" name="num_parcelas" required>
      </div>
  </div>
     <div class="col-3">
    <div class="form-group">
       <label for="forma_pagamento">Forma de Pagamento</label>
      <select id="forma_pagamento" class="form-control" name="forma_pagamento" required>
        <option>Selecione...</option>
        <option value="DINHEIRO">DINHEIRO</option>
        <option value="CARTÃO DÉBITO">CARTÃO DÉBITO</option>
        <option value="CARTÃO CRÉDITO">CARTÃO CRÉDITO</option>
      </select>
    </div>
  </div>
<div class="col-2">
    <div class="form-group">
      <label for="valor_entrada">Valor de Entrada</label>
      <input type="text" class="form-control" id="valor_entrada" name="valor_entrada" required>
      </div>
  </div>
   <div class="col-2">
    <div class="form-group">
       <label for="entrega">Entregador?</label>
      <select id="entrega" class="form-control" name="entrega" required>
        <option>Selecione...</option>
        <option value="S">SIM</option>
        <option value="N">NÃO</option>
      </select>
    </div>
  </div>
  
  <div class="col">
    <div class="form-group">
       <label for="pago">Quitado?</label>
      <select id="pago" class="form-control" name="pago" required>
        <option>Selecione...</option>
        <option value="S">SIM</option>
        <option value="N">NÃO</option>
      </select>
    </div>
  </div>

  <div class="col">
    <div class="form-group">
       <label for="tipo">Tipo</label>
        <select id="tipo" class="form-control" name="tipo" required>
          <option>Selecione...</option>
          <option value="SUBLIMAÇÃO">SUBLIMAÇÃO</option>
          <option value="TRANSFER">TRANSFER</option>
          <option value="BORDADO">BORDADO</option>
        </select>
    </div>
  </div>
</div>
<div class="row">
  <div class="col">
      <div class="form-group">
       <label for="cliente">Cliente</label>
      <select id="cliente" class="form-control" name="cliente" onchange="mostraCampo(this);" required>
        <option>Selecione...</option>
        <?php $clientes = DB::table('clientes')->orderBy('nome')->get();?>
        @foreach($clientes as $c)
          <option value="{{$c->nome}}">{{$c->nome}}</option>
        @endforeach
        <option value="OUTRO">OUTRO</option>
      </select>
    </div>
  </div>
    <div class="col-3">
    <div class="form-group">
       <label for="situacao">Situação</label>
      <select id="situacao" class="form-control" name="situacao" required>
        <option>Selecione...</option>
        <option value="Agendado">AGENDADO</option>
        <option value="Realizado">REALIZADO</option>
      </select>
    </div>
  </div>
    <div class="col-4">
      <div class="form-group">
       <label for="custo">Custo de Produção Unitário</label>
      <select id="custo" class="form-control" name="custo" required="required" required>
        <option>Selecione a combinação...</option>
        <?php $custos = DB::table('centrocustos')->orderBy('item')->get();?>
        @foreach($custos as $cs)
          <option value="{{$cs->valor}}">{{$cs->item.'(R$ '.$cs->valor.')'}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>
<!--DIV APARECE SE CLIENTE NÃO ESTIVER CADASTRADO-->
<div name="outrainst" id="outrainst" style="display: none; border: solid; padding: 10px">
    <div class="row">
      <div class="col">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome">
      </div>
    </div>
    <div class="col-3">
      <div class="form-group">
        <label for="contato">Contato</label>
        <input type="text" class="form-control" id="contato" name="contato">
      </div>
    </div>
    <div class="col-4">
      <div class="form-group">
        <label for="doc">CPF/CNPJ</label>
        <input type="text" class="form-control" id="doc" name="doc">
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
</div>


<div class="row" style="padding-top: 10px">
  <div class="col">
    <textarea class="form-control" id="obs" rows="3" name="obs" required></textarea>
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
    $('#quant').hide();
   });
  
  function mostraCampo(obj) {
  var select = document.getElementById('cliente');
  var txt = document.getElementById("outrainst");
  var cliente_new = document.getElementById("nome");
  if (select.value == "OUTRO") {
            document.getElementById("outrainst").style.display = "block";
            var troca = document.getElementById("cliente");
            troca.setAttribute("name", "");
            cliente_new.setAttribute("name", "cliente");

        } else {
            document.getElementById("outrainst").style.display = "none";
            var troca = document.getElementById("cliente");
            troca.setAttribute("name", "cliente");
            cliente_new.setAttribute("name", "");
            $('#nome').val('');
            $('#doc').val('');
            $('#numero').val('');
            $('#rua').val('');
            $('#bairro').val('');
            $('#contato').val('');
        }
}

function qtn(obj) {
  var seleciona = document.getElementById('produto');
  var selecao = seleciona[seleciona.selectedIndex].value;
  var div = document.getElementById("quant");
  var aviso = "";
  //alert(seleciona);
  //var cliente_new = document.getElementById("nome");
  if (selecao.match(/TECIDO.*/) || selecao.match(/MALHA.*/)) {
            document.getElementById("quant").style.display = "block";
            aviso = "sim";
            $('#quantidade').css('border', '2px solid #000');
            alert("Na caixa QUANTIDADE inserir a quantidade em KG utilizada para confecção de todas as peças!");
        } else {
            document.getElementById("quant").style.display = "none";
            $('#quantidade').css('border', '1px solid #000');
            //aviso = "não";
            //alert(aviso);
        }
  var duplicado = 
}
</script>

@endsection
