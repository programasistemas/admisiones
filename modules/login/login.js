const urlArr = window.location.href.split("/");
if (urlArr.pop() == "index.php") {
    location.replace(urlArr.join("/"));
}

import FormValidation from "../../components/form/form.js";
import {
    createSpinner,
    fetchUrl,
    createAlert,
} from "../../components/helpers/helpers.js";

const spinner = createSpinner("spinner_page_load"),
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

    fetchUrl("loginController.php", new FormData(this))
        .then((response) => {
            createAlert({ text: response }, "error");
        })
        .catch((error) => {
            console.error(error);
        });
});
