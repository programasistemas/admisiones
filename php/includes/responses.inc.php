<?php

/**
 * Sends an http_response_code or redirect to an url
 * @param string $url Url to be redirected
 * @param int $httpCode HTTP response code
 */
function httpResponse($url, $httpCode)
{
    if (isset($_SERVER['HTTP_REFERER'])) {
        http_response_code($httpCode);
    } else {
        header("Location: " . $url);
    }

    exit;
}
