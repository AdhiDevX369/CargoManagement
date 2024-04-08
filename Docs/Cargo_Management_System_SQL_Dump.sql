-- Initial Configurations
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

create database cargo_db;
use cargo_db;

-- Table for Access Levels
CREATE TABLE access_level (
    level_id INT AUTO_INCREMENT PRIMARY KEY,
    level ENUM('Admin', 'Agent', 'Warehouse Manager', 'Driver') NOT NULL
);

-- Table for Super User
CREATE TABLE super_user (
    super_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Gender
CREATE TABLE gender (
    gender_id INT AUTO_INCREMENT PRIMARY KEY,
    gender VARCHAR(50) NOT NULL
);

-- Table for System Status
CREATE TABLE system_status (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('Active', 'Inactive') NOT NULL
);

-- Table for Users WITHOUT foreign keys
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    tele VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    gender_id INT,
    level_id INT,
    passport VARCHAR(255)
);

-- Table for Warehouse
CREATE TABLE warehouse (
    warehouse_id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(255) NOT NULL
);

-- Table for Warehouse Drivers WITHOUT foreign keys
CREATE TABLE warehouse_driver (
    user_id INT,
    warehouse_id INT,
    level_id INT
);

-- Table for Box Type
CREATE TABLE box_type (
    box_type_id INT AUTO_INCREMENT PRIMARY KEY,
    box_type VARCHAR(255) NOT NULL
);

-- Table for Customer Data
CREATE TABLE customer_data (
    c_id INT AUTO_INCREMENT PRIMARY KEY,
    c_name VARCHAR(255) NOT NULL,
    c_address TEXT NOT NULL,
    c_tele VARCHAR(50) NOT NULL,
    passport VARCHAR(255) NOT NULL
);

-- Table for Receiver Method
CREATE TABLE r_method (
    method_id INT AUTO_INCREMENT PRIMARY KEY,
    method VARCHAR(255) NOT NULL
);

-- Table for Receiver Data WITHOUT foreign keys
CREATE TABLE reciver_data (
    c_id INT,
    r_id INT AUTO_INCREMENT PRIMARY KEY,
    r_name VARCHAR(255) NOT NULL,
    r_address TEXT NOT NULL,
    r_tele VARCHAR(50) NOT NULL,
    method_id INT
);

-- Table for Payment
CREATE TABLE payment (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    payment_method VARCHAR(255) NOT NULL
);

-- Table for Order Package Details WITHOUT foreign keys
CREATE TABLE order_package_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    package_id INT
);

-- Table for Order WITHOUT foreign keys
CREATE TABLE order_data (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    detail_id INT,
    c_id INT,
    r_id INT,
    status_id INT,
    order_date DATE NOT NULL,
    order_time TIME NOT NULL,
    customer_pay DECIMAL(10, 2),
    total_pay DECIMAL(10, 2),
    remarks TEXT
);

-- Table for Package
CREATE TABLE package (
    package_id INT AUTO_INCREMENT PRIMARY KEY,
    ewdlarge DECIMAL(10, 2),
    ewdxlarge DECIMAL(10, 2),
    ewd1m DECIMAL(10, 2),
    ewd15m DECIMAL(10, 2),
    ewd2m DECIMAL(10, 2),
    ewd25m DECIMAL(10, 2),
    ewd35m DECIMAL(10, 2),
    ecsmall DECIMAL(10, 2),
    ecmedium DECIMAL(10, 2),
    eclarge DECIMAL(10, 2),
    ecjumbo DECIMAL(10, 2),
    ecxl DECIMAL(10, 2),
    etsmall DECIMAL(10, 2),
    etmedium DECIMAL(10, 2),
    etlarge DECIMAL(10, 2),
    txl DECIMAL(10, 2),
    etxxl DECIMAL(10, 2)
);

-- Table for Status WITHOUT foreign keys
CREATE TABLE status (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    delivery_status ENUM('Pending', 'In Transit', 'Delivered'),
    pickup_status ENUM('Pending', 'Picked Up'),
    order_status ENUM('Pending', 'Completed', 'Cancelled')
);

-- Table for Container WITHOUT foreign keys
CREATE TABLE container (
    container_id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255),
    destination VARCHAR(255),
    warehouse_id INT,
    status ENUM('Pending', 'In Transit', 'Delivered'),
    location VARCHAR(255)
);

-- Table for Invoice WITHOUT foreign keys
CREATE TABLE invoice (
    invoice_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    c_id INT,
    r_id INT,
    container_id INT,
    charges_id INT
);

-- Table for Charges
CREATE TABLE charges (
    charges_id INT AUTO_INCREMENT PRIMARY KEY,
    freightcharges DECIMAL(10, 2),
    handlingcharges DECIMAL(10, 2),
    d2dcharges DECIMAL(10, 2),
    domesticcharges DECIMAL(10, 2),
    insuarancechrges DECIMAL(10, 2),
    tax DECIMAL(10, 2)
);

-- Adding Foreign Key Constraints at the End

ALTER TABLE users
    ADD FOREIGN KEY (gender_id) REFERENCES gender(gender_id),
    ADD FOREIGN KEY (level_id) REFERENCES access_level(level_id);

ALTER TABLE warehouse_driver
    ADD FOREIGN KEY (user_id) REFERENCES users(user_id),
    ADD FOREIGN KEY (warehouse_id) REFERENCES warehouse(warehouse_id),
    ADD FOREIGN KEY (level_id) REFERENCES access_level(level_id);

ALTER TABLE reciver_data
    ADD FOREIGN KEY (c_id) REFERENCES customer_data(c_id),
    ADD FOREIGN KEY (method_id) REFERENCES r_method(method_id);

ALTER TABLE order_package_details
    ADD FOREIGN KEY (order_id) REFERENCES order_data(order_id),
    ADD FOREIGN KEY (package_id) REFERENCES package(package_id);

ALTER TABLE order_data
    ADD FOREIGN KEY (detail_id) REFERENCES order_package_details(detail_id),
    ADD FOREIGN KEY (c_id) REFERENCES customer_data(c_id),
    ADD FOREIGN KEY (r_id) REFERENCES reciver_data(r_id),
    ADD FOREIGN KEY (status_id) REFERENCES status(status_id);

ALTER TABLE status
    ADD FOREIGN KEY (order_id) REFERENCES order_data(order_id);

ALTER TABLE container
    ADD FOREIGN KEY (warehouse_id) REFERENCES warehouse(warehouse_id);

ALTER TABLE invoice
    ADD FOREIGN KEY (order_id) REFERENCES order_data(order_id),
    ADD FOREIGN KEY (c_id) REFERENCES customer_data(c_id),
    ADD FOREIGN KEY (r_id) REFERENCES reciver_data(r_id),
    ADD FOREIGN KEY (container_id) REFERENCES container(container_id),
    ADD FOREIGN KEY (charges_id) REFERENCES charges(charges_id);

COMMIT;
