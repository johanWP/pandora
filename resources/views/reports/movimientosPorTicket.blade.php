@extends('master')

@section('title')
    Movimientos por Ticket
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10">
            <h1>Movimientos por Ticket</h1>
        </div>
    </div>

    <hr/>
    <?php
    $ticketActual = '~~~~~~~~';
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
                <div class="row"><div class="col-sm-10">
				<h3 class="{{$ticketActual}}">
                    @if ($ticketActual =='')
                        (Sin Ticket)
                    @else
                        {{$ticketActual}}
                    @endif
                </h3>
				</div>
				<div class="col-sm-2"><br/>
					<a class="btn btn-primary" href="/reportes/excelMovimientosPorTicket/{{ $ticketActual }}"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
				</div>
				</div>
                <table class="table table-striped {{$ticketActual}}" id="table_{{$ticketActual}}">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Cant.</th>
                        <th>Artículo</th>
                        <th>Desde</th>
                        <th><b> &nbsp;</b></th>
                        <th>Hacia</th>
                        <th class="text-center" colspan="2">Acciones</th>

                    </tr>
                    </thead>
                    <tbody>
                    @endif
                    <tr class="{{ $movement->id }}">
                        <td>
                            <p class="text-center">

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
                        <td>
                            <p class="text-left">
                                {{ $movement->quantity}}
                            </p>
                        </td>
                        <td>
                            <p class="text-left">
                                {{ $movement->article->name}}
                            </p>
                        </td>
                        <td>
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
        <h2>No hay movimientos en el sistema.</h2>
    @endif
    <a href="/reportes/movimientosPorTicket" class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
@endsection