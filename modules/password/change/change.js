import FormValidation from "../../../components/form/form.js";
import {
    fetchUrl,
    createSpinner,
    createAlert,
    handleGenericResponse,
} from "../../../components/generic/helpers.js";

const showPassButton = document.getElementById("showPassword"),
    spinner = createSpinner("double-loader"),
    password = document.getElementById("password"),
    validation = FormValidation(
        {
            formId: "changePasswordForm",
            formControls: "custom-form-control",
            DOMItems: [
                {
                    id: "password",
                    feedbackMessage:
                        "La contraseña no cumple con los requisitos mínimos",
                    validation: "password",
                },
            ],
        },
        expressions
    );

validation.init();

showPassButton.addEventListener("click", function () {
    password.type = this.checked ? "text" : "password";
});

validation.getFormDOMReference().addEventListener("submit", function (e) {
    e.preventDefault();
    if (validation.objValidation()) return;
    const data = new FormData(this);

    Swal.fire({
        title: "Confirmar nueva contraseña",
        text: "A continuación confirma tu nueva contraseña: ",
        icon: "info",
        input: "password",
        confirmButtonColor: "#a5dc86",
        confirmButtonText: "Confirmar",
        preConfirm: (text) => {
            return text;
        },
    }).then((result) => {
        if (result.isDenied) return;
        if (result.value != password.value) {
            createAlert({ text: "Las contraseñas no coinciden" }, "error");
            return;
        }

        document.body.appendChild(spinner);
        data.append("passwordConfirmation", result.value);

        fetchUrl("change.php", data).then((response) => {
            handleGenericResponse(response, spinner);
        });
    });
});
