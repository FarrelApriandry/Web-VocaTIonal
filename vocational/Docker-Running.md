# Docker Setup Guide

This project includes Docker configuration for easy local development with Apache, PHP 8.2, MySQL 8.0, and phpMyAdmin.

## Quick Start

### Using the Docker Start Script (Recommended)

The project includes convenient scripts to manage your Docker containers:

#### Linux/macOS (Bash)
```bash
# Start all services
./docker-start.sh start

# Stop all services
./docker-start.sh stop

# View service status
./docker-start.sh status

# View logs
./docker-start.sh logs

# Restart services
./docker-start.sh restart

# Show help
./docker-start.sh help
```

#### Windows (Batch)
```cmd
REM Start all services
docker-start.bat start

REM Stop all services
docker-start.bat stop

REM View service status
docker-start.bat status

REM View logs
docker-start.bat logs

REM Restart services
docker-start.bat restart

REM Show help
docker-start.bat help
```

### Manual Docker Commands

If you prefer to use Docker commands directly:

```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# View service status
docker-compose ps

# View logs
docker-compose logs -f

# Restart services
docker-compose restart
```

## Services

The Docker setup includes three main services:

### 1. Web Server (Apache + PHP 8.2)
- **Container Name**: `vocational-web`
- **Port**: 8080
- **Access URL**: http://localhost:8080
- **Features**:
  - PHP 8.2 with PDO MySQL extension
  - Apache with mod_rewrite enabled
  - Volume mapping for live development

### 2. Database (MySQL 8.0)
- **Container Name**: `vocational-db`
- **Port**: 3306
- **Database Name**: `vocational` (configurable via `.env`)
- **Root Password**: `rootpassword` (configurable via `.env`)

### 3. phpMyAdmin
- **Container Name**: `vocational-pma`
- **Port**: 8081
- **Access URL**: http://localhost:8081
- **Credentials**: root / rootpassword

## Configuration

### Environment Variables

The project uses a `.env` file to configure environment variables:

```env
DB_HOST=db
DB_NAME=vocational
DB_USER=****
DB_PASS=****
```

### Port Configuration

Default ports are configured as follows:
- Web Application: 8080
- phpMyAdmin: 8081
- Database: 3306

To change these ports, modify the `docker-compose.yml` file.

## Advanced Usage

### Executing Commands in Containers

#### Using the Script
```bash
# Enter web container shell
./docker-start.sh exec web bash

# Connect to MySQL
./docker-start.sh exec db mysql -u root -p
```

#### Manual Docker Commands
```bash
# Enter web container shell
docker-compose exec web bash

# Connect to MySQL
docker-compose exec db mysql -u root -p
```

### Viewing Logs

#### Using the Script
```bash
# View all logs
./docker-start.sh logs

# View specific service logs
./docker-start.sh logs web
./docker-start.sh logs db
./docker-start.sh logs phpmyadmin
```

#### Manual Docker Commands
```bash
# View all logs
docker-compose logs -f

# View specific service logs
docker-compose logs -f web
docker-compose logs -f db
docker-compose logs -f phpmyadmin
```

### Data Persistence

Database data is persisted using Docker volumes. The `db_data` volume stores MySQL data and will persist between container restarts.

### Cleanup

To completely remove all containers, volumes, and unused images:

#### Using the Script
```bash
./docker-start.sh cleanup
```

#### Manual Docker Commands
```bash
# Stop and remove containers with volumes
docker-compose down -v

# Remove unused images
docker image prune -f
```

## Troubleshooting

### Docker Not Running
If you get an error about Docker not running, ensure Docker Desktop is installed and running.

### Port Already in Use
If you get port binding errors, check if other services are using the same ports:
```bash
# Check what's using port 8080
lsof -i :8080  # macOS/Linux
netstat -ano | findstr :8080  # Windows
```

### Permission Issues (Linux/macOS)
If you encounter permission issues with the script:
```bash
chmod +x docker-start.sh
```

### Environment Variables Not Loading
Ensure your `.env` file is in the same directory as `docker-compose.yml` and contains the required variables.

## Project Structure

```
vocational/
├── docker-compose.yml     # Docker configuration
├── Dockerfile            # PHP/Apache container setup
├── .env                  # Environment variables
├── docker-start.sh       # Linux/macOS management script
├── docker-start.bat      # Windows management script
├── README-Docker.md      # This file
├── app/                  # Application code
├── public/               # Web root directory
└── docker/               # Docker configuration files
    └── apache/
        └── vhost.conf    # Apache virtual host configuration
```

## Development Workflow

1. **Start Services**: `./docker-start.sh start`
2. **Access Application**: http://localhost:8080
3. **Access Database Admin**: http://localhost:8081
4. **Make Code Changes**: Files are automatically synced via volume mapping
5. **Stop Services**: `./docker-start.sh stop` (when done)

## Notes

- The web container mounts your project directory to `/var/www/html` for live development
- Apache is configured with mod_rewrite for URL routing
- MySQL data persists between container restarts
- phpMyAdmin provides a web interface for database management