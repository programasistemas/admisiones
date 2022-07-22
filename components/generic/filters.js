const filters = document.querySelectorAll(".filters select");

document.getElementById("clearFilters").addEventListener("click", () => {
    filters.forEach((filter) => {
        filter.value = "";
    });
});
