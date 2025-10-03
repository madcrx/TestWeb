Beautiful Funerals Website
A professional funeral services website with complete backend administration system.

Features
Frontend Features
Responsive Design: Mobile-optimized with Tailwind CSS

Professional Dark Theme: Black, white, and silver color scheme

Service Pages: Traditional funerals, cremation, pre-planning

Upcoming Services: Live service listings with livestream links

Blog System: Grief support and educational content

Contact Forms: Arrangement requests and general inquiries

SEO Optimized: Proper meta tags and structure

Backend Features
Admin Dashboard: Complete content management system

Service Management: Add/edit/delete upcoming services

Blog Management: Create and manage blog posts

Form Management: View arrangement requests and messages

File Upload: Image upload for blog posts and content

Secure Authentication: Admin login system

RESTful API: JSON API for all data operations

Installation
Prerequisites
Web server with PHP 7.4+

MySQL 5.7+ or MariaDB 10.3+

Apache with mod_rewrite enabled

Step 1: Database Setup
Create a MySQL database

Import the database.sql file:

bash
mysql -u username -p database_name < database.sql
Update database credentials in config.php

Step 2: File Upload
Upload all files to your web server

Set proper file permissions:

bash
chmod 755 $(find . -type d)
chmod 644 $(find . -type f)
chmod 777 assets/uploads/
Step 3: Configuration
Update database settings in config.php:

php
$config = [
    'db_host' => 'your_host',
    'db_name' => 'your_database',
    'db_user' => 'your_username',
    'db_pass' => 'your_password'
];
Configure your domain in config.php:

php
define('SITE_URL', 'https://yourdomain.com');
Step 4: Server Configuration
Ensure your Apache server has:

mod_rewrite enabled

Proper .htaccess support

PHP with PDO MySQL extension

File uploads enabled

Default Login Credentials
Admin Panel: /admin/login.php

Username: admin

Password: admin123

Important: Change the default password after first login!

File Structure
text
beautiful-funerals/
├── README.md                 # This file
├── index.html               # Main website frontend
├── .htaccess               # Apache configuration
├── config.php              # Main configuration
├── database.sql            # Database schema and sample data
├── api/                    # API endpoints
│   ├── config.php          # API configuration
│   ├── auth.php            # Authentication API
│   ├── services.php        # Services management API
│   ├── blog.php            # Blog management API
│   ├── arrangements.php    # Arrangements API
│   ├── messages.php        # Contact messages API
│   └── upload.php          # File upload API
├── admin/                  # Admin panel
│   ├── login.php           # Admin login page
│   ├── dashboard.php       # Admin dashboard
│   └── admin.js            # Admin JavaScript
├── includes/               # PHP includes
│   ├── database.php        # Database connection
│   ├── functions.php       # Utility functions
│   └── auth-check.php      # Authentication middleware
└── assets/                 # Static assets
    ├── css/                # Stylesheets
    ├── js/                 # JavaScript files
    ├── images/             # Images
    └── uploads/            # File upload directory
API Endpoints
Authentication
POST /api/auth.php - Admin login

DELETE /api/auth.php - Admin logout

Services
GET /api/services.php - Get all services

POST /api/services.php - Create new service

PUT /api/services.php - Update service

DELETE /api/services.php - Delete service

Blog
GET /api/blog.php - Get all blog posts

POST /api/blog.php - Create new blog post

PUT /api/blog.php - Update blog post

DELETE /api/blog.php - Delete blog post

Forms
GET /api/arrangements.php - Get arrangements (admin only)

POST /api/arrangements.php - Submit arrangement request

GET /api/messages.php - Get messages (admin only)

POST /api/messages.php - Submit contact message

File Upload
POST /api/upload.php - Upload files (images only, admin only)

Upload Parameters:

file (required): The file to upload

Supported File Types:

JPEG, PNG, GIF, WebP

Maximum file size: 5MB

Database Schema
Main Tables
admin_users - Administrator accounts

services - Upcoming funeral services

blog_posts - Blog articles

arrangements - Funeral arrangement requests

contact_messages - General contact messages

condolences - Condolence messages for services

Security Features
Password hashing with bcrypt

SQL injection prevention with PDO prepared statements

XSS protection with input sanitization

CSRF protection in forms

Session-based authentication

Secure file upload validation

HTTPS enforcement

Security headers

Customization
Styling
The website uses Tailwind CSS. Customize colors in the <script> section of index.html:

javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'silver': '#C0C0C0',
                'dark': '#1a1a1a',
            }
        }
    }
}
Content
Update company information in index.html

Modify service packages in the pricing section

Add your own images and content

Maintenance
Regular Tasks
Backup database regularly

Update PHP and dependencies

Monitor error logs

Review and update content

Troubleshooting
500 Internal Server Error

Check file permissions

Verify .htaccess is working

Check PHP error logs

Database Connection Error

Verify credentials in config.php

Check database server is running

Ensure database exists

API Not Working

Ensure mod_rewrite is enabled

Check API file permissions

Verify CORS headers

File Upload Issues

Check assets/uploads/ directory permissions (should be 777)

Verify PHP file upload settings

Check file size and type restrictions

Admin Login Issues

Verify database has default admin user

Check session configuration

Verify password hashing

Support
For technical support or questions:

Check the error logs in your hosting control panel

Verify all file permissions are set correctly

Ensure all database tables were created properly

Check that PHP extensions (PDO, MySQL) are enabled

License
This project is licensed for use by Beautiful Funerals.

Changelog
v1.0.0
Initial release

Complete frontend and backend system

Admin dashboard with file upload

API endpoints

Database structure

Quick Start for CPanel Deployment
Upload Files via File Manager or FTP

Create Database in MySQL Databases

Import SQL via phpMyAdmin

Update Config in config.php

Set Permissions:

Folders: 755

Files: 644

assets/uploads/: 777

Test Website at your domain

Login to Admin at /admin/login.php

The system is now ready for production use!

