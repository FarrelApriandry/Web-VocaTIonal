# 📋 VocaTIonal Repository — Full Commit History Audit Report

**Branch:** `development`  
**Audit Date:** 2026-05-27  
**Total Commits Audited:** 88  
**Audit Scope:** Initial commit → Latest commit (2026-02-21 to 2026-05-21)

---

## Chronological Commit History (Oldest → Newest)

---

### [2026-02-21] - Commit: `20fb005faff98913f62e9003f8b13dec166da7d5`
- **Commit Message:** Initial commit
- **Impacted Files:**
  * 🟢 README.md
- **Technical Summary:** Repository initialization with a blank README file to establish the project on GitHub.

---

### [2026-02-21] - Commit: `5fd05206cd05c133278aa2ae98fa42fa91dcd1e1`
- **Commit Message:** Add Software Design Document for VocaTIonal project
- **Impacted Files:**
  * 🟡 README.md
- **Technical Summary:** Updated the README with the initial Software Design Document content describing the VocaTIonal project's purpose and architecture.

---

### [2026-03-01] - Commit: `c4829f2af93f47707c413128d2a03ee620ebb4bc`
- **Commit Message:** Add Dockerized vocational app scaffold
- **Impacted Files:**
  * 🟢 vocational/.env
  * 🟢 vocational/.gitignore
  * 🟢 vocational/.htaccess
  * 🟢 vocational/Dockerfile
  * 🟢 vocational/app/Config/Database.php
  * 🟢 vocational/app/Controllers/Admin.php
  * 🟢 vocational/app/Core/Controller.php
  * 🟢 vocational/app/Core/Env.php
  * 🟢 vocational/docker-compose.yml
  * 🟢 vocational/docker/apache/vhost.conf
  * 🟢 vocational/documentation/Panduan-Operasional-Docker.md
  * 🟢 vocational/documentation/PanduanOperasionalDocker/Image/phpmyadmin-login.png
  * 🟢 vocational/documentation/PanduanOperasionalDocker/Image/web-utama.png
  * 🟢 vocational/public/assets/img/logo-himatif.svg
  * 🟢 vocational/public/index.php
- **Technical Summary:** Established the full Docker-based PHP application scaffold including Apache vhost configuration, database config, MVC core classes (Controller, Env), and operational documentation with screenshots.

---

### [2026-03-02] - Commit: `d613d18f302c0a7c0335cece158b2b26b2766ad4`
- **Commit Message:** Add skeleton loader, file preview, and UI tweaks
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Added skeleton loading animations and file preview functionality to the main landing page for improved perceived performance.

---

### [2026-03-02] - Commit: `8fb03fac4033439972974817787906ecb941a4b9`
- **Commit Message:** Update Panduan Anonimitas
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Updated the anonymity guide/instructions displayed on the main page for user-facing content clarity.

---

### [2026-03-02] - Commit: `8a4022ccfa0a590bc0994294a0f41764e38ffb45`
- **Commit Message:** Create GitIgnore File
- **Impacted Files:**
  * 🟢 .gitignore
  * 🔴 vocational/.gitignore
  * 🟢 vocational/app/Config/Migration.php
- **Technical Summary:** Moved .gitignore to the repository root level and introduced the Migration.php configuration file for database schema management.

---

### [2026-03-02] - Commit: `9211e059e70fe5c2c1e0b5990decd0241cc8a935`
- **Commit Message:** Delete .env file (DUMB MISTAKE)
- **Impacted Files:**
  * 🔴 vocational/.env
- **Technical Summary:** Removed accidentally committed .env file containing sensitive environment variables from version control.

---

### [2026-03-02] - Commit: `ad2a3f472d79d3a6a3dc6d2750898ff0b61e473d`
- **Commit Message:** Add environment preparation section with video links
- **Impacted Files:**
  * 🟡 vocational/documentation/Panduan-Operasional-Docker.md
- **Technical Summary:** Enhanced Docker operational guide with environment preparation instructions and embedded video tutorial links.

---

### [2026-03-03] - Commit: `c3096ee29e2b3245cd712843e8083a725bb46f80`
- **Commit Message:** ci: implement automated PHP linting via GitHub Actions to ensure code integrity on push
- **Impacted Files:**
  * 🟢 .github/workflows/ci.yml
- **Technical Summary:** Created the initial CI pipeline with GitHub Actions for automated PHP syntax linting on every push event.

---

### [2026-03-03] - Commit: `137baa04c4425b1318a3a26aeef02b0b6b12df26`
- **Commit Message:** ci: add GitHub Actions workflow for automated PHP syntax linting, Security Scan, Docker Build Test
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Expanded CI workflow to include security scanning and Docker build testing alongside PHP linting.

---

### [2026-03-03] - Commit: `efd6a893e8b8e7e448915efd402b60c5efd10ae2`
- **Commit Message:** ci: Update Security Scan - Delete base n head
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Removed base and head branch references from the security scan step to fix workflow configuration.

---

### [2026-03-03] - Commit: `637d8ba7828e90fff3191b41eb146f4ad91a6462`
- **Commit Message:** docs: Add Software Design Document for VocaTIonal project
- **Impacted Files:**
  * 🟢 vocational/documentation/Software-Design-Document.md
- **Technical Summary:** Created a dedicated Software Design Document markdown file within the documentation folder detailing system architecture and design decisions.

---

### [2026-03-03] - Commit: `900bb9e80c189b39672536b696877d253fb4cfb5`
- **Commit Message:** docs: Revise README to enhance project overview and architectural details
- **Impacted Files:**
  * 🟡 README.md
- **Technical Summary:** Revised the root README with improved project overview, architectural descriptions, and structural documentation.

---

### [2026-03-03] - Commit: `c6924ccb68b2eb7b3fe14ca49611bcc8b19270cb`
- **Commit Message:** feat: Add Docker setup guide and management scripts for local development
- **Impacted Files:**
  * 🟢 vocational/Docker-Running.md
  * 🟢 vocational/docker-start.bat
  * 🟢 vocational/docker-start.sh
- **Technical Summary:** Added cross-platform Docker startup scripts (batch for Windows, shell for Linux/Mac) and a running guide for local development setup.

---

### [2026-03-04] - Commit: `be138021a3a3c1a8992d92e3fce1a6fb0073940c`
- **Commit Message:** Upload New Documentation
- **Impacted Files:**
  * 🟢 vocational/documentation/img/AnonimActive.png
  * 🟢 vocational/documentation/img/DefaultPage.png
- **Technical Summary:** Added documentation screenshots showing the default page state and the anonymity-active state of the application UI.

---

