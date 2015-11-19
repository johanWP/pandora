<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand logo" href="index.html"><span class="spanLogo">Pandora Admin</span></a>
</div>


<ul class="nav navbar-top-links navbar-right">
     <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            {!!Auth::user()->firstName . " " . Auth::user()->lastName!!}&nbsp;({!! Auth::user()->username !!})<i class="fa fa-user fa-fw"></i>
            <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
            </li>
            <li class="divider"></li>
            <li><a href="{!!URL::to('/logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
    </li>
</ul>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li><a href="{!!URL::to('/escritorio')!!}"><i class="fa fa-desktop fa-fw"></i> Escritorio</a></li>
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Usuarios<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/usuarios/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/usuarios')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-building-o fa-fw"></i> Empresas<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/empresas/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/empresas/')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-tasks fa-fw"></i> Tipos de Almacén<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/tipos/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/tipos/')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-cubes fa-fw"></i> Actividades<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/actividades/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/actividades')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-archive fa-fw"></i> Almacenes<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/almacenes/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/almacenes')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-exchange fa-fw"></i> Movimientos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/movimientos/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/movimientos')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Últimos Movimientos</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Artículos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/articulos/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/articulos')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listados</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
