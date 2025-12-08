-- Create user_listings table for storing items users want to sell
CREATE TABLE IF NOT EXISTS `user_listings` (
  `user_listing_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `condition` varchar(50) NOT NULL,
  `megapixels` int(11) NOT NULL,
  `sensor` varchar(100) NOT NULL,
  `inclusions` text,
  `known_issues` text,
  `purchase_date` date,
  `reason_for_selling` text,
  `original_price` decimal(10, 2) NOT NULL,
  `asking_price` decimal(10, 2) NOT NULL,
  `status` enum('pending', 'approved', 'rejected', 'sold') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`UserID`) ON DELETE CASCADE,
  INDEX (`status`),
  INDEX (`user_id`)
);

-- Create user_listing_images table for storing images
CREATE TABLE IF NOT EXISTS `user_listing_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_listing_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_listing_id`) REFERENCES `user_listings`(`user_listing_id`) ON DELETE CASCADE,
  INDEX (`user_listing_id`)
);
