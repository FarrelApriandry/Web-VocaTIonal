# 🎓 VocaTIonal: Professional IT Student Grievance System

**VocaTIonal** is a professional-grade, secure reporting platform specifically designed for Vocational IT students at Universitas Tidar. It bridges the gap between students and stakeholders through a transparent, secure, and anonymous grievance mechanism. Built with **Clean Architecture** principles, the system ensures data integrity, user anonymity, and high-performance standards across both public and admin interfaces.

---

## 📊 Project Status

| Component | Status | Details |
|-----------|--------|---------|
| **Admin Panel MVC** | ✅ Complete | Full router, controllers, views, models |
| **Public App** | ✅ Complete | Student submission & bulletin board |
| **Authentication** | ✅ Complete | Bcrypt hashing, session management, role-based access |
| **Database Migration** | ✅ Complete | Auto-sync schema with version control |
| **HTTPS/SSL** | ✅ Complete | Production-ready SSL configuration |
| **Docker Setup** | ✅ Complete | Multi-container orchestration |
| **Dual VirtualHost** | ✅ Complete | Development & production configurations |

---

## 🚀 Architecture Overview

### **Dual Application Structure**

VocaTIonal is split into **two isolated applications** with separate entry points:

#### **1. Public Application** (`vocational/public/`)
- **Purpose**: Student aspiration submission & public bulletin board
- **Access**: `vocational.prod` (dev) / `https://vocational.info` (prod)
- **Features**:
  - Submit aspirations (Akademik, Fasilitas, Sarpras, Layanan, UKT, Lainnya)
  - Anonymous or named submissions
  - Public bulletin board viewing
  - Reaction system (emoji responses)
  - Report inappropriate content

#### **2. Admin Panel** (`vocational/admin/`)
- **Purpose**: Manage aspirations, reports, and bulletin board
- **Access**: `admin.vocational.prod` (dev) / `https://admin.vocational.info` (prod)
- **Features**:
  - Dashboard with real-time statistics
  - Aspiration management (filter, search, status update)
  - Report management (review, approve, reject)
  - Bulletin board management
  - Role-based access control (Kaprodi, Advokasi, Super_Admin)

---

## 🏗️ Technical Architecture

### **Admin Panel MVC Stack**

The admin panel implements a **clean MVC (Model-View-Controller) architecture**:

```
User Request
    ↓
Router (index.php → routeAdmin())
    ↓
Controller Layer (DashboardController, AspirationsController, etc.)
    ├─ Handles authentication checks
    ├─ Queries database via models
    ├─ Prepares data arrays
    └─ Calls renderLayout()
    ↓
View Layer (Pure view files)
    ├─ No business logic
    ├─ No database queries
    ├─ Receives extracted $data variables
    └─ Renders HTML + PHP variable echoes
    ↓
Layout Layer (main.php)
    ├─ Wraps view with header/sidebar
    ├─ Includes navigation components
    └─ Outputs complete HTML page
    ↓
Browser
```

### **Project Structure**

```
Web-VocaTIonal/
├── .github/workflows/              # DevSecOps CI/CD pipelines
│   ├── deploy.yml                  # Automated deployment
│   └── cd.yml                       # Continuous deployment
│
├── vocational/                      # Main application root
│   ├── public/                      # PUBLIC APP - Web entry point
│   │   ├── index.php               # Entry point (student aspirations)
│   │   ├── assets/                 # CSS, JS, images
│   │   └── api/                    # Public API endpoints
│   │
│   ├── admin/                       # ADMIN PANEL - Separate app
│   │   ├── public/
│   │   │   ├── index.php           # Admin entry point (router)
│   │   │   ├── auth/
│   │   │   │   └── login.php       # Admin login page
│   │   │   ├── api/                # Admin API endpoints
│   │   │   └── assets/             # Admin-specific assets
│   │   │
│   │   └── app/                    # Admin application logic
│   │       ├── Config/
│   │       │   ├── Database.php    # PDO connection
│   │       │   ├── Session.php     # Session management
│   │       │   ├── routes.php      # MVC routing
│   │       │   └── Migration.php   # Database schema versioning
│   │       │
│   │       ├── Controllers/
│   │       │   ├── AdminBaseController.php     # Base with renderLayout()
│   │       │   ├── DashboardController.php     # Stats & overview
│   │       │   ├── AspirationsController.php   # Manage aspirations
│   │       │   ├── ReportsController.php       # Manage reports
│   │       │   ├── BoardController.php         # Manage bulletin board
│   │       │   └── AdminAuth.php               # Authentication logic
│   │       │
│   │       ├── Models/
│   │       │   ├── Aspirasi.php               # Aspiration queries
│   │       │   └── AspirationReport.php       # Report queries
│   │       │
│   │       └── Views/
│   │           ├── Layouts/
│   │           │   └── main.php               # Master page layout
│   │           ├── Components/
│   │           │   └── Sidebar.php            # Navigation component
│   │           ├── dashboard.php              # Dashboard view
│   │           ├── aspirations.php            # Aspirations view
│   │           ├── reports.php                # Reports view
│   │           └── board.php                  # Bulletin board view
│   │
│   ├── app/                        # PUBLIC APP - Application logic
│   │   ├── Config/
│   │   │   ├── Database.php        # Database connection
│   │   │   └── Migration.php       # Schema migrations
│   │   ├── Controllers/
│   │   ├── Models/
│   │   └── Views/
│   │
│   ├── docker/                     # Infrastructure as Code
│   │   └── apache/
│   │       └── vhost.conf         # Apache virtual hosts (dev & prod)
│   │
│   ├── Dockerfile                  # Container image definition
│   ├── docker-compose.yml          # Multi-container orchestration
│   └── documentation/              # Operational guides
│
└── tests/                           # Integration tests

```

