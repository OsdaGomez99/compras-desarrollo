<ul class="nav nav-primary">

    <!--SOLICITUDES-->
    <li class="nav-item active">
        <a class="bg-info" data-toggle="collapse" href="#sol" class="collapsed" aria-expanded="false">
            <i class="icon-docs"></i>
            <p>Solicitudes</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="sol">
            <ul class="nav nav-collapse">
                <li class="nav-section">
                    <a href="{{route('requisiciones.index')}}">
                        <i class="fas fa-tasks"></i>
                        <p>Requisiciones</p>
                    </a>
                </li>
                <li class="nav-section">
                    <a href="{{route('cotizaciones.index')}}">
                        <i class="fas fa-money-bill"></i>
                        <p>Cotizaciones</p>
                    </a>
                </li>
                <li class="nav-section">
                    <a href="{{route('ofertas.index')}}">
                        <i class="fas fa-tags"></i>
                        <p>Ofertas de Proveedor</p>
                    </a>
                </li>
                <li class="nav-section">
                    <a href="{{route('compras.index')}}">
                        <i class="fas fa-cart-plus"></i>
                        <p>Compras</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!--CATÁLOGOS-->
    <li class="nav-item active">
        <a class="bg-info" data-toggle="collapse" href="#cat" class="collapsed" aria-expanded="false">
            <i class="icon-book-open"></i>
            <p>Catálogos</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="cat">
            <ul class="nav nav-collapse">
                <li class="nav-section">
                    <a href="{{route('articulos.index')}}">
                        <i class="fas fa-cubes"></i>
                        <p>Artículos</p>
                    </a>
                </li>
                <li class="nav-section">
                    <a href="{{route('lineas.index')}}">
                        <i class="fas fa-layer-group"></i>
                        <p>Líneas</p>
                    </a>
                </li>
                <li class="nav-section">
                    <a href="{{route('proveedores.index')}}">
                        <i class="fas fa-users"></i>
                        <p>Proveedores</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!--ADMINISTRADOR DE REPORTES-->
    <li class="nav-item active">
        <a class="bg-info" data-toggle="collapse" href="#admin" class="collapsed" aria-expanded="false">
            <i class="icon-folder-alt"></i>
            <p>Actas</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="admin">
            <ul class="nav nav-collapse">
                <li class="nav-section">
                    <a href="{{route('modificaciones.index')}}">
                        <i class="fas fa-retweet"></i>
                        <p>Modificación/Anulación <br> de Compras</p>
                    </a>
                </li>
                <li class="nav-section">
                    <a href="{{route('evaluacionesprov.index')}}">
                        <i class="fas fa-edit"></i>
                        <p>Evaluación de Proveedores</p>
                    </a>
                </li>
            </ul>
        </div>
    </li>

</ul>
