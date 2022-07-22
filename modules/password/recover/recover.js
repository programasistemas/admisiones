import FormValidation from "../../../components/form/form.js";
import {
    createSpinner,
    handleGenericResponse,
    fetchUrl,
} from "../../../components/generic/helpers.js";

const spinner = createSpinner("double-loader"),
    validation = FormValidation(
        {
            formId: "recoverPasswordForm",
            formControls: "custom-form-control",
            DOMItems: [
                {
                    id: "email",
                    feedbackMessage:
                        "Ingresa un email válido ej: example@example.com",
                    validation: "email",
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
    const data = new FormData(this);
    fetchUrl("recover.php", data).then((response) => {
        handleGenericResponse(response, spinner);
    });
});
