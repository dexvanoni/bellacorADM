<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>RECIBO</title>
  <link href="/css/impressao.css" rel="stylesheet">
  <script src="/bst/js/jquery-1.12.4.min.js"></script>
</head>
<body>
  <div class="imprimir" id="imprimir">
    <div id="folha-a4" class="folha a4_vertical">
      <img src="/imagens/bellacor.jpeg" width="280px" height="100px" style="float: left">
      <h3 style="margin-top: 50px; margin-left: 450px">IDENTIFICAÇÃO: 
          <?php  
            foreach ($itens as $i) {
              echo $i->id.' ';
            }
          ?></h3>
      <h3 style="margin-left: 350px">Cliente: {{$itens[0]->cliente}}</h3>
      <hr>
      <center><h3 style="margin-top: 50px">RECIBO</h3></center>
      <br>
      <br>
      <br>
      <p align="justify" style="margin-left: 80px; margin-right: 80px ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eu, Fabiana Bezerra de Souza Vanoni, CPF 004.690.481-66, representande da BellaCor Bordado e Estamparia, declaro que recebi o valor de <strong>R$ {{$itens->sum('valor_pago')}} </strong>reais do(a) Sr.(a) <strong>{{$itens[0]->cliente}}</strong> no dia <strong>{{date('d/m/Y', strtotime($itens[0]->dt_entrega))}}</strong> pela confecção dos seguintes itens abaixo descritos:
      </p>
      <table style="margin-left: 80px; margin-right: 80px">
        <thead>
        <tr>
          <th style="font-size: 14px">ID</th>
          <th style="font-size: 14px">Item</th>
          <th style="font-size: 14px">Quantidade</th>
          <th style="font-size: 14px">Valor</th>
          <th style="font-size: 14px">Forma de Pagamento</th>
          <th style="font-size: 14px">Nº de Parcelas</th>
         </tr>
       </thead>
       <tbody>
        @foreach ($itens as $i)
         <tr>
             <center><td align="center" style="font-size: 14px">{{$i->id}}</td></center>
             <center><td align="center" style="font-size: 14px">{{$i->produto}}</td></center>
             <center><td align="center" style="font-size: 14px">{{$i->quantidade}}</td></center>
             <center><td align="center" style="font-size: 14px">R$ {{$i->valor_pago}}</td></center>
             <center><td align="center" style="font-size: 14px">{{$i->forma_pagamento}}</td></center>
             <center><td align="center" style="font-size: 14px">{{$i->num_parcelas}}</td></center>
         </tr>
        @endforeach
       </tbody>
      </table>
      <p align="justify" style="margin-left: 80px; margin-right: 80px ">
        <strong>Observações:</strong>
        <br>
        @foreach ($itens as $i)
        {{$i->obs}}
        @endforeach
      </p>
      <br>
      <br>
      <br>
      <br>
      <p align="justify" style="margin-left: 80px; margin-right: 80px ">
        <?php 
                // Force locale
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');


        // Create Carbon date
        $dt = Carbon\Carbon::now();
        
        //$mes = Carbon\Carbon::now();
      ?>
        Campo Grande, {{$dt->formatLocalized('%d de %B de %Y')}}.
      </p>
      <br>
      <br>
      <center>_________________________________________________</center>
      <center>Fabiana Bezerra de Souza Vanoni</center>
      <center><strong>BellaCor - Bordado e Estamparia</strong></center>
      <center>CNPJ: 35.315.087/0001-70</center>
      <br>

      <center><p style="margin-left: 80px; margin-right: 80px">HASH DE DESCONTO: 123423423423456667890</p></center>
      <h6 style="margin-left: 80px; margin-right: 80px; color: red">Apresente este recibo e receba 10% de desconto na sua próxima compra! (NÃO ACUMULATIVA)</h6>

      <p style="margin-left: 80px; margin-right: 80px">
        <strong>Contatos </strong><br>
        <strong>Tel/Whatsapp:</strong> (67)99201-4825<br>
        <strong>Email:</strong> nova.bellacor@gmail.com<br>
        <strong>Loja virtual:</strong> www.dfbordados.com.br
      </p>
      <br><br>
      <center><p>A Equipe BellaCor agradece a preferência!</p></center>

    </div>
  </div><!--limite imprimir-->
</body>


<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
  function criaPDF(){
    alert('Escolha a impressora desejada ou para gerar PDF escolha a opção --> Imprimir para Arquivo');
    window.print();
  }
</script>

<script>
$( document ).ready(function() {
  $('#new').hide();
  altura = document.getElementById('tudo').offsetHeight;
  if (altura > 900) {
    $('#new').show();
  }
});
</script>

</html>

