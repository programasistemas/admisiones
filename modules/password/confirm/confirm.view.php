<main class="h-100 d-flex justify-content-center align-items-center">
    <form class="submit__form" id="confirmPasswordForm">
        <h1 class="fs-3 fw-bold mb-5">Confirma tu contraseña</h1>
        <div class="custom-form-control">
            <input type="hidden" name="change" value="<?= $_GET['change'] ?>">
            <input class="form__input" type="password" id="password" name="password" placeholder=" " title="Ingresa tu contraseña" required autocomplete="off" />
            <label for="password" class="input__placeholder">Contraseña</label>
            <span class="fas fa-key input-icon"></span>
            <div class="feedback">
                <span class="fas fa-exclamation-triangle error-icon"></span>
                <small class="feedback-message">Default Message</small>
            </div>
        </div>
        <div id="resultContainer" class="d-flex justify-content-center"></div>
        <button type="submit" class="form__btn disabled form__item">
            Confirmar contraseña
        </button>
    </form>
</main>