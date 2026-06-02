CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    phone VARCHAR(20)
);

CREATE TABLE bills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    subtotal DECIMAL(10,2),
    discount DECIMAL(10,2),
    insurance_amount DECIMAL(10,2),
    cash_amount DECIMAL(10,2),
    total DECIMAL(10,2),
    insurance_status VARCHAR(20),
    claim_reference VARCHAR(100),
    created DATETIME
);