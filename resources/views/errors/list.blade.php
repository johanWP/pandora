@if ($errors->any())
    <ul class="alert alert-danger" style="padding-left:40px;">
    @foreach($errors->all() as $error)
        <li>{{ $error}}</li>
    @endforeach
    </ul>
@endif