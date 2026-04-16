-- =====================================================
-- AIRLINE MANAGEMENT SYSTEM - FULL DATABASE SCHEMA
-- Run this in phpMyAdmin or MySQL CLI
-- =====================================================

CREATE DATABASE IF NOT EXISTS airlinedatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE airlinedatabase;

-- ─────────────────────────────────────────────
-- USERS TABLE (Admin + Regular Users login)
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,          -- bcrypt hashed
    role        ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin account  (password: Admin@1234)
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@airline.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- NOTE: The hash above is for password "Admin@1234"
-- After importing, log in as admin and change the password immediately.

-- ─────────────────────────────────────────────
-- AIRPORTS
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS airports_table (
    airport_code VARCHAR(10)  PRIMARY KEY,
    Airport_name VARCHAR(100) NOT NULL,
    city         VARCHAR(50)  NOT NULL,
    country      VARCHAR(50)  NOT NULL
);

-- ─────────────────────────────────────────────
-- PLANES
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS planes_table (
    plane_id     INT PRIMARY KEY,
    model        VARCHAR(50)  NOT NULL,
    capacity     INT          NOT NULL,
    manufacturer VARCHAR(50)  NOT NULL
);

-- ─────────────────────────────────────────────
-- FLIGHTS
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS flights_table (
    flight_id      INT PRIMARY KEY,
    flight_number  VARCHAR(20)  NOT NULL,
    departure_time DATETIME     NOT NULL,
    arrival_time   DATETIME     NOT NULL,
    origin         VARCHAR(100) NOT NULL,
    destination    VARCHAR(100) NOT NULL,
    plain_id       INT,
    status         VARCHAR(20)  DEFAULT 'Scheduled',
    FOREIGN KEY (plain_id) REFERENCES planes_table(plane_id) ON DELETE SET NULL
);

-- ─────────────────────────────────────────────
-- CREW
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS cew_table (
    crew_id    INT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name  VARCHAR(50) NOT NULL,
    role       VARCHAR(50) NOT NULL,
    flight_id  INT,
    FOREIGN KEY (flight_id) REFERENCES flights_table(flight_id) ON DELETE SET NULL
);

-- ─────────────────────────────────────────────
-- CREW ASSIGNMENTS
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS crew_assignments (
    assignment_id INT PRIMARY KEY,
    flight_id     INT NOT NULL,
    crew_id       INT NOT NULL,
    FOREIGN KEY (flight_id) REFERENCES flights_table(flight_id) ON DELETE CASCADE,
    FOREIGN KEY (crew_id)   REFERENCES cew_table(crew_id)       ON DELETE CASCADE
);

-- ─────────────────────────────────────────────
-- PASSENGERS
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS passengers (
    passenger_id INT PRIMARY KEY,
    first_name   VARCHAR(50)  NOT NULL,
    last_name    VARCHAR(50)  NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    passport_no  VARCHAR(30)  NOT NULL UNIQUE,
    DateofBirth  DATE
);

-- ─────────────────────────────────────────────
-- BOOKINGS
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS bookings_table (
    booking_id     INT PRIMARY KEY,
    passenger_id   INT,
    flight_id      INT,
    booking_date   DATETIME DEFAULT CURRENT_TIMESTAMP,
    payement_id    INT DEFAULT NULL,
    seat_number    VARCHAR(10),
    booking_status VARCHAR(20) DEFAULT 'Booked',
    FOREIGN KEY (passenger_id) REFERENCES passengers(passenger_id)    ON DELETE SET NULL,
    FOREIGN KEY (flight_id)    REFERENCES flights_table(flight_id)     ON DELETE SET NULL
);

-- ─────────────────────────────────────────────
-- PAYMENTS
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS payments_table (
    payement_id    INT PRIMARY KEY,
    booking_id     INT NOT NULL,
    payment_date   DATETIME DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(50) NOT NULL,
    amount         DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings_table(booking_id) ON DELETE CASCADE
);

-- ─────────────────────────────────────────────
-- TICKETS
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS tickets (
    ticket_id     INT AUTO_INCREMENT PRIMARY KEY,
    booking_id    INT NOT NULL,
    ticket_number VARCHAR(30) NOT NULL UNIQUE,
    seat_class    ENUM('Economy','Business','First') NOT NULL DEFAULT 'Economy',
    seat_number   VARCHAR(10) NOT NULL,
    issued_date   DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings_table(booking_id) ON DELETE CASCADE
);
