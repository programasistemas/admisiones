export const ATTR_EVENT = "ev-action";

//Constantes para trabajar dentro de los modulos:
export const HOST = window.location.host;
export const ROOT_DIRECTORY = window.location.pathname.split("/")[1];
export const MAIN_PATH = "/" + ROOT_DIRECTORY + "/";

//Filtra el arreglo pasado modificando su estructura.
//Filtra de acuerdo al callback que se le pase, si dicho callback retorna false esa posición se elimina
export function filter(arr, callback) {
    for (let i = 0, tam = arr.length; i < tam; i++)
        if (!callback(arr[i])) arr.splice(i, 1);
}

/**
 * Abre una ventana para observar un archivo.
 * @param string url ruta del proyecto empezando por una carpeta después de la ruta raiz assets/....
 */
export function showFile(url) {
    window.open(MAIN_PATH + url);
}

//Controlador general de eventos creados por medio del atributo diseñado ev-action:
export function controllerEvent(objHTML, arrayErrors, evt = ATTR_EVENT) {
    const INPUT = $(objHTML),
        EVENT = INPUT.attr(evt),
        INFLUENCEDS = $(
            "[" + evt + '="#' + EVENT + "-" + INPUT.attr("id") + '"]'
        );

    let callback,
        args = Array();

    switch (EVENT) {
        case "changeVisibleDataInverse":
            callback = INPUT.prop("checked") ? hideData : showData;
            args = [INFLUENCEDS, arrayErrors];
            break;

        case "changeVisibleData":
            callback = INPUT.prop("checked") ? showData : hideData;
            args = [INFLUENCEDS, arrayErrors];
            break;

        default:
            throw (
                new "Falta declarar el evento "() +
                EVENT +
                " en export_helpers.js > controllerEvents"
            );
    }

    callback(...args);
    //console.log(arrayErrors);
}

///--- private functions:

export function showData(inputs, arrayErrors) {
    inputs.each((i, obj) => {
        let input = $(obj);
        if (input.prop("tagName") == "DIV") input.show();
        else input.parent().show();

        if (typeof arrayErrors != "undefined" && !obj.hasAttribute("no-error"))
            arrayErrors.push(obj.getAttribute("id"));
    });
}

export function hideData(inputs, arrayErrors) {
    inputs.each((i, obj) => {
        let input = $(obj);
        let parent = input.parent();
        let id = input.attr("id");

        input.val("");
        $('input[name="' + id + '"]').val("");

        //Eliminamos la validación:
        if (typeof arrayErrors != "undefined")
            filter(arrayErrors, (val) => val != id);
        switch (input.prop("tagName")) {
            case "SELECT":
                parent.hide();
                let optionSelected = input.find('option[data-value=""]');
                if (!optionSelected.length)
                    optionSelected = input.find("option[data-value=0]");

                input.val(optionSelected.text());
                optionSelected.attr("selected", true);
                parent.removeClass(
                    "checked-valid border-success alert-valid border-danger"
                );
                break;

            case "INPUT":
                parent.hide();
                switch (input.attr("type")) {
                    case "text":
                        //Dejamos reiniciado los valores:
                        if (!obj.hasAttribute("no-disabled"))
                            input.prop("disabled", true);
                        parent.removeClass(
                            "checked-valid border-success alert-valid border-danger"
                        );
                        break;
                    case "file":
                        let div = input.siblings("div");
                        parent.removeClass(
                            "checked-valid border-success alert-valid border-danger"
                        );
                        div.removeClass("btn btn-primary showFile");
                        div.addClass("btn btn-outline-danger saveFile");
                        break;
                    default:
                        throw "No se especifican los cambios para el evento con etiqueta INPUT. Revisar en export_helpers.js > event_hideInput(obj)";
                }
                break;

            case "DIV":
                input.hide();
                break;

            default:
                throw "No se especifica el tipo de etiqueta. Revisar en export_helpers.js > event_hideInput(obj)";
        }
    });
}