### **Technology Stack**

| Layer | Technology | Version |
|-------|-----------|---------|
| **Backend** | PHP | 8.2+ (native) |
| **Database** | MySQL | 8.0 |
| **Frontend** | Tailwind CSS | Latest |
| **Icons** | Lucide Icons | Latest |
| **Web Server** | Apache | 2.4+ |
| **Container** | Docker | 20.10+ |
| **Orchestration** | Docker Compose | 1.29+ |
| **SSL/TLS** | Self-signed & Let's Encrypt | For production |

---

## 🛠️ Installation & Setup

### **Prerequisites**

- Docker & Docker Compose installed
- Git installed
- At least 2GB RAM available

### **Quick Start**

```bash
# 1. Clone repository
git clone https://github.com/FarrelApriandry/Web-VocaTIonal.git
cd Web-VocaTIonal

# 2. Navigate to vocational directory
cd vocational

# 3. Start Docker containers
docker-compose up -d --build

# 4. Run database migrations
docker exec vocational-web php app/Config/Migration.php

# 5. Access applications
#    - Public app:  http://vocational.prod
#    - Admin panel: http://admin.vocational.prod/auth/login.php
#                   (default: admin-prod / admin123)
```

### **Environment Configuration**

Create `.env` file in `vocational/` directory:

```env
# Database Configuration example
DB_HOST=vocational-db
DB_PORT=3306
DB_NAME=vocational_db
DB_USER=vocational_user
DB_PASS=secure_password_here

# Admin Credentials (for migrations)
ADMIN_USER=admin-prod
ADMIN_PASS=admin123
```

### **Database Migrations**

Database schema is version-controlled and auto-synced:

```bash
# Run migrations (auto-creates tables & inserts default admin)
docker exec vocational-web php app/Config/Migration.php

# Check database connection
docker exec vocational-db mysql -u vocational_user -p vocational_db -e "SHOW TABLES;"
```

---

## 🔐 Security Features

### **Authentication & Authorization**

- **Password Hashing**: `PASSWORD_BCRYPT` for secure storage
- **Session Management**: 60-minute timeout with configurable extension
- **Role-Based Access Control**:
  - `Super_Admin`: Full system access
  - `Kaprodi`: Program lead management
  - `Advokasi`: Advocacy officer functions
- **CSRF Protection**: Token validation on state-changing requests

### **Data Protection**

- **Anonymity Support**: Students can submit aspirations anonymously
- **Data Isolation**: Sensitive data via `.env` files (never committed)
- **SQL Injection Prevention**: PDO prepared statements on all queries
- **XSS Protection**: `htmlspecialchars()` on all output

### **Network Security**

- **HTTP → HTTPS Redirect**: Production traffic forced to SSL
- **SSL/TLS Certificates**: Self-signed (dev) / Let's Encrypt (prod)
- **Virtual Host Isolation**: Separate Apache vhosts for dev & production

---

## 🌐 Deployment

### **Development Environment**

```
vocational.prod          → http://vocational.prod (public app)
admin.vocational.prod    → http://admin.vocational.prod (admin panel)
```

Both served via HTTP with Docker-based Apache.

### **Production Environment**

```
vocational.info          → https://vocational.info (public app)
www.vocational.info      → https://vocational.info (redirected)
admin.vocational.info    → https://admin.vocational.info (admin panel)

All HTTPS with automatic HTTP → HTTPS 301 redirects
```

### **Apache VirtualHost Configuration**

Configuration in `vocational/docker/apache/vhost.conf`:

- **Development**: Simple HTTP routing with RewriteBase
- **Production**: HTTPS with SSL certificates
- **Admin Router**: Query parameter-based MVC routing (`?action=`)
- **Error Logging**: Separate logs per application & environment

---

## 📊 Admin Panel Features

### **Dashboard**

- Real-time statistics (Total, Pending, Processing, Completed)
- Most reported aspirations
- Category breakdown
- Quick action buttons