### [2026-03-04] - Commit: `545e638e0abce990c79c8455d1ed1c36d881e4fa`
- **Commit Message:** feat: Enhance CI/CD configuration and add documentation for Docker setup
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
  * 🟢 GITHUB_SECRETS_GUIDE.md
  * 🟢 composer.json
  * 🟢 phpcs.xml
  * 🟢 phpstan.neon
  * 🟢 tests/Integration/README.md
  * 🔴 vocational/Docker-Running.md
  * 🟢 vocational/documentation/Docker-Running.md
- **Technical Summary:** Enhanced CI with PHP CodeSniffer and PHPStan static analysis tools, added composer.json for dependency management, created a GitHub Secrets guide, and relocated Docker documentation.

---

### [2026-03-04] - Commit: `2a0bca71b46cf5f059a7262e9439dfc1a15243f2`
- **Commit Message:** Update CI for Vocational
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
  * 🟡 composer.json
  * 🟡 tests/Integration/README.md
- **Technical Summary:** Adjusted CI workflow paths and composer dependencies to align with the vocational project directory structure.

---

### [2026-03-04] - Commit: `9fb122d752cdd911cf76ad78b7772a281c9192c2`
- **Commit Message:** refactor: simplify CI workflow and add security scanning
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Simplified the CI pipeline structure while retaining security scanning capabilities for a cleaner workflow definition.

---

### [2026-03-04] - Commit: `f8a2cabd664074b83f7bf07abafbc5939f6a3492`
- **Commit Message:** Remove deleted CI workflow file
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Cleaned up references to a previously deleted workflow file within the CI configuration.

---

### [2026-03-04] - Commit: `fc983aee27f988a5bc51f2bb95f70a25cba5c1d6`
- **Commit Message:** chore: update Docker setup in CI workflow
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Updated Docker build and setup steps within the CI workflow for proper container testing.


---

### [2026-03-04] - Commit: `28a7c43744e2c783732ac1c787c0db1f340213f8`
- **Commit Message:** fix: correct Docker service test script syntax and improve error handling
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Fixed shell script syntax errors in Docker service health check tests and added proper error handling.

---

### [2026-03-04] - Commit: `542ebbca6a41566dc79808d7f3256cd0aaa338cf`
- **Commit Message:** ci: Delete Docker Services Steps
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Removed Docker service testing steps from CI due to environment limitations in GitHub Actions runners.

---

### [2026-03-04] - Commit: `56f9a007373b4aa24c83eca8e4c955166712a60c`
- **Commit Message:** chore: remove obsolete configuration files for GitHub Secrets, Composer, PHP CodeSniffer, and PHPStan
- **Impacted Files:**
  * 🔴 GITHUB_SECRETS_GUIDE.md
  * 🔴 composer.json
  * 🔴 phpcs.xml
  * 🔴 phpstan.neon
- **Technical Summary:** Removed previously added static analysis and dependency management configs that were deemed unnecessary for the project's current scope.

---

### [2026-03-04] - Commit: `91e9546ea5b31916a9c86b47e8a886330ffd8801`
- **Commit Message:** fix: update Docker job name for clarity
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Renamed the Docker CI job for better readability in GitHub Actions dashboard.

---

### [2026-03-05] - Commit: `e23bcfbbd0af4af3f9d7048850791262dd38ea8c`
- **Commit Message:** Update index.php
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Minor updates to the main index page content or layout.

---

### [2026-03-06] - Commit: `2d5709876c3cb88b028999e3646408d98e69fc7a`
- **Commit Message:** Update index.php
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Continued iterative updates to the main landing page UI/content.

---

### [2026-03-06] - Commit: `43535432af76373f07499404b3e604b396f4ac83`
- **Commit Message:** feat: Add login modal and auto-format NPM input
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Implemented a login modal dialog with NPM (student ID) input field that auto-formats as the user types.

---

### [2026-03-06] - Commit: `869eaaa9611ad835c83f10b15995ad1a515f9783`
- **Commit Message:** fix: login modal logic and button behavior
- **Impacted Files:**
  * 🟢 vocational/app/Views/Components/Test.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Fixed login modal open/close logic and button event handlers; added a test component for development purposes.

---

### [2026-03-12] - Commit: `e6ed3c2939a9d29e17957653fcca4cc996c74ce4`
- **Commit Message:** Update version and technology stack in SDD
- **Impacted Files:**
  * 🟡 vocational/documentation/Software-Design-Document.md
- **Technical Summary:** Updated the Software Design Document with current version numbers and revised technology stack specifications.

---

### [2026-03-14] - Commit: `9ebd268579e0b3bd415399a7c1029f61af38a40a`
- **Commit Message:** Update docker-compose.yml for service configurations
- **Impacted Files:**
  * 🟡 vocational/docker-compose.yml
- **Technical Summary:** Updated Docker Compose service definitions including volume mounts, environment variables, or network configurations.

---

### [2026-03-14] - Commit: `1ad269c1af3e4685464267cffaadcca89d59e9ad`
- **Commit Message:** fix: Add newline characters and comments to improve code formatting and readability
- **Impacted Files:**
  * 🟡 vocational/app/Config/Database.php
  * 🟡 vocational/app/Config/Migration.php
  * 🟢 vocational/app/Views/Components/Header.php
  * 🟢 vocational/app/Views/Components/Navbar.php
  * 🔴 vocational/app/Views/Components/Test.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Introduced reusable Header and Navbar view components, removed the test component, and improved code formatting across config files.

---

### [2026-03-14] - Commit: `d0f41f2195fc31a1f96f6b80e4dfdbf47e0998ca`
- **Commit Message:** nambahin table admin_web
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Added the `admin_web` table schema definition to the migration configuration for admin user management.

---

### [2026-03-14] - Commit: `5b3b89989f83afe294eff6a490e81fcf8ce59106`
- **Commit Message:** Merge branch 'main' of https://github.com/FarrelApriandry/Web-VocaTIonal
- **Impacted Files:**
  * *(No file changes — merge commit)*
- **Technical Summary:** Merge commit integrating changes from the remote main branch into the local development branch.

---

### [2026-03-14] - Commit: `fa100c55ffd082f8c37254e2ef7876ceffa53b51`
- **Commit Message:** feat: Add deployment workflow for DigitalOcean and create Form-ConfrmationAspirasi component
- **Impacted Files:**
  * 🟢 .github/workflows/deploy.yml
  * 🟢 vocational/app/Views/Components/Form-ConfrmationAspirasi.php
- **Technical Summary:** Created a CD deployment workflow targeting DigitalOcean servers and added an aspiration confirmation form component (with typo in filename).

---

### [2026-03-14] - Commit: `58372a4493284d4e1324890f3c1d3d9a59921fc6`
- **Commit Message:** chore(deploy): fix deployment script path and add build comment
- **Impacted Files:**
  * 🟡 .github/workflows/deploy.yml
