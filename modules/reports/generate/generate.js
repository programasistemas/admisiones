const form = document.getElementById("generalReportForm"),
    selectAllFieldsButton = document.getElementById("selectAllFields"),
    fields = document.querySelectorAll('#fields input[type="checkbox"]'),
    exportXLSX = document.getElementById("exportXlsx");

const submitForm = () => {
    form.submit();
};

selectAllFieldsButton.addEventListener("click", function () {
    fields.forEach((field) => {
        field.checked = Boolean(this.checked);
    });
});

exportXLSX.addEventListener("click", submitForm);
