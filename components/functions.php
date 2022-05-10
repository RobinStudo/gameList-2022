<?php
// TODO - A supprimer après la refonte de la page
function average(array $array, int $precision = 1): float
{
    $avg = array_sum($array) / count($array);
    return round($avg, $precision);
}

// ----- Database Quieres -----
function findGames(): array
{
    global $db;

    $query = <<<SQL
        SELECT 
            game.id, game.title, game.poster, 
            IFNULL(GROUP_CONCAT(genre.name SEPARATOR " - "), "Non connu") AS genre, 
            COUNT(review.game_id) AS counterRecommandation 
        FROM game
            LEFT JOIN review ON game.id = review.game_id AND review.is_recommanded = 1
            LEFT JOIN game_genre ON game.id = game_genre.game_id
            LEFT JOIN genre ON game_genre.genre_id = genre.id
        GROUP BY game.id;
    SQL;

    $stmt = $db->query($query);
    return $stmt->fetchAll();
}

// ----- Utils -----

function getDefaultGamePoster(): string
{
    return 'https://www.onlylondon.properties/application/modules/themes/views/default/assets/images/image-placeholder.png';
}

