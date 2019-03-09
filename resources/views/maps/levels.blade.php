@extends('master')

@section('title')
    Planos - Niveles de ajustes
@endsection

@section('content')
    <h1>Niveles de ajustes según tipo de construcción</h1>
        <h3>Nodos de 2000 hogares</h3>
            <p>Solo aplica a los siguientes nodos:</p>
            <ul class="list-group">
            <li class="list-group-item">LANUS: Planos LA01 a LA55 inclusive</li>
            <li class="list-group-item">AVELLANEDA: Planos AV01 a AV26 inclusive</li>
            </ul>

<div class="row">
  <div class="table-responsive">

    <table class="table table-striped table-bordered">

      <tbody>
         <tr>
            <th>Activos Directa 1GHz Retorno 42 Mhz</th>
            <th>Directa</th>
            <th>Retorno</th>
         </tr>
         <tr>
            <td></td>
            <td><mark>CH 3/116/136</mark></td>
            <td><mark>Portadora Retorno entre 18 y 20 dBmv</mark></td>
         </tr>  
         <tr>
            <td>Nodo</td>
            <td>33/44/46</td>
            <td>Nivel de Docsis</td>
         </tr>
         <tr>
            <td>Sub-Nodo</td>
            <td>33/44/46</td>
            <td>Mismo nivel del Nodo</td>
         </tr>
         <tr>
            <td>Line distribucion</td>
            <td>39/50/52</td>
            <td>Nodo -3 dB</td>
         </tr>
         <tr>
            <td>Dual/triple de distribucion</td>
            <td>39/50/52</td>
            <td>Nodo -3 dB</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>

<hr />
        
        <h3>Nodos N+1 con retorno de 42MHz</h3>
            <p>Aplica a todos los nodos que no se encuentren en el listado anterior</p>
 
 <div class="row">
  <div class="table-responsive">

    <table class="table table-striped">

      <tbody>
         <tr>
            <th>Activos Directa 1GHz Retorno 42 Mhz</th>
            <th>Directa</th>
            <th>Retorno</th>
         </tr>
         <tr>
            <td></td>
            <td><mark>CH 3/116/136</mark></td>
            <td><mark>Portadora Retorno entre 18 y 20 dBmv</mark></td>
         </tr>  
         <tr>
            <td>Nodo</td>
            <td>36/47/49</td>
            <td>Nivel de Docsis</td>
         </tr>
         <tr>
            <td>Line distribucion</td>
            <td>39/50/52</td>
            <td>Nodo -3 dB</td>
         </tr>
         <tr>
            <td>Dual/triple de distribucion</td>
            <td>42/53/55</td>
            <td>Nodo -3 dB</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>
    
<hr />
        
        <h3>Nodos N+1 con retorno de 85MHz</h3>
            
<div class="row">
  <div class="table-responsive">

    <table class="table table-striped">

      <tbody>
         <tr>
            <th>Activos Directa 1GHz Retorno 85 Mhz</th>
            <th>Directa</th>
            <th>Retorno</th>
         </tr>
         <tr>
            <td></td>
            <td><mark>CH 50/116/136</mark></td>
            <td><mark>Portadora Retorno entre 14 y 16 dBmv</mark></td>
         </tr>  
         <tr>
            <td>Nodo</td>
            <td>41/47/49</td>
            <td>Nivel de Docsis</td>
         </tr>
         <tr>
            <td>Line distribucion</td>
            <td>43/50/52</td>
            <td>Igual nodo</td>
         </tr>
         <tr>
            <td>Dual/triple de distribucion</td>
            <td>47/53/55</td>
            <td>Igual nodo</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>
 
 <hr />               
        <h2>Información a asentar en los tickets cuando se realicen ajustes de un amplificador</h2>
            <ul class="list-group">
            <li class="list-group-item">Dirección y modelo del amplificador a ajustar</li>
            <li class="list-group-item">Especificar si es SUBNODO o DISTRIBUCION</li>
            <li class="list-group-item">Especificar dirección y modelo de activo anterior y posterior en la cascada</li>
            <li class="list-group-item">Especificar si el activo anterior es NODO o SUBNODO</li>
            <li class="list-group-item">Niveles de entrada encontrados: CH03, CH70, CH115 y CH116; DOCSIS; MER y BER</li>
            <li class="list-group-item">Niveles de salida antes y después del ajuste: CH03, CH70, CH115 y CH116; DOCSIS; MER y BER</li>
            <li class="list-group-item">PAD que se coloco en el AGC</li>
            <li class="list-group-item">Foto de cómo estaba el amplificador antes y después del ajuste</li>
            </ul>
            
            <p>Listado de modelos de amplificadores: RO CISCO GS7000; RO Motorola SG4000; Amplificador LE; Amplificador HGD; Amplificador HGBT</p>
@endsection