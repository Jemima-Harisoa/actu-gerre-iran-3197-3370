<?php
/**
 * helper/Functions.php
 * Fonctions utilitaires pour l'application
 */

/**
 * Récupère URL base de l'application
 */
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'];
}

/**
 * Récupère le répertoire racine
 */
function getRootDir() {
    return dirname(dirname(__FILE__));
}

/**
 * Formate une date en français
 */
function formatDateFr($date) {
    $mois = array(
        'January' => 'janvier',
        'February' => 'février',
        'March' => 'mars',
        'April' => 'avril',
        'May' => 'mai',
        'June' => 'juin',
        'July' => 'juillet',
        'August' => 'août',
        'September' => 'septembre',
        'October' => 'octobre',
        'November' => 'novembre',
        'December' => 'décembre'
    );

    $timestamp = strtotime($date);
    $mois_angl = date('F', $timestamp);
    $mois_fr = $mois[$mois_angl];
    
    return date('d', $timestamp) . ' ' . $mois_fr . ' ' . date('Y', $timestamp);
}

/**
 * Crée un slug à partir d'une string
 */
function createSlug($string) {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

/**
 * Tronque du texte
 */
function truncate($text, $length = 100, $ending = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $ending;
}

/**
 * Nettoie l'entrée utilisateur
 */
function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

/**
 * Récupère le paramètre GET de manière sécurisée
 */
function getGet($key, $default = null) {
    return isset($_GET[$key]) ? sanitizeInput($_GET[$key]) : $default;
}

/**
 * Récupère le paramètre POST de manière sécurisée
 */
function getPost($key, $default = null) {
    return isset($_POST[$key]) ? sanitizeInput($_POST[$key]) : $default;
}

/**
 * Envoie JSON response
 */
function sendJson($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

/**
 * Redirige vers une URL
 */
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

/**
 * Vérifie si une requête est AJAX
 */
function isAjax() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Enregistre un log
 */
function logEvent($message, $level = 'INFO') {
    $timestamp = date('Y-m-d H:i:s');
    $logFile = dirname(__FILE__) . '/../logs/app.log';
    
    if (!is_dir(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    
    file_put_contents($logFile, "[$timestamp] [$level] $message\n", FILE_APPEND);
}

/**
 * Génère un token CSRF (pour formulaires)
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valide un token CSRF
 */
function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

?>
