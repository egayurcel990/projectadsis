# *Final Project — System Administration Course*

### Web Service Management with Docker Containers

> **Final Project — System Administration**
> A multi-container web application that demonstrates web service management using Docker and Docker Compose. Two isolated Laravel services share a single MySQL database, simulating a real-world multi-tier web hosting environment.

---

## Table of Contents

- [Overview](#overview)
- [System Design](#system-design)
- [Architecture](#architecture)
- [Project Structure](#project-structure)
- [Tech Stack](#tech-stack)
- [Database Schema](#database-schema)
- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
- [Services & Ports](#services--ports)
- [Environment Variables](#environment-variables)
- [Usage](#usage)

---

## Overview

This project implements a **Student Attendance and Leave Request Management System** deployed across two containerized Laravel web applications. The system is split into two roles:

- **Website A** — Admin/Lecturer portal for managing student data and reviewing submissions
- **Website B** — Student portal for submitting attendance and leave requests

Both services run in isolated Docker containers but share a single MySQL 8 database, demonstrating how independent web services can be orchestrated and managed efficiently using Docker Compose.

---

## System Design

The application is intentionally split into two separate web services to simulate a **multi-tenant service architecture** — a core concept in system administration.

| Role | Application | Description |
|------|-------------|-------------|
| Admin / Lecturer | Website A (Port 8001) | Manage students, view & filter attendance, approve or reject leave requests |
| Student | Website B (Port 8002) | Submit attendance, apply for leave, check personal history |

### Website A — Admin Panel Features
- **Student Management** — Add, edit, and delete student records (name & NIM)
- **Attendance Monitor** — View all attendance records, filter by date
- **Leave Request Management** — View all leave submissions, approve or reject with status update

### Website B — Student Portal Features
- **Attendance Submission** — Submit daily attendance using NIM (Present / Late / Absent + notes)
- **Leave Application** — Submit leave requests with start date, end date, and reason
- **History** — Look up personal attendance or leave history by NIM

---

## Architecture

```
┌──────────────────────────────────────────────────────┐
│                     Docker Host                      │
│                                                      │
│  ┌─────────────────────┐  ┌─────────────────────┐   │
│  │     website-a       │  │     website-b       │   │
│  │   (Admin Panel)     │  │  (Student Portal)   │   │
│  │   Laravel + PHP     │  │   Laravel + PHP     │   │
│  │     Port 8001       │  │     Port 8002       │   │
│  └──────────┬──────────┘  └──────────┬──────────┘   │
│             │                        │              │
│             └────────────┬───────────┘              │
│                          │                          │
│                ┌─────────▼─────────┐                │
│                │     MySQL 8       │                │
│                │  (projekadsis)    │                │
│                │    Port 3307      │                │
│                └───────────────────┘                │
└──────────────────────────────────────────────────────┘
```

Both web services connect to the same MySQL container through Docker's internal network. The database is not exposed to the public internet — only mapped to port `3307` on localhost for local development.

---

## Project Structure

```
projectadsis/
├── docker-compose.yml                   # Orchestrates all three services
│
├── website-a/                           # Admin Panel (Port 8001)
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── EmployeeController.php   # CRUD for student records
│   │   │   ├── AttendanceController.php # View & filter attendance
│   │   │   └── LeaveRequestController.php # Approve/reject leave
│   │   └── Models/
│   │       ├── Employee.php
│   │       ├── Attendance.php
│   │       └── LeaveRequest.php
│   ├── database/migrations/             # employees, attendances, leave_requests tables
│   ├── resources/views/
│   │   ├── employees/                   # index, create, edit
│   │   ├── attendances/                 # index with date filter
│   │   └── leave_requests/             # index with approve/reject
│   ├── routes/web.php
│   └── Dockerfile
│
└── website-b/                           # Student Portal (Port 8002)
    ├── app/
    │   ├── Http/Controllers/
    │   │   ├── AttendanceController.php # Submit & view attendance history
    │   │   └── LeaveRequestController.php # Submit & view leave history
    │   └── Models/
    │       ├── Employee.php
    │       ├── Attendance.php
    │       └── LeaveRequest.php
    ├── resources/views/
    │   ├── attendance/                  # form, history
    │   └── leave/                       # form, history
    ├── routes/web.php
    └── Dockerfile
```

---

## Tech Stack

| Component        | Technology              |
|------------------|-------------------------|
| Web Framework    | Laravel (PHP)           |
| Templating       | Blade + Bootstrap 5     |
| Database         | MySQL 8                 |
| Asset Bundler    | Vite                    |
| Containerization | Docker & Docker Compose |
| PHP Deps Manager | Composer                |

---

## Database Schema

All three tables are created via Laravel migrations and shared between both web services through the same MySQL container.

```
employees
├── id (PK)
├── name        (string, 100)
├── nim         (string, 20, unique)
└── timestamps

attendances
├── id (PK)
├── employee_id (FK → employees)
├── date        (date)
├── status      (enum: present | late | absent)
├── notes       (text, nullable)
└── timestamps

leave_requests
├── id (PK)
├── employee_id (FK → employees)
├── start_date  (date)
├── end_date    (date)
├── reason      (text)
├── status      (enum: pending | approved | rejected, default: pending)
└── timestamps
```

---

## Prerequisites

Make sure the following are installed on your machine:

- [Docker](https://docs.docker.com/get-docker/) (v20+)
- [Docker Compose](https://docs.docker.com/compose/install/) (v2+)
- Git

---

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/egayurcel990/projectadsis.git
cd projectadsis
```

### 2. Build and run all containers

```bash
docker compose up -d --build
```

### 3. Verify all containers are running

```bash
docker compose ps
```

You should see three running containers: `website_a`, `website_b`, and `mysql_projek`.

### 4. Run database migrations

```bash
# Run migrations on website-a (creates all tables)
docker exec -it website_a php artisan migrate
```

> **Note:** Since both services share the same database (`projekadsis`), running migrations on website-a is sufficient.

### 5. Access the applications

| Role    | URL                    | Description                        |
|---------|------------------------|------------------------------------|
| Admin   | http://localhost:8001  | Manage students, view submissions  |
| Student | http://localhost:8002  | Submit attendance & leave requests |

### 6. Typical workflow

1. Open **Website A** (admin) → add at least one student with their NIM
2. Open **Website B** (student) → submit attendance using that NIM
3. Open **Website A** → view the attendance record or approve/reject a leave request

---

## Services & Ports

| Container       | Internal Port | Host Port | Description              |
|-----------------|---------------|-----------|--------------------------|
| `website_a`     | 80            | 8001      | Laravel Admin Panel      |
| `website_b`     | 80            | 8002      | Laravel Student Portal   |
| `mysql_projek`  | 3306          | 3307      | Shared MySQL 8 database  |

---

## Environment Variables

Both web services receive the following environment variables via `docker-compose.yml`:

| Variable      | Value         | Description              |
|---------------|---------------|--------------------------|
| `DB_HOST`     | `mysql`       | MySQL container hostname |
| `DB_DATABASE` | `projekadsis` | Database name            |
| `DB_USERNAME` | `root`        | Database username        |
| `DB_PASSWORD` | `root`        | Database password        |

---

## Usage

### Stop all services

```bash
docker compose down
```

### Stop and remove volumes (full reset)

```bash
docker compose down -v
```

### View logs

```bash
# All services
docker compose logs -f

# Specific service
docker compose logs -f website-a
```

### Restart a specific service

```bash
docker compose restart website-a
```

### Access container shell

```bash
docker exec -it website_a bash
docker exec -it website_b bash
docker exec -it mysql_projek mysql -u root -p
```

---

**Ega Yurcel Satriaji - 235150700111031** — [@egayurcel990](https://github.com/egayurcel990)
