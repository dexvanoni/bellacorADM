@extends('template')
@section('titulo')
LISTA DE CLIENTES
@endsection
@section('content')
<div class="row">
    <div class="col">
        <center><h4>LISTA DE CLIENTES 
        	<a title="NOVO CLIENTE" href="{{ route('clientes.create') }}" class="badge badge-primary">+<i class="fas fa-user"></i></a></h4></center>
    </div>
</div>
<hr>

<table class="display nowrap" id="lista_clientes">
        <thead>
          <center><tr>
            <th style="text-align: center;">Nome</th>
            <th style="text-align: center;">CPF/CNPJ</th>
            <th style="text-align: center;">Contato</th>
            <th style="text-align: center;">Endereço</th>
            <th style="text-align: center;">Ações</th>
          </tr></center>
        </thead>
        <tbody>
          @foreach ($clientes as $i)
            <center><tr>
              <td style="width: 25%; text-align: center;" >
                <?php $contas = DB::table('vendas')->where('cliente', $i->nome)->get()?>
                @if($contas->contains('pago', 'N'))
                  <i title="Este Cliente possui dívidas em aberto!" class="fas fa-exclamation-triangle" style="color: red"></i>
                @endif
                {{ $i->nome }}
              </td>
              <td style="width: 15%; text-align: center;" >{{$i->doc}}</td>
              <td style="width: 15%; text-align: center;" >{{$i->contato}}</td>
              <td style="width: 30%; text-align: center;" >{{$i->rua.', '.$i->numero.' - '.$i->bairro}}</td>
              <td style="width: 10%; text-align: center;" >

                      <a title="Editar" href="{{ route('clientes.edit', ['i' => $i->id]) }}" class="badge badge-success"><i class="fas fa-edit"></i></a>


                      <!--<form action="{{ route('clientes.destroy', ['i' => $i->id]) }}" onsubmit="return confirm('\nTem certeza que deseja excluir este PRODUTO?'); return false;" method="post">
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