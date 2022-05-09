SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

INSERT INTO `company` (`id`, `name`, `slug`, `logo`) VALUES
                                                         (1, 'Ubisoft', 'ubisoft', NULL),
                                                         (2, 'Epic Games', 'epic-games', NULL),
                                                         (3, 'Electronic Arts', 'electronic-arts', NULL),
                                                         (4, 'Mediatonic', 'mediatonic', NULL),
                                                         (5, 'Hazelight Studios', 'hazelight-studios', NULL),
                                                         (6, 'Respawn Entertainment', 'respawn-entertainment', NULL),
                                                         (7, 'Pine Studio', 'pine-studio', NULL),
                                                         (8, 'LucasArts', 'lucas-arts', NULL),
                                                         (9, 'Raven Software', 'raven software', NULL),
                                                         (10, 'Vicarious Visions', 'vicarious-vsions', NULL),
                                                         (11, 'BioWare', 'bioware', NULL);

INSERT INTO `developer` (`game_id`, `company_id`) VALUES
                                                      (1, 4),
                                                      (2, 5),
                                                      (3, 6),
                                                      (4, 7),
                                                      (5, 9),
                                                      (5, 10),
                                                      (6, 11);

INSERT INTO `game` (`id`, `title`, `slug`, `released_at`, `description`, `poster`, `main_id`, `editor_id`, `licence_id`) VALUES
                                                                                                                             (1, 'Fall Guys', 'fall-guys', '2020-08-04', NULL, NULL, NULL, 2, NULL),
                                                                                                                             (2, 'It Takes Two', 'it-takes-two', '2021-03-26', NULL, NULL, NULL, 3, NULL),
                                                                                                                             (3, 'Star Wars Jedi: Fallen Order', 'star-wars-jedi-fallen-order', '2019-11-15', NULL, NULL, NULL, 3, 1),
                                                                                                                             (4, 'Escape Simulator', 'escape-simulator', '2021-10-19', NULL, NULL, NULL, NULL, NULL),
                                                                                                                             (5, 'Star Wars Jedi Knight: Jedi Academy', 'star-wars-jedi-knight-jedi-academy', '2003-09-13', NULL, NULL, NULL, 8, 1),
                                                                                                                             (6, 'Mass Effect', 'mass-effect', '2008-05-28', NULL, NULL, NULL, 11, 3);

INSERT INTO `game_genre` (`game_id`, `genre_id`) VALUES
                                                     (1, 4),
                                                     (2, 1),
                                                     (2, 2),
                                                     (3, 1),
                                                     (3, 3),
                                                     (4, 5),
                                                     (5, 3),
                                                     (5, 6),
                                                     (6, 3),
                                                     (6, 7);

INSERT INTO `game_platform` (`game_id`, `platform_id`) VALUES
                                                           (1, 1),
                                                           (1, 4),
                                                           (2, 1),
                                                           (2, 2),
                                                           (2, 3),
                                                           (3, 1),
                                                           (4, 1),
                                                           (5, 1),
                                                           (5, 4),
                                                           (6, 1);

INSERT INTO `game_tag` (`tag_id`, `game_id`) VALUES
                                                 (1, 1),
                                                 (1, 5),
                                                 (2, 3),
                                                 (2, 5);

INSERT INTO `genre` (`id`, `name`, `slug`) VALUES
                                               (1, 'Aventure', 'aventure'),
                                               (2, 'Plateforme', 'plateforme'),
                                               (3, 'Action', 'action'),
                                               (4, 'Adresse', 'adresse'),
                                               (5, 'Puzzle', 'puzzle'),
                                               (6, 'FPS', 'fps'),
                                               (7, 'RPG', 'rpg');

INSERT INTO `licence` (`id`, `name`, `slug`) VALUES
                                                 (1, 'Star Wars', 'star-wars'),
                                                 (2, 'Harry Potter', 'harry-potter'),
                                                 (3, 'Mass Effect', 'mass-effect'),
                                                 (4, 'Call of Duty', 'call-of-duty');

INSERT INTO `platform` (`id`, `name`, `slug`, `icon`) VALUES
                                                          (1, 'PC', 'pc', 'fa-solid fa-computer'),
                                                          (2, 'Playstation 5', 'ps5', 'fa-brands fa-playstation'),
                                                          (3, 'Xbox Series', 'xbox-series', 'fa-brands fa-xbox'),
                                                          (4, 'Nintendo Switch', 'switch', NULL);

INSERT INTO `tag` (`id`, `name`, `slug`) VALUES
                                             (1, 'Multijoueur', 'multiplayer'),
                                             (2, 'Solo', 'solo'),
                                             (3, 'Ecran partagé', 'split-screen');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
