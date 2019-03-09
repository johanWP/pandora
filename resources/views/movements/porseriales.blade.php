@extends('master')

@section('title')
    Detalles del movimiento
@endsection

@section('content')
    <h1>Detalles del movimiento // FROM {{ $origin_id }} >> TO {{ $destination_id }} >> ART {{ $article_id }} </h1>
    <hr/>

      <table class="table table-responsive">
      <thead>
         <tr>
            <th>Código</th>
            <th>Desde</th>
            <th>Hacia</th>
            <th>Serial</th>
  
         </tr>
      </thead>
      <tbody>

        @foreach($seriales as $serial)
 
               <tr>
                  <td>{{ $article_id }}</td>
                  <td>{{ $origin_id }}</td>
                  <td>{{ $destination_id }}</td>
                  <td>{{ $serial }}</td>
               </tr>
         
        @endforeach
        
      </tbody>
    </table>

{{ $remito }} // {{ $note }} // {{ $ticket }} // {{ $user_id }} // {{ $i }}


@endsection