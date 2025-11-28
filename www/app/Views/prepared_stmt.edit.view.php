<?php

declare(strict_types=1);

?>
<div class="card shadow mb-4">
    <form method="post" action="">
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control"
                               name="username" id="username"
                               value="<?php
                                echo $input['username'] ?? ''; ?>"
                               maxlength="50"
                               placeholder="MyUsername"
                        />
                        <p class="text-danger small">
                            <?php
                            echo $errors['username'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label for="salario_bruto">Salario bruto:</label>
                        <input type="text" class="form-control"
                               name="salario_bruto" id="salario_bruto"
                               value="<?php
                                echo isset($input['salarioBruto']) ?
                                       str_replace('.', ',', $input['salarioBruto']) : ''; ?>"
                               maxlength="20"
                               placeholder="3456,60"
                        />
                        <p class="text-danger small">
                            <?php
                            echo $errors['salario_bruto'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label for="retencionIRPF">Retención IRPF:</label>
                        <input type="text" class="form-control"
                               name="retencionIRPF" id="retencionIRPF"
                               value="<?php
                                echo isset($input['retencionIRPF']) ? (int)$input['retencionIRPF'] : ''; ?>"
                               maxlength="3"
                               placeholder="30"
                        />
                        <p class="text-danger small">
                            <?php
                            echo $errors['retencionIRPF'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="mb-3">
                        <label for="id_rol">Rol:</label>
                        <select name="id_rol" id="id_rol" class="form-control select2" data-placeholder="Rol">
                            <option value="">-</option>
                            <?php
                            foreach ($roles as $rol) {
                                ?>
                                <option
                                        value="<?php echo $rol['nombre_rol'] ?>"
                                        <?php echo isset(
                                            $input['id_rol']
                                        ) && $input['id_rol'] == $rol['id_rol'] ?
                                                'selected' : ''; ?>>
                                    <?php echo ucfirst($rol['nombre_rol']) ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <p class="small text-danger"><?php echo $errors['id_rol'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label for="id_country">Países:</label>
                        <select name="id_country" id="id_country" class="form-control select2">
                            <option value="">-</option>
                            <?php foreach ($paises as $pais) { ?>
                                <option <?php
                                echo isset(
                                    $input['id_country']
                                        ) && in_array($pais['country_name'], $input['id_country'])
                                        ? 'selected' : ''; ?>
                                        value="<?php echo $pais['country_name']; ?>"
                                ><?php echo ucfirst($pais['country_name']); ?></option>
                            <?php } ?>
                        </select>
                        <p class="text-danger small"><?php echo $errors['id_country'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label for="activo">Activo:</label>
                        <select name="activo" id="activo" class="form-control">
                            <option value="1" <?php echo isset($input['activo']) && $input['activo'] == 1 ?
                                    'selected' : ''; ?>>Sí</option>
                            <option value="0" <?php echo isset($input['activo']) && $input['activo'] == 0 ?
                                    'selected' : ''; ?>>No</option>
                        </select>
                        <p class="text-danger small"><?php echo $errors['activo'] ?? ''; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <a href="/prepared" class="btn btn-danger">Cancelar</a>
                <input type="submit" value="Guardar" class="btn btn-primary ml-2"/>
            </div>
        </div>
    </form>
</div>
