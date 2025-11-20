# 💊 Pharmacy Management System (PMS)

## 📖 Project Overview
The **Pharmacy Management System** is a web-based software solution developed using **PHP** and **MySQL**.  
It digitalizes and automates traditional pharmacy operations — including sales, inventory, supplier management, and reporting — to enhance efficiency, accuracy, and customer satisfaction.

This project resolves the challenges of manual record-keeping, stock tracking, and billing by introducing a **role-based, secure, and user-friendly** interface for administrators, cashiers, and customers.

---

## 🚀 Key Features

### 👩‍💼 Admin Domain
- Add, edit, or remove medicines.
- Manage suppliers and employees.
- Track stock levels and receive expiry alerts.
- Generate detailed **sales and stock reports**.
- View all transactions (audit logs).
- Access full system functionalities.

### 💳 Cashier Domain
- Process customer sales and refunds.
- Search medicines by name or category.
- Print or email digital receipts.
- View daily transaction summaries.

### 👨‍⚕️ Pharmacist Domain
- Verify prescriptions and update stock.
- Manage medicine expiry and safety details.

### 🧾 Customer Domain
- Register and log in securely.
- Search and view medicines online.
- Add items to the shopping cart and checkout.
- View order history and invoices.

---

## 🧠 System Architecture
The system is divided into **three main layers**:

1. **Presentation Layer** – PHP/HTML/CSS interface  
2. **Application Layer** – Business logic and validation  
3. **Database Layer** – MySQL database for secure data storage  

---

## ⚙️ Functional Requirements

| ID | Requirement | Description |
|----|--------------|-------------|
| 1 | User Registration & Login | Secure login for customers and admins. |
| 2 | Search Medicine | Search medicines by name or category. |
| 3 | View Product Details | Show price, stock, expiry date, and description. |
| 4 | Shopping Cart | Add items and checkout. |
| 5 | Payment Processing | Record sales and print invoices. |
| 6 | Manage Medicines | Admin can add, update, or delete medicines. |
| 7 | Manage Orders | Admin can update order status. |
| 8 | Manage Suppliers | Admin can manage supplier information. |
| 9 | Stock Monitoring | Auto alerts for low or expired stock. |
| 10 | Reporting | Generate sales and stock reports. |
| 11 | Role-Based Login | Different access levels for Admin and Cashier. |
| 12 | Cashier Functions | Handle sales and refunds. |
| 13 | Admin Functions | Full control over the system. |

---

## 🧩 Non-Functional Requirements

| ID | Requirement | Description | Priority |
|----|--------------|-------------|----------|
| 14 | Security | Role-based access; encrypted login. | High |
| 15 | Usability | Simple and responsive UI. | High |
| 16 | Performance | Fast response (< 3 seconds per query). | Medium |
| 17 | Reliability | All data stored safely in database. | High |
| 18 | Scalability | Should handle growing users and data. | Medium |
| 19 | Maintainability | Modular code for easy updates. | Medium |
| 20 | Access Control | Each user restricted to their domain. | High |
| 21 | Auditability | Admin can track cashier activity. | Medium |

---

## 👥 Stakeholders

| Role | Description |
|------|--------------|
| **Admin / Owner** | Manages all operations, reports, and inventory. |
| **Cashier** | Handles sales, billing, and refunds. |
| **Pharmacist** | Maintains accurate medicine data. |
| **Customer** | Searches, views, and buys products online. |
| **Supplier** | Provides medicine stock and updates supply info. |
| **Developer / DBA** | Maintains software, tests features, and ensures database security. |

---

## 🧪 Software Testing Plan

### 🔸 Testing Types
- **Unit Testing** – Validate modules (login, stock update, billing).
- **Integration Testing** – Ensure smooth flow (Order → Payment → Report).
- **System Testing** – Validate overall PMS performance and data consistency.
- **Acceptance Testing** – Confirm system meets all functional requirements.

### 🔸 Sample Test Cases

| Test ID | Description | Input | Expected Output | Status |
|----------|-------------|--------|------------------|---------|
| TC01 | Login validation | Valid credentials | Redirect to dashboard | ✅ |
| TC02 | Medicine search | “Paracetamol” | Product info displayed | ✅ |
| TC03 | Checkout | Items in cart | Invoice generated | ✅ |
| TC04 | Add new medicine | Valid form data | Record saved successfully | ✅ |
| TC05 | Expired stock alert | Medicine expiry < today | Warning notification | ✅ |

---

## 🧰 Tools & Technologies
- **Frontend:** HTML, CSS, Bootstrap  
- **Backend:** PHP (Core / Laravel)  
- **Database:** MySQL  
- **Server:** XAMPP / Apache  
- **Testing:** PHPUnit, Selenium, Postman  
- **Version Control:** Git & GitHub  

---

## 🏗️ Installation & Setup

### 🪜 Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html)
- [Git](https://git-scm.com/)
- Web browser (Chrome/Edge)
- MySQL Database

### ⚡ Steps
1. Clone the repository  
   ```bash
   git clone https://github.com/3seem/pharmacy-management.git