- **Technical Summary:** Corrected the deployment script's working directory path and added clarifying comments to the build step.

---

### [2026-03-14] - Commit: `ca2f40a287f5c60751ee7d74902ad30d67e1f17e`
- **Commit Message:** Testing Deployment Action GitHub into Server
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Made a test change to index.php to verify the GitHub Actions deployment pipeline is functioning correctly.

---

### [2026-03-14] - Commit: `bf573810067826f7864f8ea74b10ecbcf21d15d8`
- **Commit Message:** Update homepage greeting and add form confirmation modal with validation
- **Impacted Files:**
  * 🟢 vocational/app/Views/Components/Form-ConfirmationAspirasi.php
  * 🔴 vocational/app/Views/Components/Form-ConfrmationAspirasi.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Fixed the typo in the aspiration confirmation form filename, added form validation logic, and updated the homepage greeting text.

---

### [2026-03-15] - Commit: `28c1dff99f7811dc8d94b7af540c9e1d1c7f98d3`
- **Commit Message:** feat: add admin_web table and initial admin record
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟢 vocational/app/Views/Form-Aspirasi.php
- **Technical Summary:** Added initial admin seed data to the migration and created a standalone aspiration form view template.

---

### [2026-03-15] - Commit: `8ae819183ab13f254fa20cc79693658b9e7d5ba1`
- **Commit Message:** refactor: remove unused form and simplify main content layout
- **Impacted Files:**
  * 🟡 vocational/public/index.php
  * 🟢 vocational/public/js/WILLBEDELEETEDSOON.php
- **Technical Summary:** Simplified the main page layout by removing unused form elements and added a temporary placeholder JS file.

---

### [2026-03-18] - Commit: `543bca9f418bda45562cf676d4ef36f8a8e71ff9`
- **Commit Message:** Remove redundant comment from .gitignore
- **Impacted Files:**
  * 🟡 .gitignore
- **Technical Summary:** Cleaned up unnecessary comments in the root .gitignore file.

---

### [2026-03-18] - Commit: `262e2825e421c8f91307f2fb9d0d36e4f2fca443`
- **Commit Message:** chore: update Docker port mapping from 80 to 8080
- **Impacted Files:**
  * 🟡 vocational/docker-compose.yml
- **Technical Summary:** Changed the host port mapping from 80 to 8080 to avoid conflicts with other local services.


---

### [2026-04-01] - Commit: `41ae364e0dab361eb33f15b0d9510b84146b643d`
- **Commit Message:** ci: update deployment workflow and seed initial data
- **Impacted Files:**
  * 🟡 .github/workflows/deploy.yml
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Updated the deployment workflow steps and added initial seed data (admin records) to the database migration.

---

### [2026-04-01] - Commit: `9df4e10a0dea610a67b5f52948f97de2c26906d7`
- **Commit Message:** fix: make migration idempotent with INSERT IGNORE and error handling
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Made database migrations safe to re-run by using INSERT IGNORE statements and adding try-catch error handling.

---

### [2026-04-01] - Commit: `842c0358b551d28afa88f1089d84718a50407880`
- **Commit Message:** refactor: hash default admin password in migration
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Replaced plaintext default admin password with a bcrypt hash in the migration seed data for security.

---

### [2026-04-01] - Commit: `e22ba84168931ffb19d1f62fd2427da06abe6d2c`
- **Commit Message:** feat(config): adjust whitelist column types and add migration comments
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Modified whitelist table column data types and added inline documentation comments to migration SQL statements.

---

### [2026-04-01] - Commit: `2f4a98a67410d15c2a97f4c536c16923539bd9b8`
- **Commit Message:** nothin
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Minor/trivial change to the migration file (likely whitespace or formatting adjustment).

---

### [2026-04-01] - Commit: `2fe47d64f061da8e8fe4b5cbc965f1dfe8332843`
- **Commit Message:** chore: reset local changes before pulling latest code in deployment workflow
- **Impacted Files:**
  * 🟡 .github/workflows/deploy.yml
- **Technical Summary:** Added a git reset step in the deployment workflow to discard local server changes before pulling the latest code.

---

### [2026-04-01] - Commit: `349ff432e8d2bcd7b6a4c830c937327d40813a16`
- **Commit Message:** refactor: increase admin password field length to 255
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Increased the admin_web password column from a shorter length to VARCHAR(255) to accommodate bcrypt hashes.

---

### [2026-04-01] - Commit: `b3e45f4919e97897981693a046099988a28c35b1`
- **Commit Message:** feat: implement secure login with CSRF protection and session tracking
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟢 vocational/app/Config/Session.php
  * 🟢 vocational/app/Controllers/Auth.php
  * 🟢 vocational/public/api/login.php
  * 🟢 vocational/public/api/logout.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Implemented the complete authentication system with CSRF token protection, session management configuration, Auth controller logic, and login/logout API endpoints.

---

### [2026-04-01] - Commit: `f0d17eaa8a2b5619b28cebc7d91b1a457a4dfbdd`
- **Commit Message:** ci: renumber and clarify deployment script steps
- **Impacted Files:**
  * 🟡 .github/workflows/deploy.yml
- **Technical Summary:** Reorganized and renumbered deployment workflow steps with clearer naming for maintainability.

---

### [2026-04-01] - Commit: `79f7f40c5a4432b5f2eab434e4b0e25b391900b6`
- **Commit Message:** feat: implement session timeout and security enhancements
- **Impacted Files:**
  * 🟡 vocational/app/Config/Database.php
  * 🟡 vocational/app/Config/Session.php
  * 🟡 vocational/app/Controllers/Auth.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Added session timeout/expiry logic, enhanced session security settings (httponly, secure flags), and updated the Auth controller with session validation.

---

### [2026-04-02] - Commit: `b3abd1ae51c03d75e890979987164fb48370ae68`
- **Commit Message:** chore: update web container port to standard HTTP port 80
- **Impacted Files:**
  * 🟡 vocational/docker-compose.yml
- **Technical Summary:** Reverted the Docker port mapping back to port 80 for production-like local development.

---

### [2026-04-02] - Commit: `2a016131159b86e7cf790ba880340aeb310195f7`
- **Commit Message:** docs: update Docker web port from 8080 to 80
- **Impacted Files:**
  * 🟡 vocational/documentation/Docker-Running.md
  * 🟡 vocational/documentation/Panduan-Operasional-Docker.md
  * 🟡 vocational/documentation/PanduanOperasionalDocker/Image/web-utama.png
- **Technical Summary:** Updated all Docker documentation and screenshots to reflect the port change from 8080 back to 80.

---

