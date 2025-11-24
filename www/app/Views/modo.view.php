<?php

declare(strict_types=1);

?>
<div class="card-shadow mb-4">
<form method="post" action="/modo">
    <input type="hidden" name="order" value="1" />
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <!--<form action="./?sec=formulario" method="post">                   -->
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="mb-3">
                    <label for="modo">Tipo:</label>
                    <select name="modo" id="modo" class="form-control" data-placeholder="modo">
                        <option value="1">Claro</option>
                        <option value="0">Oscuro</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-12 text-right">
            <a href="/modo" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
            <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2" />
        </div>
    </div>
</form>
</div>