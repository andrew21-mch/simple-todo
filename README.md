
# Task Manager

A simple task manager application built with Laravel for the backend and Vue.js for the frontend. This project is structured with two separate folders: `backend` for the Laravel API and `frontend` for the Vue.js frontend.

## Table of Contents

- [Project Overview](#project-overview)
- [Requirements](#requirements)
- [Setup Instructions](#setup-instructions)
  - [Backend (Laravel)](#backend-laravel)
  - [Frontend (Vue.js)](#frontend-vuejs)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Project Overview

This project is a task management system with basic features like creating, viewing, and updating tasks. The backend is built with Laravel, providing API endpoints, while the frontend is a Vue.js app that interacts with the backend.

## Requirements

### Backend (Laravel)
- PHP >= 8.1
- Composer
- MySQL or another supported database
- Laravel 11

### Frontend (Vue.js)
- Node.js >= 16.0
- npm or yarn
- Vue.js 3.x
- Tailwind CSS
- Font Awesome (for icons)

## Setup Instructions

### Backend (Laravel)

1. **Clone the repository**:  
   If you haven't already, clone the repository to your local machine:
   ```bash
   git clone https://github.com/andrew21-mch/simple-todo
   cd task-manager
   ```

2. **Navigate to the backend directory**:  
   ```bash
   cd backend
   ```

3. **Install dependencies**:  
   Install the required PHP dependencies using Composer:
   ```bash
   composer install
   ```

4. **Create the `.env` file**:  
   Copy the `.env.example` file to `.env` and configure your database settings and other environment variables:
   ```bash
   cp .env.example .env
   ```

5. **Generate the application key**:  
   Run the following Artisan command to generate the application key:
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**:  
   If you're using MySQL, run the migrations to set up the database:
   ```bash
   php artisan migrate
   ```

7. **Start the backend server**:  
   You can use the built-in PHP server to start the backend server:
   ```bash
   php artisan serve
   ```
8. **Rurn Backend test **
   You can run test using
   ```
   php artisan test
   ```

### Frontend (Vue.js)

1. **Navigate to the frontend directory**:  
   ```bash
   cd ../frontend
   ```

2. **Install dependencies**:  
   Run the following command to install the required dependencies for Vue.js:
   ```bash
   npm install
   ```

3. **Run the frontend server**:  
   Start the Vue.js development server:
   ```bash
   npm run dev
   ```

4. **Open the app**:  
   After the development server starts, you can view the app in your browser by visiting `http://localhost:5173`.

## Usage

Once both servers are running, you can use the Task Manager application in your browser. The frontend interacts with the backend API to perform CRUD operations on tasks.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any changes or improvements.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
