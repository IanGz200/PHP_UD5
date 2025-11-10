<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/prepared">
                <input type="hidden" name="order" value="1"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="username"
                                        id="username"
                                        value="<?php echo $input['username'] ?? ''; ?>" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="rol">Rol:</label>
                                <select
                                        name="rol"
                                        id="rol"
                                        class="form-control"
                                        data-placeholder="Rol"
                                        >
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                    <option <?php echo isset($_GET['rol']) && $_GET['rol'] == $rol['nombre_rol'] ? 'selected' : ''; ?>
                                            value="<?php echo $rol['nombre_rol']; ?>"
                                            ><?php echo ucfirst($rol['nombre_rol']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="salario">Salario:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input
                                                type="text"
                                                class="form-control"
                                                name="min_salario"
                                                id="min_salario"
                                                value=""
                                                placeholder="Salario Mí­nimo" />
                                    </div>
                                    <div class="col-6">
                                        <input
                                                type="text"
                                                class="form-control"
                                                name="max_salario"
                                                id="max_salario"
                                                value=""
                                                placeholder="Salario Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="retencion">Retención:</label>
                                <input type="number" class="form-control" name="retencion" id="retencion" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="card shadow mb-4">

            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
            </div>

            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <thead>
                    <tr>
                        <th><a href="/consultas?order=1">Username</a></th>
                        <th><a href="/consultas?order=5">Rol</a></th>
                        <th><a href="/consultas?order=2">Salario Bruto</a></th>
                        <th><a href="/consultas?order=3">Retencion IRPF</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($trabajadores as $trabajador) { ?>
                        <tr class="">
                            <td><?php echo $trabajador['username'] ?></td>
                            <td><?php echo ucfirst($trabajador['nombre_rol']) ?></td>
                            <td><?php echo number_format($trabajador['salarioBruto'], 2, ',', '.') ?></td>
                            <td><?php echo $trabajador['retencionIRPF'] ?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="/consultas?page=1&order=1" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/consultas?page=2&order=1" aria-label="Previous">
                                <span aria-hidden="true">&lt;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <li class="page-item active"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="/consultas?page=4&order=1" aria-label="Next">
                                <span aria-hidden="true">&gt;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/consultas?page=8&order=1" aria-label="Last">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->