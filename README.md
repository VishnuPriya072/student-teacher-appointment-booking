Student-Teacher Appointment Booking System
This project is a full-stack web application for managing student-teacher appointments. 
The system allows students to book appointments with their teachers, view available time slots, and handle user authentication (registration and login).
The project was developed as part of the mentorship program provided by Unified Mentor.

Table of Contents

Features

Technologies Used

Setup Instructions

Database Schema

Usage

Screenshots

License

Features

User Registration:

Students can register as new users.

User Login:

Students can log in using their credentials.

Appointment Booking: 

Students can book appointments with teachers.

View Booked Slots: 

Users can view all booked appointments.

Check for Availability: 

The system warns students if a teacher is already booked for the selected time slot.
Logout Functionality: Users can log out securely.

Technologies Used

Frontend:

HTML5
CSS3
JavaScript (optional for enhancements)

Backend:

PHP
MySQL

Tools:

Apache (XAMPP or similar)

Git for version control

Setup Instructions

To set up the project on your local machine, follow these steps:

1. Clone the Repository
bash

git clone https://github.com/VishnuPriya072/student-teacher-appointment-booking.git

2. Install XAMPP (or MAMP for macOS users)
Make sure to have a web server like XAMPP (for Windows/Linux) or MAMP (for macOS) installed.

3. Database Setup

Open phpMyAdmin (usually accessible at http://localhost/phpmyadmin/).
Create a new database called appointment_system.
Run the following SQL queries in phpMyAdmin or MySQL CLI to create the necessary tables:sql

CREATE DATABASE appointment_system;

USE appointment_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    teacher_name VARCHAR(255) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_name VARCHAR(255) NOT NULL
);

-- Sample data for teachers
INSERT INTO teachers (teacher_name) 
VALUES ('Mr. John'), ('Ms. Emily'), ('Dr. Smith'), ('Prof. Andrew');

4. Configure the Project

Place the project folder inside your web server directory (e.g., htdocs in XAMPP or Sites in MAMP).
Edit the database connection in login.php, register.php, and appointment.php as necessary. Example:php

$servername = "localhost";

$username = "root";
// Default username for XAMPP/MAMP

$password = ""; 
// Default password for XAMPP/MAMP (often blank)

$dbname = "appointment_system";

5. Start the Server

Open XAMPP/MAMP and start Apache and MySQL servers.
Access the project via http://localhost/student-teacher-appointment/register.php to begin registration.
Database Schema

Users Table:

id: Primary Key, Auto Increment
username: Stores the student's username (unique)
password: Hashed password of the user

Appointments Table:

id: Primary Key, Auto Increment
student_name: Name of the student booking the appointment
teacher_name: Name of the teacher
appointment_date: Date of the appointment
appointment_time: Time of the appointment
created_at: Timestamp when the appointment was created

Teachers Table:

id: Primary Key, Auto Increment
teacher_name: Name of the teacher available for appointments
Usage
Registration:

New students can register by providing a unique username and password.

Login: 

Existing users can log in using their credentials.

Book Appointment:

After login, students can select a teacher, choose an available date and time, and book an appointment.
View Booked Appointments: Students can view their booked appointments along with other students’ bookings.

Check for Availability: 

If a teacher is already booked for a selected time slot, a warning message will be displayed.

Screenshots

Login Page


Appointment Booking Page

License

This project is licensed under the MIT License. See the LICENSE file for details.
