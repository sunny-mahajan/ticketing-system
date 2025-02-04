# Laravel + Vue.js + MongoDB Dockerized Setup

This repository provides a full-stack application setup using **Laravel (PHP Backend)**, **Vue.js (Frontend)**, and **MongoDB** as the database. The application is fully containerized using **Docker Compose**.

---

## 🚀 Quick Start Guide

### 📌 Prerequisites

Ensure you have the following installed on your system:

- **Docker** (Latest version recommended)
- **Docker Compose** (If using an older version of Docker)
- **Git** (For cloning the repository)

---

## 📂 Project Structure

```
/project-root
│── /backend           # Laravel API
│── /frontend          # Vue.js frontend
│── /docker-compose.yml  # Docker Compose configuration
│── /README.md         # This file
```

---

## 🏗️ Setting Up the Project

### 1️⃣ Clone the Repository
```sh
git clone https://github.com/your-repo-name.git
cd your-repo-name
```

### 2️⃣ Start Docker Containers
Run the following command in the project root:
```sh
docker-compose up --build -d
```
This will:

- Build and start the **Laravel API (backend)**
- Build and start the **Vue.js application (frontend)**
- Set up **MongoDB** as the database

---

## 🖥️ Accessing the Application

| Service   | URL                      |
|-----------|--------------------------|
| Backend (Laravel) | http://localhost:8000 |
| Frontend (Vue.js) | http://localhost:5173 |
| MongoDB (Database) | localhost:27017 |

---

## 🔌 API Endpoints (Laravel Backend)

The Laravel API is accessible at `http://localhost:8000/api`. Here are some sample endpoints:

### 📍 Example CRUD Endpoints
- **GET** `/api/tickets` - Fetch all tickets
- **POST** `/api/tickets` - Create a new ticket
- **GET** `/api/tickets/{id}` - Fetch a single ticket
- **PUT** `/api/tickets/{id}` - Update a ticket
- **DELETE** `/api/tickets/{id}` - Delete a ticket

---

## 🛠️ Development Workflow

### 🔄 Restart Containers
```sh
docker-compose restart
```

### 📜 View Logs
```sh
docker-compose logs -f
```

### ⏹️ Stop and Remove Containers
```sh
docker-compose down
```

---

## 🛠️ Managing Dependencies

### Backend (Laravel)
- To install a new PHP package, enter the container:
  ```sh
  docker exec -it laravel_backend bash
  ```
  Then run:
  ```sh
  composer require package-name
  ```

### Frontend (Vue.js)
- To install a new JavaScript package, enter the container:
  ```sh
  docker exec -it vue_frontend sh
  ```
  Then run:
  ```sh
  yarn add package-name
  ```


Happy Coding! 🚀