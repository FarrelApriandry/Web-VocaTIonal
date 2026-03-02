# 🎓 VocaTIonal: Advanced IT Student Grievance System

**VocaTIonal** is a professional-grade, secure reporting platform specifically designed for Vocational IT students. It bridges the gap between students and stakeholders through a transparent yet secure grievance mechanism. Built with a **Zero-Trust** mindset, the system ensures data integrity and user anonymity while maintaining high-performance standards.

---

## 🚀 Architectural Excellence

The project follows a modular **Clean Architecture** approach, ensuring that business logic is decoupled from infrastructure.

### 1. DevSecOps & Automation (S1 Infrastructure Layer)

* **Automated Linting**: Every push is scanned for PHP syntax errors to ensure code reliability.
* **Secret Scanning**: Integrated **TruffleHog** to prevent sensitive credentials from leaking into the public repository.
* **Docker Build Validation**: Automated testing of container builds to ensure environment consistency across development and production.

### 2. Database Engineering

* **Version-Controlled Migrations**: A custom PHP-based migration system that allows team members to synchronize database schemas effortlessly.
* **NPM Whitelisting**: A security layer that only allows verified student IDs to submit reports, preventing spam and unauthorized data entry.

### 3. Modern Tech Stack

* **Backend**: PHP 8.2 (Native) with a custom modular kernel [cite: 2025-12-23].
* **Frontend**: Tailwind CSS for high-performance styling, Lucide Icons for aesthetic clarity, and Framer Motion for seamless UI transitions.
* **Database**: MySQL 8.0.
* **Orchestration**: Docker Compose for a "one-click" development setup.

---

## 📂 Project Structure

```text
Web-VocaTIonal/
├── .github/workflows/       # Automated DevSecOps CI/CD Pipelines
├── vocational/              # Main Application Source
│   ├── app/                 # Encapsulated Application Logic
│   │   ├── Config/          # DB Connections & Auto-Migrations
│   │   ├── Core/            # System Kernel & Env Loaders
│   │   └── Controllers/     # Logic Orchestrators
│   ├── docker/              # Infrastructure-as-Code (IaC)
│   ├── public/              # Web Entry Point & Static Assets
│   └── documentation/       # SDD & Operational Manuals
├── docker-compose.yml       # Multi-container service definition
└── .gitignore               # Security-driven file exclusion

```

---

## 🛠️ Installation & Setup

Ensure you have **Docker** and **Docker Compose** installed on your machine.

1. **Clone the Repository**:
```bash
git clone https://github.com/FarrelApriandry/Web-VocaTIonal.git
cd Web-VocaTIonal/vocational
```

2. **Environment Configuration**:
Duplicate the example environment file and configure your database credentials:
```bash
cp .env.example .env
```

3. **Boot Up Containers**:
```bash
docker-compose up -d --build
```

4. **Execute Database Migrations**:
Sync your database schema automatically without manual SQL imports:
```bash
docker exec -it vocational-web php app/Config/Migration.php

```

---

## 🛡️ Security Implementation (Zero Trust)

This project prioritizes **Cyber Security** over mere functionality:

* **Data Isolation**: All sensitive data is managed via `.env` files and never committed to version control.
* **Principle of Least Privilege**: Docker containers are configured with restricted permissions and isolated networks.
* **Integrity Checks**: Automated workflows verify that no "backdoors" or leaked secrets are introduced into the codebase.

---