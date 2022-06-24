// ------------------------------
// Utility functions

const getDOMItem = (selector, config = {}) => {
    return config["selector"]
        ? document.querySelector(selector)
        : document.getElementById(selector);
};

const getDOMItems = (selector) => document.querySelectorAll(selector);

// ------------------------------

// FormValidation Component
export default function FormValidation(config, expressions) {
    const form = config.formId;
    document.getElementById(form).reset();
    const items = config.DOMItems;

    // -------------------------------
    // Object configuration for properly handling validation

    const submitButton = getDOMItem(`#${form} button[type="submit"]`, {
            selector: true,
        }),
        formControls = getDOMItems(`#${form} .${config.formControls}`),
        formInputs = getDOMItems(`#${form} input, #${form} select`),
        validationObject = Object.fromEntries(
            items.map((item) => [item.id, false])
        );

    Object.preventExtensions(validationObject);

    let validityState = false;

    // -------------------------------

    // -------------------------------
    // Validation functionality

    const validationHandler = (target) => {
        const targetId = target.getAttribute("id"),
            item = items.find((element) => element.id === targetId);

        if (!item) return;

        let validationState;
        const message = item.feedbackMessage,
            value = target.value;

        if (item.customValidation) {
            validationState = item.customValidation(target);
        } else {
            const validation = item.validation;
            console.log(validation);
            validationState =
                validation == "notEmpty"
                    ? !(value === "")
                    : expressions[validation].test(value);
        }

        validationObject[targetId] =
            typeof validationState != "boolean" ? false : validationState;
        validityState = !Object.values(validationObject).includes(false);

        inputStateHandler(target, message, validationState);
        submitButtonStateHandler();
    };

    const inputStateHandler = (input, message, validation) => {
        validation
            ? successfulInputStateHandler(input)
            : inputErrorStateHandler(input, message);
    };

    const inputErrorStateHandler = (input, message) => {
        const formControl = input.parentElement,
            small = formControl.querySelector(".feedback-message");

        small.innerText = message;
        formControl.className = "custom-form-control error";
    };

    const successfulInputStateHandler = (input) => {
        input.parentElement.className = "custom-form-control success";
    };

    const submitButtonStateHandler = () => {
        submitButton.disabled = !validityState;
        validityState
            ? submitButton.classList.remove("disabled")
            : submitButton.classList.add("disabled");
    };

    // -------------------------------

    return {
        init: () => {
            submitButton.disabled = true;

            formInputs.forEach((input) => {
                input.addEventListener("input", (e) => {
                    validationHandler(e.target);
                });

                input.addEventListener("focus", (e) => {
                    validationHandler(e.target);
                });
            });
        },
        getValidityState: () => validityState,
        getFormId: () => form,
        getFormDOMReference: () => getDOMItem(form),
    };
}
