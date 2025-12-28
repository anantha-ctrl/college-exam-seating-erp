<?php
// Simple footer partial — safe for PHP 5.4.16
$year = date('Y');
$centre = defined('EXAM_CENTRE') ? EXAM_CENTRE : '9503';
?>

<style>
    /* Base Footer Styling */
    footer {
        background-color: white;
        color: #343a40;
        border-top: 1px solid #e9ecef;
        padding: 20px 0;
        margin-top: auto; /* Push to bottom if flex layout */
        font-family: 'Segoe UI', sans-serif;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        text-align: left;
    }

    .footer-col {
        flex: 1;
        min-width: 250px;
        margin-bottom: 10px;
        padding: 5px;
    }

    /* Text Styling */
    .copy-txt {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .copy-txt strong {
        color: #343a40;
    }

    .team-text {
        font-size: 0.85rem;
        line-height: 1.4;
        color: #6c757d;
        text-align: center;
    }

    .team-text strong {
        color: #007bff;
        font-weight: 600;
    }
    
    .foot-links {
        text-align: right;
        font-size: 0.9rem;
    }

    /* Centre Badge */
    .centre-badge {
        display: inline-block;
        padding: 0.25em 0.6em;
        font-size: 0.8rem;
        font-weight: 700;
        line-height: 1;
        border-radius: 0.25rem;
        background-color: #ffc107;
        color: #212529;
    }

    /* Footer Links */
    .footer-nav-link {
        color: #007bff;
        text-decoration: none;
        margin: 0 5px;
        transition: color 0.3s ease;
    }

    .footer-nav-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .footer-container {
            flex-direction: column;
            text-align: center;
        }
        
        .footer-col {
            width: 100%;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .foot-links {
            text-align: center;
        }
    }
</style>

<footer>
    <div class="footer-container">
        <!-- Copyright -->
        <div class="footer-col copy-txt">
            &copy; <?php echo $year; ?> <strong>Grace College of Engineering</strong>.<br>All Rights Reserved.
        </div>

        <!-- Developer Credit -->
        <div class="footer-col team-text">
            Designed & Developed by<br>
            <strong>Dr. K. M. Alaaudeen</strong>, M.E., Ph.D (HOD/CSE)<br>
            <strong>Anantha Kumar G</strong> (IV CSE)
        </div>

        <!-- Links & Badge -->
        <div class="footer-col foot-links">
            <span style="color:#adb5bd;">Centre:</span>
            <span class="centre-badge"><?php echo htmlspecialchars($centre, ENT_QUOTES, 'UTF-8'); ?></span>
            
            <div style="margin-top: 5px;">
                <a href="index.php" class="footer-nav-link">Home</a> ·
                <a href="view_plan.php" class="footer-nav-link">Saved Plans</a> ·
                <a href="upload.php" class="footer-nav-link">Upload CSV</a>
            </div>
        </div>
    </div>
</footer>