# EventBook – Event Booking & Management Platform

> A full-stack web application that enables users to discover events, book tickets, and manage reservations through a secure and user-friendly interface.

## 📖 Overview

EventBook is a modern Event Booking and Management Platform designed to simplify the process of event discovery, registration, and ticket booking for both event organizers and attendees.

The platform allows users to browse upcoming events, view detailed event information, book tickets, and manage their reservations through a personalized dashboard. Administrators can efficiently manage events, users, and bookings through a centralized admin panel.

The application is built using **PHP, MySQL, HTML, CSS, JavaScript, AJAX, and Bootstrap 5**, ensuring a responsive, secure, and seamless user experience across all devices.

Developed and tested using **Laragon** as the local development environment and deployed using **cPanel Hosting**.

---

## ✨ Key Features

### 👤 User Authentication

* User Registration and Login
* Secure Password Hashing
* Session Management
* Logout Functionality

### 🎫 Event Management

* Dynamic Event Listings
* Event Details Page
* Event Categorization
* Upcoming Events Showcase

### 📅 Booking System

* Online Ticket Booking
* Booking Confirmation
* Booking Status Tracking
* Booking History Management

### 🛠️ Admin Panel

* Event Management
* User Management
* Booking Administration
* Dashboard Overview

### 📩 Contact & Support

* Contact Form Integration
* User Feedback Management

### 🔒 Security Features

* Prepared Statements for SQL Injection Prevention
* XSS Protection using `htmlspecialchars()`
* Input Validation and Sanitization
* Secure Session Handling

### 📱 Responsive Design

* Mobile-Friendly Interface
* Bootstrap 5 Based UI
* Cross-Browser Compatibility

---

## 🛠️ Tech Stack

| Category                | Technologies                               |
| ----------------------- | ------------------------------------------ |
| Frontend                | HTML5, CSS3, Bootstrap 5, JavaScript, AJAX |
| Backend                 | PHP                                        |
| Database                | MySQL                                      |
| Icons                   | Bootstrap Icons                            |
| Development Environment | Laragon                                    |
| Deployment              | cPanel Hosting                             |
| Version Control         | Git & GitHub                               |

---

## 📂 Project Structure

```text
EventBook/
│
├── admin/
│   ├── dashboard.php
│   ├── manage-events.php
│   ├── manage-users.php
│   └── manage-bookings.php
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
│
├── includes/
│   ├── db.php
│   ├── header.php
│   ├── footer.php
│   ├── auth.php
│   └── functions.php
│
├── database/
│   └── eventbook.sql
│
├── index.php
├── about.php
├── events.php
├── contact.php
├── login.php
├── register.php
├── logout.php
├── booking.php
└── README.md
```

---

## 🚀 Installation & Setup

1. Clone the repository:

```bash
git clone https://github.com/your-username/eventbook.git
```

2. Navigate to the project directory:

```bash
cd eventbook
```

3. Import the `eventbook.sql` file into MySQL.

4. Update database credentials in `includes/db.php`.

5. Start Apache and MySQL using Laragon or XAMPP.

6. Open your browser and visit:

```text
http://localhost/eventbook
```

---

## 🎯 Project Objective

The objective of EventBook is to provide a centralized and user-friendly platform for event discovery, registration, and booking while ensuring secure user authentication, efficient event management, and an enhanced user experience through a modern and responsive interface.

---

## 🔮 Future Enhancements

* Payment Gateway Integration
* Email Notifications
* QR Code Ticket Verification
* Event Search and Advanced Filters
* AI-Powered Chatbot
* Multi-Role Access Control
* Analytics Dashboard

---

## 🙏 Acknowledgements

Special thanks to  **Travarsa Private Limited** for their guidance, mentorship, and continuous support throughout the development of this project.

---

## 👩‍💻 Author

**Sneha Naskar**

Web Developer Associate

---

## 📄 License

This project is developed for educational, learning, and portfolio purposes.
