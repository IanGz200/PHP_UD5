<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <?php
        if (!empty($usuarios)) {
            ?>
            <div class="card shadow mb-4">
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-9"><h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6></div>
                </div>
                <form action="" method="get">
                    <div class="card-body">
                        <!--<form action="./?sec=formulario" method="post">                   -->
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="rol">Rol:</label>
                                    <input type="text" class="form-control" name="rol" id="rol" value=""/>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" name="username" id="username" value=""/>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="nacionalidad">Nacionalidad:</label>
                                    <input type="text" class="form-control" name="nacionalidad" id="nacionalidad"
                                           value=""/>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="retencion">Retención:</label>
                                    <input type="text" class="form-control" name="retencion" id="retencion"
                                           value=""/>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="salar">Salario:</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="min_salar" id="min_salar"
                                                   value=""
                                                   placeholder="Mí­nimo"/>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="max_salar" id="max_salar"
                                                   value=""
                                                   placeholder="Máximo"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-12 text-right">
                            <a href="/Ejercicio-8-1" value="" name="reiniciar" class="btn btn-danger">Reiniciar
                                filtros</a>
                            <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                        </div>
                    </div>
                </form>
                <!-- Card Body -->
                <div class="card-body" id="card_table">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <table id="tabladatos" class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th>Nombre de usuario</th>
                            <th>Salario bruto</th>
                            <th>Retención IRPF</th>
                            <th>Rol</th>
                            <th>Nacionalidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($usuarios as $usuario) {
                            ?>
                            <tr class="<?php echo !$usuario['activo'] ? 'table-danger' : ''; ?>">
                                <td><?php echo $usuario['username'] ?></td>
                                <td><?php echo number_format($usuario['salarioBruto'], 2, ',', '.'); ?></td>
                                <td><?php echo number_format($usuario['retencionIRPF'], 0) ?>%</td>
                                <td><?php echo $usuario['nombre_rol'] ?></td>
                                <td><?php echo $usuario['country_name'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                No hay usuarios que cumplan los requisitos seleccionados
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!--Fin HTML -->