### **Aspirations Management**

- Advanced filtering (Status, Category, Search)
- Pagination (20 items per page)
- Inline editing of aspiration status
- Detail modal with full information
- Anonymous/Named indicator

### **Reports Management**

- Review inappropriate content reports
- Filter by reason (Inappropriate, Spam, Offensive)
- Approve/Reject reports
- Statistics dashboard

### **Bulletin Board Management**

- Approve aspirations for public display
- Manage published content
- Category filtering
- Reaction tracking

---

## 🧪 Testing & Verification

### **Syntax Validation**

```bash
# Check Apache configuration
docker exec vocational-apache apache2ctl configtest
# Output: Syntax OK

# Check PHP syntax
docker exec vocational-web php -l app/Config/Database.php
# Output: No syntax errors detected
```

### **Application Testing**

```bash
# Test public app
curl -v http://vocational.prod/

# Test admin login
curl -v http://admin.vocational.prod/auth/login.php

# Test admin dashboard (after login)
curl -v http://admin.vocational.prod/?action=dashboard

# Test production HTTPS redirect
curl -v http://vocational.info/
# Should return: 301 redirect to https://vocational.info
```

### **Database Testing**

```bash
# Check migrations were applied
docker exec vocational-db mysql -u vocational_user -p vocational_db -e "SHOW TABLES;"

# Verify admin user created
docker exec vocational-db mysql -u vocational_user -p vocational_db \
  -e "SELECT id_admin, role_adm FROM admin_web WHERE id_admin = 1;"
```

---

## 📝 API Endpoints

### **Admin Panel API**

| Method | Endpoint | Purpose |
|--------|----------|---------|
| POST | `/api/admin-login.php` | Authenticate admin user |
| POST | `/api/admin-logout.php` | Logout session |
| POST | `/api/update-aspirasi-status.php` | Update aspiration status |

### **Public App API**

| Method | Endpoint | Purpose |
|--------|----------|---------|
| POST | `/api/submit-aspirasi.php` | Submit new aspiration |
| GET | `/api/get-board-aspirasi.php` | Fetch bulletin board |
| POST | `/api/add-reaction.php` | Add emoji reaction |

---

## 🐛 Troubleshooting

### **Apache Configuration Issues**

```bash
# Check logs
docker logs vocational-apache

# View error logs
docker exec vocational-apache tail -f /var/log/apache2/admin_dev_error.log
```

### **Database Connection Issues**

```bash
# Test database connection
docker exec vocational-web php -r "
  require 'app/Config/Database.php';
  try {
    \$pdo = Database::getConnection();
    echo 'Database connected!';
  } catch (PDOException \$e) {
    echo 'Error: ' . \$e->getMessage();
  }
"
```

### **Router Issues**

- Ensure `mod_rewrite` is enabled: `docker exec vocational-apache a2enmod rewrite`
- Check RewriteBase in vhost configuration
- Verify `.htaccess` has `AllowOverride All` in Apache config

---

## 📚 Documentation

- **[Docker Running Guide](./vocational/documentation/Docker-Running.md)** - Docker setup & troubleshooting
- **[Operational Guide](./vocational/documentation/Panduan-Operasional-Docker.md)** - Day-to-day operations
- **[Software Design Document](./vocational/documentation/Software-Design-Document.md)** - Architecture details

---

## 👥 Contributing

1. Create a feature branch: `git checkout -b feature/your-feature`
2. Commit changes: `git commit -m 'Add your feature'`
3. Push to branch: `git push origin feature/your-feature`
4. Submit pull request

---

## 🔒 Security Notice

- Never commit `.env` files or SSL private keys
- Always use HTTPS in production
- Regularly rotate admin credentials
- Keep dependencies updated
- Review access logs regularly

---

## 📄 License

This project is proprietary and designed for Universitas Tidar's IT Student Association (HIMATIF).

---

## 👤 Author

**Farrel Apriandry Ciu**  
Student Developer, Universitas Tidar  
| Name | GitHub Account | 
|--------|--------|
| Farrel Apriandry Ciu | [@FarrelApriandry](https://github.com/FarrelApriandry) | 
| Nabila Syafiqah Zahran Firlina | [@nabilaszf](https://github.com/nabilaszf) |
| Yasabuana Athallahaufa Natawijaya | [@Yasabuana](https://github.com/Yasabuana) |
| Nofiya Millatina | [@nofiyamillatina](https://github.com/nofiyamillatina) |
| Hakkan Azrul Suseno | [@hakkanazrul06](https://github.com/hakkanazrul06) |

---

## 🎯 Project Links

- **Repository**: https://github.com/FarrelApriandry/Web-VocaTIonal
- **Website**: https://vocational.info (Production)
- **Admin Panel**: https://admin.vocational.info (Production)

---

**Last Updated**: April 6, 2026  
**Version**: 2.0.0 (MVC Architecture Complete)