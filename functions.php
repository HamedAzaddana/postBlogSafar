<?php

use App\Factories\ModelFactory;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;
use Symfony\Component\Security\Csrf\CsrfToken;
use Dotenv\Dotenv;

if (!function_exists("redirect")) {
    function redirect($route)
    {
        header("Location: $route");
        die;
    }
}

if (!function_exists("env_app")) {
    function env_app($key, $default = "")
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/');
        $dotenv->load();
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists("view")) {
    function view($path, $compact = [], $layoutPath = '', $title = '')
    {
        ob_start();
        extract($compact);
        require_once __DIR__ . "/app/Views/" . $path . ".php";
        $output = ob_get_clean();
        if (!$layoutPath) {
            return $output;
        } else {
            $contentViewPath =  $output;
            $titlePage =  $title;
            unset($output);
            unset($title);
            require_once __DIR__ . "/app/Views/" . $layoutPath . ".php";
        }
    }
}
if (!function_exists("request")) {
    function request($key, $default = "")
    {
        return !empty($_REQUEST[$key]) ? htmlspecialchars(trim($_REQUEST[$key])) : $default;
    }
}
if (!function_exists("session_put")) {
    function session_put($key, $value)
    {
        $_SESSION[$key] = json_encode($value);
    }
}
if (!function_exists("session_get")) {
    function session_get($key, $default = "")
    {
        return @$_SESSION[$key] ? (array)json_decode($_SESSION[$key]) : $default;
    }
}

if (!function_exists("__ec")) {
    function __ec($var)
    {
        echo htmlspecialchars($var);
    }
}
if (!function_exists("load_file")) {
    function load_file($path)
    {
        $file = __DIR__ . "/public/" . $path;
        if (file_exists($file)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file);
            finfo_close($finfo);
            header("Content-Type: $mimeType");
            echo file_get_contents($file);
        }
    }
}
if (!function_exists("csrf_token")) {
    function csrf_token($key = 'csrf_token')
    {
        $csrfStorage = new NativeSessionTokenStorage();
        $csrfTokenManager = new CsrfTokenManager(null, $csrfStorage);
        $token = $csrfTokenManager->getToken($key)->getValue();
        session_put($key, $token);
        return $token;
    }
}
if (!function_exists("validate_csrf_token")) {
    function validate_csrf_token($token, $key = 'csrf_token')
    {
        $csrfStorage = new NativeSessionTokenStorage();
        $csrfTokenManager = new CsrfTokenManager(null, $csrfStorage);
        return $csrfTokenManager->isTokenValid(new CsrfToken($key, $token));
    }
}
if (!function_exists("old_app")) {
    function old_app($key)
    {
        $get = session_get('old_form', []) ? @session_get('old_form', [])[$key] : "";
        return $get;
    }
}
if (!function_exists("set_old_app")) {
    function set_old_app()
    {
        session_put('old_form', $_REQUEST);
    }
}
if (!function_exists("factory_model_instance")) {
    function factory_model_instance($case)
    {
        switch ($case) {
            case 'user':
                return (new ModelFactory())->createUserModel();
                break;
            case 'post':
                return (new ModelFactory())->createPostModel();
                break;
            default:
                return null;
                break;
        }
    }
}
