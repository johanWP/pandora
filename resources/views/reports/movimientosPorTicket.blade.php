@extends('master')

@section('title')
    Movimientos Por Ticket
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10">
            <h1>Movimientos Por Ticket</h1>
        </div>
    </div>

    <hr/>
    <?php
    $ticketActual = '~~~~~~~~~';
    $i = 0;
    ?>
    <div class="row">
        @if($movements->count() > 0)
            <div class="table-responsive">

                @foreach($movements as $movement)
                @if($ticketActual != $movement->ticket)

                    @if ($i > 0)
                        </tbody>
                        </table>

                    @endif
                <?php
                $ticketActual = $movement->ticket;
                $i++;
                ?>
                <h3 class="{{$ticketActual}}">
<<<<<<< HEAD
                    @if ($movement->ticket=='')
                        (Sin Ticket)
=======
                    @if ($ticketActual === '' OR $ticketActual === NULL)
                        (Sin Ticket)

>>>>>>> Development
                    @else
                    {{$ticketActual}}
                    @endif
                </h3>
                <table class="table table-striped {{$ticketActual}}" id="table_{{$ticketActual}}">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Cant.</th>
                        <th>Artículo</th>
                        <th><h3>Desde</h3></th>
                        <th><b> &nbsp;</b></th>
                        <th><h3>Hacia</h3></th>
                        <th class="text-center"><h3>Acciones</h3></th>
                    </tr>
                    </thead>
                    <tbody>
                    @endif
                    <tr>
                        <td class="col-sm-1">
                            <p class="text-left">

                                @if ($movement->status_id == '1')
                                    <i class="fa fa-check"></i>
                                @elseif($movement->status_id == '2')
                                    <i class="fa fa-question"></i>
                                @elseif($movement->status_id == '3')
                                    <i class="fa fa-trash"></i>
                                @elseif($movement->status_id == '4')
                                    <i class="fa fa-close"></i>
                                @endif
                            </p>
                        </td>
                        <td class="col-sm-1">
                            <p class="text-left">
                                {{ $movement->quantity}}
                            </p>
                        </td>
                        <td class="col-sm-4">
                            <p class="text-left">
                                {{ $movement->article->name}}
                            </p>
                        </td>
                        <td class="col-sm-2">
                            <p class="text-left">
                                {{ $movement->origin->name}}
                            </p>
                        </td>
                        <td>
                            <p class="text-center">
                                <span><i class="fa fa-arrow-right fw"></i></span>
                            </p>
                        </td>
                        <td>
                            <p class="text-left">
                                {{ $movement->destination->name}}
                            </p>
                        </td>
                        <td class="text-center">
                            <a href="/movimientos/{{ $movement->id }}" id="btnVer" class="btn btn-default">
                                <i class="fa fa-eye fa-2x"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

    </div>
    @else
        <h2> No hay movimientos cargados.</h2>
    @endif
    <a href="/reportes/movimientosPorTicket" class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>

@endsection