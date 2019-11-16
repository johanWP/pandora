@extends('master')

@section('title')
    Artículos con movimientos
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Artículos con movimientos</h1>
  </div>

</div>

    <hr/>
<div class="row">

    <table class="table table-responsive">
      <thead>
         <tr>
            <th>id</th>
            <th>name</th>
            <th>product_code</th>
         </tr>
      </thead>
            @foreach($results as $article)
               <tr>
                  <td>{{ $article['id'] }}</td>
                  <td>{{ $article['name'] }}</td>
                  <td>{{ $article['product_code'] }}</td>
               </tr>
            @endforeach
    </table>

</div>

@endsection