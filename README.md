# 🎬 Online Cinema Booking

An online movie ticket booking system built with **PHP** and **MySQL** that allows users to browse movies, select seats, book tickets, and manage their bookings, while providing powerful tools for admins and theatres to manage operations.

---

## 🔧 Features

### 👤 User Features
- User Registration & Login
- Browse & Search Movies
- Seat Selection
- Booking & Payment Processing
- Manage Bookings
- Profile Settings

### 🛠️ Admin Features
- Movie & Showtime Management
- Booking Overview
- User Management
- Revenue Reports
- Admin Dashboard (Powered by AdminLTE)

### 🎭 Theatre Features
- Theatre Profile Management
- Screen & Seat Layout Management
- Show Scheduling

---

## 💻 Technologies Used

- **Frontend:** HTML, CSS, JavaScript, Bootstrap  
- **Backend:** PHP  
- **Database:** MySQL/MariaDB  
- **Template:** AdminLTE (for admin dashboard)

---

## 📋 System Requirements

- PHP (>= 7.0)
- MySQL or MariaDB
- Web Server (e.g., Apache with XAMPP/LAMP)
- Modern Web Browser

---

## 🚀 Installation Guide

1. **Clone the Repository**

```bash
git clone https://github.com/ANAS-AAMMARI/cinema-booking.git
```

2. **Set Up the Database**

- Create a new MySQL database named `db_movie`.
- Import the SQL file from the `database/` directory into the `db_movie` database using phpMyAdmin or MySQL CLI.

3. **Configure Database Connection**

Update `config.php` with your database credentials:

```php
<?php
    $host = "127.0.0.1";
    $user = "your_db_username";   // Replace with your DB username
    $pass = "";                   // Replace with your DB password if set
    $db   = "db_movie";
    $port = 3306;

   existing code ...
?>
```

4. **Run the Application**

- Launch a local web server (XAMPP, WAMP, LAMP).
- Place this project in the htdocs file inside XAMPP
- Access the app via: `http://localhost/cinema-booking/`

---

## 📚 Usage Guide

### 🎟️ For Users

1. Register or log in using your credentials.
2. Browse available movies.
3. Select a movie, show date, and time.
4. Choose available seats.
5. Proceed with payment.
6. Receive booking confirmation.

### 🔐 For Admins

1. Log in via the Admin Panel.
2. Manage movies, shows, bookings, and users.
3. Generate revenue and booking reports.

### 🎭 For Theatre Managers

1. Manage theatre profiles.
2. Set up screens and seat layouts.
3. Schedule shows for different movies.

---

## 📬 Feedback & Contributions

Feel free to submit issues or pull requests to contribute to the project.

**GitHub Repo:** [cinema-booking](https://github.com/ANAS-AAMMARI/cinema-booking)