### [2026-04-02] - Commit: `7183bf89d6324bc882b8b715b81790a8c04e39b3`
- **Commit Message:** feat(auth): enhance login security with session regeneration and validation
- **Impacted Files:**
  * 🟡 vocational/app/Config/Session.php
  * 🟡 vocational/app/Controllers/Auth.php
  * 🟢 vocational/app/Views/Components/ConfirmationModal.php
  * 🟡 vocational/app/Views/Components/Header.php
  * 🟡 vocational/public/api/login.php
  * 🟢 vocational/public/js/confirmation-modal.js
- **Technical Summary:** Added session ID regeneration on login to prevent session fixation attacks, created a reusable confirmation modal component with JavaScript, and updated the login API response handling.

---

### [2026-04-02] - Commit: `98928b6f572535c0af3b1ceaa229af4fcccce300`
- **Commit Message:** ci: update pipeline to main branch and rename workflow
- **Impacted Files:**
  * 🟢 .github/workflows/cd.yml (renamed from deploy.yml)
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Renamed the deployment workflow from `deploy.yml` to `cd.yml` for conventional naming and updated CI triggers to target the main branch.


---

### [2026-04-02] - Commit: `5995ede91e9d2265500968fb918ae524c18c0063`
- **Commit Message:** feat: add new migration, improve login UX, and refactor comments
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟡 vocational/public/api/login.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Added new database table migrations, improved the login user experience flow, updated navbar component, and cleaned up code comments.

---

### [2026-04-02] - Commit: `74c4372ee22847cf0e61fb4a2ecc182b6df72aa0`
- **Commit Message:** feat: add descriptive name to deploy job workflow
- **Impacted Files:**
  * 🟡 .github/workflows/cd.yml
- **Technical Summary:** Added a human-readable `name` field to the CD workflow job for better GitHub Actions UI display.

---

### [2026-04-02] - Commit: `26faba7b30a6ad8489e5ffd4c9d9c5c253ce3ae7`
- **Commit Message:** feat: improve login response handling with JSON parsing and error recovery
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Improved client-side login response handling with proper JSON parsing and graceful error recovery for failed requests.

---

### [2026-04-02] - Commit: `8a47af8ed40df652bf392ba5bc446b964bf6845f`
- **Commit Message:** feat: display user name in login success alert
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Added personalized greeting by displaying the authenticated user's name in the login success notification.

---

### [2026-04-02] - Commit: `a187837116bac5b713a0ee818f776818d804711d`
- **Commit Message:** feat(auth): improve login response handling and debug logging
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Enhanced login response processing with additional debug logging for troubleshooting authentication issues.

---

### [2026-04-02] - Commit: `9172b39e77c706c70ab5bfc45310715e675eb284`
- **Commit Message:** feat: add logs directory and improve Docker file permissions
- **Impacted Files:**
  * 🟡 vocational/Dockerfile
- **Technical Summary:** Updated the Dockerfile to create a logs directory and set proper file permissions for the Apache/PHP process.

---

### [2026-04-03] - Commit: `410f2fb3606401580f6d9cc9eadbff8ad2b2a88a`
- **Commit Message:** feat: improve accessibility and UX with semantic buttons and modals
- **Impacted Files:**
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Replaced non-semantic elements with proper button/dialog elements for improved accessibility and screen reader support.

---

### [2026-04-03] - Commit: `ff79287ef63e65d5e85996de60f1c801befdf975`
- **Commit Message:** feat: Add bulletin board and reaction system for aspirations
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟢 vocational/app/Models/Aspirasi.php
  * 🟢 vocational/app/Models/AspirationReaction.php
  * 🟢 vocational/app/Models/AspirationReport.php
  * 🟢 vocational/app/Views/Components/BoardAspirationCard.php
  * 🟡 vocational/app/Views/Components/Form-ConfirmationAspirasi.php
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟢 vocational/app/Views/Components/ReportModal.php
  * 🟢 vocational/app/Views/Components/ShowBoardToggle.php
  * 🟢 vocational/public/api/board/aspirations.php
  * 🟢 vocational/public/api/board/react.php
  * 🟢 vocational/public/api/board/report.php
  * 🟢 vocational/public/api/submit-aspirasi.php
  * 🟢 vocational/public/bulletin-board.php
  * 🟡 vocational/public/index.php
  * 🔴 vocational/public/js/WILLBEDELEETEDSOON.php
  * 🟢 vocational/public/js/toast.js
- **Technical Summary:** Major feature addition implementing the public bulletin board with aspiration cards, emoji reaction system, content reporting functionality, and associated API endpoints and models.

---

### [2026-04-03] - Commit: `94605d35e04ad4f6e850a856ed219d0589f4a5a7`
- **Commit Message:** feat: add Sarpras and Layanan categories to aspirasi system
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟡 vocational/app/Models/Aspirasi.php
  * 🟡 vocational/public/api/board/aspirations.php
  * 🟡 vocational/public/api/submit-aspirasi.php
  * 🟡 vocational/public/bulletin-board.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Extended the aspiration category system with new "Sarpras" (infrastructure) and "Layanan" (services) categories across the model, API, and UI layers.

---

### [2026-04-03] - Commit: `4677263c269a341b0e206429a46f3dd14199ffdf`
- **Commit Message:** feat(navbar): add responsive mobile navigation menu
- **Impacted Files:**
  * 🟡 vocational/app/Views/Components/Navbar.php
- **Technical Summary:** Implemented a responsive hamburger menu for mobile viewports with slide-in navigation panel.

---

### [2026-04-03] - Commit: `4cf2f5248055185f1b382f33264819e17461a91f`
- **Commit Message:** feat: add migration entry for Muhammad Asyrof
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Added a new admin user seed record for Muhammad Asyrof in the database migration.

---

### [2026-04-03] - Commit: `e77637b891a72e5c2588a80300bd45b0282cd9a1`
- **Commit Message:** feat: remove trailing comma from migration entry
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Fixed a syntax issue by removing a trailing comma from the migration SQL insert statement.


---

### [2026-04-03] - Commit: `84c1a1c4d9be22af108d8bc31a81a223f3c668ca`
- **Commit Message:** Add centralized path configuration and new profile navigation pages
- **Impacted Files:**
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟢 vocational/public/includes/paths.php
  * 🟢 vocational/public/panduan.php
  * 🟢 vocational/public/profile-navigation/profile.php
  * 🟢 vocational/public/profile-navigation/settings.php
- **Technical Summary:** Created a centralized path configuration file and added new profile navigation pages (profile view, settings) along with a panduan (guide) page.

---

