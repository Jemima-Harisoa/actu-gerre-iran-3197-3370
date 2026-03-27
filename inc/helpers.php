<?php
/**
 * Fonctions utilitaires globales
 */

/**
 * Calcule et retourne le temps écoulé depuis une date
 * @param string $date Date au format Y-m-d H:i:s
 * @return string Texte du temps écoulé (ex: "il y a 2 jours")
 */
function getTimeAgo($date) {
    $timestamp = strtotime($date);
    $currentTime = time();
    $elapsed = $currentTime - $timestamp;
    
    // Moins d'une minute
    if ($elapsed < 60) {
        return 'à l\'instant';
    }
    
    // Moins d'une heure
    if ($elapsed < 3600) {
        $minutes = floor($elapsed / 60);
        return 'il y a ' . $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    }
    
    // Moins d'un jour
    if ($elapsed < 86400) {
        $hours = floor($elapsed / 3600);
        return 'il y a ' . $hours . ' heure' . ($hours > 1 ? 's' : '');
    }
    
    // Moins d'une semaine
    if ($elapsed < 604800) {
        $days = floor($elapsed / 86400);
        return 'il y a ' . $days . ' jour' . ($days > 1 ? 's' : '');
    }
    
    // Moins d'un mois (30 jours)
    if ($elapsed < 2592000) {
        $weeks = floor($elapsed / 604800);
        return 'il y a ' . $weeks . ' semaine' . ($weeks > 1 ? 's' : '');
    }
    
    // Moins d'un an
    if ($elapsed < 31536000) {
        $months = floor($elapsed / 2592000);
        return 'il y a ' . $months . ' mois';
    }
    
    // Plus d'un an
    $years = floor($elapsed / 31536000);
    return 'il y a ' . $years . ' an' . ($years > 1 ? 's' : '');
}

/**
 * Formate une date au format français lisible
 * @param string $date Date au format Y-m-d H:i:s
 * @return string Date formatée (ex: "27 mars 2026 à 14h32")
 */
function formatDateFr($date) {
    $timestamp = strtotime($date);
    
    $months = [
        'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
    ];
    
    $day = date('d', $timestamp);
    $month = $months[date('n', $timestamp) - 1];
    $year = date('Y', $timestamp);
    $time = date('H\\hi', $timestamp);
    
    return $day . ' ' . $month . ' ' . $year . ' à ' . $time;
}

/**
 * Échappe et affiche un texte HTML en sécurité
 * @param mixed $text Texte à afficher
 * @return void
 */
function eh($text) {
    echo htmlspecialchars($text);
}
?>
