import FormValidation from "../../components/form/form.js";
import {
    createSpinner,
    fetchUrl,
    handleGenericResponse,
} from "../../components/generic/helpers.js";

const spinner = createSpinner("double-loader"),
    validation = FormValidation(
        {
            formId: "loginForm",
            formControls: "custom-form-control",
            DOMItems: [
                {
                    id: "email",
                    feedbackMessage:
                        "Ingresa un email válido ej: example@example.com",
                    validation: "email",
                },
                {
                    id: "password",
                    validation: "notEmpty",
                    feedbackMessage: "Ingresa una contraseña",
                },
            ],
        },
        expressions
    );

validation.init();

document.getElementById("showPassword").addEventListener("click", function () {
    document.getElementById("password").type = this.checked
        ? "text"
        : "password";
});

validation.getFormDOMReference().addEventListener("submit", function (e) {
    e.preventDefault();
    document.body.appendChild(spinner);
    if (validation.objValidation()) return;

    fetchUrl("login.php", new FormData(this)).then((response) => {
        handleGenericResponse(response, spinner);
    });
});