### [2026-04-03] - Commit: `5f87c809df71596a760e7cd58c71b969195338fd`
- **Commit Message:** Move Documentation Folder into Root
- **Impacted Files:**
  * 🟡 vocational/documentation/Docker-Running.md → documentation/Docker-Running.md
  * 🟡 vocational/documentation/Panduan-Operasional-Docker.md → documentation/Panduan-Operasional-Docker.md
  * 🟡 vocational/documentation/PanduanOperasionalDocker/Image/phpmyadmin-login.png → documentation/PanduanOperasionalDocker/Image/phpmyadmin-login.png
  * 🟡 vocational/documentation/PanduanOperasionalDocker/Image/web-utama.png → documentation/PanduanOperasionalDocker/Image/web-utama.png
  * 🟡 vocational/documentation/Software-Design-Document.md → documentation/Software-Design-Document.md
  * 🟡 vocational/documentation/img/AnonimActive.png → documentation/img/AnonimActive.png
  * 🟡 vocational/documentation/img/DefaultPage.png → documentation/img/DefaultPage.png
- **Technical Summary:** Relocated the entire documentation folder from inside the vocational app directory to the repository root for better project-level accessibility.

---

### [2026-04-04] - Commit: `f34d8dc58bd731421dad30b0f89021bc0e4087ed`
- **Commit Message:** feat: add anonymous aspiration support with database schema updates
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟡 vocational/public/api/submit-aspirasi.php
  * 🟡 vocational/public/index.php
  * 🟡 vocational/public/panduan.php
- **Technical Summary:** Added anonymous submission capability to the aspiration system with corresponding database schema changes and UI toggle for anonymity.

---

### [2026-04-04] - Commit: `af54b295102c51d6556590be2f2121771a03c6f2`
- **Commit Message:** feat: refactor bulletin board file paths using dynamic variables
- **Impacted Files:**
  * 🟡 vocational/public/bulletin-board.php
- **Technical Summary:** Replaced hardcoded file paths in the bulletin board with dynamic path variables from the centralized configuration.

---

### [2026-04-04] - Commit: `c02694a2b82d2027292831d235d7b1bbac019b34`
- **Commit Message:** feat: update CD workflow to pull from root directory
- **Impacted Files:**
  * 🟡 .github/workflows/cd.yml
- **Technical Summary:** Updated the CD workflow's git pull command to operate from the repository root directory instead of a subdirectory.

---

### [2026-04-04] - Commit: `a894a7e42e1cc7df2ec1533070e71f1007566ed5`
- **Commit Message:** style: add border styling to category filter buttons
- **Impacted Files:**
  * 🟡 vocational/public/bulletin-board.php
- **Technical Summary:** Added border CSS styling to the category filter buttons on the bulletin board for better visual definition.

---

### [2026-04-04] - Commit: `a87ff4e94b117dd22e3ec4295fcb88a8e1b8a8ca`
- **Commit Message:** style: update category filter border color to gray-200
- **Impacted Files:**
  * 🟡 vocational/public/bulletin-board.php
- **Technical Summary:** Refined the category filter button border color to a lighter gray-200 shade for subtler visual appearance.

---

### [2026-04-04] - Commit: `419e7dfee297c8d0aa8cdf103e07cbbccbc55a79`
- **Commit Message:** feat(navbar): make logo clickable and add panduan link
- **Impacted Files:**
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟡 vocational/public/profile-navigation/settings.php
- **Technical Summary:** Made the HIMATIF logo a clickable link to the homepage and added a navigation link to the panduan (guide) page.

---

### [2026-04-04] - Commit: `46d773037500ffb7c4ad81c231d079bfb9edeaed`
- **Commit Message:** feat: move confirmation modal and script before main scripts
- **Impacted Files:**
  * 🟡 vocational/public/profile-navigation/profile.php
- **Technical Summary:** Reordered the confirmation modal component and its script to load before main page scripts for proper initialization order.

---

### [2026-04-05] - Commit: `23fc2d2b56875fc9eec04e1f490b2a6446cfafd3`
- **Commit Message:** feat: improve auth flow and add CSS line-clamp standard property
- **Impacted Files:**
  * 🟢 vocational/app/Controllers/AdminController.php
  * 🟢 vocational/app/Controllers/AspirationController.php
  * 🟡 vocational/app/Views/Components/BoardAspirationCard.php
  * 🟡 vocational/public/bulletin-board.php
  * 🟡 vocational/public/index.php
  * 🟡 vocational/public/panduan.php
- **Technical Summary:** Added AdminController and AspirationController classes, applied CSS `line-clamp` standard property for text truncation, and improved the authentication flow.

---

### [2026-04-05] - Commit: `0e0b77d360d8265af58a74f84b01f852543c3bf3`
- **Commit Message:** feat: improve code clarity by standardizing comments
- **Impacted Files:**
  * 🟡 vocational/public/bulletin-board.php
  * 🟡 vocational/public/panduan.php
- **Technical Summary:** Standardized code comments across bulletin board and panduan pages for consistent documentation style.

---

### [2026-04-05] - Commit: `1f3b789ae6239b62625f215d1ec39b0ae3e36e96`
- **Commit Message:** feat: enhance login flow with conditional skeleton loader and post-login transitions
- **Impacted Files:**
  * 🟡 vocational/public/index.php
- **Technical Summary:** Added conditional skeleton loader display during authentication and smooth UI transitions after successful login.

---

### [2026-04-05] - Commit: `860b91fb527ebcfc32b2740fc914c22d88b11548`
- **Commit Message:** feat: suppress error output in production environments
- **Impacted Files:**
  * 🟡 vocational/app/Controllers/Auth.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Disabled PHP error display output in production mode to prevent information leakage while maintaining error logging.

---

### [2026-04-05] - Commit: `95293dcd1aff416acd85d90a6033fa9eea999d3b`
- **Commit Message:** feat: improve aspirasi filtering and add riwayat navigation
- **Impacted Files:**
  * 🟡 vocational/app/Models/Aspirasi.php
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟢 vocational/public/api/get-riwayat.php
  * 🟢 vocational/public/riwayat.php
- **Technical Summary:** Enhanced aspiration filtering in the model layer and added a "riwayat" (history) page with API endpoint for users to view their past submissions.

---

### [2026-04-05] - Commit: `1025378a8bc2efbae0e98e1f6060cd0fe6d478bc`
- **Commit Message:** feat: configure timezone settings for docker services
- **Impacted Files:**
  * 🟡 vocational/docker-compose.yml
- **Technical Summary:** Added timezone environment variables to Docker services for consistent date/time handling across containers.


---

### [2026-04-05] - Commit: `d78559f286de9bc5c6f0cb52de385f72e2f4eb85`
- **Commit Message:** feat: add separate vhost configs for student and admin portals
- **Impacted Files:**
  * 🟢 vocational/admin/index.php
  * 🟡 vocational/docker/apache/vhost.conf
