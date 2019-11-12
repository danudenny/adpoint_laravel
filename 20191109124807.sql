/*
MySQL Backup
Database: adpoint_laravel
Backup Time: 2019-11-09 12:48:09
*/

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `adpoint_laravel`.`banners`;
DROP TABLE IF EXISTS `adpoint_laravel`.`brands`;
DROP TABLE IF EXISTS `adpoint_laravel`.`business_settings`;
DROP TABLE IF EXISTS `adpoint_laravel`.`categories`;
DROP TABLE IF EXISTS `adpoint_laravel`.`colors`;
DROP TABLE IF EXISTS `adpoint_laravel`.`countries`;
DROP TABLE IF EXISTS `adpoint_laravel`.`coupon_usages`;
DROP TABLE IF EXISTS `adpoint_laravel`.`coupons`;
DROP TABLE IF EXISTS `adpoint_laravel`.`currencies`;
DROP TABLE IF EXISTS `adpoint_laravel`.`customers`;
DROP TABLE IF EXISTS `adpoint_laravel`.`flash_deal_products`;
DROP TABLE IF EXISTS `adpoint_laravel`.`flash_deals`;
DROP TABLE IF EXISTS `adpoint_laravel`.`general_settings`;
DROP TABLE IF EXISTS `adpoint_laravel`.`home_categories`;
DROP TABLE IF EXISTS `adpoint_laravel`.`languages`;
DROP TABLE IF EXISTS `adpoint_laravel`.`links`;
DROP TABLE IF EXISTS `adpoint_laravel`.`migrations`;
DROP TABLE IF EXISTS `adpoint_laravel`.`order_details`;
DROP TABLE IF EXISTS `adpoint_laravel`.`orders`;
DROP TABLE IF EXISTS `adpoint_laravel`.`password_resets`;
DROP TABLE IF EXISTS `adpoint_laravel`.`payments`;
DROP TABLE IF EXISTS `adpoint_laravel`.`policies`;
DROP TABLE IF EXISTS `adpoint_laravel`.`product_stocks`;
DROP TABLE IF EXISTS `adpoint_laravel`.`products`;
DROP TABLE IF EXISTS `adpoint_laravel`.`reviews`;
DROP TABLE IF EXISTS `adpoint_laravel`.`roles`;
DROP TABLE IF EXISTS `adpoint_laravel`.`searches`;
DROP TABLE IF EXISTS `adpoint_laravel`.`sellers`;
DROP TABLE IF EXISTS `adpoint_laravel`.`seo_settings`;
DROP TABLE IF EXISTS `adpoint_laravel`.`shops`;
DROP TABLE IF EXISTS `adpoint_laravel`.`sliders`;
DROP TABLE IF EXISTS `adpoint_laravel`.`staff`;
DROP TABLE IF EXISTS `adpoint_laravel`.`sub_categories`;
DROP TABLE IF EXISTS `adpoint_laravel`.`sub_sub_categories`;
DROP TABLE IF EXISTS `adpoint_laravel`.`subscribers`;
DROP TABLE IF EXISTS `adpoint_laravel`.`ticket_replies`;
DROP TABLE IF EXISTS `adpoint_laravel`.`tickets`;
DROP TABLE IF EXISTS `adpoint_laravel`.`users`;
DROP TABLE IF EXISTS `adpoint_laravel`.`wallets`;
DROP TABLE IF EXISTS `adpoint_laravel`.`wishlists`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `published` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `top` int(1) NOT NULL DEFAULT 0,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `business_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `banner` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured` int(1) NOT NULL DEFAULT 0,
  `top` int(1) NOT NULL DEFAULT 0,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `brands` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=297 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `discount` double(8,2) NOT NULL,
  `discount_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(15) NOT NULL,
  `end_date` int(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` double(10,5) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `flash_deal_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flash_deal_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `discount` double(8,2) DEFAULT 0.00,
  `discount_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `flash_deals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` int(20) DEFAULT NULL,
  `end_date` int(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frontend_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_login_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_login_sidebar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_plus` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `home_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `subsubcategories` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rtl` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `variation` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double(24,2) DEFAULT NULL,
  `tax` double(8,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) DEFAULT NULL,
  `payment_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid',
  `delivery_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `shipping_address` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'unpaid',
  `payment_details` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `grand_total` double(24,2) DEFAULT NULL,
  `coupon_discount` double(8,2) NOT NULL DEFAULT 0.00,
  `code` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(20) NOT NULL,
  `viewed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `payment_details` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `stocks` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `added_by` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `photos` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flash_deal_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_provider` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_price` double(24,2) NOT NULL,
  `purchase_price` double(24,2) DEFAULT NULL,
  `choice_options` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `colors` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `variations` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `todays_deal` int(11) NOT NULL DEFAULT 0,
  `published` int(11) NOT NULL DEFAULT 1,
  `featured` int(11) NOT NULL DEFAULT 0,
  `current_stock` int(10) NOT NULL DEFAULT 0,
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `discount_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax` double(8,2) DEFAULT NULL,
  `tax_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'flat_rate',
  `shipping_cost` double(8,2) DEFAULT 0.00,
  `num_of_sale` int(11) NOT NULL DEFAULT 0,
  `meta_title` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `rating` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `termin_pembayaran` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latlong` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `audien_target` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statistik_masyarakat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jumlah_pendengarradio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target_pendengarradio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subsubcategory_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `verification_status` int(1) NOT NULL DEFAULT 0,
  `verification_info` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `cash_on_delivery_status` int(1) NOT NULL DEFAULT 0,
  `sslcommerz_status` int(1) NOT NULL DEFAULT 0,
  `stripe_status` int(1) DEFAULT 0,
  `paypal_status` int(1) NOT NULL DEFAULT 0,
  `paypal_client_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_client_secret` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssl_store_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssl_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_secret` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instamojo_status` int(1) NOT NULL DEFAULT 0,
  `instamojo_api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instamojo_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_status` int(1) NOT NULL DEFAULT 0,
  `razorpay_api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_secret` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_status` int(1) NOT NULL DEFAULT 0,
  `paystack_public_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_secret_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_to_pay` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `seo_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `revisit` int(11) NOT NULL,
  `sitemap_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sliders` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `brands` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `sub_sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brands` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_sub_category_id` (`sub_category_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` longtext COLLATE utf8_unicode_ci NOT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `viewed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'customer',
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_original` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `wallets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
BEGIN;
LOCK TABLES `adpoint_laravel`.`banners` WRITE;
DELETE FROM `adpoint_laravel`.`banners`;
INSERT INTO `adpoint_laravel`.`banners` (`id`,`photo`,`url`,`position`,`published`,`created_at`,`updated_at`) VALUES (4, 'uploads/banners/nfoc3KCkruScpk4IBbSOGH46eV7lkXIYt5tmXVjm.png', 'http://192.168.10.107/shop/', 1, 1, '2019-03-12 12:58:23', '2019-10-23 07:38:15'),(5, 'uploads/banners/al7wRU3pSRXLkNhQ8voftvSwQZdeBHJltsLLYSPq.png', 'http://192.168.10.107/shop/public/', 1, 1, '2019-03-12 12:58:41', '2019-10-23 07:38:55'),(6, 'uploads/banners/0fDNB57mFvlTFefz86mf99vasp6Piqy6sa69gwuT.png', 'http://192.168.10.107/shop/public/', 2, 1, '2019-03-12 12:58:52', '2019-10-23 07:36:44'),(7, 'uploads/banners/27fwH56q2VhjQlcQd43WSkOJ5lV3wgOSBqHoORlq.png', '#', 2, 1, '2019-05-26 12:16:38', '2019-10-23 07:37:24'),(8, 'uploads/banners/zcZL3wsLRrI38r3JS813zqDCP1rZFXiVuPfj4BCO.png', 'http://', 2, 1, '2019-06-11 12:00:06', '2019-10-23 07:37:33'),(9, 'uploads/banners/iQWxrg468SExARO1HbQEkAxWQro0kA4sve2H6SgX.png', 'http://', 1, 1, '2019-06-11 12:00:15', '2019-10-23 07:39:08');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`brands` WRITE;
DELETE FROM `adpoint_laravel`.`brands`;
INSERT INTO `adpoint_laravel`.`brands` (`id`,`name`,`logo`,`top`,`slug`,`meta_title`,`meta_description`,`created_at`,`updated_at`) VALUES (1, 'Lima', 'uploads/brands/9hndWF69yJBf5MgQqXuhhtlTLNALJvmv6uDgSZz4.png', 1, 'Lima', 'Lima', NULL, '2019-03-12 13:05:56', '2019-10-22 09:10:07'),(2, 'Global Radio', 'uploads/brands/udpgHIeQAAznVn5GGZ3AY9nbQM0oEsk8qtwkxRHd.png', 1, 'Global-Radio', 'Global Radio', NULL, '2019-03-12 13:06:13', '2019-10-22 09:14:45'),(3, 'Delta Radio', 'uploads/brands/X8w2nsrjKaQzC2kMHpEnMzt0b3ubVYjFi8GbRVng.png', 1, 'Delta-Radio-w8jC5', NULL, NULL, '2019-10-23 05:43:34', '2019-10-23 07:41:52'),(4, 'MCM Advertising', 'uploads/brands/MDo57bMRqlRI65WdDrkro0khl1onWHc3zrNfzbsZ.png', 1, 'MCM-Advertising-lTj3r', NULL, NULL, '2019-10-23 05:43:53', '2019-10-23 07:41:52'),(5, 'Oval', 'uploads/brands/AwQMJaNIeRubBmcan2pHDkMDT88rMujKDMjoYWke.png', 1, 'Oval-7d4eU', NULL, NULL, '2019-10-23 05:44:15', '2019-10-23 07:41:52'),(6, 'Cinema XXI', 'uploads/brands/YkhNbph27I1016MrTh9AjpqolyenUOzJNYwzZ9LG.png', 1, 'Cinema-XXI-2we4b', NULL, NULL, '2019-10-23 05:44:48', '2019-10-23 07:41:52'),(7, 'Pilar Advertising', 'uploads/brands/yk9M0EsyP8T8M0Lj5OTVS2qrTwGuozcyuhRRqzSO.png', 0, 'Pilar-Advertising-OnAXz', NULL, NULL, '2019-10-23 07:23:14', '2019-10-23 07:23:14'),(8, 'Gen FM', 'uploads/brands/9AMoOIXmSUTZw5WR0Z9GIGwqsPJWFeeFLRjjKEVd.jpeg', 0, 'Gen-FM-2Wt6r', NULL, NULL, '2019-10-23 07:23:26', '2019-10-23 07:23:26'),(9, 'Duta Asia Advertising', 'uploads/brands/UjeJPMTO0UqgEuEvA0I4gCemxOgh7MlZ88tn8YVN.png', 0, 'Duta-Asia-Advertising-DSbMo', NULL, NULL, '2019-10-23 07:23:44', '2019-10-23 07:23:44'),(10, 'Elfara FM', 'uploads/brands/WEjGeLqwnvDKUHzA0oqiuvvhcoKO4oOqsSsqH2uU.png', 0, 'Elfara-FM-dWGU4', NULL, NULL, '2019-10-23 07:23:59', '2019-10-23 07:23:59'),(11, 'Ubiklan', 'uploads/brands/OaTTMgfFluxq0co8qatOKiCtLK8FaD768Dt8q1kc.png', 0, 'Ubiklan-ajAqm', NULL, NULL, '2019-10-23 07:24:46', '2019-10-23 07:24:46'),(12, 'Pamintori', 'uploads/brands/ms1keNp428q0qmg7vepifDcCSvCEi67228eT0Q2y.png', 0, 'Pamintori-oOqEk', NULL, NULL, '2019-10-23 09:31:34', '2019-10-23 09:31:34');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`business_settings` WRITE;
DELETE FROM `adpoint_laravel`.`business_settings`;
INSERT INTO `adpoint_laravel`.`business_settings` (`id`,`type`,`value`,`created_at`,`updated_at`) VALUES (1, 'home_default_currency', '1', '2018-10-16 08:35:52', '2019-01-28 08:26:53'),(2, 'system_default_currency', '1', '2018-10-16 08:36:58', '2019-03-13 08:49:19'),(3, 'currency_format', '1', '2018-10-17 10:01:59', '2018-10-17 10:01:59'),(4, 'symbol_format', '1', '2018-10-17 10:01:59', '2019-01-20 09:10:55'),(5, 'no_of_decimals', '0', '2018-10-17 10:01:59', '2018-10-17 10:01:59'),(6, 'product_activation', '1', '2018-10-28 08:38:37', '2019-02-04 08:11:41'),(7, 'vendor_system_activation', '1', '2018-10-28 14:44:16', '2019-02-04 08:11:38'),(8, 'show_vendors', '1', '2018-10-28 14:44:47', '2019-02-04 08:11:13'),(9, 'paypal_payment', '0', '2018-10-28 14:45:16', '2019-01-31 12:09:10'),(10, 'stripe_payment', '0', '2018-10-28 14:45:47', '2018-11-14 08:51:51'),(11, 'cash_payment', '1', '2018-10-28 14:46:05', '2019-01-24 10:40:18'),(12, 'payumoney_payment', '0', '2018-10-28 14:46:27', '2019-03-05 12:41:36'),(13, 'best_selling', '1', '2018-12-24 15:13:44', '2019-02-14 12:29:13'),(14, 'paypal_sandbox', '1', '2019-01-16 19:44:18', '2019-01-16 19:44:18'),(15, 'sslcommerz_sandbox', '1', '2019-01-16 19:44:18', '2019-03-14 07:07:26'),(16, 'sslcommerz_payment', '0', '2019-01-24 16:39:07', '2019-01-29 13:13:46'),(17, 'vendor_commission', '20', '2019-01-31 13:18:04', '2019-04-13 13:49:26'),(18, 'verification_form', '[{\"type\":\"text\",\"label\":\"Shop URL\"},{\"type\":\"text\",\"label\":\"Nama Perusahaan\"},{\"type\":\"text\",\"label\":\"Nama Pemilik\"},{\"type\":\"text\",\"label\":\"Nomor Telepon\"},{\"type\":\"text\",\"label\":\"Nomor Rekening\"},{\"type\":\"text\",\"label\":\"Nama Bank\"},{\"type\":\"text\",\"label\":\"Alamat Perusahaan\"},{\"type\":\"file\",\"label\":\"SIUP\"}]', '2019-02-03 18:36:58', '2019-10-23 10:27:11'),(19, 'google_analytics', '0', '2019-02-06 19:22:35', '2019-02-06 19:22:35'),(20, 'facebook_login', '0', '2019-02-07 19:51:59', '2019-02-09 02:41:15'),(21, 'google_login', '0', '2019-02-07 19:52:10', '2019-10-22 08:49:26'),(22, 'twitter_login', '0', '2019-02-07 19:52:20', '2019-02-08 09:32:56'),(23, 'payumoney_payment', '1', '2019-03-05 18:38:17', '2019-03-05 18:38:17'),(24, 'payumoney_sandbox', '1', '2019-03-05 18:38:17', '2019-03-05 12:39:18'),(36, 'facebook_chat', '0', '2019-04-15 18:45:04', '2019-04-15 18:45:04'),(37, 'email_verification', '0', '2019-04-30 14:30:07', '2019-10-29 09:25:11'),(38, 'wallet_system', '0', '2019-05-19 15:05:44', '2019-05-19 09:11:57'),(39, 'coupon_system', '0', '2019-06-11 16:46:18', '2019-06-11 16:46:18'),(40, 'current_version', '1.6', '2019-06-11 16:46:18', '2019-06-11 16:46:18'),(41, 'instamojo_payment', '0', '2019-07-06 16:58:03', '2019-07-06 16:58:03'),(42, 'instamojo_sandbox', '1', '2019-07-06 16:58:43', '2019-07-06 16:58:43'),(43, 'razorpay', '0', '2019-07-06 16:58:43', '2019-07-06 16:58:43'),(44, 'paystack', '0', '2019-07-21 20:00:38', '2019-07-21 20:00:38'),(45, 'paystack', '0', '2019-10-22 18:03:09', '2019-10-22 18:03:09');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`categories` WRITE;
DELETE FROM `adpoint_laravel`.`categories`;
INSERT INTO `adpoint_laravel`.`categories` (`id`,`name`,`banner`,`icon`,`featured`,`top`,`slug`,`meta_title`,`meta_description`,`created_at`,`updated_at`,`brands`) VALUES (1, 'Billboard', 'uploads/categories/banner/qsA2IlnN0RWkJdjN481BRFEcw0QJCdSy2HRukd3E.png', 'uploads/categories/icon/hfbHla498mx2866XBOzZ3LbEVDBNT0Id4b62BJXv.png', 1, 1, 'Billboard', 'Billboard', NULL, '2019-10-22 16:41:29', '2019-10-22 09:41:29', NULL),(2, 'Videotron', 'uploads/categories/banner/liBvwOhov3tjOb0IOJpefpcc5CuU4QtPP8MIrgWj.png', 'uploads/categories/icon/C7vaWpwfvoCsklVJc5JT3BNGXAqQWWrt5wlienWM.png', 1, 1, 'Videotron', 'Videotron', NULL, '2019-10-23 12:38:44', '2019-10-23 05:38:44', NULL),(3, 'Radio', 'uploads/categories/banner/0MTL1SsO5iaCBijaiolH4Rq3l3xnvfMMtP5yOJf8.png', 'uploads/categories/icon/VHmjwjW2kkDFd6PBEZs55Eqb9EaupvhJR8A6f7pM.png', 1, 1, 'Radio', 'Radio', NULL, '2019-10-22 16:41:42', '2019-10-22 09:41:42', NULL),(4, 'Mobil', 'uploads/categories/banner/2Lq6IdsDY8fvKpNz2e6gIOlS0nBybdAVDWzzwU1o.png', 'uploads/categories/icon/CoLRmymSQPDAGRtxgodirojlQG9LQxJEWwlVobt8.png', 1, 1, 'Mobil', 'Mobil', NULL, '2019-10-23 14:41:52', '2019-10-23 07:41:52', NULL),(5, 'Motor', 'uploads/categories/banner/9e4kBqOoJDwyQQjVFiB1Tj3SrNrrwkVoLH5kE6FP.png', 'uploads/categories/icon/1YmPwRVpUxFfQoCrVGxJpV3GpJ3yg5htCPbM1gho.png', 1, 1, 'Motor', 'Motor', 'Motor', '2019-10-23 14:41:52', '2019-10-23 07:41:52', NULL),(6, 'Airport', 'uploads/categories/banner/JDQUcL37hij8VbTvNgDESa3sbgPqoXBbSYVg7RGt.png', 'uploads/categories/icon/Zf6qJf3SfeK01IDuu0E3JVbpzSi1tZRp0JZIkNO0.png', 1, 0, 'Airport', 'Airport', NULL, '2019-10-22 18:03:11', '2019-10-22 11:03:11', NULL),(7, 'Taxi', 'uploads/categories/banner/O9MFRzQiTFxrQXm3EYllCcYfKlghvz9aZ6a5Ij2r.png', 'uploads/categories/icon/dXqTuSkU4AD1VCqkFu4bE3fpiad0RL3gKFy9Y22d.png', 1, 0, 'Taxi', 'Taxi', NULL, '2019-10-22 18:03:11', '2019-10-22 11:03:11', NULL),(8, 'Bus', 'uploads/categories/banner/P0vxaKNHhr3wcI2emyNn5EfaLXzNooi9SgKz77Wl.png', 'uploads/categories/icon/wzo6rcqOZ9Z4KxuDCI7MzuarkuPyJP04tvQ4dXoI.png', 1, 1, 'Bus', 'Bus', NULL, '2019-10-23 12:38:44', '2019-10-23 05:38:44', NULL),(9, 'Movie Theater', 'uploads/categories/banner/hPQXW9r2qrgkVZ8i6UBjC84zCGFTNPgMBBcpgF6Q.png', 'uploads/categories/icon/j1hjZIUtJeLkxWAE91avMSau9GMWL93998yayvzd.png', 1, 0, 'Movie-Theater', 'Movie Theater', NULL, '2019-10-22 18:03:11', '2019-10-22 11:03:11', NULL),(10, 'Train', 'uploads/categories/banner/bZOsar7C95nPGoaKWeUqrPFSC0CcGtc4aR0cFW1D.png', 'uploads/categories/icon/Hv45Yhsf5exewdPJI7IJQKU40Uh4us4gXg7i3cJw.png', 1, 0, 'Train', 'Train', NULL, '2019-10-22 18:03:11', '2019-10-22 11:03:11', NULL),(11, 'Airline', 'uploads/categories/banner/aacFYKdACHtteuqyvB9XdmbICDbvCFcUTAVZdwi7.png', 'uploads/categories/icon/agF0R374cYdxvURNYoZaVkNcOytt6EnzP0KhxAi2.png', 1, 0, 'Airline', 'Airline', NULL, '2019-10-22 18:03:11', '2019-10-22 11:03:11', NULL);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`colors` WRITE;
DELETE FROM `adpoint_laravel`.`colors`;
INSERT INTO `adpoint_laravel`.`colors` (`id`,`name`,`code`,`created_at`,`updated_at`) VALUES (1, 'IndianRed', '#CD5C5C', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(2, 'LightCoral', '#F08080', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(3, 'Salmon', '#FA8072', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(4, 'DarkSalmon', '#E9967A', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(5, 'LightSalmon', '#FFA07A', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(6, 'Crimson', '#DC143C', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(7, 'Red', '#FF0000', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(8, 'FireBrick', '#B22222', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(9, 'DarkRed', '#8B0000', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(10, 'Pink', '#FFC0CB', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(11, 'LightPink', '#FFB6C1', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(12, 'HotPink', '#FF69B4', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(13, 'DeepPink', '#FF1493', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(14, 'MediumVioletRed', '#C71585', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(15, 'PaleVioletRed', '#DB7093', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(16, 'LightSalmon', '#FFA07A', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(17, 'Coral', '#FF7F50', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(18, 'Tomato', '#FF6347', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(19, 'OrangeRed', '#FF4500', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(20, 'DarkOrange', '#FF8C00', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(21, 'Orange', '#FFA500', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(22, 'Gold', '#FFD700', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(23, 'Yellow', '#FFFF00', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(24, 'LightYellow', '#FFFFE0', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(25, 'LemonChiffon', '#FFFACD', '2018-11-05 09:12:26', '2018-11-05 09:12:26'),(26, 'LightGoldenrodYellow', '#FAFAD2', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(27, 'PapayaWhip', '#FFEFD5', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(28, 'Moccasin', '#FFE4B5', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(29, 'PeachPuff', '#FFDAB9', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(30, 'PaleGoldenrod', '#EEE8AA', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(31, 'Khaki', '#F0E68C', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(32, 'DarkKhaki', '#BDB76B', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(33, 'Lavender', '#E6E6FA', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(34, 'Thistle', '#D8BFD8', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(35, 'Plum', '#DDA0DD', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(36, 'Violet', '#EE82EE', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(37, 'Orchid', '#DA70D6', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(38, 'Fuchsia', '#FF00FF', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(39, 'Magenta', '#FF00FF', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(40, 'MediumOrchid', '#BA55D3', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(41, 'MediumPurple', '#9370DB', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(42, 'Amethyst', '#9966CC', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(43, 'BlueViolet', '#8A2BE2', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(44, 'DarkViolet', '#9400D3', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(45, 'DarkOrchid', '#9932CC', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(46, 'DarkMagenta', '#8B008B', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(47, 'Purple', '#800080', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(48, 'Indigo', '#4B0082', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(49, 'SlateBlue', '#6A5ACD', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(50, 'DarkSlateBlue', '#483D8B', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(51, 'MediumSlateBlue', '#7B68EE', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(52, 'GreenYellow', '#ADFF2F', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(53, 'Chartreuse', '#7FFF00', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(54, 'LawnGreen', '#7CFC00', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(55, 'Lime', '#00FF00', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(56, 'LimeGreen', '#32CD32', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(57, 'PaleGreen', '#98FB98', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(58, 'LightGreen', '#90EE90', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(59, 'MediumSpringGreen', '#00FA9A', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(60, 'SpringGreen', '#00FF7F', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(61, 'MediumSeaGreen', '#3CB371', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(62, 'SeaGreen', '#2E8B57', '2018-11-05 09:12:27', '2018-11-05 09:12:27'),(63, 'ForestGreen', '#228B22', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(64, 'Green', '#008000', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(65, 'DarkGreen', '#006400', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(66, 'YellowGreen', '#9ACD32', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(67, 'OliveDrab', '#6B8E23', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(68, 'Olive', '#808000', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(69, 'DarkOliveGreen', '#556B2F', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(70, 'MediumAquamarine', '#66CDAA', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(71, 'DarkSeaGreen', '#8FBC8F', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(72, 'LightSeaGreen', '#20B2AA', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(73, 'DarkCyan', '#008B8B', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(74, 'Teal', '#008080', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(75, 'Aqua', '#00FFFF', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(76, 'Cyan', '#00FFFF', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(77, 'LightCyan', '#E0FFFF', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(78, 'PaleTurquoise', '#AFEEEE', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(79, 'Aquamarine', '#7FFFD4', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(80, 'Turquoise', '#40E0D0', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(81, 'MediumTurquoise', '#48D1CC', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(82, 'DarkTurquoise', '#00CED1', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(83, 'CadetBlue', '#5F9EA0', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(84, 'SteelBlue', '#4682B4', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(85, 'LightSteelBlue', '#B0C4DE', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(86, 'PowderBlue', '#B0E0E6', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(87, 'LightBlue', '#ADD8E6', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(88, 'SkyBlue', '#87CEEB', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(89, 'LightSkyBlue', '#87CEFA', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(90, 'DeepSkyBlue', '#00BFFF', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(91, 'DodgerBlue', '#1E90FF', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(92, 'CornflowerBlue', '#6495ED', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(93, 'MediumSlateBlue', '#7B68EE', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(94, 'RoyalBlue', '#4169E1', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(95, 'Blue', '#0000FF', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(96, 'MediumBlue', '#0000CD', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(97, 'DarkBlue', '#00008B', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(98, 'Navy', '#000080', '2018-11-05 09:12:28', '2018-11-05 09:12:28'),(99, 'MidnightBlue', '#191970', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(100, 'Cornsilk', '#FFF8DC', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(101, 'BlanchedAlmond', '#FFEBCD', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(102, 'Bisque', '#FFE4C4', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(103, 'NavajoWhite', '#FFDEAD', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(104, 'Wheat', '#F5DEB3', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(105, 'BurlyWood', '#DEB887', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(106, 'Tan', '#D2B48C', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(107, 'RosyBrown', '#BC8F8F', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(108, 'SandyBrown', '#F4A460', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(109, 'Goldenrod', '#DAA520', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(110, 'DarkGoldenrod', '#B8860B', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(111, 'Peru', '#CD853F', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(112, 'Chocolate', '#D2691E', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(113, 'SaddleBrown', '#8B4513', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(114, 'Sienna', '#A0522D', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(115, 'Brown', '#A52A2A', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(116, 'Maroon', '#800000', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(117, 'White', '#FFFFFF', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(118, 'Snow', '#FFFAFA', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(119, 'Honeydew', '#F0FFF0', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(120, 'MintCream', '#F5FFFA', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(121, 'Azure', '#F0FFFF', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(122, 'AliceBlue', '#F0F8FF', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(123, 'GhostWhite', '#F8F8FF', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(124, 'WhiteSmoke', '#F5F5F5', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(125, 'Seashell', '#FFF5EE', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(126, 'Beige', '#F5F5DC', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(127, 'OldLace', '#FDF5E6', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(128, 'FloralWhite', '#FFFAF0', '2018-11-05 09:12:29', '2018-11-05 09:12:29'),(129, 'Ivory', '#FFFFF0', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(130, 'AntiqueWhite', '#FAEBD7', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(131, 'Linen', '#FAF0E6', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(132, 'LavenderBlush', '#FFF0F5', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(133, 'MistyRose', '#FFE4E1', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(134, 'Gainsboro', '#DCDCDC', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(135, 'LightGrey', '#D3D3D3', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(136, 'Silver', '#C0C0C0', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(137, 'DarkGray', '#A9A9A9', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(138, 'Gray', '#808080', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(139, 'DimGray', '#696969', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(140, 'LightSlateGray', '#778899', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(141, 'SlateGray', '#708090', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(142, 'DarkSlateGray', '#2F4F4F', '2018-11-05 09:12:30', '2018-11-05 09:12:30'),(143, 'Black', '#000000', '2018-11-05 09:12:30', '2018-11-05 09:12:30');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`countries` WRITE;
DELETE FROM `adpoint_laravel`.`countries`;
INSERT INTO `adpoint_laravel`.`countries` (`id`,`code`,`name`) VALUES (1, 'AF', 'Afghanistan'),(2, 'AL', 'Albania'),(3, 'DZ', 'Algeria'),(4, 'DS', 'American Samoa'),(5, 'AD', 'Andorra'),(6, 'AO', 'Angola'),(7, 'AI', 'Anguilla'),(8, 'AQ', 'Antarctica'),(9, 'AG', 'Antigua and Barbuda'),(10, 'AR', 'Argentina'),(11, 'AM', 'Armenia'),(12, 'AW', 'Aruba'),(13, 'AU', 'Australia'),(14, 'AT', 'Austria'),(15, 'AZ', 'Azerbaijan'),(16, 'BS', 'Bahamas'),(17, 'BH', 'Bahrain'),(18, 'BD', 'Bangladesh'),(19, 'BB', 'Barbados'),(20, 'BY', 'Belarus'),(21, 'BE', 'Belgium'),(22, 'BZ', 'Belize'),(23, 'BJ', 'Benin'),(24, 'BM', 'Bermuda'),(25, 'BT', 'Bhutan'),(26, 'BO', 'Bolivia'),(27, 'BA', 'Bosnia and Herzegovina'),(28, 'BW', 'Botswana'),(29, 'BV', 'Bouvet Island'),(30, 'BR', 'Brazil'),(31, 'IO', 'British Indian Ocean Territory'),(32, 'BN', 'Brunei Darussalam'),(33, 'BG', 'Bulgaria'),(34, 'BF', 'Burkina Faso'),(35, 'BI', 'Burundi'),(36, 'KH', 'Cambodia'),(37, 'CM', 'Cameroon'),(38, 'CA', 'Canada'),(39, 'CV', 'Cape Verde'),(40, 'KY', 'Cayman Islands'),(41, 'CF', 'Central African Republic'),(42, 'TD', 'Chad'),(43, 'CL', 'Chile'),(44, 'CN', 'China'),(45, 'CX', 'Christmas Island'),(46, 'CC', 'Cocos (Keeling) Islands'),(47, 'CO', 'Colombia'),(48, 'KM', 'Comoros'),(49, 'CG', 'Congo'),(50, 'CK', 'Cook Islands'),(51, 'CR', 'Costa Rica'),(52, 'HR', 'Croatia (Hrvatska)'),(53, 'CU', 'Cuba'),(54, 'CY', 'Cyprus'),(55, 'CZ', 'Czech Republic'),(56, 'DK', 'Denmark'),(57, 'DJ', 'Djibouti'),(58, 'DM', 'Dominica'),(59, 'DO', 'Dominican Republic'),(60, 'TP', 'East Timor'),(61, 'EC', 'Ecuador'),(62, 'EG', 'Egypt'),(63, 'SV', 'El Salvador'),(64, 'GQ', 'Equatorial Guinea'),(65, 'ER', 'Eritrea'),(66, 'EE', 'Estonia'),(67, 'ET', 'Ethiopia'),(68, 'FK', 'Falkland Islands (Malvinas)'),(69, 'FO', 'Faroe Islands'),(70, 'FJ', 'Fiji'),(71, 'FI', 'Finland'),(72, 'FR', 'France'),(73, 'FX', 'France, Metropolitan'),(74, 'GF', 'French Guiana'),(75, 'PF', 'French Polynesia'),(76, 'TF', 'French Southern Territories'),(77, 'GA', 'Gabon'),(78, 'GM', 'Gambia'),(79, 'GE', 'Georgia'),(80, 'DE', 'Germany'),(81, 'GH', 'Ghana'),(82, 'GI', 'Gibraltar'),(83, 'GK', 'Guernsey'),(84, 'GR', 'Greece'),(85, 'GL', 'Greenland'),(86, 'GD', 'Grenada'),(87, 'GP', 'Guadeloupe'),(88, 'GU', 'Guam'),(89, 'GT', 'Guatemala'),(90, 'GN', 'Guinea'),(91, 'GW', 'Guinea-Bissau'),(92, 'GY', 'Guyana'),(93, 'HT', 'Haiti'),(94, 'HM', 'Heard and Mc Donald Islands'),(95, 'HN', 'Honduras'),(96, 'HK', 'Hong Kong'),(97, 'HU', 'Hungary'),(98, 'IS', 'Iceland'),(99, 'IN', 'India'),(100, 'IM', 'Isle of Man'),(101, 'ID', 'Indonesia'),(102, 'IR', 'Iran (Islamic Republic of)'),(103, 'IQ', 'Iraq'),(104, 'IE', 'Ireland'),(105, 'IL', 'Israel'),(106, 'IT', 'Italy'),(107, 'CI', 'Ivory Coast'),(108, 'JE', 'Jersey'),(109, 'JM', 'Jamaica'),(110, 'JP', 'Japan'),(111, 'JO', 'Jordan'),(112, 'KZ', 'Kazakhstan'),(113, 'KE', 'Kenya'),(114, 'KI', 'Kiribati'),(115, 'KP', 'Korea, Democratic People\'s Republic of'),(116, 'KR', 'Korea, Republic of'),(117, 'XK', 'Kosovo'),(118, 'KW', 'Kuwait'),(119, 'KG', 'Kyrgyzstan'),(120, 'LA', 'Lao People\'s Democratic Republic'),(121, 'LV', 'Latvia'),(122, 'LB', 'Lebanon'),(123, 'LS', 'Lesotho'),(124, 'LR', 'Liberia'),(125, 'LY', 'Libyan Arab Jamahiriya'),(126, 'LI', 'Liechtenstein'),(127, 'LT', 'Lithuania'),(128, 'LU', 'Luxembourg'),(129, 'MO', 'Macau'),(130, 'MK', 'Macedonia'),(131, 'MG', 'Madagascar'),(132, 'MW', 'Malawi'),(133, 'MY', 'Malaysia'),(134, 'MV', 'Maldives'),(135, 'ML', 'Mali'),(136, 'MT', 'Malta'),(137, 'MH', 'Marshall Islands'),(138, 'MQ', 'Martinique'),(139, 'MR', 'Mauritania'),(140, 'MU', 'Mauritius'),(141, 'TY', 'Mayotte'),(142, 'MX', 'Mexico'),(143, 'FM', 'Micronesia, Federated States of'),(144, 'MD', 'Moldova, Republic of'),(145, 'MC', 'Monaco'),(146, 'MN', 'Mongolia'),(147, 'ME', 'Montenegro'),(148, 'MS', 'Montserrat'),(149, 'MA', 'Morocco'),(150, 'MZ', 'Mozambique'),(151, 'MM', 'Myanmar'),(152, 'NA', 'Namibia'),(153, 'NR', 'Nauru'),(154, 'NP', 'Nepal'),(155, 'NL', 'Netherlands'),(156, 'AN', 'Netherlands Antilles'),(157, 'NC', 'New Caledonia'),(158, 'NZ', 'New Zealand'),(159, 'NI', 'Nicaragua'),(160, 'NE', 'Niger'),(161, 'NG', 'Nigeria'),(162, 'NU', 'Niue'),(163, 'NF', 'Norfolk Island'),(164, 'MP', 'Northern Mariana Islands'),(165, 'NO', 'Norway'),(166, 'OM', 'Oman'),(167, 'PK', 'Pakistan'),(168, 'PW', 'Palau'),(169, 'PS', 'Palestine'),(170, 'PA', 'Panama'),(171, 'PG', 'Papua New Guinea'),(172, 'PY', 'Paraguay'),(173, 'PE', 'Peru'),(174, 'PH', 'Philippines'),(175, 'PN', 'Pitcairn'),(176, 'PL', 'Poland'),(177, 'PT', 'Portugal'),(178, 'PR', 'Puerto Rico'),(179, 'QA', 'Qatar'),(180, 'RE', 'Reunion'),(181, 'RO', 'Romania'),(182, 'RU', 'Russian Federation'),(183, 'RW', 'Rwanda'),(184, 'KN', 'Saint Kitts and Nevis'),(185, 'LC', 'Saint Lucia'),(186, 'VC', 'Saint Vincent and the Grenadines'),(187, 'WS', 'Samoa'),(188, 'SM', 'San Marino'),(189, 'ST', 'Sao Tome and Principe'),(190, 'SA', 'Saudi Arabia'),(191, 'SN', 'Senegal'),(192, 'RS', 'Serbia'),(193, 'SC', 'Seychelles'),(194, 'SL', 'Sierra Leone'),(195, 'SG', 'Singapore'),(196, 'SK', 'Slovakia'),(197, 'SI', 'Slovenia'),(198, 'SB', 'Solomon Islands'),(199, 'SO', 'Somalia'),(200, 'ZA', 'South Africa'),(201, 'GS', 'South Georgia South Sandwich Islands'),(202, 'SS', 'South Sudan'),(203, 'ES', 'Spain'),(204, 'LK', 'Sri Lanka'),(205, 'SH', 'St. Helena'),(206, 'PM', 'St. Pierre and Miquelon'),(207, 'SD', 'Sudan'),(208, 'SR', 'Suriname'),(209, 'SJ', 'Svalbard and Jan Mayen Islands'),(210, 'SZ', 'Swaziland'),(211, 'SE', 'Sweden'),(212, 'CH', 'Switzerland'),(213, 'SY', 'Syrian Arab Republic'),(214, 'TW', 'Taiwan'),(215, 'TJ', 'Tajikistan'),(216, 'TZ', 'Tanzania, United Republic of'),(217, 'TH', 'Thailand'),(218, 'TG', 'Togo'),(219, 'TK', 'Tokelau'),(220, 'TO', 'Tonga'),(221, 'TT', 'Trinidad and Tobago'),(222, 'TN', 'Tunisia'),(223, 'TR', 'Turkey'),(224, 'TM', 'Turkmenistan'),(225, 'TC', 'Turks and Caicos Islands'),(226, 'TV', 'Tuvalu'),(227, 'UG', 'Uganda'),(228, 'UA', 'Ukraine'),(229, 'AE', 'United Arab Emirates'),(230, 'GB', 'United Kingdom'),(231, 'US', 'United States'),(232, 'UM', 'United States minor outlying islands'),(233, 'UY', 'Uruguay'),(234, 'UZ', 'Uzbekistan'),(235, 'VU', 'Vanuatu'),(236, 'VA', 'Vatican City State'),(237, 'VE', 'Venezuela'),(238, 'VN', 'Vietnam'),(239, 'VG', 'Virgin Islands (British)'),(240, 'VI', 'Virgin Islands (U.S.)'),(241, 'WF', 'Wallis and Futuna Islands'),(242, 'EH', 'Western Sahara'),(243, 'YE', 'Yemen'),(244, 'ZR', 'Zaire'),(245, 'ZM', 'Zambia'),(246, 'ZW', 'Zimbabwe'),(247, 'AF', 'Afghanistan'),(248, 'AL', 'Albania'),(249, 'DZ', 'Algeria'),(250, 'DS', 'American Samoa'),(251, 'AD', 'Andorra'),(252, 'AO', 'Angola'),(253, 'AI', 'Anguilla'),(254, 'AQ', 'Antarctica'),(255, 'AG', 'Antigua and Barbuda'),(256, 'AR', 'Argentina'),(257, 'AM', 'Armenia'),(258, 'AW', 'Aruba'),(259, 'AU', 'Australia'),(260, 'AT', 'Austria'),(261, 'AZ', 'Azerbaijan'),(262, 'BS', 'Bahamas'),(263, 'BH', 'Bahrain'),(264, 'BD', 'Bangladesh'),(265, 'BB', 'Barbados'),(266, 'BY', 'Belarus'),(267, 'BE', 'Belgium'),(268, 'BZ', 'Belize'),(269, 'BJ', 'Benin'),(270, 'BM', 'Bermuda'),(271, 'BT', 'Bhutan'),(272, 'BO', 'Bolivia'),(273, 'BA', 'Bosnia and Herzegovina'),(274, 'BW', 'Botswana'),(275, 'BV', 'Bouvet Island'),(276, 'BR', 'Brazil'),(277, 'IO', 'British Indian Ocean Territory'),(278, 'BN', 'Brunei Darussalam'),(279, 'BG', 'Bulgaria'),(280, 'BF', 'Burkina Faso'),(281, 'BI', 'Burundi'),(282, 'KH', 'Cambodia'),(283, 'CM', 'Cameroon'),(284, 'CA', 'Canada'),(285, 'CV', 'Cape Verde'),(286, 'KY', 'Cayman Islands'),(287, 'CF', 'Central African Republic'),(288, 'TD', 'Chad'),(289, 'CL', 'Chile'),(290, 'CN', 'China'),(291, 'CX', 'Christmas Island'),(292, 'CC', 'Cocos (Keeling) Islands'),(293, 'CO', 'Colombia'),(294, 'KM', 'Comoros'),(295, 'CG', 'Congo'),(296, 'CK', 'Cook Islands');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`coupon_usages` WRITE;
DELETE FROM `adpoint_laravel`.`coupon_usages`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`coupons` WRITE;
DELETE FROM `adpoint_laravel`.`coupons`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`currencies` WRITE;
DELETE FROM `adpoint_laravel`.`currencies`;
INSERT INTO `adpoint_laravel`.`currencies` (`id`,`name`,`symbol`,`exchange_rate`,`status`,`code`,`created_at`,`updated_at`) VALUES (1, 'Indonesia Rupiah', 'Rp', 1.00000, 1, 'IDR', '2018-10-09 18:35:08', '2018-10-17 12:50:52');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`customers` WRITE;
DELETE FROM `adpoint_laravel`.`customers`;
INSERT INTO `adpoint_laravel`.`customers` (`id`,`user_id`,`created_at`,`updated_at`) VALUES (5, 17, '2019-10-29 09:19:29', '2019-10-29 09:19:29'),(7, 19, '2019-10-29 09:30:52', '2019-10-29 09:30:52'),(9, 22, '2019-11-04 04:44:27', '2019-11-04 04:44:27');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`flash_deal_products` WRITE;
DELETE FROM `adpoint_laravel`.`flash_deal_products`;
INSERT INTO `adpoint_laravel`.`flash_deal_products` (`id`,`flash_deal_id`,`product_id`,`discount`,`discount_type`,`created_at`,`updated_at`) VALUES (19, 4, 9, 10.00, 'percent', '2019-11-04 09:39:15', '2019-11-04 09:39:15');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`flash_deals` WRITE;
DELETE FROM `adpoint_laravel`.`flash_deals`;
INSERT INTO `adpoint_laravel`.`flash_deals` (`id`,`title`,`start_date`,`end_date`,`status`,`created_at`,`updated_at`) VALUES (4, 'Flash Deal', 1571788800, 1574294400, 0, '2019-10-23 07:25:42', '2019-11-04 10:35:37');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`general_settings` WRITE;
DELETE FROM `adpoint_laravel`.`general_settings`;
INSERT INTO `adpoint_laravel`.`general_settings` (`id`,`frontend_color`,`logo`,`admin_logo`,`admin_login_background`,`admin_login_sidebar`,`favicon`,`site_name`,`address`,`description`,`phone`,`email`,`facebook`,`instagram`,`twitter`,`youtube`,`google_plus`,`created_at`,`updated_at`) VALUES (1, '4', 'uploads/logo/GJh2JiAOxNqMi4drWEZOcpOibEVaY4xZ6z5qXj2s.png', 'uploads/admin_logo/gRSS4HcXD9kIvLoTSYuXZmr7Gbj8sNmFQgYWBCMh.ico', NULL, NULL, 'uploads/favicon/9o6o4xXKa1rLZXblGSIHKdsiY7pqnpuqGmFA3o4f.ico', 'Adpoint', 'jakarta', '© 2018. PT. Adpoint Media Online allright reserved.\r\nSemua content yang ada di lindungi oleh undang undang hak cipta. Dilarang mencopy atau mencontoh tanpa seizin adpoint indonesia.', '082221114716', 'danudenny@gmail.com', 'https://www.facebook.com', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.youtube.com', 'https://www.googleplus.com', '2019-10-23 22:45:26', '2019-10-23 15:45:26');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`home_categories` WRITE;
DELETE FROM `adpoint_laravel`.`home_categories`;
INSERT INTO `adpoint_laravel`.`home_categories` (`id`,`category_id`,`subsubcategories`,`status`,`created_at`,`updated_at`) VALUES (1, 1, '[\"1\"]', 0, '2019-03-12 13:38:23', '2019-10-23 16:02:09'),(2, 2, '[\"10\"]', 0, '2019-03-12 13:44:54', '2019-10-23 07:33:32'),(3, 3, '[\"4\",\"8\"]', 0, '2019-10-23 07:33:24', '2019-10-23 16:02:10');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`languages` WRITE;
DELETE FROM `adpoint_laravel`.`languages`;
INSERT INTO `adpoint_laravel`.`languages` (`id`,`name`,`code`,`rtl`,`created_at`,`updated_at`) VALUES (1, 'English', 'en', 0, '2019-01-20 19:13:20', '2019-01-20 19:13:20');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`links` WRITE;
DELETE FROM `adpoint_laravel`.`links`;
INSERT INTO `adpoint_laravel`.`links` (`id`,`name`,`url`,`created_at`,`updated_at`) VALUES (1, 'Ad Insight', '#', '2019-11-04 10:31:08', '2019-11-04 10:31:09'),(2, 'Why Us', '#', '2019-11-04 10:30:31', '2019-11-04 10:30:31'),(3, 'Contact Us', '#', '2019-11-04 10:30:39', '2019-11-04 10:30:39'),(4, 'F.A.Q', '#', '2019-11-04 10:30:52', '2019-11-04 10:30:52');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`migrations` WRITE;
DELETE FROM `adpoint_laravel`.`migrations`;
INSERT INTO `adpoint_laravel`.`migrations` (`id`,`migration`,`batch`) VALUES (1, '2014_10_12_000000_create_users_table', 1),(2, '2014_10_12_100000_create_password_resets_table', 1);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`order_details` WRITE;
DELETE FROM `adpoint_laravel`.`order_details`;
INSERT INTO `adpoint_laravel`.`order_details` (`id`,`order_id`,`seller_id`,`product_id`,`variation`,`price`,`tax`,`shipping_cost`,`quantity`,`payment_status`,`delivery_status`,`created_at`,`updated_at`) VALUES (1, 1, 20, 9, 'Bulanan', 480000000.00, 0.00, 0.00, 4, 'unpaid', 'pending', '2019-11-05 06:22:21', '2019-11-05 06:22:21');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`orders` WRITE;
DELETE FROM `adpoint_laravel`.`orders`;
INSERT INTO `adpoint_laravel`.`orders` (`id`,`user_id`,`guest_id`,`shipping_address`,`payment_type`,`payment_status`,`payment_details`,`grand_total`,`coupon_discount`,`code`,`date`,`viewed`,`created_at`,`updated_at`,`start_date`,`end_date`) VALUES (1, 20, NULL, '{\"name\":\"MCM Media Networks\",\"email\":\"denny.danuwijaya@imaniprima.com\",\"address\":\"Jl. Pahlawan Seribu Golden Road Blok C.27\\/No.49.BSD City\",\"country\":\"Indonesia\",\"city\":\"Tangerang Selatan\",\"postal_code\":\"1234\",\"phone\":\"081256644444\",\"checkout_type\":\"logged\"}', 'cash_on_delivery', 'unpaid', NULL, 480000000.00, 0.00, '20191105-062221', 1572934941, 0, '2019-11-05 06:22:21', '2019-11-05 06:22:21', NULL, NULL);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`password_resets` WRITE;
DELETE FROM `adpoint_laravel`.`password_resets`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`payments` WRITE;
DELETE FROM `adpoint_laravel`.`payments`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`policies` WRITE;
DELETE FROM `adpoint_laravel`.`policies`;
INSERT INTO `adpoint_laravel`.`policies` (`id`,`name`,`content`,`created_at`,`updated_at`) VALUES (1, 'support_policy', '', '2019-10-29 16:03:12', '2019-01-22 12:13:15'),(2, 'return_policy', '', '2019-10-29 16:03:14', '2019-01-24 12:40:11'),(4, 'seller_policy', '', '2019-10-29 16:03:15', '2019-02-05 00:50:15'),(5, 'terms', '', '2019-10-29 16:03:18', '0000-00-00 00:00:00'),(6, 'privacy_policy', '', '2019-10-29 16:03:16', '0000-00-00 00:00:00');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`product_stocks` WRITE;
DELETE FROM `adpoint_laravel`.`product_stocks`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`products` WRITE;
DELETE FROM `adpoint_laravel`.`products`;
INSERT INTO `adpoint_laravel`.`products` (`id`,`name`,`added_by`,`user_id`,`category_id`,`subcategory_id`,`brand_id`,`photos`,`thumbnail_img`,`featured_img`,`flash_deal_img`,`video_provider`,`video_link`,`tags`,`description`,`unit_price`,`purchase_price`,`choice_options`,`colors`,`variations`,`todays_deal`,`published`,`featured`,`current_stock`,`unit`,`discount`,`discount_type`,`tax`,`tax_type`,`shipping_type`,`shipping_cost`,`num_of_sale`,`meta_title`,`meta_description`,`meta_img`,`pdf`,`slug`,`rating`,`created_at`,`updated_at`,`termin_pembayaran`,`alamat`,`latlong`,`provinsi`,`kota`,`kecamatan`,`audien_target`,`statistik_masyarakat`,`jumlah_pendengarradio`,`target_pendengarradio`,`subsubcategory_id`) VALUES (10, 'Billboard Test', 'seller', 20, 1, 14, 4, '[\"uploads\\/products\\/photos\\/gRfHI7OSP1plHuLl5nX2XVUak88BAH9hfddzM03X.jpeg\"]', 'uploads/products/thumbnail/o84dgb901luqQBaqUfQ8o6YncnnWeGwoFgI1s3k3.jpeg', 'uploads/products/featured/Uk3c3ivDV16hN3uBSuVVZjB9456THa0FMaimkWB0.jpeg', 'uploads/products/flash_deal/0PM65wErgjoOyVN42XG0zzdNYea0ABXkoWsJDi22.jpeg', 'youtube', NULL, 'Bill', 'Bill', 60000.00, NULL, '[{\"name\":\"choice_0\",\"title\":\"Periode\",\"options\":[\"Harian\",\"Bulanan\",\"Tahunan\"]}]', NULL, '{\"Harian\":{\"price\":\"6000\",\"sku\":\"BT-Harian\",\"qty\":\"10\"},\"Bulanan\":{\"price\":\"60000\",\"sku\":\"BT-Bulanan\",\"qty\":\"10\"},\"Tahunan\":{\"price\":\"600000\",\"sku\":\"BT-Tahunan\",\"qty\":\"10\"}}', 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, 'free', 0.00, 0, 'Bill', 'bill', 'uploads/products/meta/pREm2tmmeW6cbmU0ZNHPfbQKG6RWnVHIueVWOUlG.jpeg', NULL, 'Billboard-Test-zVYR9', 0.00, '2019-11-06 14:57:30', '2019-11-06 14:57:30', 'Bill', 'Gg. Syah Iran No.8, RT.3/RW.9, Ragunan, Kec. Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12540, Indonesia', '-6.287655407741582,106.82237738484082', 'DKI JAKARTA', 'KOTA JAKARTA SELATAN', 'PASAR MINGGU', NULL, NULL, NULL, NULL, NULL);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`reviews` WRITE;
DELETE FROM `adpoint_laravel`.`reviews`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`roles` WRITE;
DELETE FROM `adpoint_laravel`.`roles`;
INSERT INTO `adpoint_laravel`.`roles` (`id`,`name`,`permissions`,`created_at`,`updated_at`) VALUES (1, 'Manager', '[\"1\",\"2\",\"4\"]', '2018-10-10 11:39:47', '2018-10-10 11:51:37'),(2, 'Accountant', '[\"2\",\"3\"]', '2018-10-10 11:52:09', '2018-10-10 11:52:09');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`searches` WRITE;
DELETE FROM `adpoint_laravel`.`searches`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`sellers` WRITE;
DELETE FROM `adpoint_laravel`.`sellers`;
INSERT INTO `adpoint_laravel`.`sellers` (`id`,`user_id`,`verification_status`,`verification_info`,`cash_on_delivery_status`,`sslcommerz_status`,`stripe_status`,`paypal_status`,`paypal_client_id`,`paypal_client_secret`,`ssl_store_id`,`ssl_password`,`stripe_key`,`stripe_secret`,`instamojo_status`,`instamojo_api_key`,`instamojo_token`,`razorpay_status`,`razorpay_api_key`,`razorpay_secret`,`paystack_status`,`paystack_public_key`,`paystack_secret_key`,`admin_to_pay`,`created_at`,`updated_at`) VALUES (8, 20, 1, '[{\"type\":\"text\",\"label\":\"Shop URL\",\"value\":\"mcmmedia\"},{\"type\":\"text\",\"label\":\"Nama Perusahaan\",\"value\":\"MCM Media Networks\"},{\"type\":\"text\",\"label\":\"Nama Pemilik\",\"value\":\"MCM\"},{\"type\":\"text\",\"label\":\"Nomor Telepon\",\"value\":\"62215385359\"},{\"type\":\"text\",\"label\":\"Nomor Rekening\",\"value\":\"6805069591\"},{\"type\":\"text\",\"label\":\"Nama Bank\",\"value\":\"BCA\"},{\"type\":\"text\",\"label\":\"Alamat Perusahaan\",\"value\":\"Jl. Pahlawan Seribu Golden Road Blok C.27\\/No.49\"},{\"type\":\"file\",\"label\":\"SIUP\",\"value\":\"uploads\\/verification_form\\/z6jm9wRHQMZ8JZizoQHHDqBRVnq7zVGqWYx7c0W0.jpeg\"}]', 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, -999999.99, '2019-10-29 09:48:40', '2019-11-05 06:22:29');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`seo_settings` WRITE;
DELETE FROM `adpoint_laravel`.`seo_settings`;
INSERT INTO `adpoint_laravel`.`seo_settings` (`id`,`keyword`,`author`,`revisit`,`sitemap_link`,`description`,`created_at`,`updated_at`) VALUES (1, 'adpoint,advertising', 'Adpoint', 11, 'https://www.adpoint.id', '', '2019-11-04 05:36:41', '2019-11-04 05:36:42');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`shops` WRITE;
DELETE FROM `adpoint_laravel`.`shops`;
INSERT INTO `adpoint_laravel`.`shops` (`id`,`user_id`,`name`,`logo`,`sliders`,`address`,`facebook`,`google`,`twitter`,`youtube`,`slug`,`meta_title`,`meta_description`,`created_at`,`updated_at`) VALUES (8, 20, 'MCM Media Networks', 'uploads/shop/logo/csAmVwPBBYtSWqTmuXo9wDwA90VOcH4OVegiBxka.png', NULL, 'Jl. Pahlawan Seribu Golden Road Blok C.27/No.49 BSD City - Tangerang Selatan - Banten', NULL, NULL, NULL, NULL, 'MCM-Media-Networks-8', 'MCM', 'MCM', '2019-10-29 09:48:40', '2019-10-29 09:49:05'),(9, 21, 'Nazmudin', NULL, NULL, 'Kp leuwilisung Rt/01 rw/01, Jl raya cibeber raya', NULL, NULL, NULL, NULL, 'Nazmudin-', NULL, NULL, '2019-11-04 04:42:36', '2019-11-04 04:42:36');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`sliders` WRITE;
DELETE FROM `adpoint_laravel`.`sliders`;
INSERT INTO `adpoint_laravel`.`sliders` (`id`,`photo`,`published`,`created_at`,`updated_at`) VALUES (9, 'uploads/sliders/s91ZsU2tDWk65xy5wQXmdTwt6RIBenSICl2DL0hA.jpeg', 1, '2019-10-23 07:35:27', '2019-10-23 07:35:27'),(10, 'uploads/sliders/0Bb6BZt49TMc0khzh1jOYFEyEtDwBtdwuNfSqyPM.png', 1, '2019-10-23 07:35:27', '2019-10-23 07:35:27');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`staff` WRITE;
DELETE FROM `adpoint_laravel`.`staff`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`sub_categories` WRITE;
DELETE FROM `adpoint_laravel`.`sub_categories`;
INSERT INTO `adpoint_laravel`.`sub_categories` (`id`,`name`,`category_id`,`slug`,`meta_title`,`meta_description`,`created_at`,`updated_at`,`brands`) VALUES (14, 'Horizontal Billborad', 1, 'Horizontal-Billborad-4norI', 'Billboard', NULL, '2019-11-04 07:45:11', '2019-11-04 07:45:11', '[\"1\",\"4\",\"5\",\"7\",\"9\",\"11\",\"12\"]'),(15, 'Vertical Billboard', 1, 'Vertical-Billboard-Zans3', NULL, NULL, '2019-11-04 07:47:15', '2019-11-04 07:47:15', '[\"1\",\"4\",\"5\",\"7\",\"9\",\"11\",\"12\"]');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`sub_sub_categories` WRITE;
DELETE FROM `adpoint_laravel`.`sub_sub_categories`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`subscribers` WRITE;
DELETE FROM `adpoint_laravel`.`subscribers`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`ticket_replies` WRITE;
DELETE FROM `adpoint_laravel`.`ticket_replies`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`tickets` WRITE;
DELETE FROM `adpoint_laravel`.`tickets`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`users` WRITE;
DELETE FROM `adpoint_laravel`.`users`;
INSERT INTO `adpoint_laravel`.`users` (`id`,`provider_id`,`user_type`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`avatar`,`avatar_original`,`address`,`country`,`city`,`postal_code`,`phone`,`balance`,`created_at`,`updated_at`) VALUES (9, NULL, 'admin', 'adpoint', 'danudenny@gmail.com', '2019-10-22 08:10:15', '$2y$10$sKnhtbRdra0yjxzBOUge0uJoVcV4UK7j4oRsY9MxFgU7uTVVHe6eS', 'jGJqNtEw4tqTHwAXWdXAjoqskmUDUb7CepS0v0aB1n1hu6BIBGA7nQE974Cm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, '2019-10-22 08:48:15', '2019-10-22 08:48:15'),(17, NULL, 'customer', 'Elsa', 'elsaoktarizaaa@gmail.com', '2019-10-29 09:10:29', '$2y$10$AYSn5PM3fvfMJL92Cb0HweFlbab/EDi0oaIHlxkyJeVJoB3sbUBHa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, '2019-10-29 09:19:29', '2019-10-29 09:19:29'),(18, NULL, 'customer', 'ELSA', 'elsa.oktariza@imaniprima.com', NULL, '$2y$10$xccDlJ9c5B2A3lXgw111S.iWjQhy.n5KDZN3r8xZdpDoJtUvgkvUa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, '2019-10-29 09:22:30', '2019-10-29 09:22:30'),(19, NULL, 'customer', 'Denny', 'denny.danuwijaya@gmail.com', '2019-10-29 09:10:52', '$2y$10$RyN/TGOXkedH1FnFYkG.l.y/lYunItH1Hbhj7E3jBBSIW98OGpMMy', NULL, NULL, 'uploads/users/roxaSlJ2EKMruKyIon052qeR2pfAv0DxAyjGTaua.png', 'Jalan Gotong Royong I No 10', 'ID', 'Jakarta Selatan', '12550', '082221114716', 0.00, '2019-10-29 09:30:52', '2019-10-29 09:31:40'),(20, NULL, 'seller', 'MCM Media Networks', 'denny.danuwijaya@imaniprima.com', '2019-10-29 09:10:40', '$2y$10$GVTaC8uGon7Togr8hBq1muLVpaXDwQM.tpoB9H6gEw5X5cHvD3Pvi', 'Ts2DozAatCymIbduDe6VFFlOZ3DMxRC6z1uORw4uUBqfW87BKiMmpAmVB5ur', NULL, 'uploads/Ur9f8AMQ8XQ09GNSzeQ5qv53xjQynBAiE7dphH1b.png', 'Jl. Pahlawan Seribu Golden Road Blok C.27/No.49.\r\nBSD City', 'ID', 'Tangerang Selatan', NULL, '6221538 53 59', 0.00, '2019-10-29 09:46:58', '2019-10-29 09:49:59'),(22, NULL, 'admin', 'admin', 'admin@admin.com', '2019-11-04 04:11:26', '$2y$10$K6jDI7lfvR7Ua7mK9PID7.KduiqSn4jF2ITPKxYY13w7Xzy64HGOq', 'vZW1HMlZZV1c84NVm0m2icH7h6BSqGDtsOF6KBNQeTtmJztTNgXhGLwzDa6W', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, '2019-11-04 04:44:26', '2019-11-04 04:44:26');
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`wallets` WRITE;
DELETE FROM `adpoint_laravel`.`wallets`;
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `adpoint_laravel`.`wishlists` WRITE;
DELETE FROM `adpoint_laravel`.`wishlists`;
UNLOCK TABLES;
COMMIT;
