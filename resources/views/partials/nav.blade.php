<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand logo" href="/"><span class="spanLogo"></span></a>
</div>


<ul class="nav navbar-top-links navbar-right">
     <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            {!!Auth::user()->firstName . " " . Auth::user()->lastName!!}&nbsp;(<span id="spanCurrentCompanyName">{{ Auth::user()->currentCompany->name }}</span>)<i class="fa fa-user fa-fw"></i>
            <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="/ajustes"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
            </li>
            <li class="divider"></li>
            <li><a href="{!!URL::to('/logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Salir del Sistema</a>
            </li>
        </ul>
    </li>
</ul>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li><a href="{!!URL::to('/escritorio')!!}"><i class="fa fa-desktop fa-fw"></i> Escritorio</a></li>

{{--Los usuarios los crea Gerente o mayor            --}}
@if (Auth::user()->securityLevel >= 40)
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Usuarios<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                @if (Auth::user()->securityLevel >= 40)
                    <li>
                        <a href="{!!URL::to('/usuarios/create')!!}"><i class='fa fa-plus fa-fw'></i> Nuevo Usuario</a>
                    </li>
                @endif
                    <li>
                        <a href="{!!URL::to('/usuarios')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
@endif
{{--Las empresas las crea el Director o mayor--}}
@if (Auth::user()->securityLevel >= 50)
            <li>
                <a href="#"><i class="fa fa-building-o fa-fw"></i> Empresas<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/empresas/create')!!}"><i class='fa fa-plus fa-fw'></i> Nueva Empresa</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/empresas/')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
@endif
{{--Solo admin puede hacer esto--}}
@if (Auth::user()->securityLevel > 99)
            <li>
                <a href="#"><i class="fa fa-tasks fa-fw"></i> Tipos de Almacén<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/tipos/create')!!}"><i class='fa fa-plus fa-fw'></i> Nuevo Tipo</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/tipos/')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
@endif
{{--Solo Admin puede hacer esto--}}
@if (Auth::user()->securityLevel > 99)
            <li>
                <a href="#"><i class="fa fa-cubes fa-fw"></i> Actividades<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/actividades/create')!!}"><i class='fa fa-plus fa-fw'></i> Nueva Actividad</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/actividades')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
@endif
{{--Jefe o mayor puede hacer esto--}}
@if (Auth::user()->securityLevel >= 30)
            <li>
                <a href="#"><i class="fa fa-archive fa-fw"></i> Almacenes<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/almacenes/create')!!}"><i class='fa fa-plus fa-fw'></i> Nuevo Almacén</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/almacenes')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listado</a>
                    </li>
                </ul>
            </li>
@endif
            <li>
                <a href="#"><i class="fa fa-exchange fa-fw"></i> Movimientos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/movimientos/create')!!}"><i class='fa fa-plus'></i> Nuevo Movimiento</a>
                    </li>

@if (Auth::user()->securityLevel >= 20)
                    <li>
                        <a href="{!!URL::to('/movimientos/createbasic')!!}"><i class='fa fa-plus'></i> Nuevos movimientos no seriados</a>
                    </li>
@endif
                    

                    <li>
                        <a href="{!!URL::to('/movimientos/alta')!!}"><i class='fa fa-arrow-circle-up'></i> Ingreso/Recupero de Artículos</a>
                    </li>

@if (Auth::user()->securityLevel >= 20)
                    <li>
                        <a href="{!!URL::to('/movimientos/porAprobar')!!}"><i class='fa fa-check'></i> Pendientes por Aprobar</a>
                    </li>
@endif
                    <li>
                        <a href="{!!URL::to('/movimientos/')!!}"><i class='fa fa-list-ol'></i> Ver Últimos Movimientos</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-exchange fa-fw"></i> Tickets<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/vttickets')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver tickets VT</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/vttickets/agenda')!!}"><i class='fa fa-calendar fa-fw'></i> Agenda del día</a>
                    </li>
@if (Auth::user()->securityLevel >= 20)
                    <li>
                        <a href="{!!URL::to('/vttickets/import')!!}"><i class='fa fa-cloud-upload fa-fw'></i> Importar tickets VT ETA</a>
                    </li>
@endif
                </ul>
            </li>
                
                
            <li>
                <a href="#"><i class="fa fa-book fa-fw"></i> Planos y manuales<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/maps')!!}"><i class='fa fa-map-marker fa-fw'></i> Ver localidades</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/levels')!!}"><i class='fa fa-map-marker fa-fw'></i> Ajustes de niveles</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/selector')!!}"><i class='fa fa-map-marker fa-fw'></i> Selector de fases</a>
                    </li>
                </ul>
            </li>

{{--Supervisor o mayor puede hacer esto--}}
@if (Auth::user()->securityLevel >= 20)
            <li>
                <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Artículos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/articulos/create')!!}"><i class='fa fa-plus fa-fw'></i> Nuevo Artículo</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/articulos')!!}"><i class='fa fa-list-ol fa-fw'></i> Ver Listados</a>
                    </li>

                @if (Auth::user()->securityLevel >= 50)
                    <li>
                        <a href="{!!URL::to('/articulos/import')!!}"><i class='fa fa-cloud-upload fa-fw'></i> Importar</a>
                    </li>
                @endif

                </ul>
            </li>
@endif

{{--Los reportes lo ven Jefe o mayor--}}
@if (Auth::user()->securityLevel >= 30)
            <li>
                <a href="#"><i class="fa fa-table fa-fw"></i> Reportes<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/reportes/articulos')!!}"><i class='fa fa-th-list fa-fw'></i> Maestro de articulos</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/reportes/articulosPorAlmacenAlt')!!}"><i class='fa fa-list-ol fa-fw'></i> Artículos por almacén</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/reportes/movimientosPorAlmacen')!!}"><i class='fa fa-arrows fa-fw'></i> Movimientos por Almacén</a>
                    </li>
                    <li>
                        <a href="{!!URL::to('/reportes/movimientosPorTicket')!!}"><i class='fa fa-ticket fa-fw'></i> Movimientos por Ticket</a>
                    </li>
{{--
                    <li>
                        <a href="{!!URL::to('/reportes/movimientosPorUsuario')!!}"><i class='fa fa-users fa-fw'></i> Movimientos por Usuario</a>
                    </li>
--}}
                    <li>
                        <a href="{!!URL::to('/reportes/buscarEquipo')!!}"><i class='fa fa-search fa-fw'></i> Buscar Equipo por MAC</a>
                    </li>
                </ul>
            </li>
@endif
@if (Auth::user()->securityLevel >= 50)
            <li>
                <a href="#"><i class="fa fa-cogs fa-fw"></i> Configuración<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{!!URL::to('/ajustes/actualizarArticulosActivos')!!}"><i class='fa fa-shield fa-fw'></i> Actualizar Artículos Activos</a>
                    </li>
                </ul>
            </li>
@endif
        </ul>
    </div>
</div>
