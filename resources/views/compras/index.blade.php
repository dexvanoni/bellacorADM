@extends('template')
@section('titulo')
LISTA DE COMPRAS
@endsection
@section('content')
<div class="row">
    <div class="col">
        <center><h4>LISTA DE COMPRAS 
        	<a title="NOVA COMPRA" href="{{ route('compras.create') }}" class="badge badge-primary">+<i class="fas fa-money-bill-alt"></i></a></h4></center>
    </div>
</div>
<hr>

<table class="display nowrap" id="lista_compras" style="font-size: 12px">
        <thead>
          <center><tr>
            <th style="text-align: center;">Item</th>
            <th style="text-align: center;">Qtn</th>
            <th style="text-align: center;">Valor Pago</th>
            <th style="text-align: center;">Parcelas</th>
            <th style="text-align: center;">Forma pg</th>
            <th style="text-align: center;">Fornecedor</th>
            <th style="text-align: center;">Data</th>
            <th style="text-align: center;">Quem</th>
            <th style="text-align: center;">Ações</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($compras as $i)
            <center><tr>
              <td style="width: 25%; text-align: center;" >
                <?php $prod = DB::table('produtos')->where('produto', $i->item)->get()?>
                  @if($prod->isNotEmpty())
                    <i title="Este item existe na lista de produtos" class="fas fa-check" style="color: green"></i>
                    @else
                    <a title="Adicionar este item na lista de produtos e insumos?" href="{{ route('produtos.adicionar', ['i' => $i->item, 'q' => $i->quantidade]) }}" class="badge badge-success"><i class="fas fa-cart-plus"></i></a>
                  @endif
                {{$i->item}}
              </td>
              <td style="width: 5%; text-align: center;" >
                @if($prod->isNotEmpty())
                  @if(is_null($i->add_estoque_produto))
                    <!--<a title="Adicionar esta quantidade no estoque deste produto" href="{{ route('produtos.add_compra', ['i' => $prod[0]->produto, 'q' => $i->quantidade]) }}" class="badge badge-primary">+</a>-->
                    @endif
                @endif
                {{$i->quantidade}}
              </td>
              <td style="width: 10%; text-align: center;" >R$ {{$i->valor_pago}}</td>
              <td style="width: 5%; text-align: center;" >{{$i->num_parcelas}}</td>
              <td style="width: 15%; text-align: center;" >{{$i->forma_pagamento}}</td>
              <td style="width: 15%; text-align: center;" >{{$i->fornecedor}}</td>
              <td style="width: 15%; text-align: center;" >{{date('d/m/Y', strtotime($i->created_at))}}</td>
              <td style="width: 15%; text-align: center;" >{{$i->quem_pagou}}</td>
              <td style="width: 10%; text-align: center;" >

                      <a title="Editar" href="{{ route('compras.edit', ['i' => $i->id]) }}" class="badge badge-success"><i class="fas fa-edit"></i></a>


                      <!--<form action="{{ route('compras.destroy', ['i' => $i->id]) }}" onsubmit="return confirm('\nTem certeza que deseja excluir este PRODUTO?'); return false;" method="post">
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