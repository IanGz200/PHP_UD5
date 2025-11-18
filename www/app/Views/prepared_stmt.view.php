<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/prepared">
                <input type="hidden" name="order" value="<?php echo $order; ?>"/>
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
                                        value="<?php echo $input['username'] ?? ''; ?>"/>
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
                                <label for="paises">Países:</label>
                                <select
                                        name="paises[]"
                                        id="paises"
                                        class="form-control select2"
                                        data-placeholder="Pais"
                                        multiple
                                >
                                    <option value="">-</option>
                                    <?php foreach ($paises as $pais) { ?>
                                        <option <?php
                                        echo isset($_GET['paises']) && in_array($pais['country_name'], $_GET['paises'])
                                                ? 'selected' : ''; ?>
                                                value="<?php echo $pais['country_name']; ?>"
                                        ><?php echo ucfirst($pais['country_name']); ?></option>
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
                                                value="<?php
                                                echo isset($input['min_salario']) && $input['min_salario'] !== ""
                                                        ? $input['min_salario'] : '' ?>"
                                                placeholder="<?php
                                                echo isset($input['min_salario']) && $input['min_salario'] !== ""
                                                        ? $input['min_salario'] : 'Salarío Mínimo' ?>"/>
                                    </div>
                                    <div class="col-6">
                                        <input
                                                type="text"
                                                class="form-control"
                                                name="max_salario"
                                                id="max_salario"
                                                value="<?php
                                                echo isset($input['max_salario']) && $input['max_salario'] !== ""
                                                        ? $input['max_salario'] : '' ?>"
                                                placeholder="<?php
                                                echo isset($input['max_salario']) && $input['max_salario'] !== ""
                                                        ? $input['max_salario'] : 'Salario Máximo' ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="retencion">Retención:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input
                                                type="text"
                                                class="form-control"
                                                name="min_retencion"
                                                id="min_retencion"
                                                value="<?php
                                                echo isset($input['min_retencion']) && $input['min_retencion'] !== ""
                                                        ? $input['min_retencion'] : '' ?>"
                                                placeholder="<?php
                                                echo isset($input['min_retencion']) && $input['min_retencion'] !== ""
                                                        ? $input['min_retencion'] : 'Retención Mínima' ?>"/>
                                    </div>
                                    <div class="col-6">
                                        <input
                                                type="text"
                                                class="form-control"
                                                name="max_retencion"
                                                id="max_retencion"
                                                value="<?php
                                                echo isset($input['max_retencion']) && $input['max_retencion'] !== ""
                                                        ? $input['max_retencion'] : '' ?>"
                                                placeholder="<?php
                                                echo isset($input['max_retencion']) && $input['max_retencion'] !== ""
                                                        ? $input['max_retencion'] : 'Retención Máxima' ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/prepared" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
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
                        <th><a href="<?php echo $url ?>&order=<?php echo $order === 1 ? '-' : '' ?>1">
                                Nombre de usuario <?php echo abs($order) === 1 ? '<i class="fas fa-sort-amount-' .
                                        (($order < 0) ? 'up' : 'down') . '-alt"></i>' : ''; ?></a>
                        </th>
                        <th>
                            <a href="<?php echo $url ?>&order=<?php echo $order === 2 ? '-' : '' ?>2">
                                Rol <?php echo abs($order) === 2 ? '<i class="fas fa-sort-amount-' .
                                        (($order < 0) ? 'up' : 'down') . '-alt"></i>' : ''; ?></a>
                        </th>
                        <th>
                            <a href="<?php echo $url ?>&order=<?php echo $order === 3 ? '-' : '' ?>3">
                                Salario <?php echo abs($order) === 3 ? '<i class="fas fa-sort-amount-' .
                                        (($order < 0) ? 'up' : 'down') . '-alt"></i>' : ''; ?></a>
                        </th>
                        <th>
                            <a href="<?php echo $url ?>&order=<?php echo $order === 4 ? '-' : '' ?>4">
                                IRPF <?php echo abs($order) === 4 ? '<i class="fas fa-sort-amount-' .
                                        (($order < 0) ? 'up' : 'down') . '-alt"></i>' : ''; ?></a>
                        </th>
                        <th>
                            <a href="<?php echo $url ?>&order=<?php echo $order === 5 ? '-' : '' ?>5">
                                Nacionalidad <?php echo abs($order) === 5 ? '<i class="fas fa-sort-amount-' .
                                        (($order < 0) ? 'up' : 'down') . '-alt"></i>' : ''; ?></a>
                        </th>
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
                            <td><?php echo $trabajador['country_name'] ?></td>

                        </tr>
                    <?php } ?>
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