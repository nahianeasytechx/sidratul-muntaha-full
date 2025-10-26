CREATE TABLE hero_sections (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page_title VARCHAR(100) NOT NULL,
  hero_title VARCHAR(255) NOT NULL,
  hero_description TEXT,
  hero_img VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  img VARCHAR(255),
  descriptions TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE activities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(100),
  title VARCHAR(255) NOT NULL,
  descriptions TEXT,
  img VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE activity_sub_titles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  activity_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
);


CREATE TABLE activity_sub_descriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  activity_id INT NOT NULL,
  activity_sub_title_id INT NOT NULL,
  descriptions TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
  FOREIGN KEY (activity_sub_title_id) REFERENCES activity_sub_titles(id) ON DELETE CASCADE
);


CREATE TABLE donation_categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_title VARCHAR(255) NOT NULL,
  category_description TEXT,
  category_img VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE donate_page (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  descriptions TEXT,
  img VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE payment_methods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  method_name VARCHAR(100) NOT NULL,
  account_num VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE donations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  donor_name VARCHAR(255) NOT NULL,
  donor_phone VARCHAR(20),
  donate_category_id INT,
  donate_on_behalf VARCHAR(255),
  payment_method INT,
  paid_amount DECIMAL(12,2) NOT NULL,
  payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (donate_category_id) REFERENCES donation_categories(id) ON DELETE SET NULL,
  FOREIGN KEY (payment_method) REFERENCES payment_methods(id) ON DELETE SET NULL
);


CREATE TABLE galleries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  img VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  descriptions TEXT,
  img VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  experied_at DATETIME
);


CREATE TABLE zakat_collection (
  id INT AUTO_INCREMENT PRIMARY KEY,
  donor_name VARCHAR(255) NOT NULL,
  donor_phone VARCHAR(20),
  payment_method INT,
  paid_amount DECIMAL(12,2) NOT NULL,
  payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (payment_method) REFERENCES payment_methods(id) ON DELETE SET NULL
);


CREATE TABLE partners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  logo VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE web_info (
  id INT AUTO_INCREMENT PRIMARY KEY,
  organization_name VARCHAR(255) NOT NULL,
  logo VARCHAR(255),
  brand_color VARCHAR(50),
  reg_no VARCHAR(100),
  phone VARCHAR(20),
  email VARCHAR(100),
  address_location VARCHAR(255),
  google_map_location TEXT,
  yt_video_link VARCHAR(255),
  fb_link VARCHAR(255),
  yt_link VARCHAR(255),
  x_link VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE user_msg_list (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL,
  subject VARCHAR(255),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);