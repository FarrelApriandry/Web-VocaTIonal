@echo off
REM Docker Start Script for Vocational Web Project
REM Windows Batch File Version

echo.
echo =================================
echo   Vocational Web Project Docker
echo =================================
echo.

REM Check if Docker is running
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Docker is not running. Please start Docker Desktop first.
    pause
    exit /b 1
)

REM Check if docker-compose.yml exists
if not exist "docker-compose.yml" (
    echo ERROR: docker-compose.yml not found in current directory
    pause
    exit /b 1
)

echo Docker is running...
echo docker-compose.yml found...
echo.

REM Show project information
echo Project Services:
echo   • Web Server (Apache + PHP 8.2) → http://localhost:8080
echo   • Database (MySQL 8.0) → Port 3306
echo   • phpMyAdmin → http://localhost:8081
echo.

REM Load environment variables from .env file
if exist ".env" (
    for /f "tokens=1,* delims==" %%A in (.env) do (
        set "%%A=%%B"
    )
)

REM Check if command is provided
if "%~1"=="" (
    call :show_help
    pause
    exit /b 1
)

REM Parse command
if /i "%~1"=="start" goto start_services
if /i "%~1"=="stop" goto stop_services
if /i "%~1"=="restart" goto restart_services
if /i "%~1"=="status" goto status_services
if /i "%~1"=="logs" goto show_logs
if /i "%~1"=="exec" goto exec_command
if /i "%~1"=="cleanup" goto cleanup
if /i "%~1"=="info" goto show_info
if /i "%~1"=="help" goto show_help
if /i "%~1"=="-h" goto show_help
if /i "%~1"=="--help" goto show_help

echo ERROR: Unknown command: %~1
call :show_help
pause
exit /b 1

REM Functions
:start_services
echo Starting all Docker services...
echo.

REM Check if containers are already running
docker-compose ps | findstr /C:"Up" >nul
if %errorlevel% equ 0 (
    echo Some containers are already running. Stopping them first...
    docker-compose down
)

REM Start services
docker-compose up -d
if %errorlevel% equ 0 (
    echo SUCCESS: All services started successfully!
    echo.
    echo Waiting for services to be ready...
    timeout /t 10 >nul
    call :status_services
    call :show_urls
) else (
    echo ERROR: Failed to start services
    pause
    exit /b 1
)
goto end

:stop_services
echo Stopping all Docker services...
echo.
docker-compose down
if %errorlevel% equ 0 (
    echo SUCCESS: All services stopped successfully!
) else (
    echo ERROR: Failed to stop services
    pause
    exit /b 1
)
goto end

:restart_services
echo Restarting all Docker services...
echo.
docker-compose restart
if %errorlevel% equ 0 (
    echo SUCCESS: All services restarted successfully!
    timeout /t 5 >nul
    call :status_services
) else (
    echo ERROR: Failed to restart services
    pause
    exit /b 1
)
goto end

:status_services
echo Checking service status...
echo.
docker-compose ps
echo.
docker-compose ps | findstr /C:"Up" >nul
if %errorlevel% equ 0 (
    echo SUCCESS: All services are running!
) else (
    echo WARNING: Some services may still be starting up. Please wait a moment.
)
goto end

:show_logs
if not "%~2"=="" (
    echo Showing logs for service: %~2
    docker-compose logs -f "%~2"
) else (
    echo Showing logs for all services
    docker-compose logs -f
)
goto end

:exec_command
if "%~2"=="" (
    echo ERROR: Usage: exec ^<service^> ^<command^>
    echo Example: exec web bash
    pause
    exit /b 1
)
echo Executing '%~3 %~4 %~5 %~6 %~7 %~8 %~9' in %~2 container...
docker-compose exec "%~2" %~3 %~4 %~5 %~6 %~7 %~8 %~9
goto end

:cleanup
echo WARNING: This will remove all data volumes and unused images!
set /p "confirm=Are you sure? (y/N): "
if /i not "%confirm%"=="y" (
    echo Cleanup cancelled
    goto end
)
echo Stopping and removing all containers...
docker-compose down -v
echo Removing unused images...
docker image prune -f
echo SUCCESS: Cleanup completed!
goto end

:show_info
echo Project Services:
echo   • Web Server (Apache + PHP 8.2) → http://localhost:8080
echo   • Database (MySQL 8.0) → Port 3306
echo   • phpMyAdmin → http://localhost:8081
echo.
echo Environment:
echo   • Database Name: %DB_NAME:vocational%
echo   • Database Password: %DB_PASS:rootpassword%
echo.
goto end

:show_help
echo Usage: %~n0 [COMMAND] [OPTIONS]
echo.
echo Commands:
echo   start           Start all Docker services
echo   stop            Stop all Docker services
echo   restart         Restart all Docker services
echo   status          Show service status
echo   logs [service]  Show logs (optionally for specific service)
echo   exec ^<service^> ^<command^>  Execute command in container
echo   cleanup         Remove all data and unused images
echo   info            Show project information
echo   help            Show this help message
echo.
echo Examples:
echo   %~n0 start                    Start all services
echo   %~n0 logs web                 Show web service logs
echo   %~n0 exec web bash            Enter web container shell
echo   %~n0 exec db mysql -u root -p Connect to MySQL
echo.
goto end

:show_urls
echo.
echo =================================
echo      Access URLs
echo =================================
echo Web Application:     http://localhost:8080
echo phpMyAdmin:          http://localhost:8081
echo Database Port:       3306
echo.
echo Default phpMyAdmin credentials:
echo Username: root
echo Password: %DB_PASS:rootpassword%
echo.
goto end

:end
echo.
pause