import FormValidation from "../../../components/form/form.js";
import {
    fetchUrl,
    createSpinner,
    handleGenericResponse,
} from "../../../components/generic/helpers.js";

const spinner = createSpinner("double-loader"),
    validation = FormValidation(
        {
            formId: "confirmPasswordForm",
            formControls: "custom-form-control",
            DOMItems: [
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
validation.getFormDOMReference().addEventListener("submit", function (e) {
    e.preventDefault();
    if (validation.objValidation()) return;
    document.body.appendChild(spinner);

    fetchUrl("confirm.php", new FormData(this)).then((response) => {
        handleGenericResponse(response, spinner);
    });
});