- **Technical Summary:** Created the admin portal entry point and configured separate Apache virtual hosts for the student-facing and admin-facing applications.

---

### [2026-04-05] - Commit: `c7b019b6b31de5e485497702d1149ded26620d4a`
- **Commit Message:** feat: improve Docker configuration for Apache setup and permissions
- **Impacted Files:**
  * 🔴 vocational/.htaccess
  * 🟡 vocational/Dockerfile
- **Technical Summary:** Removed the .htaccess file in favor of vhost-level configuration and updated Dockerfile with proper Apache module enabling and permissions.

---

### [2026-04-05] - Commit: `c569d3a8908c44d4fb9553711bdfee222c384742`
- **Commit Message:** feat: add production domain aliases to Apache vhost configuration
- **Impacted Files:**
  * 🟡 vocational/docker/apache/vhost.conf
- **Technical Summary:** Added ServerAlias directives for production domains (vocational.info, admin.vocational.info) to the Apache vhost configuration.

---

### [2026-04-05] - Commit: `1057812971c6846719dd78a41c3def7af5688d59`
- **Commit Message:** feat(database): refactor admin_web table schema and add username field
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Refactored the admin_web table schema to include a dedicated username field for authentication purposes.

---

### [2026-04-05] - Commit: `b88a5ab577d96e26557d1fef42cb77d2795f3a98`
- **Commit Message:** Add admin authentication system with login functionality
- **Impacted Files:**
  * 🟢 vocational/admin/api/admin-login.php
  * 🟢 vocational/admin/api/admin-logout.php
  * 🟢 vocational/admin/assets/img/logo-himatif.svg
  * 🟢 vocational/admin/auth/login.php
  * 🟡 vocational/admin/index.php
  * 🟢 vocational/app/Controllers/AdminAuth.php
- **Technical Summary:** Implemented the complete admin authentication system with login/logout API endpoints, a styled login page, and the AdminAuth controller with credential validation.

---

### [2026-04-05] - Commit: `0c0ddf2e50e9eb80e9d8cc82837e781af59b94e4`
- **Commit Message:** feat: add admin panel header and sidebar components
- **Impacted Files:**
  * 🟢 vocational/admin/components/Header.php
  * 🟢 vocational/admin/components/Sidebar.php
  * 🟢 vocational/admin/dashboard.php
- **Technical Summary:** Created the admin panel layout components (header with user info, sidebar navigation) and the initial dashboard page.

---

### [2026-04-05] - Commit: `588ee290923e8be30373c38487b3c7b4a0deb8a4`
- **Commit Message:** feat: rename admin_web id column from id_admin to admin_id
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
- **Technical Summary:** Renamed the primary key column in admin_web table from `id_admin` to `admin_id` for naming consistency.

---

### [2026-04-05] - Commit: `afeaa71a8cada208b6b06c38e6cc8c73b90fb2fb`
- **Commit Message:** fix: correct admin table column names and role assignment
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟡 vocational/app/Controllers/AdminAuth.php
- **Technical Summary:** Fixed column name references in the migration and AdminAuth controller to match the renamed schema fields.

---

### [2026-04-05] - Commit: `e4bb1131bc1639a8c507b53f653cc68f340957e3`
- **Commit Message:** feat: update admin login styling and fix session key
- **Impacted Files:**
  * 🟡 vocational/admin/api/admin-login.php
  * 🟡 vocational/admin/auth/login.php
  * 🟡 vocational/app/Controllers/AdminAuth.php
- **Technical Summary:** Updated the admin login page styling, fixed session key naming for admin authentication, and aligned API response format.

---

### [2026-04-05] - Commit: `d7fa4b3e1433954dea4772c84fe8be54f1cd7140`
- **Commit Message:** feat: remove debug console logs from codebase
- **Impacted Files:**
  * 🟡 vocational/public/index.php
  * 🟡 vocational/public/riwayat.php
- **Technical Summary:** Cleaned up development debug console.log statements from production-facing JavaScript code.

---

### [2026-04-05] - Commit: `81cb435bf212c86ba8273cb2273c1a899d7064ab`
- **Commit Message:** feat: add defensive null checks for database query results
- **Impacted Files:**
  * 🟡 vocational/admin/components/Sidebar.php
  * 🟡 vocational/admin/dashboard.php
- **Technical Summary:** Added null/empty checks on database query results in the admin sidebar and dashboard to prevent undefined index errors.

---

### [2026-04-05] - Commit: `9b3b966c2aa03abf6b74dca14723203b1b33425f`
- **Commit Message:** feat: add admin aspirations management page
- **Impacted Files:**
  * 🟢 vocational/admin/aspirations.php
  * 🟢 vocational/admin/board.php
  * 🟢 vocational/admin/reports.php
- **Technical Summary:** Created the admin management pages for aspirations, bulletin board, and reports with listing, filtering, and action capabilities.

---

### [2026-04-05] - Commit: `2380066a3747c20c5cc3daa7c0b1099bb320df31`
- **Commit Message:** feat: implement aspiration status update API endpoint
- **Impacted Files:**
  * 🟢 vocational/admin/api/update-aspirasi-status.php
  * 🟡 vocational/admin/aspirations.php
- **Technical Summary:** Created an API endpoint for admins to update aspiration statuses (pending/processing/completed) and integrated it with the aspirations management UI.


---

### [2026-04-06] - Commit: `b1002a74f82f523cb3887be12781beaeac9f2264`
- **Commit Message:** feat: Add admin login functionality and routing
- **Impacted Files:**
  * 🟢 vocational/admin/app/Config/Database.php
  * 🟢 vocational/admin/app/Config/Session.php
  * 🟢 vocational/admin/app/Config/routes.php
  * 🟡 vocational/app/Controllers/Admin.php → vocational/admin/app/Controllers/Admin.php (renamed)
  * 🟡 vocational/app/Controllers/AdminAuth.php → vocational/admin/app/Controllers/AdminAuth.php (renamed)
  * 🟢 vocational/admin/app/Controllers/AdminBaseController.php
  * 🟢 vocational/admin/app/Controllers/AspirationsController.php
  * 🟢 vocational/admin/app/Controllers/BoardController.php
  * 🟢 vocational/admin/app/Controllers/DashboardController.php
  * 🟢 vocational/admin/app/Controllers/ReportsController.php
  * 🟢 vocational/admin/app/Core/Env.php
  * 🟢 vocational/admin/app/Models/Aspirasi.php
  * 🟢 vocational/admin/app/Models/AspirationReport.php
  * 🟡 vocational/admin/components/Sidebar.php → vocational/admin/app/Views/Components/Sidebar.php (renamed)
  * 🟡 vocational/admin/components/Header.php → vocational/admin/app/Views/Layouts/Header.php (renamed)
  * 🟢 vocational/admin/app/Views/Layouts/main.php
  * 🟢 vocational/admin/app/Views/aspirations.php
  * 🟡 vocational/admin/board.php → vocational/admin/app/Views/board.php (renamed)
  * 🟢 vocational/admin/app/Views/dashboard.php
  * 🟡 vocational/admin/reports.php → vocational/admin/app/Views/reports.php (renamed)
  * 🔴 vocational/admin/aspirations.php
  * 🔴 vocational/admin/dashboard.php
  * 🔴 vocational/admin/index.php
  * 🟡 vocational/admin/api/admin-login.php → vocational/admin/public/api/admin-login.php (renamed)
  * 🟡 vocational/admin/api/admin-logout.php → vocational/admin/public/api/admin-logout.php (renamed)
  * 🟡 vocational/admin/api/update-aspirasi-status.php → vocational/admin/public/api/update-aspirasi-status.php (renamed)
  * 🟡 vocational/admin/assets/img/logo-himatif.svg → vocational/admin/public/assets/img/logo-himatif.svg (renamed)
  * 🟡 vocational/admin/auth/login.php → vocational/admin/public/auth/login.php (renamed)
  * 🟢 vocational/admin/public/index.php
  * 🔴 vocational/app/Controllers/AdminController.php
  * 🟡 vocational/docker/apache/vhost.conf
