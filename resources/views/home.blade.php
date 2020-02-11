@extends('template')

@section('titulo')
    Tela Inicial - ADM STAMP
@endsection
@section('content')
                  <div class="row justify-content-md-center">
                    <div class="col-8 col-offset-2">
                        
                        <center><img src="/imagens/bellacor.jpeg" width="300px" height="100px"></center>    
                        <br>
                        <hr>
                        <table class="table table-striped table-bordered table-condensed table-hover">
                        <tbody>
                            <tr class="success">
                                <td>Total de Vendas deste mês</td>
                                <td>R$ {{$vendas->sum('valor_pago')}}</td>
                            </tr>
                            <tr class="active">
                                <td>Lucro LÍQUIDO</td>
                                <td>R$ {{$lucro_liq}}</td>
                            </tr>
                            <tr class="danger">
                                <td>GASTOS</td>
                                <td>Evoque</td>
                            </tr>
                            <tr class="warning">
                                <td>Em caixa</td>
                                <td>R$ {{$vendas_realizadas->sum('valor_pago')}}</td>
                            </tr>
                            <tr class="info">
                                <td>Itens Vendidos - REALIZADOS</td>
                                <td>{{$vendas_realizadas->sum('quantidade')}}</td>
                            </tr>
                            <tr class="danger">
                                <td>Itens Vendidos - AGENDADOS</td>
                                <td>{{$vendas_agendadas->sum('quantidade')}}</td>
                            </tr>
                            <tr class="success">
                                <td>A Receber</td>
                                <td>{{$vendas_agendadas->sum('valor_pago')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



@endsection

             

