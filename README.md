# PHP Website Basic

A basic PHP website template with MySQL backend, user authentication (login/signup), and modern Tailwind CSS frontend. This project provides a clean starting point for building PHP web applications.

## 🚀 Features

- **Modern Frontend**: Tailwind CSS integration via CDN
- **Database Integration**: MySQL with PDO for secure database operations
- **Clean Architecture**: Organized folder structure
- **Responsive Design**: Mobile-first approach
- **Security**: Prepared statements and secure coding practices
- **User Authentication**: Ready-to-implement login/signup system

## 📁 Project Structure

```
php-website-basic/
├── css/
│   └── style.css          # Custom CSS styles
├── includes/
│   └── database.php       # Database connection and configuration
├── public/
│   └── index.php          # Main entry point
└── README.md              # Project documentation
```

## 🛠️ Setup Instructions

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB)
- Web server (Apache, Nginx, or PHP built-in server)
- Composer (optional, for dependency management)

### Step 1: Clone the Repository

```bash
git clone https://github.com/NikHil12907/php-website-basic.git
cd php-website-basic
```

### Step 2: Database Setup

1. **Create a MySQL database:**
   ```sql
   CREATE DATABASE php_website_basic;
   ```

2. **Create the users table:**
   ```sql
   USE php_website_basic;
   
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       full_name VARCHAR(100) NOT NULL,
       email VARCHAR(150) UNIQUE NOT NULL,
       password_hash VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   ```

3. **Configure database connection:**
   
   Edit `includes/database.php` and update the database credentials:
   ```php
   define('DB_HOST', 'localhost');     // Your database host
   define('DB_NAME', 'php_website_basic'); // Your database name
   define('DB_USER', 'your_username');     // Your database username
   define('DB_PASS', 'your_password');     // Your database password
   ```

### Step 3: Web Server Setup

#### Option A: Using PHP Built-in Server (Development)

```bash
# Navigate to the project directory
cd php-website-basic

# Start the PHP server (pointing to public folder)
php -S localhost:8000 -t public
```

Then visit: `http://localhost:8000`

#### Option B: Using Apache/Nginx (Production)

1. **Apache Configuration:**
   
   Create a virtual host or point your document root to the `public` folder:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "/path/to/php-website-basic/public"
       ServerName yoursite.local
       
       <Directory "/path/to/php-website-basic/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

2. **Nginx Configuration:**
   ```nginx
   server {
       listen 80;
       server_name yoursite.local;
       root /path/to/php-website-basic/public;
       index index.php;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   ```

### Step 4: File Permissions (Linux/Mac)

```bash
# Make sure web server can read files
sudo chown -R www-data:www-data php-website-basic/
sudo chmod -R 755 php-website-basic/
```

## 🎨 Customization

### Adding Custom Styles

You can add custom CSS to `css/style.css`. The file already includes:
- Custom utility classes
- Form styling helpers
- Animation utilities
- Responsive design helpers

### Extending the Database

The `includes/database.php` file provides a Database class with methods for:
- `query()` - Execute prepared statements
- `single()` - Get single record
- `resultSet()` - Get multiple records
- `rowCount()` - Get affected rows
- `lastInsertId()` - Get last inserted ID

## 🚀 Usage Examples

### Basic Database Query

```php
<?php
require_once '../includes/database.php';

// Get all users
$users = $database->resultSet("SELECT * FROM users");

// Get user by email
$user = $database->single("SELECT * FROM users WHERE email = ?", ['user@example.com']);

// Insert new user
$database->query(
    "INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)",
    ['John Doe', 'john@example.com', password_hash('password123', PASSWORD_DEFAULT)]
);
?>
```

### Form Processing

```php
<?php
if ($_POST) {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    if ($email) {
        $database->query(
            "INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)",
            [$name, $email, $password]
        );
        echo "User registered successfully!";
    }
}
?>
```

## 🔒 Security Features

- **PDO Prepared Statements**: Prevents SQL injection
- **Password Hashing**: Uses PHP's `password_hash()` function
- **Input Validation**: Examples of proper input sanitization
- **Error Handling**: Database errors are logged, not displayed

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 💡 Next Steps

This template provides a foundation. Consider adding:
- User session management
- CSRF protection
- Environment-based configuration
- Composer for dependency management
- PHP frameworks (Laravel, Symfony, etc.)
- API endpoints
- Unit tests

## 🐛 Issues & Support

If you encounter any issues or have questions:
1. Check the [Issues](https://github.com/NikHil12907/php-website-basic/issues) page
2. Create a new issue with detailed information
3. Include your PHP version, web server, and database setup

---

**Built with ❤️ using PHP, MySQL, and Tailwind CSS**