//---- Alertas:
/**
 * Create Alert With SweetAlert
 * @param {object} json el contenido del sweet alert que será añadido.
 * @param {string} status valor opcional para agarrar las plantillas, debe ser: success, error, warning, info
 */
export function createAlert(json, status = null, callback = null) {
    let defaultValues = {
        confirmButtonText: "Aceptar",
    };

    if (status !== null) {
        let preValues = {};
        switch (status) {
            case "success":
                preValues = {
                    title: "El proceso ha sido éxitoso",
                    confirmButtonColor: "#a5dc86",
                    customClass: {
                        title: "swalertText-Primary",
                    },
                };
                break;
            case "error":
                preValues = {
                    title: "Ha ocurrido un error!",
                    confirmButtonColor: "#dd3545",
                    customClass: {
                        title: "text-danger",
                    },
                };
                break;
            case "warning":
                preValues = {
                    title: "Tienes una observación!",
                    confirmButtonColor: "#ffc108",
                    customClass: {
                        title: "text-warning",
                    },
                };
                break;

            case "info":
                preValues = {
                    title: "Aviso Importante!",
                    confirmButtonColor: "#3dc3ee",
                    customClass: {
                        title: "text-info",
                    },
                };
                break;
            default:
                throw "No se especifica este tipo de estado en la función";
        }

        if (json.noIcon !== true) preValues.icon = status;
        delete json.noIcon;

        Object.assign(defaultValues, preValues);
    }

    if (json.customClass !== undefined)
        Object.assign(json.customClass, defaultValues.customClass);
    json = Object.assign(defaultValues, json);

    Swal.fire(json).then(callback);
}

//--- Spinners:
/**
 * Crear un spinner de la forma: <span class="tipo-spinner"><span></span></span>
 * @param {string} classObj clase que contendrá el spinner para ser creado.
 * @return {object} objeto creado con la estructura y la clase.
 */
export function createSpinner(classObj) {
    const spinner = document.createElement("span");
    spinner.appendChild(document.createElement("span"));
    spinner.classList.add(classObj);
    return spinner;
}

/**
 * Valida si la respuesta del servidor es un arreglo formato clave=>valor, con un parametro llamado 'expired'
 * @param JSON response, respuesta del servidor.
 */
export function validExpiredSession(response) {
    if (response["expired"]) {
        createAlert(
            {
                title: "Sesión expirada!",
                html: response.msj,
            },
            "error",
            () => (window.location = MAIN_PATH)
        );
        return false;
    }
    return true;
}

/**
 * Realiza una peticion a la url pasada por argumento, usando el metodo, headers y body pasados
 * a la misma.
 *
 * @param string url Url del endpoint
 * @param string method Nombre del metodo mediante el cual se realizara la peticiono
 * @param Headers headers Objesto de tipo Headers con los headers de la peticion
 * @param FormData data Objeto de tipo FormData que contiene los datos para enviar en el cuerpo de la peticion
 * @return Object JSON parseado a objeto nativo de javascript
 */
export async function fetchUrl(
    url,
    data = "",
    method = "POST",
    headers = new Headers({ "X-Requested-With": "XMLHttpRequest" })
) {
    const response = await fetch(url, {
        method: method,
        cache: "no-cache",
        credentials: "same-origin",
        headers: headers,
        body: data,
    }).catch((error) => {
        console.error(error);
    });

    if (response.status === 200) return response.json();
    else throw new Error("La petición no pudo ser realizada correctamente.");
}

// Used to obtain de language configuration
export function getDatatablesLanguageSettings() {
    return {
        decimal: "",
        emptyTable: "No hay registros",
        info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        infoEmpty: "Mostrando 0 a 0 de 0 Entradas",
        infoFiltered: "(Filtrado de _MAX_ total entradas)",
        infoPostFix: "",
        thousands: ",",
        lengthMenu: "Mostrar _MENU_ Entradas",
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        search: "Buscar:",
        zeroRecords: "Sin resultados encontrados",
        paginate: {
            first: "Primero",
            last: "Ultimo",
            next: "Siguiente",
            previous: "Anterior",
        },
    };
}
