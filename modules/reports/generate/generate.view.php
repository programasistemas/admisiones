<?php global $html_filters, $html_inputs; ?>

<main class="d-flex justify-content-center flex-column align-items-center p-5">
    <div class="w-100 text-center">
        <p class="display-4 mt-3 mb-5 fw-bold px-5">Reporte general</p>
        <form id="generalReportForm" method="POST" action="generate.php">
            <?= $html_filters ?>
            <div id="fields" class="mt-5 card">
                <div class="fs-5 card-header fw-bold text-start d-flex align-items-center px-5 py-3">Campos</div>
                <div class="d-flex justify-content-start mt-5 px-5">
                    <input class="btn-check" type="checkbox" id="selectAllFields" name="selectAllFields" autocomplete="off">
                    <label class="btn btn-outline-primary py-2 px-4 fw-bold" for="selectAllFields">Seleccionar todos los campos</label>
                </div>
                <?= $html_inputs; ?>
            </div>
        </form>
    </div>

    <button id='exportXlsx' class='btn-floating' data-bs-toggle="tooltip" data-bs-placement="top" title="Exportar a EXCEL">
        <i class="fas fa-file-excel fa-2x align-self-end"></i>
    </button>
</main>