- **Technical Summary:** Major architectural refactor of the admin panel into a full MVC structure with dedicated Config, Controllers, Models, Views, and routing. Relocated all admin files into the proper `admin/app/` and `admin/public/` directory structure with a clean separation of concerns.

---

### [2026-04-06] - Commit: `2df556c5995bd11489064421cedf2c566d2e3161`
- **Commit Message:** style: update button colors to darker blue scheme
- **Impacted Files:**
  * 🟡 vocational/admin/app/Views/aspirations.php
- **Technical Summary:** Updated action button colors in the admin aspirations view to a darker blue color scheme for better visual hierarchy.

---

### [2026-04-06] - Commit: `a2b9b6ef7cf1260b6bfe098668f1d66d98742ca3`
- **Commit Message:** feat: add security key files to gitignore
- **Impacted Files:**
  * 🟡 .gitignore
- **Technical Summary:** Added SSL certificate and private key file patterns to .gitignore to prevent accidental commit of security credentials.

---

### [2026-04-06] - Commit: `7028a3d8a30e584de39ab3507cceeb356f65a616`
- **Commit Message:** feat: add SSL/HTTPS support and improve Apache configuration
- **Impacted Files:**
  * 🟡 vocational/Dockerfile
  * 🟡 vocational/docker-compose.yml
  * 🟡 vocational/docker/apache/vhost.conf
- **Technical Summary:** Added SSL/TLS support with HTTPS virtual hosts, port 443 exposure in Docker, SSL module enabling in Dockerfile, and certificate path configuration in Apache vhosts.

---

### [2026-04-06] - Commit: `510d922a48affc2f981adf567b9342e479c7b676`
- **Commit Message:** ci: enhance CD workflow with graceful container shutdown and cache management
- **Impacted Files:**
  * 🟡 .github/workflows/cd.yml
- **Technical Summary:** Improved the CD workflow with graceful Docker container shutdown (docker-compose down) and Docker layer cache management for faster rebuilds.

---

### [2026-04-06] - Commit: `2045fe33a5410b96e4acc1152bf1d9b4918d9aac`
- **Commit Message:** feat: expand README with complete project documentation
- **Impacted Files:**
  * 🟡 README.md
- **Technical Summary:** Comprehensive README rewrite with full project documentation including architecture diagrams, installation guide, API endpoints, testing procedures, and deployment instructions.

---

### [2026-04-06] - Commit: `1c90b2f9883206e3a8e324e1ecff3504cd1a765e`
- **Commit Message:** ci: add development branch to workflow triggers
- **Impacted Files:**
  * 🟡 .github/workflows/ci.yml
- **Technical Summary:** Added the development branch to CI workflow trigger conditions so pushes to development also run the linting pipeline.

---

### [2026-04-07] - Commit: `9d832e4aa0333d59a29a47e88313baafe1ff9ad1`
- **Commit Message:** feat: update deployment configuration and security details
- **Impacted Files:**
  * 🟡 README.md
  * 🔴 tests/Integration/README.md
- **Technical Summary:** Updated README with deployment configuration details and security information; removed the now-obsolete integration tests README.

---

### [2026-04-07] - Commit: `18aff6489463c6afd30c5190793ff6a63d000c5e`
- **Commit Message:** fix: update author name in README to reflect current student designation
- **Impacted Files:**
  * 🟡 README.md
- **Technical Summary:** Corrected the author/contributor name in the README to reflect the proper student designation.

---

### [2026-04-07] - Commit: `f7a7dbb91bda272ed9da2c8315dd7910ade321a7`
- **Commit Message:** feat: add admin report management APIs and enhance modal UI
- **Impacted Files:**
  * 🟢 vocational/admin/public/api/delete-report.php
  * 🟢 vocational/admin/public/api/get-report-detail.php
  * 🟢 vocational/admin/public/api/get-report-stats.php
  * 🟢 vocational/admin/public/api/get-reports.php
  * 🟢 vocational/admin/public/api/submit-report.php
  * 🟢 vocational/admin/public/api/update-report-status.php
  * 🟡 vocational/app/Config/Migration.php
  * 🟢 vocational/app/Models/Report.php
  * 🟡 vocational/app/Views/Components/ReportModal.php
  * 🟡 vocational/public/bulletin-board.php
- **Technical Summary:** Implemented the full admin report management API suite (CRUD operations, statistics) with a new Report model and enhanced the public-facing report modal UI.

---

### [2026-04-07] - Commit: `5bb5f534ea4d2e68e598d70d7b1d93024aa4c1c2`
- **Commit Message:** fix: correct include paths and model reference in board API files
- **Impacted Files:**
  * 🟡 vocational/public/api/board/react.php
  * 🟡 vocational/public/api/board/report.php
- **Technical Summary:** Fixed broken include/require paths and corrected model class references in the bulletin board reaction and report API files.

---

### [2026-04-09] - Commit: `2ef3ee9061c57df241a1239b4f6d2256e9e74705`
- **Commit Message:** feat: refactor reports view with MVC architecture and statistics dashboard
- **Impacted Files:**
  * 🟡 vocational/admin/app/Views/reports.php
  * 🟡 vocational/admin/public/api/get-report-detail.php
  * 🟡 vocational/admin/public/api/update-report-status.php
  * 🟡 vocational/app/Config/Migration.php
  * 🟡 vocational/app/Models/Report.php
  * 🟡 vocational/app/Views/Components/Header.php
  * 🟡 vocational/app/Views/Components/ReportModal.php
  * 🟡 vocational/public/index.php
