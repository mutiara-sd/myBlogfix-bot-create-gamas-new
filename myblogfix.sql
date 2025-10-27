-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 05:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myblogfix`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('captcha_5bf3efd8ed2708c2b8318616702b37e0', 'a:3:{i:0;s:1:\"p\";i:1;s:1:\"p\";i:2;s:1:\"u\";}', 1742865413),
('captcha_b1d5f4df793d1e868981dce8216b5281', 'a:3:{i:0;s:1:\"y\";i:1;s:1:\"f\";i:2;s:1:\"4\";}', 1742865043),
('captcha_b72f69a0d4f886f44a6e3f6b2b35caa0', 'a:3:{i:0;s:1:\"b\";i:1;s:1:\"a\";i:2;s:1:\"h\";}', 1742865108),
('captcha_be3f176c9c58aa7d9b5872d262d32565', 'a:3:{i:0;s:1:\"6\";i:1;s:1:\"4\";i:2;s:1:\"j\";}', 1742865372),
('captcha_e528dc70d04142d6a9509f2f3aeac1fd', 'a:3:{i:0;s:1:\"z\";i:1;s:1:\"m\";i:2;s:1:\"r\";}', 1742865078),
('captcha_e9619651fc1d2cbf9bd51e6eab5802e2', 'a:3:{i:0;s:1:\"7\";i:1;s:1:\"6\";i:2;s:1:\"n\";}', 1742865038),
('otp_cooldown_21', 'i:1744073525;', 1744073525);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Web Design', 'web-design', 'red', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(2, 'Data Structure', 'data-structure', 'blue', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(3, 'Front-End WebDev', 'front-end-webdev', 'yellow', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(4, 'Machine Learning', 'machine-learning', 'green', '2025-03-24 18:06:37', '2025-03-24 18:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `list` int(11) DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `route`, `icon`, `list`, `menu_id`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', '/', 'home', 1, NULL, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(2, 'Apps', '#', 'grid', 2, NULL, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(3, 'Authentication', '#', 'users', 3, NULL, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(4, 'Calendar', '/calendar', NULL, NULL, 2, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(5, 'Chat', '/chat', NULL, NULL, 2, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(6, 'Email', '#', NULL, NULL, 2, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(7, 'Invoices', '#', NULL, NULL, 2, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(9, 'Verify Users', '/admin', NULL, NULL, 3, NULL, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(10, 'Inbox', '/inbox-mail', NULL, NULL, NULL, 6, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(11, 'Read Email', '/read-email', NULL, NULL, NULL, 6, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(12, 'Invoices List', '/invoices-list', NULL, NULL, NULL, 7, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(13, 'Invoices Detail', '/invoices-detail', NULL, NULL, NULL, 7, '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(14, 'Contact', '/contact', NULL, NULL, 2, NULL, '2025-03-26 06:10:45', '2025-03-26 06:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_02_04_032506_create_roles_table', 1),
(4, '2025_02_04_032507_create_users_table', 1),
(5, '2025_02_24_033027_create_categories_table', 1),
(6, '2025_02_24_033034_create_posts_table', 1),
(7, '2025_03_07_024413_create_otps_table', 1),
(8, '2025_03_18_015645_create_menus_table', 1),
(9, '2025_03_24_015923_create_role_menus_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `otp_code` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `telegram_username` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `author_id`, `category_id`, `slug`, `body`, `created_at`, `updated_at`) VALUES
(1, 'Culpa deleniti ipsa expedita repellendus iste.', 4, 4, 'at-repellendus-recusandae-sapiente-voluptas', 'Maxime ut dolor accusamus pariatur. Sit dolores eligendi ut provident numquam officiis. Ea et iusto voluptatem officia perferendis.\n\nNatus et unde et at et. Omnis consequatur est ducimus molestias tempora error vitae. Et odit vel distinctio qui eum dolorem corporis.\n\nQuibusdam fugit quos dolorem recusandae in labore. Eveniet nulla ullam accusamus reprehenderit consequatur voluptatem ipsa fugit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(2, 'Ea a saepe voluptatem consequatur illum.', 2, 2, 'sunt-cupiditate-voluptates-id-provident-dignissimos-consequatur', 'Est quidem voluptatem ipsum quo in. Consectetur aut dolor culpa dignissimos ea nostrum. Odit expedita rerum blanditiis similique illo omnis. Dicta quam quas nulla voluptas eos. Iusto ea dignissimos minus provident id magni quae.\n\nConsequatur laboriosam debitis nihil perferendis sit. Rerum odio veniam delectus rerum. Ratione veniam qui ut expedita quod eos provident.\n\nFugit nihil et eveniet aperiam. Natus voluptas animi voluptatum fuga. Deleniti ut repellat odio iusto qui pariatur velit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(3, 'Ullam qui quis sunt ut voluptatem impedit dolorem.', 8, 4, 'sint-delectus-debitis-facilis-ea-nisi-laboriosam-vel-dolores', 'Eum tempora a molestiae eos. Id sed delectus ea itaque ipsam animi omnis. Qui cum nobis adipisci hic molestiae consequatur.\n\nConsequatur itaque suscipit dolorum ab dolor ducimus occaecati. Minus sed similique ut quas perferendis repellat corporis. Aut ut quis sapiente similique natus.\n\nMolestiae iure distinctio perspiciatis minima vitae placeat ipsum. Et in veniam rerum. Qui dicta qui quia qui ut cupiditate enim. Non sint sapiente deserunt.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(4, 'In ut commodi sunt magni expedita qui ut explicabo.', 1, 3, 'sequi-fugit-ea-et-magnam', 'Non architecto facere et eos eos dolor blanditiis. Consequatur quidem similique voluptas est et quis. Amet voluptas excepturi veniam voluptate ut numquam fugit. Ratione consequatur nemo minus officiis repellendus qui dolores.\n\nFacere voluptatibus autem dolorem quia et. Eaque dolore eaque quas sit id ex omnis. Qui tenetur voluptate aut neque dolor consequatur.\n\nQuisquam aut non ratione consequuntur. Eveniet aliquam et rerum ut. Explicabo eum sit eveniet eum iusto quaerat ratione.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(5, 'Eaque dolorem quaerat et dolores inventore non.', 17, 1, 'iusto-dolor-sed-temporibus-est-officia', 'Beatae blanditiis similique eos non eos. Qui iusto numquam explicabo consequatur et consectetur. Nisi quia commodi rerum perspiciatis nesciunt maiores vero.\n\nEa aut et possimus dicta molestias officiis alias ea. In sequi est iusto. Laudantium nisi quo repudiandae quia numquam rerum molestias eius. Ex esse ratione impedit eos voluptas laudantium. Sit autem dignissimos suscipit sint deserunt asperiores.\n\nIllum eligendi voluptatem dolore ut et. Quasi quis consectetur aut nisi quod dolores. Cumque molestiae ut qui autem dolorem laboriosam. Esse natus aut assumenda quibusdam nostrum.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(6, 'Autem nihil dolores est non.', 15, 3, 'doloribus-sed-labore-sunt', 'Est eaque cupiditate quia dolorem. Laboriosam natus excepturi autem pariatur officia dolore laborum.\n\nDoloremque nihil commodi aut beatae voluptas. Non ratione porro id consequatur qui. Possimus deleniti aliquam omnis sapiente laboriosam. Sit alias doloribus qui consequatur.\n\nQui non ea nam ut. Eaque recusandae culpa ut tempora at. Doloribus occaecati iste excepturi repellendus excepturi velit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(7, 'Nam eos aperiam deserunt magni deserunt aliquam nam.', 10, 2, 'consequuntur-blanditiis-dicta-in-ut', 'Dolore harum et soluta quam natus eius rem. Dolorem repellat quaerat voluptas architecto mollitia iste. Odit exercitationem aut quia repellendus. Voluptatem aut animi nihil necessitatibus. Officia nam modi perferendis.\n\nQuia dolorem ducimus commodi est tenetur. Porro porro cumque sapiente iusto dolorem. Corporis dolorum facilis officiis praesentium.\n\nFacere dolor sunt enim ea quis. Magnam aut distinctio eaque consequatur fuga sit. Amet nisi in eveniet. Aut illo voluptas dolorem voluptas quia sit qui. Nesciunt dolorem et saepe explicabo.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(8, 'Esse soluta fuga eum commodi facilis est exercitationem.', 16, 2, 'rem-rerum-esse-voluptatem-dolores-velit-quos-voluptates', 'Qui dolores molestiae recusandae quia. Qui incidunt blanditiis sit corrupti. Voluptatibus odio velit aut ipsa voluptas eum. Quia totam est aut qui sit sequi.\n\nRecusandae ut et vero. Ut et asperiores est quam quam nam. Ipsum molestiae consectetur enim totam libero et necessitatibus. Non omnis labore similique dolore.\n\nIusto tenetur dolorum velit nesciunt. Voluptatem nobis suscipit minima sint. Repellat dolore minus sint nihil.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(9, 'Est non vel aliquid provident.', 3, 2, 'eius-aspernatur-quam-expedita-assumenda-id-similique-cum', 'Iusto et illo id nihil cupiditate ut. Officiis aut est similique voluptatibus labore sunt non. Laborum at enim commodi architecto laboriosam eveniet.\n\nRepudiandae maxime provident pariatur voluptas. Aut veniam quia aut asperiores. Quam et hic est voluptatem inventore debitis quia.\n\nEligendi alias atque non ipsam accusamus provident commodi. Voluptatum qui sunt voluptatem voluptas facilis sit. Fugiat unde nisi ut corrupti inventore. Totam debitis praesentium in quod sit maiores possimus.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(10, 'Aut rerum maxime officiis architecto fugiat minima.', 19, 2, 'sint-molestiae-consequuntur-consequatur-accusantium-reiciendis', 'Delectus id omnis harum incidunt. Sint omnis veniam asperiores repellat hic omnis. Ipsa exercitationem ut quas atque iste ab. Est vel voluptatem est et odio in odio.\n\nError quam ut perferendis ab. Est eum dolor est provident culpa voluptatum. Vel earum aliquam non modi ut quia. Dolor molestiae esse rem rem qui.\n\nAssumenda velit numquam nostrum voluptates dolores. Reprehenderit ea perspiciatis ipsam odio. Eum est rerum modi ut esse aut quia.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(11, 'Provident necessitatibus nemo eveniet similique ullam voluptatem eum.', 19, 1, 'possimus-porro-sunt-molestiae-officiis', 'Aliquam nisi accusantium nulla. Laborum voluptas ipsam hic sunt possimus. Sequi ut veniam fugiat ut rerum delectus nihil.\n\nUt quo aut est minima quia. Eaque assumenda labore sint ipsum optio ex fugiat. Voluptas quidem libero sapiente aut. Reiciendis repudiandae in totam dolor quam omnis dolores.\n\nAtque ut dicta velit et sed aspernatur maiores. Recusandae repellat esse quis nostrum.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(12, 'Tenetur ut repellendus laboriosam rerum ipsum quos ullam.', 9, 3, 'ratione-sit-et-et', 'Optio architecto maxime laudantium quis. Distinctio maiores temporibus ullam corporis aut non. Laudantium velit labore sapiente sapiente veniam placeat aut.\n\nFuga autem fugiat accusamus iusto eveniet soluta consequatur earum. Ea aspernatur unde labore consequatur numquam. Qui quos voluptate magnam asperiores ea.\n\nFugit omnis repudiandae distinctio iste. Ab facere consequatur fugit dolorum. Suscipit ad et delectus deserunt aspernatur. Et ullam ut consequuntur aliquam incidunt mollitia et nemo.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(13, 'Aut est aut harum illum itaque nostrum odio saepe.', 19, 3, 'libero-autem-illo-illo-earum-facere-atque-minus', 'Illum autem qui dignissimos quisquam fuga. In facere adipisci eum ad. Earum consectetur molestiae qui aspernatur suscipit quia necessitatibus. Officiis libero earum qui maxime repellat.\n\nMinima omnis quis quibusdam sit sed. Placeat aut soluta qui ratione. Veniam quibusdam dolor modi nobis ad consequatur consequatur. Tenetur repellendus et maxime est.\n\nDucimus est unde deleniti sequi quae eum id vel. Et qui numquam aut qui placeat voluptatem. Excepturi et ipsam libero voluptatem iure saepe. Fuga aspernatur nemo doloribus vero in eum.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(14, 'Laborum sit qui sunt ratione ut.', 11, 1, 'aut-sint-corporis-amet-aliquam-asperiores', 'Odit harum culpa excepturi voluptates minima facilis saepe. Nam ex et quia saepe similique modi ut. Inventore rem vel doloribus asperiores sit sed rerum.\n\nEst debitis architecto minima alias voluptatem. Dignissimos voluptas doloremque suscipit beatae et. Molestias ea qui voluptas eaque.\n\nEx vitae est omnis quis. Dolorem fugiat et libero et pariatur velit. Qui reprehenderit libero nostrum et eos.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(15, 'Pariatur iusto occaecati dignissimos dolorum veniam qui doloribus.', 12, 3, 'voluptatem-totam-dolorem-in-cumque-nostrum-nobis-qui', 'Qui quae necessitatibus porro quis laborum. Qui ab neque quos dignissimos alias illo. Voluptatum et illo quis facere laboriosam.\n\nVel tempora architecto praesentium ea quod neque. Accusamus qui itaque natus occaecati distinctio quos. Sequi dolores ad adipisci reiciendis dolores.\n\nOfficia incidunt occaecati voluptas. Eum earum enim aut omnis et facilis aperiam. Sint eveniet doloremque ea molestiae sint qui. Est ut itaque nulla et ab.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(16, 'Cum est est excepturi quia.', 20, 3, 'expedita-optio-maxime-et-et-cupiditate-beatae-voluptatem-nemo', 'Vel autem doloribus quasi. Nostrum similique voluptas magni et vitae nostrum. Ut alias reiciendis cupiditate rerum sit voluptatum exercitationem vero. Doloremque temporibus saepe sunt rerum et.\n\nError natus commodi eos dolores veniam. Harum sint aspernatur quasi fugit provident voluptate velit. Voluptatem veritatis omnis non nam qui laboriosam voluptas. Sed velit praesentium optio nisi facilis laboriosam hic in.\n\nUt dolor labore maxime est laudantium inventore ea. Fuga perferendis fuga excepturi praesentium consequuntur sunt laborum. Tempore sunt dolor qui aliquam sapiente. Modi possimus doloribus facere fugit excepturi fuga sed.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(17, 'Repellat sunt autem vero pariatur nihil enim ipsam.', 6, 3, 'tempora-nostrum-odit-modi', 'Ut sunt ut quia natus cupiditate. Cupiditate molestiae quis iste dicta itaque temporibus ipsa. Et eligendi quae deserunt dolor aliquam porro est. Fuga veniam ea dolorem et doloremque.\n\nIpsam voluptas deserunt ut placeat molestiae. Quis tempora nisi occaecati vel. Iste officiis ea quis.\n\nOptio harum animi incidunt nihil tenetur architecto sed. Exercitationem et debitis quod atque. Optio autem sed neque. Pariatur consequatur et necessitatibus repudiandae numquam quibusdam aliquid voluptate.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(18, 'Consequuntur repudiandae qui officiis accusantium facere praesentium.', 5, 3, 'sunt-eos-voluptatem-repudiandae-incidunt-nulla-est', 'Necessitatibus debitis eveniet ratione et maxime. Sed quaerat iusto vel occaecati omnis quaerat. Delectus adipisci est inventore impedit. Quasi dignissimos et laborum placeat debitis.\n\nVelit et provident dolor doloribus. In magni quo quidem rerum. Illum rem in dignissimos nobis perferendis ut.\n\nDignissimos fugiat laboriosam ut. Quidem amet dolorum corporis. Possimus dicta dolores facilis molestias similique omnis nihil. Deleniti sit sint voluptas deleniti laborum deleniti aut. Maiores tempore fugiat cum a sit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(19, 'Non perspiciatis qui libero aut facilis molestias.', 5, 1, 'molestiae-ullam-enim-fuga-quis-quia-voluptatem', 'Sint tempore quis laborum est sit ea ducimus ullam. Praesentium voluptas dolorem amet optio. Omnis blanditiis cum rerum non et. Ut perferendis magni officia ducimus aut dolorem sunt et.\n\nDolorum non veniam itaque sunt aut sunt et voluptatem. Nisi ullam illo voluptas et similique. Doloremque est nihil ab nesciunt reiciendis nostrum.\n\nId aut enim repellendus delectus sunt quod et. Voluptatem incidunt sed vitae quia voluptate. Minus iste optio perspiciatis et.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(20, 'Fugit similique deleniti sit optio enim.', 16, 1, 'asperiores-quas-ut-quia-et-accusamus-hic-laborum-dignissimos', 'Culpa porro unde corrupti eveniet tempora sint aut. Voluptas dolor et repudiandae earum. Similique numquam iusto ut fugiat iusto. Doloribus voluptas sit consequatur et aperiam ut.\n\nLaboriosam ad inventore omnis non voluptatem sit eius. Ea asperiores et et incidunt necessitatibus architecto tempore. Ratione cum quaerat ab pariatur velit veniam. Aut a quisquam est officia ratione.\n\nQui dolore optio odio alias dolores veniam assumenda. Facere velit totam vitae nihil et ullam earum. Deleniti molestiae facere ut placeat consequatur. Repellendus itaque quo labore dicta accusamus.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(21, 'Quia et adipisci quia maiores id eum non.', 10, 3, 'quisquam-expedita-eum-aut-aspernatur-laudantium-omnis-facilis', 'Eaque velit sit non cumque et. Quasi neque veritatis id nisi culpa voluptatum. Deleniti omnis voluptatem iusto sunt.\n\nAccusantium ipsa dolores est quia asperiores ipsam dicta. Cumque qui iure expedita aut aut. Exercitationem fugiat quis porro.\n\nConsequatur molestiae aliquam et reprehenderit. Voluptas accusantium laborum et sequi harum quidem. Ut nihil est porro rem vitae incidunt et. Commodi et voluptas vel occaecati debitis ea corrupti expedita.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(22, 'Quisquam voluptas minus exercitationem molestiae suscipit magnam suscipit.', 14, 4, 'ea-veritatis-id-id-sed', 'Harum asperiores doloremque molestias nam. Non ut nemo eius autem. Et assumenda odit reprehenderit nam nihil fugit molestiae. Amet enim ut vel provident rerum rerum cumque.\n\nAutem nostrum est asperiores et quasi et. Est velit occaecati vitae rerum. Praesentium cum quo non culpa. Impedit cumque est ullam voluptatem neque.\n\nNam dolorum doloremque quasi eos. Adipisci provident debitis non ea. Commodi voluptates dolorem voluptates ab eius magnam earum.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(23, 'Recusandae earum autem placeat.', 16, 4, 'ullam-totam-ut-et-rerum-et-ut', 'Quo enim praesentium neque in. Amet et quia consequatur aut quam ipsa sequi ut. Debitis voluptate dolorem magnam. Repellat id non ad non voluptatem. Et optio asperiores eos saepe.\n\nPorro ex labore molestias ut. Aut id nobis ut voluptatum et quod ab est. Ut sapiente est reprehenderit. Unde ex quas consequatur dicta aut minima libero.\n\nDolor nulla assumenda aperiam aliquid ipsa sit. Est tempora cum enim molestiae dolor quaerat. Aut et fugiat sunt nesciunt qui cumque molestiae occaecati.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(24, 'Commodi dolor officiis velit et et aut.', 20, 4, 'fugit-eum-qui-adipisci-hic-quidem-et-aperiam-sed', 'Eaque quia occaecati quo sunt ex non. Voluptas voluptatem quia natus placeat sunt. Est labore autem consectetur minima. Et ea cupiditate ipsum sed.\n\nQui et animi et dicta vitae. Et dolor illo dolores earum ipsam quod nemo. Iusto et consectetur sit ad. Corrupti dolores et sunt assumenda facere sit.\n\nExcepturi sit eaque accusamus ut nam. Dolores excepturi quia consequatur aut ratione rerum.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(25, 'Et blanditiis non qui.', 15, 4, 'debitis-velit-at-aut-nihil-asperiores-et-ut-amet', 'Ea voluptatem a sit. Molestias molestiae porro quae nihil sed quasi. Vitae ad natus quod voluptatem aliquam sint vero. Rem commodi ipsam voluptates a voluptatem facilis qui et.\n\nPlaceat officia reiciendis eaque dolor officia rerum. Id et natus voluptas aut et et veniam.\n\nExercitationem voluptatem nobis quos eius. Inventore enim neque voluptate cupiditate autem molestiae. Ut velit sint sapiente alias excepturi veniam atque.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(26, 'Odit inventore dolorum eum libero voluptatum et qui.', 2, 4, 'voluptatum-unde-nam-natus-sed', 'Sapiente vel ipsum ut animi. Cum nostrum harum ad unde et commodi. Dolor libero veritatis odio enim. Vitae est optio cupiditate similique.\n\nModi dignissimos corrupti dolore hic. Eius ea quaerat suscipit dignissimos. Hic distinctio ducimus excepturi ab dignissimos. Sit illum deleniti voluptatibus esse dolores sed nisi tempora.\n\nEt iste consectetur aliquid. Alias illo ratione distinctio totam corporis voluptatem voluptatum. Commodi eveniet minima necessitatibus.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(27, 'Voluptatem perspiciatis quidem qui explicabo commodi molestiae inventore.', 6, 3, 'aut-sit-consequatur-repellat-quis-nostrum-maxime-maxime-et', 'Temporibus molestiae sapiente et assumenda enim. Deserunt delectus a deleniti quibusdam dolor. Est sit delectus unde id itaque maxime.\n\nItaque vitae quia fuga nihil in eum. Nihil impedit illum numquam veniam consequuntur itaque.\n\nDistinctio ab enim dolor aut ut ut sed tempora. Quaerat natus labore quis hic. Expedita quisquam temporibus illo ut. Ex non aut quia dicta explicabo voluptatem.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(28, 'Ea omnis nostrum quia dolorum sunt quaerat molestiae.', 12, 4, 'consectetur-non-delectus-et-laboriosam', 'Nam saepe non est nulla minus aperiam. Quae eos culpa sapiente magnam est. Et non totam recusandae doloribus id. Accusamus quo rerum perferendis tempora quis velit.\n\nVoluptatem veritatis voluptatem voluptas accusamus error ad eum qui. Impedit distinctio sed commodi numquam omnis reiciendis sapiente accusantium.\n\nVoluptatibus sit incidunt libero. Sunt debitis voluptatum sed. Corrupti illo cupiditate nemo laboriosam quia. Nihil dolorum veritatis sed sed consequatur. Autem voluptate accusantium non vero enim.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(29, 'Possimus autem perspiciatis quis optio qui.', 7, 4, 'molestiae-nesciunt-veritatis-molestias-vel', 'Reiciendis alias illo est nihil. Non maiores eius ut rerum aliquam ad. Fugit saepe omnis beatae occaecati vero cum doloribus voluptate. Enim nisi expedita molestiae dolor iste optio.\n\nNihil ab qui enim maxime nulla minima. Inventore et repudiandae qui. Non praesentium aliquam aut delectus vitae molestiae minus. Laudantium omnis odit itaque aperiam et nihil.\n\nPossimus delectus reiciendis cupiditate voluptatem autem id deserunt. Quod quia id similique sequi facere voluptas velit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(30, 'Ea saepe aut tempora soluta est vero.', 9, 3, 'in-delectus-qui-vitae-officiis', 'Fugiat neque asperiores temporibus error. Accusamus perferendis et in inventore ut voluptatibus nesciunt. Nobis nisi natus facilis. Velit ratione quod veritatis molestiae quo.\n\nQuis sit velit id ea excepturi sit aspernatur. Eaque mollitia omnis rerum atque in saepe. Similique qui est sed dignissimos et nihil aut.\n\nUt ipsa enim exercitationem et voluptatem ut tempora. Voluptatum eum dignissimos est ex. Et dolor deleniti molestiae dolores. Eaque perferendis quos sed qui aliquam pariatur.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(31, 'Dolores libero quos ut consequatur fugit sint non reprehenderit.', 7, 3, 'dolor-excepturi-quia-ipsam-qui-nihil-aut-non', 'Ipsum hic aliquam quo in nam. Odio et consequatur et voluptatem. Debitis quisquam nisi perferendis sequi ullam repudiandae. Aut et consectetur omnis quis magnam.\n\nRerum modi ullam magni et aut dicta. Quo quibusdam distinctio quod. Molestias officiis aut ut ea sed eaque eum. Eos dolores culpa voluptatibus quia id eum.\n\nFacere ducimus quo autem molestias et. Rerum minima doloribus est. Soluta aut corporis quia expedita alias. Molestiae quo officia tempore iste et vel rerum quia.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(32, 'Recusandae velit magnam necessitatibus qui odio.', 17, 3, 'sint-est-voluptas-et-aut', 'Possimus repellat magnam dicta libero ea. Voluptatum in nobis placeat est nemo. Dolores amet expedita molestias non. Alias eaque ipsam totam voluptates non autem deleniti.\n\nRepellendus sed quo temporibus natus consequatur est. Recusandae nesciunt cupiditate quis eum nihil aut numquam. Illo et nihil vel. Sunt consectetur rerum quis distinctio.\n\nAtque qui dignissimos saepe perferendis qui. Quibusdam ea qui sit id soluta illo. In officiis illo aut est repudiandae autem omnis.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(33, 'Natus cumque sapiente accusamus error rerum.', 17, 2, 'aperiam-autem-odio-eligendi-dignissimos-sed', 'Recusandae nam sed recusandae sed sint eveniet id doloribus. Voluptatem magnam impedit quia tempore saepe consequuntur. Dignissimos aliquam laudantium earum distinctio distinctio. Qui laudantium sed qui nobis velit accusamus quo.\n\nQuo eligendi ut cumque magni esse dicta placeat. Nam iure ratione itaque id. Et quidem nulla sit placeat ea. Eum illo quidem et sunt sed est.\n\nOccaecati nihil sint laudantium quis minus. Doloribus ut molestiae consequatur sapiente. Exercitationem fugit voluptatem odio dicta.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(34, 'Quia animi doloremque vero alias.', 20, 4, 'architecto-repudiandae-earum-eius-consectetur-sunt-quia', 'Ea rerum quo omnis voluptatem. Est eligendi eos praesentium maiores quasi est fuga. Consequuntur dolorum doloremque assumenda dolor nostrum qui eos. Facere qui ut tempora rerum numquam quae.\n\nId voluptatem recusandae similique tempore. Eaque mollitia et non quas qui exercitationem. Ut enim numquam distinctio modi ut sequi. Beatae eaque aut aliquid mollitia consequuntur dignissimos quia.\n\nHic deserunt laborum placeat nobis ea nihil. Soluta et mollitia est aperiam nam. Quasi perferendis eius quis possimus vel repellendus voluptas.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(35, 'Placeat iusto tempore eaque.', 3, 1, 'autem-illum-rerum-cupiditate-doloribus-sint-delectus-quo', 'Sint minus fugiat est. Facere aut impedit tempore vel ipsa ea. Quibusdam iste quis distinctio quia. Qui tempora rem odit quo minima voluptas ad.\n\nAmet maxime facere tempore possimus consequatur aspernatur. Eius a similique laboriosam et quae. Quod soluta et tenetur nemo voluptas. Consequatur minima sint doloremque facilis voluptate at debitis. Magni nisi corrupti laboriosam voluptatem.\n\nVeritatis inventore deserunt sit iure quis. Est quod exercitationem maxime velit. Eos ut sunt numquam amet.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(36, 'Sit suscipit et repellendus sed voluptatem nobis pariatur.', 14, 3, 'aut-veniam-officiis-unde-incidunt-laudantium', 'Voluptates eos similique dolorum eius. Soluta nostrum autem rerum aut officia quis. Et velit ad laborum quis. Est eius ad quis laudantium.\n\nHic aut incidunt dolor sequi. Nihil ratione qui voluptatibus. Expedita sint in unde et error repellendus.\n\nFugit et molestias sed dolores unde exercitationem et molestiae. Voluptatum qui nihil iusto laboriosam debitis. Rerum est incidunt voluptate eos laudantium sint. Alias reprehenderit magnam iste alias atque quo.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(37, 'Voluptatem doloremque rerum incidunt eum.', 12, 2, 'commodi-fuga-repellendus-qui-aliquam-nemo', 'Aut rerum ut quasi. Quod laboriosam inventore minima sed omnis amet accusantium. Ducimus excepturi voluptas aspernatur necessitatibus. Quia neque non ipsum molestiae ratione magnam.\n\nExplicabo quis qui perspiciatis voluptatum debitis quia nobis. Incidunt iste atque libero sit est quia. Nostrum commodi est quasi eos harum tempore. Odio similique non enim natus.\n\nUt ab voluptatum laboriosam odit laboriosam ducimus non. Unde voluptatem eos odio aliquam aspernatur nihil voluptate.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(38, 'Consectetur voluptas sequi a rerum.', 14, 2, 'aut-suscipit-quisquam-corrupti-est-earum', 'Rerum atque in dolorem neque. In voluptatum omnis non itaque et ratione voluptas praesentium. Fugiat tempora asperiores porro sed quaerat ut. Quasi ipsa ut et eveniet est aut sit voluptates.\n\nCupiditate aut quia facere aperiam commodi odio quaerat. At ex aut sit architecto accusantium. Qui magnam qui iusto fuga quisquam.\n\nIure qui mollitia qui ipsam eos est possimus. Exercitationem nihil sequi qui quis et sed dolor. Consectetur minus quo consectetur nesciunt. Quam blanditiis enim sed veniam.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(39, 'Dolorem reiciendis aliquam aut doloremque accusantium autem qui.', 2, 2, 'ex-sint-quia-ratione-omnis', 'Blanditiis qui et maiores qui qui. Sed doloremque quidem quis corporis quasi asperiores quisquam. Quia reprehenderit aut eos quas provident. Quibusdam neque est velit distinctio veniam fuga dolor.\n\nConsectetur aut iste mollitia et sint eligendi. Quia minus iste quod nemo qui occaecati aut. Eos et eligendi aut.\n\nSit sed sunt aspernatur ea magni amet tempore. Repudiandae rerum sed consequatur deleniti accusantium. Exercitationem expedita et velit quia eos officiis repellat. Facilis et non ipsa et similique laboriosam.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(40, 'Quis voluptatibus et praesentium aut qui.', 8, 3, 'quibusdam-fuga-sed-et-aut-rerum', 'Quia pariatur ullam atque qui et quidem ullam blanditiis. Et quia quae soluta quia id. Velit voluptatem iure qui consequatur amet exercitationem non. Ipsam dolorum nobis qui voluptatibus.\n\nRerum eos rerum reprehenderit aspernatur neque ut. Dicta voluptatem est non ea velit qui. Nihil ut qui necessitatibus itaque odio. Provident corporis illo et at. Minima fugiat incidunt ex ipsa quisquam voluptas.\n\nLabore voluptas ratione maxime aut. Culpa iusto quae unde qui dolorem. Aliquid aut velit iure qui. Vel eos pariatur fuga voluptatem optio.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(41, 'Ut aut rerum et atque possimus.', 20, 4, 'similique-rerum-delectus-reiciendis-recusandae-id-doloribus-dolores', 'Autem dolore labore quibusdam ut nobis placeat est aut. Sed corrupti voluptatem pariatur doloremque quod adipisci. Libero possimus voluptate quia rerum. Fuga dolorum nesciunt illo dolorem quisquam iste.\n\nRecusandae sed natus sit numquam dolor. Aperiam eos ut natus corporis fuga dicta enim. Omnis ad voluptas molestiae aliquam quo sunt. Qui adipisci est reprehenderit iusto quia. Ut hic dolor officiis ratione eligendi est in.\n\nDolor non dolor fugiat non rem adipisci voluptatem. Eveniet perferendis aut dolor nesciunt sint. Illo saepe quod est accusamus molestiae.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(42, 'Aspernatur ipsam est quo qui esse.', 8, 3, 'porro-voluptatem-quibusdam-modi-dolores-illo-et-praesentium', 'Officia aut consequatur soluta saepe autem molestiae dolores. Impedit qui eius culpa eveniet qui dolorem. Qui delectus aperiam qui vel incidunt mollitia. Totam recusandae id occaecati voluptatem.\n\nTenetur quaerat distinctio repudiandae labore. Modi velit earum sit molestiae ex mollitia. Excepturi in consequatur sunt blanditiis debitis.\n\nInventore velit pariatur impedit totam veritatis incidunt est. Non voluptatem qui veritatis provident ipsam fugit. Consectetur enim adipisci commodi ab magni.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(43, 'Illum aut rerum quasi nulla provident sint nihil.', 1, 4, 'dolores-et-voluptas-modi-et', 'Consequuntur nemo quisquam dolores voluptates voluptas consectetur. Et ut velit expedita et nobis voluptatem inventore nemo. Et fuga iste ea ea ipsum. Asperiores cupiditate error maxime aut.\n\nCorrupti in sed quo quaerat nihil. Voluptatem eius incidunt perferendis et aut qui. Deleniti sint quaerat sed dolor.\n\nCumque corporis vitae ea porro quis cupiditate. Aut et ullam vitae molestiae beatae aut velit. Et est ex tenetur modi perspiciatis officiis pariatur.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(44, 'Est optio ex odit voluptatum magnam.', 14, 1, 'deleniti-aliquam-ad-blanditiis-at-ut-expedita', 'Voluptates quis ex quae et. Fugit adipisci sed repellendus et rerum quia. Atque nam fugiat aspernatur dolores nisi ea. Ut dolorem velit minima soluta quia.\n\nVitae eum quisquam voluptas nam omnis maiores. Ducimus et similique dicta vitae fugit ea illo. Et est eaque optio officia non nulla.\n\nQuod ut sapiente voluptatem corporis enim et. Dolores totam autem commodi aut. Corporis qui voluptates eos debitis explicabo quis.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(45, 'Voluptatibus alias est quo quis magnam placeat ullam officia.', 13, 4, 'et-modi-ab-et-pariatur-unde-saepe-quis', 'Dicta ad aut est fuga quisquam iusto qui. Repellendus ut nihil velit modi sunt. Eaque est exercitationem doloribus itaque sapiente nemo.\n\nRepellendus nulla suscipit fugiat. Quia ea assumenda sint debitis placeat. Harum rerum ut porro et. Itaque eveniet voluptatibus sit est dolores dolor nihil recusandae.\n\nEsse at est rerum et rerum exercitationem. In qui maxime earum cupiditate natus consequatur. Adipisci recusandae aliquam itaque voluptatum eius optio est. Perferendis consequatur impedit consequuntur quis est perferendis exercitationem.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(46, 'Facere consequuntur et sunt quis.', 8, 1, 'quo-eos-possimus-dolor-sint', 'Est impedit est aliquid repellendus quisquam vel amet. Voluptatem saepe eum esse vel sed soluta. Perferendis sed provident dolorem deleniti quia. Excepturi unde eum saepe consequatur rerum rerum.\n\nIllo sed nobis ut consequatur. Nostrum nisi iure perferendis nemo aut placeat sunt. Enim sit voluptatem odit.\n\nTemporibus debitis dolores facere sed. Corrupti neque quo ullam ut. Dolore commodi in nihil ducimus architecto. Doloribus harum nam cumque.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(47, 'In quis quos et necessitatibus eum rerum.', 3, 3, 'molestias-ducimus-maiores-illo-quia-voluptatibus-et-quia', 'Consectetur minima non unde recusandae at numquam libero. Exercitationem necessitatibus et adipisci qui autem occaecati. Aut sed quasi qui tempore ipsa molestiae. Sit officiis ducimus molestias cum quisquam error nemo.\n\nNumquam nisi voluptas quo saepe reiciendis ut molestiae similique. Necessitatibus ea incidunt voluptatibus reprehenderit veniam ut consequuntur natus.\n\nIpsum eos ipsum necessitatibus sit a temporibus. Ut velit facere dolorum. Dolorem ex possimus necessitatibus aliquam eligendi magni deleniti et. Voluptas magnam unde vitae sint consequatur error.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(48, 'Minus animi aut fuga expedita eius suscipit.', 12, 3, 'mollitia-corrupti-officiis-quo-dolorem-reprehenderit', 'Facere quo dolores rerum consequatur expedita delectus enim. Eum repudiandae exercitationem deleniti laboriosam laborum quia ratione. Tempora soluta sint qui consequatur eos occaecati sit. Possimus molestiae temporibus soluta ipsam consectetur possimus aspernatur.\n\nVelit est officiis adipisci facilis sit dolorem ut. Reiciendis facere minus illum eaque quaerat non autem. Provident porro et est sint earum in. Consequatur aspernatur nisi dolore.\n\nEt facere nemo dicta architecto velit aut. Est voluptatem id mollitia vitae laboriosam eos. Autem suscipit ut illo optio. Et aliquid voluptatem laudantium esse.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(49, 'Ducimus numquam quasi necessitatibus quod voluptas atque.', 17, 1, 'ea-et-facere-voluptatum-libero', 'Eum illo occaecati et. Consequuntur rerum atque quaerat voluptas rem. Porro vitae voluptatem unde pariatur. Tempore assumenda nihil et dolore. Omnis dolorum rerum aperiam explicabo eos.\n\nNobis et dolorem consequatur ut beatae voluptas voluptatem. Odit temporibus voluptatum et eum. Sit qui consequatur consequatur quam. Vel eum consequatur earum sed excepturi temporibus.\n\nQuas recusandae error rerum eveniet ut assumenda earum quibusdam. Et dolorum nostrum a cumque earum. Ipsa aspernatur dolorum sint accusantium quia necessitatibus velit. Ut eveniet et aperiam.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(50, 'Ad aut est autem dolor ut eum non.', 18, 1, 'omnis-modi-in-quasi-error-aliquid-porro', 'Quia et rerum voluptatum saepe quos non. Sit fugiat ut aut autem doloremque aut. Vero aut quo architecto sit officiis eos. Consequatur quo molestiae dolor at inventore.\n\nAtque eum possimus quod aut voluptates totam debitis. Dolores cum ut ipsa excepturi. Ea qui autem maiores.\n\nEaque sed vel consectetur. Odio deleniti molestiae voluptatibus quo quo dignissimos non. Voluptas minus aut provident quos. Et aut aut qui rem ut.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(51, 'Quae aut sit ipsam illo rem nemo tempora.', 5, 2, 'numquam-laborum-maiores-at-eum-eum-ut-et', 'Neque facilis iure fugit nostrum molestiae. Repellendus labore perspiciatis ut est architecto. Vitae laudantium quia quis facilis.\n\nOfficia eos eligendi velit eum numquam doloribus. Quaerat consequatur autem nihil beatae vel voluptas expedita. Ex excepturi esse quae et modi. Rerum id accusantium harum molestiae qui et ut totam.\n\nEt qui aut voluptatem perferendis aut aut eos similique. Reiciendis culpa accusamus deleniti ullam voluptatibus quod ut quia. Itaque et totam saepe nemo iste. Et quibusdam alias doloribus alias.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(52, 'Temporibus voluptatem molestiae aliquam est.', 7, 2, 'consequatur-quia-nulla-omnis-sequi-ea', 'In dolorem non nam dolore. Natus veniam aut dolore quia molestias provident eum labore. Et sint blanditiis consequatur dolores animi. Expedita illum error et aspernatur earum et.\n\nIpsam in aperiam vitae voluptate aliquid nulla. Provident modi quo laudantium quia quo aspernatur odio repellendus. Quasi molestiae id eius laudantium iste.\n\nRem vel voluptas officia doloremque velit itaque qui. Nesciunt odit velit voluptas ut ex. Fugit veritatis eum temporibus sunt voluptatem aperiam magnam dignissimos. Beatae consequatur officia eum adipisci vero nulla.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(53, 'Consequatur quisquam assumenda odio ut neque illo.', 20, 3, 'quo-soluta-id-incidunt-aut-voluptas-laborum', 'Ut placeat et ea quas. Deserunt ducimus ipsum accusantium molestiae rerum necessitatibus.\n\nEnim autem ut nihil qui sed dolor. Fugiat occaecati praesentium adipisci eos et quisquam qui temporibus. Quaerat itaque similique velit. Ducimus enim veritatis corrupti consequuntur nihil et qui.\n\nEt sed voluptas dolor sed fugit optio molestias. Modi minus aut ullam iure minima aut. Consectetur dignissimos ipsam consequatur similique quisquam laudantium laudantium qui. Est ipsa ipsa quaerat et at.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(54, 'Placeat veniam rerum quo asperiores alias sit adipisci.', 5, 2, 'est-quod-in-possimus-libero-nisi', 'Quam aut sint culpa itaque. Qui nisi quod deserunt beatae. Ipsum nihil qui nihil et nostrum. Eius sed voluptatibus non soluta velit natus vitae.\n\nAspernatur et voluptate et qui. Aperiam eveniet ea qui minima vel aspernatur dolore. Sit quaerat facilis est debitis iure neque.\n\nEt pariatur cumque consequatur in magnam quia voluptates. Minima omnis eum fugit quia minima eaque. Tempora vel explicabo iste aliquam tempora. Accusantium quis dolor iusto occaecati rerum. Possimus eum ex quas id et.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(55, 'Ut quam possimus qui nemo vero et.', 14, 1, 'corrupti-consectetur-asperiores-et-pariatur-laboriosam-impedit-cumque-provident', 'Molestiae veritatis enim delectus quod ut. Laborum sed aut et ut molestias et.\n\nCum fugit culpa quis ducimus. Aliquid tempora placeat nam quidem et maxime molestias. Tempora qui quam vero repellendus non quam.\n\nOfficia eius hic modi consequatur voluptate. Nostrum omnis molestias esse facere ea sed corrupti. Odit sequi voluptatibus sed non aut.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(56, 'Doloribus exercitationem et possimus et aperiam.', 10, 3, 'aspernatur-deleniti-hic-aut-quo-magni', 'Reprehenderit ut est quae nihil. Enim quidem cupiditate quos excepturi aut eos cupiditate sint. Ut nostrum est soluta doloribus qui ea ullam.\n\nExplicabo rem magni aut voluptas nesciunt. Aut similique iure et iusto quasi. Recusandae veritatis dignissimos ut et sunt. Ut voluptates laudantium omnis quia est vel aut ipsum.\n\nNihil in inventore dolor modi molestiae alias. Laboriosam excepturi fuga ipsa et id labore. Atque eum voluptatibus reiciendis voluptatibus quis labore.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(57, 'Possimus ab vel reiciendis magnam.', 11, 3, 'ut-non-qui-aliquam-consequatur', 'Sint ea aliquam eveniet illum. Sed omnis vel nostrum doloribus repellendus quam. Minus nam ratione ab sed et distinctio. Iste accusamus autem vero eligendi corrupti. Officia maiores facere vel fuga ut deleniti.\n\nOptio sed dolor fuga consequuntur molestiae. Architecto nulla recusandae expedita porro mollitia dolorem illum facere. Qui sit aut iusto ratione dicta omnis ea. Excepturi consequatur aut qui.\n\nOdio deserunt dolor laudantium et. Praesentium eos ab quod. Quis non quasi qui laboriosam beatae officiis illum. Impedit quidem dolores alias soluta reprehenderit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(58, 'Dolore repellat aut distinctio quos.', 1, 3, 'voluptas-explicabo-rerum-officia-repudiandae-veritatis', 'Nesciunt eveniet natus laudantium atque voluptas et ex. Qui aut tempora blanditiis et ut excepturi hic voluptas. Est architecto occaecati tempora.\n\nPorro et quas repudiandae nemo nostrum. Sed iusto quod molestias quos. Non dignissimos dolor laudantium molestias omnis maiores.\n\nIure quos maxime incidunt illum ratione fugit aperiam. Et et nobis maiores nihil quis. Aliquam qui omnis accusantium inventore ipsum dolorem tempora a. Hic laudantium omnis recusandae quas voluptas odit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(59, 'Dicta voluptas beatae sed.', 2, 4, 'pariatur-at-et-distinctio-labore', 'Error odit neque eaque et saepe. Quod et ad temporibus aspernatur. Sed eius nostrum est totam accusantium consequatur iure.\n\nUt sunt omnis quis rerum commodi. Sit expedita incidunt odio. Eum distinctio consectetur et blanditiis perspiciatis dolores iure laboriosam.\n\nIste rerum magnam est. Repellendus et consectetur consequatur ipsam deleniti. Autem recusandae qui eligendi molestiae dolore sit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(60, 'Similique consequatur minus unde voluptatem aperiam sint quas.', 2, 4, 'vel-quia-vitae-debitis-tenetur', 'Odit velit iste placeat quidem corporis. Voluptatem nesciunt sunt quod odio id. Error doloribus id fugiat commodi autem voluptatibus. Delectus corrupti et cupiditate ipsam distinctio aperiam ut.\n\nVoluptate accusamus eos ipsa vitae. Ipsum quae aut recusandae sint vel est. Quaerat ab magnam eos aut laudantium voluptate minima. Aut voluptas ex nam commodi.\n\nQuia soluta soluta porro eum quas. Quas officiis eum consequatur minima. Et ut atque est velit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(61, 'Ut enim consequatur dolor expedita atque quae est.', 7, 2, 'id-excepturi-quaerat-est', 'Qui et voluptate odio vitae rerum. Iste quas ut eum laboriosam ipsa. Voluptatem non eius omnis vel consequatur cupiditate tempore.\n\nNatus voluptatem nemo culpa vel consequatur. Adipisci soluta et doloremque repudiandae perferendis. Similique sed eos id et rem deserunt.\n\nFuga occaecati aperiam dolores dolores. Quam quidem est ut fugiat. Perferendis veniam aut sed in.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(62, 'Dolores voluptates et qui et.', 19, 1, 'est-quaerat-ut-qui-mollitia-velit-placeat', 'Quibusdam ut dolores quos quo. Voluptatem rerum necessitatibus quam inventore ut qui inventore sed. Ex sunt quia qui non voluptatem nam cum. Nihil quo sequi reiciendis perferendis accusantium ratione. Beatae voluptatem aperiam quibusdam ut sit.\n\nQuia sequi ut nihil sunt voluptas. Fugit ut ipsum non odio. Possimus sint omnis exercitationem quis fuga.\n\nIusto eligendi accusantium architecto exercitationem ducimus soluta. Qui est et magnam aut. Exercitationem sint totam minima magnam ut.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(63, 'Autem enim quia et ipsum id sint tempora.', 3, 2, 'ut-omnis-nisi-repellat-ut-minima-est-sed', 'Quia quo soluta eum fugiat sed. Quod veritatis natus molestiae temporibus. Consequatur at ut velit sit quod. Blanditiis velit distinctio quam magnam delectus magnam.\n\nTempore occaecati ut quia minus. Autem minus nihil est ut et eos. Aut et quasi et est autem porro unde.\n\nLaboriosam est itaque nobis ut voluptatem exercitationem. Quo optio nam dolor voluptatem molestiae dolor sapiente. Ut aut ab non velit aut.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(64, 'Natus voluptate dolorem rerum et.', 15, 4, 'rem-natus-magnam-blanditiis-ipsa-officiis', 'Laudantium voluptatem impedit officiis ratione. Nobis aut similique sint laudantium corporis laborum.\n\nUt alias vero ut quia nisi. Qui sit officiis qui voluptas enim eos quos eligendi. Est error architecto consequatur omnis veritatis iure sed.\n\nEx et reiciendis porro assumenda et possimus. Ut alias qui facilis perspiciatis.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(65, 'Ratione quasi molestiae non est consectetur.', 9, 3, 'esse-magnam-in-earum-asperiores', 'Officia ut est sint praesentium et et. Nihil laboriosam id est laudantium error nulla. Asperiores dolorem rerum vel in neque beatae magni.\n\nDoloribus possimus fuga consequatur ut qui. Ut aut fugiat veniam voluptas ea laborum fugit. Aut molestiae eum reprehenderit vitae pariatur odit.\n\nQuis consequatur nulla est et. Est incidunt architecto deleniti molestiae quibusdam rerum voluptas. Ut enim qui tempore quibusdam tempora est animi qui. Perferendis est doloribus ut aut voluptatem.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(66, 'Adipisci itaque reprehenderit necessitatibus consequuntur dolorum non voluptas.', 4, 2, 'placeat-voluptate-non-deserunt', 'Officia voluptatem possimus perferendis labore accusamus atque. Impedit ut est dolorem dolor. Provident sit illum repudiandae eum.\n\nRerum aut et unde numquam laborum. Aliquid commodi cum optio quia aut eius. Saepe omnis itaque officiis eos doloremque quia. Magnam vitae laborum odio consequuntur rerum vitae.\n\nDeserunt eaque qui quos aliquam libero. Est et aut fugit aut et. Sapiente voluptas quo iusto modi. Incidunt rerum ut doloremque maiores tenetur quae in ut. Quia dolorem ut totam quas asperiores aliquid deserunt.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(67, 'Rerum omnis earum sed facilis.', 3, 1, 'vel-sed-hic-veniam-possimus-eligendi', 'Veritatis et qui non eveniet ut. Rerum autem facilis et et odio nobis. Magnam ut laboriosam eum quis.\n\nDelectus ducimus dolorem labore et ad. Cum quibusdam excepturi suscipit dolor nobis ad rem. Aliquam officia aperiam fuga aut excepturi vel. Provident ea et explicabo sunt.\n\nAt voluptatem optio vel dolorem aut voluptas deleniti. Excepturi sunt aut quia dolorum. Dolor enim eaque quae.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(68, 'Dignissimos quo rem rerum necessitatibus ut iusto quasi.', 11, 4, 'repellendus-possimus-optio-dolor-et-neque-laborum-similique', 'Dignissimos quo nihil iusto qui quia occaecati in. Mollitia et vel officia sequi maxime provident aut eos. Quibusdam eligendi pariatur quis voluptatem quia minima labore.\n\nFuga ducimus quia numquam et eum. Laboriosam numquam nihil magnam quibusdam et et repellendus quisquam. Repellat voluptas facilis ut nemo consequatur ducimus. Perspiciatis maxime cum vero et qui eaque.\n\nSed fuga accusamus asperiores id alias. Porro commodi voluptatem similique. Maiores odit illo vel quidem. Eaque commodi ipsam voluptatem velit nobis a.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(69, 'Qui sed non voluptate omnis sed nihil optio.', 12, 2, 'earum-quod-et-magnam', 'Cupiditate animi aut ea voluptas exercitationem nam. Totam ut doloribus et eos delectus est. Et vel dolore eum reiciendis neque voluptatibus odio. Saepe voluptates facere ea et enim vero accusamus.\n\nDelectus molestiae recusandae ut eos deserunt nisi iusto. Earum et reiciendis rem. Soluta iure eius nisi.\n\nTemporibus temporibus similique quas voluptatem adipisci facere sunt. Sed odit consequatur molestiae aliquid mollitia dicta. Ut autem quia molestiae quis fugit enim.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(70, 'Doloremque vero eum in sint sint.', 15, 2, 'soluta-enim-atque-aut-deserunt-ullam', 'Vel natus repellat corrupti nulla quis. Ullam rem expedita voluptas dolore.\n\nFugiat et atque qui sunt. Eum qui neque iste facilis laudantium soluta. Consequatur qui culpa maxime minima reprehenderit deleniti.\n\nNam aut consequuntur voluptate nam. Quis dolor et et voluptas quis iure et. Sint quisquam qui nulla quos.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(71, 'Et qui inventore molestias.', 20, 2, 'aspernatur-nemo-nisi-et', 'Id dolorem numquam non aut. Excepturi laboriosam tempore dolorem quis consequatur quasi excepturi qui. Minus dicta corporis dolorem omnis quod dolor.\n\nEos ut praesentium molestiae nostrum excepturi deserunt facilis. Culpa fugiat explicabo ut. Quae ducimus fugit dicta omnis occaecati fugiat pariatur suscipit.\n\nConsequatur et voluptates quis sed at quis necessitatibus. Beatae consequuntur vero ut autem molestias. Quidem dolor officiis in modi dolore.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(72, 'Perspiciatis illum asperiores optio velit et vel.', 6, 1, 'ut-facilis-incidunt-voluptatibus-est', 'Consequatur molestiae eum enim sunt vitae et. Doloribus enim consequatur esse. Officiis necessitatibus voluptas cumque alias. Consectetur est laboriosam neque in. Omnis tempora corrupti soluta quisquam deleniti quo.\n\nDebitis iste quia et. Cum mollitia nulla ut sunt earum atque. Aut enim atque sed perspiciatis est itaque nam. Ut ipsum quisquam qui eos voluptas esse.\n\nEarum et et reiciendis aut excepturi corrupti. Sequi nihil et est sit voluptas. Quo et dignissimos enim voluptas. Magni ut qui molestias illum voluptatem. Voluptatum deserunt soluta ipsam et.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(73, 'Illo est aut ut qui non sunt ut et.', 6, 2, 'ut-possimus-quaerat-nihil-ex', 'Fugiat voluptas nihil ipsam exercitationem cumque. Ea eveniet repellat at sunt. Consequuntur sint similique est corrupti. Minima veritatis nisi a totam distinctio.\n\nId dicta dolor est similique eligendi deleniti est. Odio quia rem est occaecati. Sunt officia qui molestiae illum necessitatibus doloribus vero distinctio. Modi nihil nulla voluptatem quo ducimus soluta.\n\nDolorum porro sit maiores eos neque. Rerum neque saepe sint minus laboriosam quo voluptatem. Quis a unde impedit itaque quae veritatis totam. Rerum quos suscipit est autem error velit et.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(74, 'Quidem sunt sequi explicabo rem minus quia iure.', 13, 1, 'tenetur-earum-corporis-sequi-molestiae-magni', 'Voluptatem quia id autem. Est expedita maxime eos omnis odit. Mollitia temporibus error commodi totam quisquam ut sit deserunt.\n\nEst eaque aut quasi ad occaecati officiis. Sint eos et aut ipsum. Eos aut odio vel. Aut molestias eum dolores cupiditate alias et deserunt.\n\nConsequatur libero blanditiis asperiores aliquam quod molestias eaque. Consequatur nihil et voluptatum. Saepe ea adipisci et perferendis eos magni eos voluptatem. Neque a dolor corrupti incidunt dolor.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(75, 'Amet natus voluptatem consequuntur architecto qui.', 13, 3, 'voluptates-sint-sunt-amet-rerum-odit-dolorem-aut-sequi', 'Minima modi maxime dolorum. Dignissimos animi nam officiis vitae libero asperiores. Quo aut velit vitae quod.\n\nEligendi nemo qui iste sequi qui quidem sit. Placeat officiis necessitatibus quae. Tempora harum nisi quaerat eum possimus.\n\nIpsum laborum omnis eaque doloribus eum nihil aut sequi. Aut ex omnis recusandae dolor consequatur maiores labore. Nemo et explicabo corrupti exercitationem cumque libero. Veniam autem rem quae doloribus ut qui nemo.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(76, 'Dolor velit aspernatur quia.', 5, 4, 'blanditiis-a-totam-nemo-voluptates-laboriosam-excepturi-sed', 'Molestiae laborum enim quos aperiam. Est quia aspernatur a voluptas autem esse. Perferendis porro voluptatem voluptas excepturi. Modi sint earum neque officia rem.\n\nCorrupti corporis laborum quos ipsam ex ut eos. Omnis reprehenderit ex enim architecto culpa et consequatur. Et nostrum quia vel et porro quo.\n\nAut omnis reprehenderit expedita minima. Optio a aut assumenda. A et sunt magnam. Fuga aut voluptas adipisci soluta.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(77, 'Dolorem odio enim eos non.', 7, 4, 'est-molestiae-facere-a-nihil-rerum-suscipit', 'Optio vitae saepe aut rerum earum. Quo quia maxime ipsa voluptatem nihil voluptatem. Omnis quasi et nam impedit.\n\nAd alias ipsum sit doloribus non est voluptatum nam. Eaque sit quia odit doloribus iste aperiam sit. Perferendis necessitatibus facilis maxime quasi qui.\n\nHic quod optio nesciunt alias. Ut qui sed dolor sed debitis at. Iste consequatur odit voluptate velit quia sit et.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(78, 'Voluptate ut eaque aut voluptatum et ipsa et veniam.', 16, 2, 'quis-voluptate-tempora-modi-sapiente-vel-quo-eligendi-ut', 'Incidunt odit maxime qui sunt ab. Aut expedita rerum et provident. Est repellendus accusantium quo est sit.\n\nRepellendus odit id quia sit sed ad delectus. Omnis dignissimos laboriosam assumenda nam. Optio ab nesciunt qui ab veniam quisquam cumque.\n\nDebitis tempora ut ratione. Delectus perspiciatis suscipit est maiores id ut.', '2025-03-24 18:06:38', '2025-03-24 18:06:38');
INSERT INTO `posts` (`id`, `title`, `author_id`, `category_id`, `slug`, `body`, `created_at`, `updated_at`) VALUES
(79, 'Totam nostrum sint quia ratione excepturi consequatur a ut.', 7, 3, 'aut-dolore-itaque-possimus-aut-sit-ullam-eos', 'Accusamus qui vel et molestias sunt praesentium nihil. Vitae omnis suscipit omnis non maxime molestiae tempore facere. Nostrum illum iste dolore velit voluptatibus at. Ut suscipit possimus voluptates qui nisi magnam. Veritatis non et corrupti perferendis.\n\nMolestiae blanditiis placeat temporibus. Debitis nisi ad illo et non occaecati. Molestiae quia sed fugit aliquam perspiciatis vel.\n\nCulpa magni eum et et eius. Voluptatum ea labore illo est ut. Inventore excepturi aut cumque occaecati.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(80, 'Eos praesentium adipisci quia debitis aut dolores.', 3, 1, 'cum-voluptatem-facere-asperiores-laborum-placeat', 'Deleniti maxime at enim cumque eius autem perferendis. Fugit est soluta blanditiis inventore. Nesciunt aut aut repellendus aut. Tempore dolor porro aut sit.\n\nMagni in cumque possimus rem. Nisi quia expedita voluptatem possimus a ut veritatis eum. Sint est magni ut beatae.\n\nDucimus dolores eaque ipsam numquam. Nulla et qui dolorem enim quidem. Natus nostrum nihil accusantium atque eligendi deleniti. Qui consectetur consequatur dolorum nostrum non quia.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(81, 'Dolorem nulla et eum id.', 15, 3, 'labore-dolorem-quos-harum-nostrum-ut-laudantium-est', 'Necessitatibus est dolores quia. Inventore consequuntur incidunt eligendi voluptatem libero molestiae eos. Quis ut voluptatum fugiat autem possimus neque. Ut quo iste quaerat.\n\nRerum qui sit necessitatibus ex esse dolorum est. Voluptate autem ut consequatur ea. Minus quas error asperiores maxime dolorem et earum. Praesentium quo quia pariatur nihil qui dolorem exercitationem.\n\nQui mollitia reprehenderit et labore quia aut. Cum aut vero aliquam nihil rem id. Voluptates facere dicta sed nostrum quo omnis. Quis dolor hic accusamus dolore.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(82, 'Facere occaecati vel sed quis ipsam doloremque et.', 8, 4, 'velit-modi-ut-quia-perspiciatis', 'Laboriosam iusto dolor id nobis est assumenda. Eligendi ex debitis quis quis. Rerum et aut dolor et earum.\n\nNesciunt est rerum aperiam incidunt itaque ea. Libero hic et dolores cupiditate earum sed quo ducimus. Nisi sint et voluptatem omnis. Odit non soluta eaque et.\n\nOmnis laboriosam non illo et debitis corporis ducimus sint. Exercitationem omnis voluptatem ipsam. Ut dolorem et fugit quia quos deserunt ut fugiat. Iusto quibusdam id necessitatibus. Et eaque ratione porro et et nam aut.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(83, 'Et sequi ut quo.', 10, 3, 'porro-eos-quo-corrupti-quidem-velit-omnis', 'Molestiae aut facilis et vitae fugit amet. Necessitatibus quibusdam nam saepe consequatur velit qui officiis. Numquam soluta ut dolorem dolores ipsam placeat suscipit. Reprehenderit modi officia voluptatibus.\n\nRerum facilis vel corrupti non. Voluptas et recusandae et non. Voluptate enim voluptatem sed excepturi est odio optio voluptas. Numquam et voluptatibus sit beatae dolorem rerum consectetur. Ut omnis odio dicta laboriosam.\n\nNobis et rerum nemo laudantium. Sit non aut hic cum omnis aut totam rem. Ipsam ex autem dolorem omnis aperiam voluptas aperiam voluptates.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(84, 'Est sint illum consequatur laborum.', 17, 3, 'et-consequuntur-et-quod-quisquam-repellendus-sequi', 'Officia minus laborum quis. Adipisci et natus veniam omnis ut hic magnam voluptate. Modi officia voluptas reiciendis voluptas laudantium porro. Veritatis et delectus quae nesciunt et.\n\nNostrum dignissimos consequuntur sed iusto ipsam. Sint temporibus unde sit aliquam voluptatem ut cumque. Deserunt aliquam ratione rerum.\n\nVeritatis est eos hic eaque ipsam. Beatae deleniti saepe et aut iste labore odio. Dolor sint aliquid porro qui sapiente. Provident mollitia cumque dolorem aliquid.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(85, 'Natus voluptas est unde omnis omnis modi et.', 6, 3, 'aliquam-tempora-corrupti-et-dolor-mollitia-rem', 'Quisquam similique odit maxime repellendus. Voluptas et voluptas sequi velit hic similique qui. Voluptates voluptatem omnis dolorum in itaque.\n\nDoloribus culpa natus nostrum sunt est. Adipisci voluptatem aut blanditiis architecto sit error.\n\nNemo modi eum et incidunt sunt earum. Optio autem in quibusdam expedita illo et beatae. Qui vel ut et ducimus delectus laboriosam. Iusto id consequatur enim.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(86, 'Aut dolores cumque voluptatem quae adipisci enim numquam quae.', 18, 3, 'cumque-sit-sequi-odio-autem', 'Qui enim nobis distinctio qui accusamus. Libero aliquam eos est accusamus. Iste voluptas accusamus et animi dicta et. Labore animi omnis porro enim maiores.\n\nEaque ut voluptas voluptatum. Est voluptate omnis repudiandae minus omnis.\n\nQuia sed consequatur doloremque vitae magnam et vel iure. Repellendus delectus aut et quisquam dolor eveniet culpa. Magnam animi accusantium distinctio fugit neque consequatur debitis.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(87, 'Enim voluptatem qui eos blanditiis et.', 4, 3, 'ut-sunt-sint-maxime-provident', 'Ab libero earum sunt perferendis aliquid quia. Expedita hic doloremque odio molestias assumenda enim. Aut eveniet et iusto omnis fugit tempore. Quam nulla voluptatem quia modi.\n\nLaborum blanditiis occaecati sit dolorum qui. Ut fuga dolores expedita et. Ducimus delectus mollitia dolorem soluta in consequuntur.\n\nRepudiandae consequatur quod voluptas blanditiis velit aspernatur et. A est iusto eius voluptate. Reprehenderit recusandae ullam saepe quia et. Occaecati exercitationem omnis quam ut itaque cum nesciunt. Et molestias assumenda doloremque quisquam aliquid velit neque.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(88, 'Sapiente non ipsum unde voluptatem ducimus.', 14, 1, 'praesentium-dolore-velit-vero-accusantium-architecto-qui-nihil', 'Quae et ut dolores quas dolores. Voluptas quia nemo qui cum vero. Veniam incidunt esse consequuntur ut dolorum. Nisi asperiores qui facere magni voluptatem.\n\nEveniet ut nobis aut nihil est. Non sint ab porro omnis amet ipsam architecto. Porro accusantium ab itaque quia eum. Aperiam corporis distinctio iure.\n\nRecusandae tempora est nihil corporis saepe eaque dolorum. Exercitationem ipsum consequatur doloribus consequatur impedit voluptas eaque.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(89, 'Et sunt a sunt nisi quia.', 19, 3, 'beatae-exercitationem-nam-modi-consequatur-ut-in', 'Expedita maiores dolore sed. Et nemo nesciunt omnis tempore perspiciatis velit omnis expedita. Qui quia accusantium ea id et.\n\nAb ut quo sed consequatur magni sit. Adipisci sequi et similique fugiat doloremque ratione. Assumenda quod esse animi qui. Eum expedita voluptate ut magni. Corrupti non doloribus repellendus qui sed quaerat libero aut.\n\nMaxime error placeat non sunt. Ea atque quisquam laboriosam labore tenetur. Consequuntur tempore assumenda rerum. Fuga aut mollitia possimus quia et.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(90, 'Quos sit qui eos rem et.', 14, 1, 'tenetur-cupiditate-repellat-a-dolor', 'Perspiciatis quam voluptatibus sunt aut aliquam. Sit beatae eum omnis. Magni aut incidunt fuga corporis et repellendus ducimus.\n\nAtque quo sed et perferendis est mollitia debitis. Autem ducimus et dolorem sit optio. Possimus beatae nesciunt aut. Sint ea vel harum numquam soluta ab.\n\nDoloremque id alias officia amet doloribus. Occaecati velit id nesciunt alias. Sequi voluptatem et itaque ipsa debitis doloribus ut. Sunt quaerat placeat dolores laboriosam.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(91, 'Quam rem aliquam dolorem consectetur voluptatem provident non tempora.', 17, 3, 'et-velit-omnis-vel-est-ut-consequatur-eius', 'Omnis dolor consectetur dolores omnis. Quisquam inventore deleniti fuga doloremque enim iusto. Quae consequatur unde rerum non. Labore modi qui perferendis labore temporibus blanditiis cupiditate. Ut accusantium nihil molestiae unde ut similique.\n\nOmnis perspiciatis vero officiis fugiat voluptatem. Eligendi voluptas quibusdam consequuntur assumenda amet eum eveniet. Quis aliquam quia fugit dolor ad nostrum provident vel. Ea totam similique et pariatur.\n\nModi exercitationem voluptate saepe harum natus rem voluptas illum. Officiis velit ex sequi distinctio corporis. Et voluptatem odit sed et aut occaecati deleniti.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(92, 'Ut et perspiciatis rerum illo voluptatibus.', 3, 2, 'corrupti-voluptates-vero-autem', 'Quibusdam eaque tempore molestias ducimus est iusto accusamus. Beatae modi ratione sit dolorem dolorem adipisci eos. Aut aut ea enim suscipit rem ullam. Dolorem sit nihil cupiditate consectetur voluptas dolore et.\n\nLaudantium repellendus sed omnis et inventore id qui. Consequuntur ratione quia accusantium accusantium velit aut modi. Eum impedit maiores veritatis aliquam.\n\nEa nihil voluptas libero illum. Incidunt tempore earum aperiam. Qui laborum est non rem quo voluptatem nostrum a. Aut in nobis sunt officiis aspernatur tempora. Enim unde eum ut deserunt dicta.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(93, 'Voluptates minus id aperiam illum.', 20, 4, 'eum-libero-doloremque-vel-sit-deserunt', 'Maiores quae voluptatibus doloremque quam distinctio. Fugiat error eius vel qui numquam odio dolor. Illo nihil reprehenderit culpa nulla.\n\nSequi velit deserunt et. Quia delectus quidem quae illo quia iusto dolores. Est rem laborum maiores optio laborum tenetur natus dolores. Et alias expedita alias velit deserunt ratione iure.\n\nQuia explicabo rerum sed ut ab. Rem id nihil vel labore. Amet architecto sapiente id id enim. Dolorum sunt et eos quidem nostrum.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(94, 'Modi facilis alias aspernatur.', 7, 4, 'nam-iste-ipsa-aut-dignissimos-nesciunt', 'Dolorem quasi iure perferendis voluptates quo rerum. Quibusdam consequuntur dolores ipsum nihil. Quae doloremque quasi tempora maxime ab quisquam. Doloribus eos repudiandae reiciendis placeat modi consequuntur.\n\nUt eaque voluptate voluptas itaque assumenda quia. Repellat suscipit animi sed vel rerum. Exercitationem debitis aut porro.\n\nConsequatur dolor deserunt dolores cum amet officiis. Voluptates voluptatem quia sed nihil dolorem placeat in. Totam dolore quod ipsa corrupti. Quis et maxime laborum quia atque tempora.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(95, 'Quis dolor deserunt repudiandae sint esse magnam.', 14, 4, 'ut-sit-et-vel-ad', 'Quod voluptas qui repellendus et explicabo. Neque voluptas dolor alias occaecati id adipisci sed molestiae. Vel eos velit nam culpa perspiciatis est.\n\nQuas nemo vitae molestiae quidem. Qui rerum voluptates veniam consectetur. Sed quod error quis rem doloremque.\n\nAliquid provident error et odio fugiat quia nulla. Mollitia animi cum expedita ut ut ut officiis. Et ut sed excepturi quidem est provident qui.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(96, 'Voluptatem quam qui hic.', 6, 4, 'pariatur-et-doloribus-dolore-voluptatum-sit', 'Numquam et et cupiditate aut. Aut expedita maxime molestiae laudantium. Ut eos nam hic vitae voluptatem velit. Inventore non aspernatur exercitationem aut.\n\nMolestiae autem incidunt culpa ipsam distinctio. Corrupti exercitationem distinctio facere tempora rerum minus quasi. Enim ad corrupti repellendus expedita.\n\nConsequatur sint nam praesentium deleniti mollitia reprehenderit. Labore vel cupiditate excepturi laudantium commodi quibusdam quasi. Error aut est nostrum commodi odit. Aut earum impedit fuga. Rerum nemo velit quasi ut consequatur unde et.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(97, 'Dolores ipsum cumque et et.', 12, 3, 'illo-est-numquam-placeat-consectetur', 'Dolor sed officia occaecati tempora. Ducimus quaerat et aut pariatur rerum. Nihil sed perferendis est enim placeat tempora aspernatur totam.\n\nAut eaque ea velit molestiae et repudiandae. Ut aut blanditiis omnis quisquam. Consequuntur provident cumque ut blanditiis molestias vel.\n\nConsequatur veritatis enim nemo. Voluptatem ut odit veritatis aut est. Praesentium ea aut facilis voluptatem similique. Itaque perspiciatis nobis sapiente ducimus. Quia quis dicta voluptatem.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(98, 'Sit est in ullam aut maxime provident rerum.', 18, 1, 'voluptatem-sint-eligendi-et-culpa-qui-earum', 'Rerum quasi ut repellat repellendus soluta. Illum et consequatur molestiae. Perspiciatis nisi necessitatibus molestiae distinctio. Harum et tempora unde adipisci et quis. Dignissimos odio cupiditate aut laudantium sed porro quaerat.\n\nCommodi atque ab rerum molestiae et occaecati. Facilis et vel quia rerum rerum. Aperiam totam illum eos est magnam libero.\n\nNatus occaecati dignissimos modi eum aut. Non veniam hic nihil dicta eos. Eum fuga laudantium laboriosam rerum at omnis repellat sint.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(99, 'Molestiae est aut velit sint nobis quis sapiente asperiores.', 2, 2, 'dolores-ut-explicabo-doloremque-atque', 'Unde ipsum ipsa delectus aut amet officiis atque similique. Est eos et doloremque id magni. Commodi voluptatibus aut ut quo soluta. Cum id qui consequuntur natus.\n\nMaiores qui ut quibusdam laboriosam. Repudiandae voluptate quia provident dolores error vel ipsa. Illum eaque placeat eligendi dignissimos nesciunt. Totam sit consequatur ea similique iste deleniti quibusdam.\n\nIste labore quia ex mollitia. Qui tempora impedit vero enim. Repellat rerum sequi nisi distinctio dolorum ex aspernatur.', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(100, 'Deleniti sed voluptatem aut voluptas consequuntur.', 16, 3, 'in-eos-perspiciatis-ducimus-odio-numquam', 'Fugit alias quo atque nam illo illo. Numquam aut eligendi et ipsum autem. Et harum saepe repudiandae et. Ad velit minima quo aut quam assumenda.\n\nAsperiores eum ipsum repudiandae. Vitae repellendus quia ut aut fugiat. Nisi laborum ipsum odit facilis a.\n\nConsequatur veritatis est sint corrupti alias eveniet ut. Vero velit quis provident voluptatem et dolores nam. Et dolor quaerat id quod illo eum vel. Aliquid facere perspiciatis cumque sit.', '2025-03-24 18:06:38', '2025-03-24 18:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(2, 'Assurance', 'assurance', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(3, 'Wifi', 'wifi', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(4, 'HO', 'ho', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(5, 'SDV', 'sdv', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(6, 'Bges', 'bges', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(7, 'Public', 'public', '2025-03-24 18:06:37', '2025-03-24 18:06:37'),
(8, 'Fullfilment', 'fulfillment', '2025-03-24 18:06:37', '2025-03-24 18:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_menus`
--

