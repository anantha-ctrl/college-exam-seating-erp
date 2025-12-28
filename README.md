# College Exam Seating Arrangement ERP

A simple and efficient **Exam Seating Arrangement System** built using **PHP and MySQL**, designed to help colleges manage students, generate seating plans, and organize exam halls with ease.

This project is ideal for **college projects**, **internal ERP systems**, and **academic demonstrations**.

---

## Features

- 📋 Student Management (Add, Edit, Delete)
- 📤 Upload Students via CSV file
- 🪑 Automatic Exam Seating Plan Generation
- 🏫 Hall-wise Seating Arrangement
- 🖨️ Print-Friendly Seating Plans
- 🔍 View Session Plans & Hall Plans
- 🧩 Modular PHP files (menu, footer, connection)
- ⚡ Lightweight & Bootstrap-free UI

---

## Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript  
- **Backend:** PHP (Core PHP)  
- **Database:** MySQL  
- **Server:** Apache (XAMPP / WAMP / LAMP)

---

##  Project Structure

```

college-exam-seating-erp/
│
├── index.php
├── menu.php
├── footer.php
├── connection.php
├── seat.php
├── upload.php
├── view.php
├── view_plan.php
├── view_seating_single.php
├── stud_add.php
├── stud_edit.php
├── stud_del.php
├── update_student.php
├── reprint_plan.php
├── exam.csv
├── g_exam.sql
├── grace.png
├── au.png
└── README.md

````

---

## Installation & Setup

Follow these steps to run the project locally:

### Clone the Repository
```bash
git clone https://github.com/ananthe-ctrl/college-exam-seating-erp.git
````

### Move to Server Directory

* For XAMPP: `htdocs/`
* For WAMP: `www/`

### Create Database

* Open **phpMyAdmin**
* Create a database (example: `exam_seating`)
* Import the file:

  ```
  g_exam.sql
  ```

### Configure Database Connection

Edit `connection.php`:

```php
$conn = mysqli_connect("localhost", "root", "", "exam_seating");
```

### Run the Project

Open your browser and visit:

```
http://localhost/college-exam-seating-erp/
```

---

## CSV Upload Format

Ensure your CSV file follows the required structure (example):

```
Register No, Name, Department
```

Incorrect formats may cause upload errors.

---

## Printing

* Seating plans are optimized for printing
* Use **Print Preview** for best results
* Recommended: A4 size, Portrait mode

---

## Use Cases

* College Examination Cells
* Internal Assessment Seating
* Academic Mini / Final Year Projects
* PHP CRUD Practice Projects

---

## Future Enhancements

* Login & Role-based Access (Admin / Staff)
* Subject-wise Seating Allocation
* Conflict-Free Seating Algorithm
* Export Seating Plan as PDF
* Dashboard with Statistics

---

## Contribution

Contributions are welcome!
Feel free to fork this repository and submit a pull request.

---

## License

This project is for **educational purposes**.
You are free to modify and use it for learning and academic submissions.

---

## Author

**Anantha**
GitHub: [https://github.com/ananthe-ctrl](https://github.com/ananthe-ctrl)

---

⭐ If you found this project useful, give it a star on GitHub!

```
