@extends('generic')

@section('title')
Restablecer Contraseña
@endsection

@section('content')
<h1>Restablecer Contraseña</h1>
<hr/>

<div class="col-sm-10">
  @include('partials.flash')
    @if (count($errors) > 0)
    <div class="alert alert-danger alert-important" style="padding-left:40px;margin-top:1%;">

          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
    </div>
    @endif

</div>
<div class="col-sm-10">
<form method="POST" action="/password/reset">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
    </div>

    <div  class="form-group">
        <label for="pasword">Password</label>
        <input type="password" name="password"  class="form-control">
    </div>

    <div class="form-group">
       <label for="password_confirmation"> Confirm Password</label>
        <input type="password" name="password_confirmation"  class="form-control">
    </div>

    <div class="form-group">
        <button type="submit"  class="btn btn-primary">
            Restablecer Contraseña
        </button>
    </div>
</form>
</div>
@endsection