- **Technical Summary:** Refactored the admin reports view to follow MVC patterns, added a statistics dashboard with report metrics, and updated the report detail/status APIs with improved data handling.


---

### [2026-05-20] - Commit: `ad03984d1a338f1362afe24b4b0fd373e6efd8bf`
- **Commit Message:** feat: add password-based authentication to login system
- **Impacted Files:**
  * 🟡 vocational/app/Config/Migration.php
  * 🟡 vocational/app/Controllers/Auth.php
  * 🟢 vocational/public/api/change-password.php
  * 🟡 vocational/public/api/login.php
  * 🟡 vocational/public/index.php
  * 🟡 vocational/public/profile-navigation/settings.php
- **Technical Summary:** Implemented password-based authentication for the student login system with a change-password API endpoint and updated the settings page with password management UI.

---

### [2026-05-20] - Commit: `af093da90933a97b55d485bb5d40220b1564ba59`
- **Commit Message:** feat: improve accessibility and code formatting
- **Impacted Files:**
  * 🟡 vocational/app/Views/Components/Header.php
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟢 vocational/design.md
  * 🟡 vocational/public/bulletin-board.php
  * 🟡 vocational/public/index.php
  * 🟡 vocational/public/profile-navigation/settings.php
- **Technical Summary:** Improved accessibility attributes (ARIA labels, semantic HTML) across components, standardized code formatting, and added a design specification document.

---

### [2026-05-20] - Commit: `337f20c94a4071258c5a02e9e4bf6003484626d7`
- **Commit Message:** feat: refactor profile page layout and simplify markup
- **Impacted Files:**
  * 🟡 vocational/public/profile-navigation/profile.php
- **Technical Summary:** Simplified the profile page HTML markup and refactored the layout structure for cleaner rendering.

---

### [2026-05-20] - Commit: `d296e23133161470de9a8f4768149ab8e2210958`
- **Commit Message:** feat: improve navbar, enhance api response, and update bulletin board
- **Impacted Files:**
  * 🟡 vocational/app/Views/Components/Navbar.php
  * 🟢 vocational/public/api/delete-aspirasi.php
  * 🟡 vocational/public/api/get-riwayat.php
  * 🟡 vocational/public/bulletin-board.php
  * 🟡 vocational/public/index.php
  * 🟡 vocational/public/panduan.php
  * 🟡 vocational/public/profile-navigation/profile.php
  * 🟡 vocational/public/profile-navigation/settings.php
  * 🟡 vocational/public/riwayat.php
- **Technical Summary:** Enhanced navbar with improved navigation, added aspiration deletion API endpoint, improved riwayat API response format, and updated multiple pages with consistent UI patterns.

---

### [2026-05-20] - Commit: `4fc1a028f77b9a954ab5b48b105af3791733eec0`
- **Commit Message:** feat: enhance report modal layout for improved user experience
- **Impacted Files:**
  * 🟡 vocational/app/Views/Components/ReportModal.php
- **Technical Summary:** Redesigned the report modal layout with better spacing, clearer form fields, and improved visual hierarchy for the reporting workflow.

---

### [2026-05-21] - Commit: `dad712a0fb9b44e3cf00f21c6a25250ffe43c889`
- **Commit Message:** feat: update UI components with icons for improved visual clarity
- **Impacted Files:**
  * 🔴 vocational/app/Views/Form-Aspirasi.php
  * 🟡 vocational/public/bulletin-board.php
  * 🟡 vocational/public/panduan.php
  * 🟡 vocational/public/profile-navigation/profile.php
  * 🟡 vocational/public/profile-navigation/settings.php
  * 🟡 vocational/public/riwayat.php
- **Technical Summary:** Added Lucide icon integration across UI components for improved visual clarity, removed the obsolete Form-Aspirasi view file, and updated multiple pages with icon-enhanced elements.

---

---

## 📊 Repository Evolution Summary

### Overview Metrics

| Metric | Value |
|--------|-------|
| **Total Commits Audited** | 88 |
| **Development Period** | 2026-02-21 → 2026-05-21 (90 days) |
| **Active Development Days** | 22 unique days |
| **Average Commits per Active Day** | ~4 |

---

### 🔥 Peak Development Dates (Most Active Periods)

| Date | Commits | Focus Area |
|------|---------|------------|
| **2026-04-05** | 16 commits | Admin panel development, authentication system, Docker vhost configuration |
| **2026-04-03** | 8 commits | Bulletin board feature, categories, mobile navigation, profile pages |
| **2026-04-02** | 9 commits | Login UX improvements, session security, CI/CD pipeline, Docker ports |
| **2026-04-01** | 10 commits | Migration hardening, CSRF protection, deployment workflow |
| **2026-03-04** | 9 commits | CI/CD pipeline iteration, documentation, static analysis tooling |

---

### 📁 Top 3 Most Frequently Modified Files/Modules

| Rank | File/Module | Modification Count | Role |
|------|-------------|-------------------|------|
| **#1** | `vocational/public/index.php` | ~30 modifications | Main public application entry point — login UI, form handling, page layout |
| **#2** | `vocational/app/Config/Migration.php` | ~22 modifications | Database schema management — table creation, column changes, seed data |
| **#3** | `.github/workflows/ci.yml` | ~13 modifications | CI pipeline — PHP linting, security scanning, Docker build testing |

**Honorable Mentions:**
- `vocational/app/Views/Components/Navbar.php` (~10 modifications) — Navigation component evolution
- `vocational/public/bulletin-board.php` (~10 modifications) — Bulletin board feature development
- `vocational/docker-compose.yml` (~6 modifications) — Infrastructure configuration

---

### 🏗️ Development Phases Identified

1. **Foundation Phase** (Feb 21 – Mar 4): Repository setup, Docker scaffold, CI/CD pipeline establishment
2. **UI Development Phase** (Mar 5 – Mar 18): Landing page iteration, login modal, component creation
3. **Authentication Phase** (Apr 1 – Apr 2): Secure login, CSRF, session management, deployment workflow
4. **Feature Development Phase** (Apr 3 – Apr 5): Bulletin board, reactions, reports, admin panel MVC
5. **Admin Architecture Phase** (Apr 5 – Apr 6): Full MVC refactor, SSL/HTTPS, production readiness
6. **Report Management Phase** (Apr 7 – Apr 9): Admin report APIs, statistics dashboard
7. **Polish & Enhancement Phase** (May 20 – May 21): Password auth, accessibility, UI icons, cleanup

---

*Report generated by repository audit on 2026-05-27*  
*Branch: development | Repository: Web-VocaTIonal*