CREATE TABLE `role_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_menus`
--

INSERT INTO `role_menus` (`id`, `menu_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, NULL, NULL),
(2, 2, 7, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 7, NULL, NULL),
(5, 5, 7, NULL, NULL),
(6, 6, 4, NULL, NULL),
(7, 7, 3, NULL, NULL),
(8, 7, 2, NULL, NULL),
(10, 14, 7, NULL, NULL),
(11, 10, 4, NULL, NULL),
(12, 11, 4, NULL, NULL),
(13, 12, 3, NULL, NULL),
(14, 12, 2, NULL, NULL),
(15, 13, 3, NULL, NULL),
(16, 13, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gtkyk1Bxbnad4ajvGnrHrtvHOcX5Xj0WKkFdOJfB', 21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiN1lGTWNDdFdvMzVraTlSTlVhMVl1VndZUTRBR0RUcDRiQjRHYlZONyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTc6InRoZW1lX3ByZWZlcmVuY2VzIjthOjM6e3M6MTE6ImxheW91dC1tb2RlIjtzOjQ6ImRhcmsiO3M6MTM6InNpZGViYXItY29sb3IiO3M6NDoiZGFyayI7czoxMjoidG9wYmFyLWNvbG9yIjtzOjQ6ImRhcmsiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMTtzOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e319', 1744076988),
('RgiJILtbwn6ZpWEJrsrE9v4TosAZHR6mR91wWgTB', 21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRFdJZnp5UTRTU2FHVUNVcjJZR3pzdXV2b1JSMzhyc2hNMUlmWHpyZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTc6InRoZW1lX3ByZWZlcmVuY2VzIjthOjM6e3M6MTE6ImxheW91dC1tb2RlIjtzOjQ6ImRhcmsiO3M6MTM6InNpZGViYXItY29sb3IiO3M6NDoiZGFyayI7czoxMjoidG9wYmFyLWNvbG9yIjtzOjQ6ImRhcmsiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMTtzOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e319', 1742975455);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `telegram_id` bigint(20) DEFAULT NULL,
  `telegram_username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `theme_preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`theme_preferences`)),
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `telegram_id`, `telegram_username`, `password`, `role_id`, `profile_picture`, `is_verified`, `theme_preferences`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Cornelia Hani Lestari S.IP', 'salimah51', NULL, 'muyainah', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 3, 'https://randomuser.me/api/portraits/women/55.jpg', 0, NULL, 'LyZSCbkROg', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(2, 'Eman Gilang Najmudin S.H.', 'hani.purwanti', NULL, 'yuliana75', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 7, 'https://randomuser.me/api/portraits/men/72.jpg', 0, NULL, 'oy8wQB4dvA', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(3, 'Balapati Eka Wahyudin S.Kom', 'lirawan', NULL, 'samiah.prastuti', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 8, 'https://randomuser.me/api/portraits/men/56.jpg', 0, NULL, 'r2zghybscV', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(4, 'Violet Mandasari', 'bsirait', NULL, 'lili46', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 3, 'https://randomuser.me/api/portraits/women/55.jpg', 0, NULL, 'Vmn2D9hync', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(5, 'Maman Winarno', 'pratama.salwa', NULL, 'malika.rahimah', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 8, 'https://randomuser.me/api/portraits/men/82.jpg', 0, NULL, 'BHp4vlMTH5', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(6, 'Rini Nasyidah M.Farm', 'prasasta.pranawa', NULL, 'vivi.pradana', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 7, 'https://randomuser.me/api/portraits/women/8.jpg', 0, NULL, '1M8YG2KHLK', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(7, 'Cecep Mangunsong', 'nasyiah.wirda', NULL, 'karna.laksmiwati', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 5, 'https://randomuser.me/api/portraits/women/97.jpg', 0, NULL, 'fmF5WRI2dc', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(8, 'Hamzah Siregar', 'wulan84', NULL, 'jpratama', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 2, 'https://randomuser.me/api/portraits/women/82.jpg', 0, NULL, 'lvMkO6uGMy', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(9, 'Diana Zulaika', 'ehabibi', NULL, 'gnurdiyanti', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 6, 'https://randomuser.me/api/portraits/men/62.jpg', 0, NULL, 'UlSFRCgAVM', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(10, 'Julia Zulfa Hastuti', 'suci48', NULL, 'xandriani', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 8, 'https://randomuser.me/api/portraits/women/47.jpg', 0, NULL, '6XyY1Xpzoj', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(11, 'Omar Mustika Uwais', 'padma67', NULL, 'kramadan', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 4, 'https://randomuser.me/api/portraits/women/61.jpg', 0, NULL, 'huCKUNFzNj', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(12, 'Gawati Riyanti', 'yuniar.ciaobella', NULL, 'vwaskita', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 8, 'https://randomuser.me/api/portraits/women/55.jpg', 0, NULL, 'aJbbBeoS3x', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(13, 'Irwan Waluyo S.Gz', 'natsir.dewi', NULL, 'azalea.budiman', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 6, 'https://randomuser.me/api/portraits/women/99.jpg', 0, NULL, 'cDZyjfSMn6', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(14, 'Caturangga Garda Hutapea', 'wijaya.kayla', NULL, 'nrima49', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 3, 'https://randomuser.me/api/portraits/men/35.jpg', 0, NULL, 'pn7yR6Txzn', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(15, 'Halima Rina Wulandari', 'jane17', NULL, 'lpalastri', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 6, 'https://randomuser.me/api/portraits/women/60.jpg', 0, NULL, '2Mqde2VymQ', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(16, 'Vera Suryatmi', 'baktiadi40', NULL, 'ibun.wulandari', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 3, 'https://randomuser.me/api/portraits/women/93.jpg', 0, NULL, 'MUPfzqno7d', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(17, 'Yance Yuliarti M.Ak', 'pradana.endra', NULL, 'firmansyah.balijan', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 1, 'https://randomuser.me/api/portraits/women/28.jpg', 0, NULL, 'SAQUREe0UF', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(18, 'Opan Suryono', 'mariadi.palastri', NULL, 'yessi93', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 3, 'https://randomuser.me/api/portraits/women/19.jpg', 0, NULL, '5DHVteWlmv', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(19, 'Talia Hariyah S.Pt', 'jessica12', NULL, 'umay.sihotang', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 4, 'https://randomuser.me/api/portraits/women/40.jpg', 0, NULL, 'NUPADVn14d', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(20, 'Aditya Hutapea', 'rahmi72', NULL, 'ekuswoyo', '$2y$12$Nr/S/zVpC4dzQgqej8sbEeTyOBheM5PNsCI/AfO7p/F0pnBW0wipu', 1, 'https://randomuser.me/api/portraits/women/70.jpg', 0, NULL, '7X6Vw8bB3E', '2025-03-24 18:06:38', '2025-03-24 18:06:38'),
(21, 'Ichwan', 'Waann', 1082758357, 'iWaann20', '$2y$12$1Nvrz5ctJvvYOHN/XsLdfe8aguCDoitwmJaxSySlcMsws1Tr.VCrW', 1, 'profile_pictures/MmlvsFWRm6qROPOMXZJGHf5gqALJikIHUe7SYe3y.jpg', 1, '{\"layout-mode\":\"dark\",\"sidebar-color\":\"dark\",\"topbar-color\":\"dark\"}', NULL, '2025-03-24 18:10:15', '2025-03-26 07:50:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`),
  ADD KEY `menus_menu_id_foreign` (`menu_id`),
  ADD KEY `menus_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otps_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`telegram_username`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_author_id` (`author_id`),
  ADD KEY `posts_category_id` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_menus_menu_id_foreign` (`menu_id`),
  ADD KEY `role_menus_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_telegram_username_unique` (`telegram_username`),
  ADD UNIQUE KEY `users_telegram_id_unique` (`telegram_id`),
  ADD KEY `users_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `role_menus`
--
ALTER TABLE `role_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `otps`
--
ALTER TABLE `otps`
  ADD CONSTRAINT `otps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_author_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD CONSTRAINT `role_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_menus_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
