# CRM Laravel React Case

This repository is a case study showcasing a CRM system with a **Laravel backend** and a **React frontend (powered by ViteJS)**. Follow the instructions below to set up the project locally.

---

## Features
- Backend: Laravel 11.x
- Frontend: React with ViteJS
- CRUD operations for managing CRM data
- Sample data seeding and daily report generation functionality

---

## Prerequisites

Make sure you have the following installed:

- **PHP** (>=8.2)
- **Composer** (latest version)
- **Node.js** (>=16.x)
- **npm** or **yarn**
- **MySQL** or another supported database

---

## Installation Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/oktayla/crm-laravel-react-case.git
cd crm-laravel-react-case
```

### 2. Backend Setup (Laravel)

1. Navigate to the `backend` folder:

    ```bash
    cd backend
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Create a `.env` file:

    ```bash
    cp .env.example .env
    ```

4. Update the `.env` file with your database credentials.

5. Generate an application key:

    ```bash
    php artisan key:generate
    ```

6. Run database migrations:

    ```bash
    php artisan migrate
    ```

7. Seed the database with sample data:

    ```bash
    php artisan db:seed
    ```

8. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

### 3. Frontend Setup (React)

1. Navigate to the `client` folder:

    ```bash
    cd ../client
    ```

2. Install dependencies:

    ```bash
    npm install
    # OR
    yarn install
    ```

3. Start the development server:

    ```bash
    npm run dev
    # OR
    yarn dev
    ```

4. Open the React frontend in your browser. By default, it runs on `http://localhost:5173/`.

---

## Additional Backend Commands

### Generate Daily Report
To generate the daily report:

```bash
php artisan app:generate-daily-report
```

---

## Folder Structure

```
crm-laravel-react-case/
├── backend/     # Laravel backend project
├── client/      # React frontend project (ViteJS)
```

---

## License
This project is licensed under the MIT License.
