markdown
# Beautiful Funerals Website

A professional funeral services website with complete backend administration system and file upload capabilities.

## Features

### Frontend Features
- **Responsive Design**: Mobile-optimized with Tailwind CSS
- **Professional Dark Theme**: Black, white, and silver color scheme
- **Service Pages**: Traditional funerals, cremation, pre-planning
- **Upcoming Services**: Live service listings with livestream links
- **Blog System**: Grief support and educational content
- **Contact Forms**: Arrangement requests and general inquiries
- **SEO Optimized**: Proper meta tags and structure

### Backend Features
- **Admin Dashboard**: Complete content management system
- **Service Management**: Add/edit/delete upcoming services
- **Blog Management**: Create and manage blog posts
- **Form Management**: View arrangement requests and messages
- **File Upload System**: Secure image upload for blog posts and content
- **Secure Authentication**: Admin login system
- **RESTful API**: JSON API for all data operations

## Installation

### Prerequisites
- Web server with PHP 7.4+
- MySQL 5.7+ or MariaDB 10.3+
- Apache with mod_rewrite enabled
- PHP extensions: PDO, MySQL, FileInfo

### Step 1: Database Setup
1. Create a MySQL database
2. Import the `database.sql` file:
   ```bash
   mysql -u username -p database_name < database.sql
Update database credentials in config.php

Step 2: File Upload
Upload all files to your web server

Set proper file permissions:

bash
# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Set upload directory permissions
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

File uploads enabled (check php.ini)

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

File Upload System
Upload Endpoint
POST /api/upload.php - Upload files (admin authentication required)

Upload Parameters
file (required): The file to upload (multipart/form-data)

Supported File Types
Images: JPEG, PNG, GIF, WebP

Maximum File Size: 5MB

Security: File type validation, size limits, and virus scanning

Upload Response
json
{
    "success": true,
    "message": "File uploaded successfully",
    "filePath": "/assets/uploads/unique_filename.jpg",
    "fileName": "unique_filename.jpg"
}
Error Responses
json
{
    "success": false,
    "message": "Error description"
}
Upload Security Features
File type validation using MIME types

File size restrictions

Unique filename generation to prevent overwrites

Directory traversal protection

Admin authentication required

File extension validation

Database Schema
Main Tables
admin_users - Administrator accounts

services - Upcoming funeral services

blog_posts - Blog articles

arrangements - Funeral arrangement requests

contact_messages - General contact messages

condolences - Condolence messages for services

Security Features
Password Security: bcrypt hashing

SQL Injection Prevention: PDO prepared statements

XSS Protection: Input sanitization and output escaping

CSRF Protection: Form tokens and validation

Session Security: Secure session management

File Upload Security: Type validation, size limits, virus scanning

HTTPS Enforcement: SSL/TLS required

Security Headers: XSS, HSTS, frame options

Input Validation: Server-side validation for all inputs

File Upload Configuration
PHP Configuration (php.ini)
ini
file_uploads = On
upload_max_filesize = 10M
post_max_size = 10M
max_file_uploads = 20
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
Upload Directory Security
Directory permissions: 755 (readable, not executable)

File permissions: 644 (readable, not executable)

.htaccess protection against direct PHP execution

Regular security scans

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
Content Management
Update company information in index.html

Modify service packages in the pricing section

Add images via the admin panel upload system

Manage all content through the admin dashboard

Maintenance
Regular Tasks
Backup database regularly

Update PHP and dependencies

Monitor error logs

Review and update content

Check upload directory for unauthorized files

Update security patches

Troubleshooting Guide
1. File Upload Issues
Problem: "Failed to upload file" or "Invalid file type"

Solution: Check assets/uploads/ directory permissions (should be 777)

Solution: Verify file type and size (max 5MB, images only)

Solution: Check PHP error logs for upload errors

2. Database Connection Error
Solution: Verify credentials in config.php

Solution: Check database server is running

Solution: Ensure database exists and user has permissions

3. API Not Working
Solution: Ensure mod_rewrite is enabled

Solution: Check API file permissions (644)

Solution: Verify .htaccess is in root directory

4. Admin Login Issues
Solution: Verify database has default admin user

Solution: Check session configuration

Solution: Clear browser cache and cookies

5. 500 Internal Server Error
Solution: Check file permissions

Solution: Verify .htaccess syntax

Solution: Check PHP error logs

6. Images Not Displaying
Solution: Verify upload directory permissions

Solution: Check file paths in database

Solution: Ensure images are uploaded via admin panel

Support
For technical support or questions:

Check Error Logs: Review PHP and server error logs

Verify Permissions: Ensure all file permissions are correct

Database Check: Confirm all tables exist and are accessible

PHP Extensions: Verify PDO, MySQL, and FileInfo extensions are enabled

Upload Test: Test file upload functionality in admin panel

Backup Procedures
Database Backup
bash
mysqldump -u username -p database_name > backup.sql
File Backup
bash
tar -czf website_backup.tar.gz beautiful-funerals/
Upload Directory Backup
bash
tar -czf uploads_backup.tar.gz assets/uploads/
Security Best Practices
Regular Updates: Keep PHP, MySQL, and all dependencies updated

Password Policy: Use strong, unique passwords for admin accounts

File Monitoring: Regularly check upload directory for suspicious files

Access Logs: Monitor access logs for unusual activity

SSL Certificate: Maintain valid SSL certificate

Backup Strategy: Implement regular backup procedures

License
This project is licensed for use by Beautiful Funerals. All rights reserved.

Changelog
v1.1.0
Added secure file upload system

Enhanced admin panel with image management

Improved error handling and validation

Added comprehensive security features

v1.0.0
Initial release

Complete frontend and backend system

Admin dashboard

API endpoints

Database structure

Quick Deployment Checklist
Pre-Deployment
Database created and configured

File permissions set correctly

Configuration files updated

SSL certificate installed

Domain configured

Post-Deployment
Admin login tested

File upload functionality verified

All forms submitting correctly

Mobile responsiveness confirmed

SEO meta tags validated

Security Checklist
Default admin password changed

File upload restrictions working

HTTPS enforced

Error reporting disabled in production

Regular backup schedule established

Need Help? Contact your web developer or refer to the troubleshooting section above.

Emergency Contact: For critical issues, contact your hosting provider and web development team immediately.