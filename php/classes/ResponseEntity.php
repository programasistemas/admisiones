<?php

class ResponseEntity
{
    private $message;
    private $extras;
    private $expired;
    private $status;

    /**
     * Create a ResponseEntity object
     * @param boolean $ajax_request The response is generated or not for an ajax request
     * @param boolean $executable The response should be executed in the same constructor
     */
    public function __construct($ajax_request = true, $executable = true)
    {
        $this->status = '';
        $this->message = '';
        $this->extras = [];
        $this->expired = self::verifySessionStatus($executable, $ajax_request);

        if ($executable && $this->expired) {
            self::error('Su sesión ha caducado, <b>en breve serás redireccionado a la página de login para actualizar la sesión.</b>');
        }
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setExtras($extras)
    {
        $this->extras = $extras;
    }

    public function error($message, $extras = [])
    {
        $this->status = 'error';
        $this->message = $message;
        $this->extras = $extras;

        self::execute();
    }

    public function ok($message, $extras = [])
    {
        $this->status = 'success';
        $this->message = $message;
        $this->extras = $extras;

        self::execute();
    }

    public function execute()
    {
        header('Content-type: application/json');
        echo json_encode([
            'status'        => $this->status,
            'message'       => $this->message,
            'extras'        => $this->extras,
            'expired'       => $this->expired
        ]);

        exit;
    }

    /**
     * Verifica que exista una sesión y que esta sea válida
     * @return boolean
     */
    public static function verifySessionStatus($executable = true, $ajax_request = false)
    {
        define('ACTIVITY_EXPIRATION_TIME', 3600); // 1 hour
        define('CREATION_EXPIRATION_TIME', 600); // 10 minutes

        if (!isset($_SESSION)) session_start();

        // Check for the user status and login status
        if (
            !isset($_SESSION['USER_LOGIN_STATUS']) ||
            $_SESSION['USER_LOGIN_STATUS'] != 1    ||

            (isset($_SESSION['LAST_ACTIVITY']) &&
                (time() - $_SESSION['LAST_ACTIVITY'] > ACTIVITY_EXPIRATION_TIME))
        ) {
            if ($executable) {
                session_unset();
                session_destroy();
                $domain = explode('/', $_SERVER['SCRIPT_NAME'])[1];

                if ($ajax_request == false) {
                    header('Location:  ' . '/' . $domain . '/modules/login');
                    exit;
                }
            }

            return true;
        }

        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > CREATION_EXPIRATION_TIME) {
            session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
            $_SESSION['CREATED'] = time();  // update creation time
        }

        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
        return false;
    }
}
