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

/**
 * Remplace les URLs placeholder par une image locale
 * @param string $imageUrl URL de l'image
 * @return string URL locale de l'image ou placeholder par défaut
 */
function getImageUrl($imageUrl) {
    // Si l'URL est vide ou null
    if (empty($imageUrl)) {
        return BASE_URL . '/inc/img/placeholder/default.svg';
    }
    
    // Patterns de placeholder détectés
    $placeholderPatterns = [
        '/\?text=/',  // via.placeholder.com, placeholder.com
        '/via\.placeholder\.com/',
        '/placeholder\.com/',
        '/lorempicsum/',
    ];
    
    foreach ($placeholderPatterns as $pattern) {
        if (preg_match($pattern, $imageUrl)) {
            return BASE_URL . '/inc/img/placeholder/default.svg';
        }
    }
    
    return $imageUrl;
}

/**
 * Génère un slug SEO-friendly à partir d'un titre
 * @param string $title Titre de l'article
 * @return string Slug pour URL (ex: "titre-de-larticle")
 */
function generateSlug($title) {
    // Convertir en minuscules
    $slug = strtolower($title);
    
    // Remplacer les caractères accentués
    $replacements = [
        'à' => 'a', 'â' => 'a', 'ä' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'î' => 'i', 'ï' => 'i',
        'ô' => 'o', 'ö' => 'o',
        'û' => 'u', 'ü' => 'u',
        'ç' => 'c',
        'œ' => 'oe',
        'æ' => 'ae'
    ];
    
    foreach ($replacements as $from => $to) {
        $slug = str_replace($from, $to, $slug);
    }
    
    // Remplacer les caractères spéciaux par des tirets
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    
    // Supprimer les tirets en début/fin
    $slug = trim($slug, '-');
    
    // Limiter la longueur
    $slug = substr($slug, 0, 50);
    
    return $slug;
}
?>
