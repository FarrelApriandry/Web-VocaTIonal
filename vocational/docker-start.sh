#!/bin/bash

# Docker Start Script for Vocational Web Project
# This script handles starting, stopping, and managing Docker containers

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="vocational"
WEB_PORT="8080"
PMA_PORT="8081"
DB_PORT="3306"

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to check if Docker is running
check_docker() {
    if ! docker info > /dev/null 2>&1; then
        print_error "Docker is not running. Please start Docker Desktop first."
        exit 1
    fi
    print_success "Docker is running"
}

# Function to check if docker-compose.yml exists
check_compose_file() {
    if [ ! -f "docker-compose.yml" ]; then
        print_error "docker-compose.yml not found in current directory"
        exit 1
    fi
    print_success "docker-compose.yml found"
}

# Function to display project information
show_info() {
    echo -e "${GREEN}================================${NC}"
    echo -e "${GREEN}  Vocational Web Project Docker${NC}"
    echo -e "${GREEN}================================${NC}"
    echo ""
    echo -e "${BLUE}Project Services:${NC}"
    echo "  • Web Server (Apache + PHP 8.2) → http://localhost:${WEB_PORT}"
    echo "  • Database (MySQL 8.0) → Port ${DB_PORT}"
    echo "  • phpMyAdmin → http://localhost:${PMA_PORT}"
    echo ""
    echo -e "${BLUE}Environment:${NC}"
    echo "  • Database Name: ${DB_NAME:-vocational}"
    echo "  • Database Password: ${DB_PASS:-rootpassword}"
    echo ""
}

# Function to start all services
start_services() {
    print_status "Starting all Docker services..."
    
    # Check if containers are already running
    if docker-compose ps | grep -q "Up"; then
        print_warning "Some containers are already running. Stopping them first..."
        docker-compose down
    fi
    
    # Start services
    if docker-compose up -d; then
        print_success "All services started successfully!"
        echo ""
        print_status "Waiting for services to be ready..."
        sleep 10
        
        # Check service status
        check_services_status
        show_urls
    else
        print_error "Failed to start services"
        exit 1
    fi
}

# Function to stop all services
stop_services() {
    print_status "Stopping all Docker services..."
    
    if docker-compose down; then
        print_success "All services stopped successfully!"
    else
        print_error "Failed to stop services"
        exit 1
    fi
}

# Function to restart services
restart_services() {
    print_status "Restarting all Docker services..."
    
    if docker-compose restart; then
        print_success "All services restarted successfully!"
        sleep 5
        check_services_status
    else
        print_error "Failed to restart services"
        exit 1
    fi
}

# Function to check service status
check_services_status() {
    print_status "Checking service status..."
    echo ""
    
    docker-compose ps
    echo ""
    
    # Check if all services are healthy
    if docker-compose ps | grep -q "Up.*healthy\|Up.*running"; then
        print_success "All services are running!"
    else
        print_warning "Some services may still be starting up. Please wait a moment."
    fi
}

# Function to show URLs
show_urls() {
    echo ""
    echo -e "${GREEN}================================${NC}"
    echo -e "${GREEN}      Access URLs${NC}"
    echo -e "${GREEN}================================${NC}"
    echo -e "${BLUE}Web Application:${NC}     http://localhost:${WEB_PORT}"
    echo -e "${BLUE}phpMyAdmin:${NC}          http://localhost:${PMA_PORT}"
    echo -e "${BLUE}Database Port:${NC}       ${DB_PORT}"
    echo ""
    print_status "Default phpMyAdmin credentials:"
    echo -e "${BLUE}Username:${NC} root"
    echo -e "${BLUE}Password:${NC} ${DB_PASS:-rootpassword}"
    echo ""
}

# Function to show logs
show_logs() {
    local service=${1:-""}
    
    if [ -n "$service" ]; then
        print_status "Showing logs for service: $service"
        docker-compose logs -f "$service"
    else
        print_status "Showing logs for all services"
        docker-compose logs -f
    fi
}

# Function to execute command in container
exec_command() {
    local service=$1
    local command=$2
    
    if [ -z "$service" ] || [ -z "$command" ]; then
        print_error "Usage: exec <service> <command>"
        print_error "Example: exec web bash"
        exit 1
    fi
    
    print_status "Executing '$command' in $service container..."
    docker-compose exec "$service" "$command"
}

# Function to clean up volumes and images
cleanup() {
    print_warning "This will remove all data volumes and unused images!"
    read -p "Are you sure? (y/N): " -n 1 -r
    echo
    
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        print_status "Stopping and removing all containers..."
        docker-compose down -v
        
        print_status "Removing unused images..."
        docker image prune -f
        
        print_success "Cleanup completed!"
    else
        print_status "Cleanup cancelled"
    fi
}

# Function to show help
show_help() {
    echo "Usage: $0 [COMMAND] [OPTIONS]"
    echo ""
    echo "Commands:"
    echo "  start           Start all Docker services"
    echo "  stop            Stop all Docker services"
    echo "  restart         Restart all Docker services"
    echo "  status          Show service status"
    echo "  logs [service]  Show logs (optionally for specific service)"
    echo "  exec <service> <command>  Execute command in container"
    echo "  cleanup         Remove all data and unused images"
    echo "  info            Show project information"
    echo "  help            Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0 start                    # Start all services"
    echo "  $0 logs web                 # Show web service logs"
    echo "  $0 exec web bash            # Enter web container shell"
    echo "  $0 exec db mysql -u root -p # Connect to MySQL"
    echo ""
}

# Main script logic
main() {
    # Load environment variables
    if [ -f ".env" ]; then
        set -a
        source .env
        set +a
    fi
    
    # Check if command is provided
    if [ $# -eq 0 ]; then
        show_help
        exit 1
    fi
    
    # Parse command
    case $1 in
        "start")
            check_docker
            check_compose_file
            show_info
            start_services
            ;;
        "stop")
            check_docker
            check_compose_file
            stop_services
            ;;
        "restart")
            check_docker
            check_compose_file
            restart_services
            ;;
        "status")
            check_docker
            check_compose_file
            check_services_status
            ;;
        "logs")
            check_docker
            check_compose_file
            show_logs "$2"
            ;;
        "exec")
            check_docker
            check_compose_file
            exec_command "$2" "$3"
            ;;
        "cleanup")
            check_docker
            check_compose_file
            cleanup
            ;;
        "info")
            show_info
            ;;
        "help"|"-h"|"--help")
            show_help
            ;;
        *)
            print_error "Unknown command: $1"
            show_help
            exit 1
            ;;
    esac
}

# Run main function with all arguments
main "$@"