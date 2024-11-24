<!-- Modal Acceso a Módulos-->
<div class="modal fade" id="ModalModulos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><b>Acceso a Módulos</b></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row centrar">
                    <div class="col-md-6">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Usuarios">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Categorias">Categorías</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Proveedores">Proveedores</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Productos">Productos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Compras">Compras</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Ventas">Ventas</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Clientes">Clientes</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btnAdmin Panel-Empleados">Empleados</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Insert y Update-->
<div class="modal fade" id="Modal-IU" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div id="mimodal" class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><b id="titulo-header-IU"></b></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="Data-IU">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><b>Cancelar</b></button>
                <a class="btn btm-sm btn-success" id="Acciones-IU"><b id="btn-accion-IU"></b></a>
            </div>
        </div>
    </div>
</div>