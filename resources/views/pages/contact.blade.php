<div id="google-map" style="height:650px" data-latitude="-34.569305" data-longitude="-58.456850"></div>
<div class="container-wrapper">
    <div class="container">

        <div class="row">
            <div class="col-sm-4 col-sm-offset-8">
                 @include('partials.flash')
                <div class="contact-form">
                    <h3>Contact Info</h3>

                    <address>
                      <strong>SDK Tecnología & Negocios</strong><br>
                      Av. Cramer 1643<br>
                      Buenos Aires, Argentina<br>
                      <abbr title="Phone">P:</abbr> +54 (11) 6967 5264
                    </address>

                    {!! Form::open(['url'=>'/mail', 'method'=>'POST']) !!}
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control" placeholder="Asunto" required>
                        </div>
                        <div class="form-group">
                            <textarea name="text" class="form-control" rows="8" placeholder="Mensaje" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>