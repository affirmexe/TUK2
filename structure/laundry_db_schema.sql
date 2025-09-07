-- Create database
CREATE DATABASE laundry_db;
USE laundry_db;

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    address VARCHAR(255),
    email VARCHAR(255),
    no_telp INT,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create staffs table
CREATE TABLE staffs (
    staff_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    address VARCHAR(255),
    email VARCHAR(255),
    no_telp INT,
    password VARCHAR(255),
    role VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create admins table
CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    address VARCHAR(255),
    email VARCHAR(255),
    no_telp INT,
    password VARCHAR(255),
    role VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create transactions table
CREATE TABLE transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    staff_id INT,
    entry_date TIMESTAMP,
    status BOOLEAN,
    clothings_amount INT,
    clothings_detail VARCHAR(255),
    total_price INT,
    completion_date TIMESTAMP,
    pickup_date TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (staff_id) REFERENCES staffs(staff_id)
);
