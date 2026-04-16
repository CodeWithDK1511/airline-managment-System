# airline-managment-System
A role-based Airline Management System built with PHP and MySQL including booking system and admin dashboard.
# ✈ Airline Management System (PHP + MySQL)

## 📌 Overview

The Airline Management System is a web-based application developed using **PHP, MySQL, HTML, CSS, and Bootstrap**. It allows efficient management of airline operations including airports, flights, crew assignments, passengers, and ticket bookings.

This project implements a **role-based access system** with separate functionalities for Admin and User.

---

## 🚀 Features

### 👨‍💼 Admin

* Manage Airports (Add/View)
* Manage Flights (linked with planes)
* Manage Crew and Assign Crew to Flights
* Manage Planes
* Manage Users
* View Dashboard (Users, Flights, Bookings statistics)

### 👤 User

* Add and View Passengers
* Book Tickets
* View Personal Bookings

---

## 🔐 Role-Based Access Control

* Admin has full access to system modules
* User has restricted access
* Unauthorized access is blocked using session validation

---

## 🎟 Booking System

* Users can book tickets by selecting:

  * Passenger
  * Flight
* Each user can view only their bookings

---

## 🗄 Database Structure

Main tables:

* users
* airport
* flight
* crew
* plane
* crew_assignment
* passenger
* booking

---

## 🎨 UI Features

* Responsive design using Bootstrap
* Modern navigation bar
* Clean form layouts
* User-friendly interface

---

## ⚙️ Technologies Used

* PHP (Backend)
* MySQL (Database)
* HTML/CSS
* Bootstrap 5

---

## 🛠 Setup Instructions

### 1. Clone Repository

```bash
git clone https://github.com/your-username/airline-management-system.git
```

### 2. Move Project

Place the folder inside:

```
C:\xampp\htdocs\
```

### 3. Start Server

* Open XAMPP
* Start Apache and MySQL

### 4. Import Database

* Open phpMyAdmin
* Create database: `airline_db`
* Import `airline.sql`

### 5. Run Project

```
http://localhost/airlineManagmentSystem2/
```

---

## 🔑 Default Credentials

Admin:

* Username: admin
* Password: 123

User:

* Username: user1
* Password: 123

---

## 📈 Future Enhancements

* Secure password hashing
* Ticket PDF generation
* Email notifications
* Advanced dashboard with charts
* Search and filtering system

---

## 📌 Author

Divyanshu

---
