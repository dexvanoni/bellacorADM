@extends('template')
@section('titulo')
LISTA DE PRODUTOS
@endsection
@section('content')
<div class="row">
    <div class="col">
        <center><h4>LISTA DE PRODUTOS 
        	<!--<a title="NOVO PRODUTO" href="{{ route('produtos.create') }}" class="badge badge-primary">+<i class="fas fa-beer"></i></a>--></h4></center>
          <center><h6 style="color: red">Novos produtos são adicionados somente na ferramenta COMPRAS</h6></center>
    </div>
</div>
<hr>

<table class="display nowrap" id="lista">
        <thead>
          <center><tr>
            <th style="text-align: center;">Produto</th>
            <th style="text-align: center;">Valor Venda</th>
            <th style="text-align: center;">Custo</th>
            <th style="text-align: center;">Estoque</th>
            <!--<th style="text-align: center;">Adc. Estoque</th>-->
            <th style="text-align: center;">Ações</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($produtos as $i)
            <center><tr>
              <td style="width: 40%; text-align: center;" >
                @if($i->obs == 'DUP')
                  <i title="Este produto já está na lista de produtos e tem estoque proveniente de compras anteriores! A partir do próximo dia 05 os custos deste estoque antigo será zerado." class="fas fa-exclamation-circle" style="color: red"></i>
                @endif
                {{ $i->produto }}
              </td>
              <td style="width: 15%; text-align: center;" >R$ {{$i->valor_venda}}</td>
              <td style="width: 15%; text-align: center;" >R$ 
                <?php
                  $total_valor = DB::table('compras')->where('item', $i->produto)->sum('valor_pago');
                  $total_itens = DB::table('compras')->where('item', $i->produto)->sum('quantidade');
                  
                  if ($total_valor != 0) {
                    $media = $total_valor/$total_itens;
                  } else {
                    $media = 'Este produto não foi adquirido';
                  }
                ?>
                {{round($media, 2)}}
              </td>
              <td style="width: 10%; text-align: center; color: green; background-color:  <?php if ($i->estoque == 0) echo "red"; ?>" >{{$i->estoque}}</td>
              <!--<td style="width: 10%; text-align: center;">
              		<a href="{{ route('produtos.add', ['i' => $i->id]) }}" class="badge badge-primary">+1</a>
              		<a href="{{ route('produtos.add_dez', ['i' => $i->id]) }}" class="badge badge-success">+10</a>
              		<a href="{{ route('produtos.add_vinte', ['i' => $i->id]) }}" class="badge badge-warning">+20</a>
              		<a href="{{ route('produtos.add_trinta', ['i' => $i->id]) }}" class="badge badge-dark">+30</a>
              	</td>-->
              <td style="width: 10%; text-align: center;" >

                      <a title="Editar" href="{{ route('produtos.edit', ['i' => $i->id]) }}" class="badge badge-success"><i class="fas fa-edit"></i></a>


                      <!--<form action="{{ route('produtos.destroy', ['i' => $i->id]) }}" onsubmit="return confirm('\nTem certeza que deseja excluir este PRODUTO?'); return false;" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="badge badge-primary"><i class="fas fa-trash"></i></button>
                      </form>-->
              </td>
            </tr></center>
          @endforeach
        </tbody>
      </table>



@endsection