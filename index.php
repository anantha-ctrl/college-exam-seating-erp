<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Grace Exam Seating ERP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/x-icon"> 

    <style>
        /* Base Styles */
        body {
            margin: 0;
            padding: 0;
            background: #0b0b0b;
            font-family: "Poppins", sans-serif;
            overflow-x: hidden;
        }

        /* HERO SECTION - Responsive Container */
        .hero {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://res.cloudinary.com/de1tywvqm/image/upload/v1759253185/clg_wide_drone_by7hfg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .hero-content {
            width: 100%;
            max-width: 1000px;
            animation: fadeIn 1s ease-in;
        }

        /* Typography Adjustments */
        .welcome-title {
            font-weight: 700;
            letter-spacing: 3px;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .welcome-text {
            margin: 15px auto;
            line-height: 1.6;
            opacity: 0.9;
        }

        /* Button Styling */
        .learn-btn {
            margin-top: 25px;
            padding: 12px 35px;
            background: white;
            color: black;
            border-radius: 30px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .learn-btn:hover {
            transform: scale(1.05);
            background: #f0f0f0;
        }

        /* --- RESPONSIVE BREAKPOINTS --- */

        /* 1. Desktop/Laptop View (1024px and up) */
        @media (min-width: 1024px) {
            .welcome-title { font-size: 72px; }
            .welcome-text { font-size: 20px; max-width: 700px; }
        }

        /* 2. Tablet View (768px to 1023px) */
        @media (max-width: 1023px) and (min-width: 768px) {
            .welcome-title { font-size: 54px; }
            .welcome-text { font-size: 18px; max-width: 80% ; }
        }

        /* 3. Mobile View (Below 768px) */
        @media (max-width: 767px) {
            .welcome-title { 
                font-size: 36px; 
                letter-spacing: 1px;
            }
            .welcome-text { 
                font-size: 15px; 
                padding: 0 10px;
            }
            .hero {
                padding: 40px 15px;
            }
            .learn-btn {
                width: 80%; /* Larger touch target for mobile */
                padding: 15px;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    

    <div class="hero">
        <div class="hero-content">
            <h1 class="welcome-title">WELCOME</h1>
            <p class="welcome-text">
                Grace College Exam Seating ERP simplifies student management, automates seating plans, and delivers error-free hall arrangements in minutes.
            </p>
            <button class="learn-btn" onclick="window.location='seat.php'">
                Begin Seating
            </button>
        </div>
    </div>

</body>
</html>