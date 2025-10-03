-- Create database
CREATE DATABASE IF NOT EXISTS beautiful_funerals;
USE beautiful_funerals;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE
);

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    service_date DATETIME NOT NULL,
    location TEXT NOT NULL,
    description TEXT NOT NULL,
    livestream_url VARCHAR(500),
    condolences_url VARCHAR(500),
    is_published BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    featured_image VARCHAR(500),
    author_id INT,
    is_published BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES admin_users(id)
);

-- Arrangements table
CREATE TABLE IF NOT EXISTS arrangements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    service_type VARCHAR(100) NOT NULL,
    message TEXT,
    status ENUM('new', 'contacted', 'in_progress', 'completed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Condolences table
CREATE TABLE IF NOT EXISTS condolences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    message TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password_hash, email, full_name) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@beautifulfunerals.au', 'Administrator');

-- Insert sample services
INSERT INTO services (name, service_date, location, description, livestream_url, condolences_url) VALUES
('John Robert Smith', '2023-06-15 14:00:00', 'St. Mary''s Church, Berwick', 'A celebration of John''s life will be held at St. Mary''s Church, Berwick. All are welcome to attend and pay their respects.', 'https://example.com/livestream/john-smith', 'https://example.com/condolences/john-smith'),
('Margaret Elizabeth Wilson', '2023-06-16 11:00:00', 'Private Family Service', 'A private family service will be held for Margaret. Friends are welcome to join via livestream.', 'https://example.com/livestream/margaret-wilson', 'https://example.com/condolences/margaret-wilson');

-- Insert sample blog posts
INSERT INTO blog_posts (title, excerpt, content, author_id) VALUES
('Understanding the Grieving Process', 'Learn about the stages of grief and healthy coping mechanisms.', 'Grief is a natural response to loss. It''s the emotional suffering you feel when something or someone you love is taken away. Often, the pain of loss can feel overwhelming. You may experience all kinds of difficult and unexpected emotions, from shock or anger to disbelief, guilt, and profound sadness.', 1),
('How to Support Someone Who is Grieving', 'Practical ways to help friends and family through difficult times.', 'When someone you care about is grieving, it can be difficult to know what to say or do. You may be afraid of intruding, saying the wrong thing, or making the person feel even worse. While you can''t take away the pain of the loss, you can provide much-needed comfort and support.', 1);