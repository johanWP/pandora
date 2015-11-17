@if(Session::has('flash_message'))
    <div class="alert alert-success" {{Session::has('flash_message_important') ? 'alert-important' : ''}} style="padding-left:40px;margin-top:1%;">
        @if(Session::has('flash_message_important'))
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
        @endif
        {{session('flash_message')}}
    </div>
@endif

@if(Session::has('flash_message_danger'))
    <div class="alert alert-danger" {{Session::has('flash_message_important') ? 'alert-important' : ''}} style="padding-left:40px;margin-top:1%;">
        @if(Session::has('flash_message_important'))
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
        @endif
        {{session('flash_message_danger')}}
    </div>
@endif
