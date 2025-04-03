<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Services Provider</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        /* Header Styling */
        .header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }
        .nav-center {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        /* Home and Info Icons */
        .icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .icons a {
            font-size: 24px;
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }
        .icons a:hover {
            color: #007BFF;
        }
        /* Navigation Menu */
        .nav-list {
            display: flex;
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nav-list li {
            display: inline-block;
        }
        .nav-list a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            transition: color 0.3s;
        }
        .nav-list a:hover {
            color: #007BFF;
        }
        /* Responsive Menu */
        .hamburger {
            display: none;
            font-size: 28px;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .nav-list {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                right: 20px;
                background: white;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                padding: 10px;
            }
            .nav-list.active {
                display: flex;
            }
            .hamburger {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <div class="navigation">
            <div class="nav-center container">
                <!-- Home & Info Icons -->
                <div class="icons">
                    <a href="home.php"><i class="fas fa-home"></i></a>  
                    <a href="about.php"><i class="fas fa-info-circle"></i></a>
                </div>

                <!-- Navigation Menu (Right-aligned) -->
                <ul class="nav-list">
                    <li class="nav-item"><a href="service.php">Services</a></li>
                    <li class="nav-item"><a href="admin_login.php">Admin</a></li>
                    <li class="nav-item"><a href="client_login.php">Login</a></li>
                    <li class="nav-item"><a href="contact.php">Contact</a></li>
                </ul>

                <!-- Mobile Menu Icon -->
                <div class="hamburger"><i class="bx bx-menu"></i></div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay">
            <h1>Find Trusted Home Services Near You</h1>
            <p>Book professional home service providers with ease.</p>
            <form action="service.php" method="GET">
                <input type="text" name="search" placeholder="Search for a service...">
                <button type="submit">Search</button>
            </form>
        </div>
    </section>

    <!-- Available Services Section -->
    <section class="services">
        <div class="container">
            <h2>Available Services</h2>
            <p>Explore our trusted home service providers.</p>
            <div class="services-grid">
                <a href="service.php?service=Plumbing" class="service-box">
                    <img src="../image/plumbing.jpg" alt="Plumbing">
                    <h3>Plumbing</h3>
                    <p>Fix leaks, install pipes, and more.</p>
                </a>
                <a href="service.php?service=Cleaning" class="service-box">
                    <img src="../image/cleaning.jpg" alt="Cleaning">
                    <h3>Cleaning</h3>
                    <p>Home and office cleaning services.</p>
                </a>
                <a href="service.php?service=Electrical" class="service-box">
                    <img src="../image/electri.jpg" alt="Electrical Repairs">
                    <h3>Electrical Repairs</h3>
                    <p>Reliable electrical maintenance and installations.</p>
                </a>
            </div>
            <a href="service.php" class="view-all" style="color: blue; background-color: #007BFF; padding: 10px 20px; border-radius: 5px;">View All Services</a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="testimonial-grid">
                <div class="testimonial-box">
                    <p>"Great service! I booked a plumber and got the job done within hours. Highly recommended!"</p>
                    <h4>- Alice M.</h4>
                </div>
                <div class="testimonial-box">
                    <p>"Easy to use and reliable providers. The best home service platform I've used!"</p>
                    <h4>- John D.</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Home Services Provider. All Rights Reserved.</p>
            <div class="social">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        const menuIcon = document.querySelector(".hamburger");
        const navList = document.querySelector(".nav-list");

        menuIcon.addEventListener("click", () => {
            navList.classList.toggle("active");
        });
    </script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/67e6b5a796e5e5190f2b6793/1inejb63q';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
