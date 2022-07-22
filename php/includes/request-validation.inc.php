<?php

/**
 * Verifica el tipo de petición (por defecto), la ruta desde donde se hizo la petición y el método usado.
 * @param string $referer      URL del emisor esperada
 * @param string $requestMethod    Método esperado (POST || GET)
 * @param string $requestType Tipo de petición esperada por parte del emisor
 * @return true|false
 */
function validateRequest($referer, $requestMethod = 'POST', $requestType = 'XMLHttpRequest')
{
    return validateRequestedWithServerParameter($requestType)      &&
        validateRefererServerParameter(DOMAIN . $referer)          &&
        validateRequestMethodServerPerameter($requestMethod);
}

/**
 * Verifica que el header HTTP_X_REQUESTED_WITH sea el esperado
 * @param string $requestType Valor de HTTP_X_REQUESTED_WITH esperado para acceder al recurso
 * @return true|false
 */
function validateRequestedWithServerParameter($requestType)
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH'])        &&
        !empty($_SERVER['HTTP_X_REQUESTED_WITH'])       &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == strtolower($requestType);
}

/**
 * Verifica que el parámetro HTTP_REFERER sea el esperado
 * @param string $referer Valor de referer esperado
 * @return true|false
 */
function validateMultipleReferers($referers)
{
    if (
        !isset($_SERVER['HTTP_REFERER']) ||
        empty($_SERVER['HTTP_REFERER'])  ||
        empty($referers)
    ) return false;

    $output = false;

    foreach ($referers as $item) {
        $item = DOMAIN . $item;
        $output =
            $_SERVER['HTTP_REFERER'] == $item ||
            trim(strtok($_SERVER['HTTP_REFERER'], '?')) == $item ? true : false;

        if ($output == true) break;
    }

    return $output;
}

/**
 * Verifica que el parámetro HTTP_REFERER sea el esperado
 * @param string $referer Valor de referer esperado
 * @return true|false
 */
function validateRefererServerParameter($referer)
{
    return isset($_SERVER['HTTP_REFERER'])     &&
        !empty($_SERVER['HTTP_REFERER'])    &&
        ($_SERVER['HTTP_REFERER'] == $referer
            || trim(strtok($_SERVER['HTTP_REFERER'], '?')) == $referer);
}

/**
 * Verifica que el método usado para acceder al script sea el esperado
 * @param string $requestMethod Método usado para acceder al recurso esperado  
 * @return true|false
 */
function validateRequestMethodServerPerameter($requestMethod)
{
    return isset($_SERVER['REQUEST_METHOD'])    &&
        !empty($_SERVER['REQUEST_METHOD'])      &&
        $_SERVER['REQUEST_METHOD'] == $requestMethod;
}

/**
 * Verifica si el host+dominio coincide con el http referer traido.
 * @return true|false
 */
function validateHostServerParameterForHTTPREFERER()
{
    if (isset($_SERVER['HTTP_REFERER'])) {
        $http_referer_arr = explode('/', $_SERVER['HTTP_REFERER']);
        $http_referer_domain =  $http_referer_arr[2] . '/' . $http_referer_arr[3];

        return $http_referer_domain == $_SERVER['HTTP_HOST'] . '/' . explode('/', $_SERVER['SCRIPT_NAME'])[1];
    }
    return false;
}
