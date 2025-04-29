<?php
require_once 'controllers/ErrorController.php';

class App {
    function __construct() {

        // Obtenemos todo lo que venga después de localhost/dss/mvc y validamos que si el campo viene vacío este será null
        $url = isset($_GET["url"]) ? $_GET["url"] : null;

        // Limpiamos la url para evitar parámetros como localhost/dss/mvc//////Controller
        $url = rtrim($url, '/');

        // Convertimos a un arreglo todo lo que venga después de la raíz del proyecto
        $url = explode('/', $url);

        if (empty($url[0])) {
            // Creamos la url para invocar el archivo del controlador
            $archivoController = 'controllers/MainController.php';
            require_once($archivoController);
            $controller = new MainController();
            return false;
        }

        // Creamos la url para invocar el archivo del controlador
        $archivoController = 'controllers/' . $url[0] . '.php';

        // Validamos que el archivo exista
        if (file_exists($archivoController)) {
            // Invocamos el archivo con el controlador
            require_once $archivoController;

            // Instanciamos la clase del controlador
            $controller = new $url[0];

            if (isset($url[1])) {
                // Aquí invocaremos a las acciones o funciones de cada controller
                $controller->{$url[1]}();
            }
        } else {
            // De lo contrario invocamos al controller de error
            $controller = new ErrorController();
        }
    }
}
?>
