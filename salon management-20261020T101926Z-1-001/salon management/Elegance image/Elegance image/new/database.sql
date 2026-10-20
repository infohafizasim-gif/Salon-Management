-- Elegance Salon Management System
-- Database Schema for Aptech eProject

CREATE DATABASE IF NOT EXISTS elegance_salon;
USE elegance_salon;

-- Users table (Admin, Receptionist, Stylist)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'receptionist', 'stylist', 'client') DEFAULT 'client',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Clients table
CREATE TABLE clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20) NOT NULL,
    gender ENUM('male', 'female', 'other'),
    address TEXT,
    preferences TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Services table
CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    duration INT NOT NULL COMMENT 'in minutes',
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50),
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Staff / Stylists (linked to users)
CREATE TABLE staff (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    specialization VARCHAR(100),
    commission_rate DECIMAL(5,2) DEFAULT 10.00,
    schedule TEXT,
    bio TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Appointments table
CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    service_id INT NOT NULL,
    staff_id INT,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled', 'no-show') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE SET NULL
);

-- Inventory / Products
CREATE TABLE inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    quantity INT DEFAULT 0,
    unit_price DECIMAL(10,2),
    supplier VARCHAR(100),
    low_stock_threshold INT DEFAULT 10,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Payments
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    appointment_id INT,
    client_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'card', 'online', 'upi') DEFAULT 'cash',
    payment_status ENUM('pending', 'paid', 'refunded') DEFAULT 'pending',
    invoice_number VARCHAR(50),
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Feedback
CREATE TABLE feedback (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(100),
    email VARCHAR(100),
    rating INT CHECK (rating BETWEEN 1 AND 5),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Notifications
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(150),
    message TEXT,
    type ENUM('appointment', 'inventory', 'payment', 'system') DEFAULT 'system',
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ONLY ONE ADMIN by default (password: admin123). Sign-ups become role=client.
INSERT INTO users (name, email, phone, password, role) VALUES
('Admin User', 'admin@elegancesalon.com', '03001234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Sample Services
INSERT INTO services (name, description, duration, price, category) VALUES
('Signature Haircut & Style', 'Precision cut and professional styling', 60, 85.00, 'Hair'),
('Balayage Color & Blowout', 'Hand-painted highlights with blow dry', 120, 165.00, 'Hair'),
('Relaxing Aromatherapy Facial', 'Deep cleansing facial with essential oils', 75, 120.00, 'Skin'),
('Ultimate Relaxation Massage', 'Full body massage for complete relaxation', 90, 130.00, 'Massage'),
('Manicure & Pedicure', 'Complete nail care package', 60, 70.00, 'Nails'),
('Bridal Makeup Package', 'Full bridal makeup and hair styling', 180, 350.00, 'Makeup');

-- Sample Inventory
INSERT INTO inventory (product_name, category, quantity, unit_price, supplier, low_stock_threshold) VALUES
('Shampoo - Premium 1L', 'Hair Care', 25, 15.00, 'BeautySupply Co', 10),
('Hair Color - Ash Blonde', 'Color', 8, 22.00, 'LOreal Distributor', 10),
('Facial Cream - Hydrating', 'Skin Care', 18, 28.00, 'SkinLab', 8),
('Massage Oil - Lavender', 'Wellness', 12, 18.00, 'AromaEssentials', 5),
('Nail Polish Set', 'Nails', 30, 12.00, 'NailPro', 15);

ALTER TABLE users MODIFY role ENUM('admin','receptionist','stylist','client') DEFAULT 'client';