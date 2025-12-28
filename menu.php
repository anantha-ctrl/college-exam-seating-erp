<!-- menu.php -->
 <?php
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Grace College Exam Seating</title>

<style>
/* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", system-ui, sans-serif;
}

:root {
    --primary: #8b1b5a;
    --white: #ffffff;
}

/* ===== HEADER ===== */
header {
    background: var(--primary);
    color: var(--white);
}

/* ===== CONTAINER ===== */
.header-container {
    max-width: 1400px;
    margin: auto;
    padding: 14px 20px;
}

/* ===== DESKTOP ROW ===== */
.header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* ===== BRAND ===== */
.brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand img {
    height: 46px;
}

.brand h1 {
    font-size: 18px;
    font-weight: 600;
}

.brand small {
    font-size: 13px;
    opacity: 0.9;
}

/* ===== MENU TOGGLE ===== */
.menu-toggle {
    display: none;
    font-size: 28px;
    cursor: pointer;
    user-select: none;
}

/* ===== NAV ===== */
nav ul {
    list-style: none;
    display: flex;
    gap: 26px;
}

nav a {
    color: var(--white);
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    position: relative;
}

/* Remove blue hover */
nav a,
nav a:hover,
nav a:focus,
nav a:active {
    color: var(--white);
    outline: none;
    background: transparent;
    text-decoration: none;
}

/* Subtle underline hover */
nav a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -5px;
    width: 0;
    height: 2px;
    background: var(--white);
    transition: 0.3s;
}

nav a:hover::after {
    width: 100%;
}

/* ===== MOBILE VIEW ===== */
@media (max-width: 767px) {

    .header-row {
        flex-wrap: wrap;
    }

    .menu-toggle {
        display: block;
    }

    nav {
        width: 100%;
        display: none;
        margin-top: 14px;
    }

    nav.show {
        display: block;
    }

    nav ul {
        flex-direction: column;
        gap: 14px;
        background: rgba(255,255,255,0.1);
        padding: 14px;
        border-radius: 6px;
    }
}

/* ===== TABLET ===== */
@media (min-width: 768px) and (max-width: 1024px) {
    nav ul {
        gap: 18px;
    }
}
</style>
</head>

<body>

<header>
    <div class="header-container">

        <!-- SINGLE ROW FOR DESKTOP -->
        <div class="header-row">

            <!-- BRAND -->
            <div class="brand">
                <img src="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png"
                     alt="Logo"
                     onerror="this.style.display='none'">
                <div>
                    <h1>Grace College of Engineering</h1>
                    <small>Exam Seating Arrangement — CENTRE: 9503</small>
                </div>
            </div>

            <!-- MENU TOGGLE (MOBILE ONLY) -->
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>

            <!-- NAV (RIGHT SIDE DESKTOP) -->
            <nav id="mainNav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="seat.php">Planning</a></li>
                    <li><a href="stud_add.php">Add Students</a></li>
                    <li><a href="stud_del.php">Manage Students</a></li>
                    <li><a href="upload.php">Upload CSV</a></li>
                    <li><a href="view.php">Session Plans</a></li>
                    <li><a href="view_plan.php">HALL Plans</a></li>
                </ul>
            </nav>

        </div>

    </div>
</header>

<script>
function toggleMenu() {
    document.getElementById("mainNav").classList.toggle("show");
}
</script>

</body>
</html>
