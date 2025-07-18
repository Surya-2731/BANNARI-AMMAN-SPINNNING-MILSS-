<?php
// Database connection settings
$host = "localhost";
$username = "root";       // use your MySQL username
$password = "";           // use your MySQL password
$database = "bannari_db"; // your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Execute and check result
    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Error sending message.'); window.history.back();</script>";
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us – Bannari Amman Spinning Mills</title>
  <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* Base Contact Page Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f7fa;
      color: #333;
      overflow-x: hidden;
      padding-top: 120px; /* Add space for fixed header */
    }

    header {
      background: #ffffff;
      padding: 10px 50px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }

    .navbar-container {
      display: flex;
      align-items: center;
      flex: 1;
      justify-content: center;
      gap: 50px;
    }

    .logo img {
      height: 80px;
      width: auto;
      border-radius: 20px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
      align-items: center;
    }

    nav ul li {
      position: relative;
    }

    nav ul li a {
      color: #333333;
      text-decoration: none;
      font-weight: 600;
      font-size: 18px;
      transition: all 0.3s ease;
      padding: 5px 10px;
    }

    nav ul li a:hover {
      background:  #2fab96;
      color: #ffffff;
      border-radius: 10px;
    }

    /* Dropdown Styles */
    .dropdown {
      display: none;
      position: absolute;
      top: 40px;
      left: 0;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      min-width: 200px;
      flex-direction: column;
      z-index: 1001; /* Ensure it appears above header */
    }

    .dropdown li {
      width: 100%;
    }

    .dropdown li a {
      display: block;
      cursor: pointer;
    min-height: 50px;
    line-height: 1.5rem;
    width: 100%;
    text-align: left;
    text-transform: none;
    }

    .dropdown li a:hover {
      background: #2fab96;
      color: white;
      border-radius: 0;
    }
    nav ul li {
  position: relative;
}

nav ul li:hover > .dropdown,
nav ul li .dropdown:hover {
  display: flex;
  flex-direction: column;
}


.contact-section {
  padding: 100px 20px;
  background: linear-gradient(135deg, #f0f7f4, #ffffff);
}

.contact-header {
  text-align: center;
  margin-bottom: 60px;
  animation: fadeInDown 1s ease;
}

.contact-header h2 {
  font-size: 48px;
  font-weight: 800;
  background: linear-gradient(to right, #00bfa5, #00796b);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  color: transparent; /* Fallback if text-fill isn't supported */
}


.contact-header p {
  font-size: 20px;
  color: #333;
  margin-top: 10px;
}

.contact-container {
  display: flex;
  justify-content: space-between;
  gap: 50px;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: auto;
}

.contact-info {
  flex: 1;
  min-width: 300px;
  background: #ffffff;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.07);
}

.info-box {
  margin-bottom: 30px;
}

.info-box h4 {
  color: #004d40;
  font-size: 22px;
  margin-bottom: 10px;
}

.info-box p {
  font-size: 17px;
  color: #333;
  line-height: 1.6;
}

.contact-form {
  flex: 1;
  min-width: 300px;
  background: #ffffff;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.07);
}

.contact-form form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.contact-form input,
.contact-form textarea {
  padding: 15px;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 16px;
  transition: border 0.3s ease;
}

.contact-form input:focus,
.contact-form textarea:focus {
  border-color: #00bfa5;
  outline: none;
}

.contact-form button {
  background: linear-gradient(to right, #00bfa5, #00796b);
  color: #fff;
  padding: 14px;
  border: none;
  font-size: 18px;
  border-radius: 12px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.contact-form button:hover {
  background: linear-gradient(to right, #00796b, #00bfa5);
}

.map-container {
  margin-top: 60px;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
}

.map-container iframe {
  width: 100%;
  height: 400px;
  border: 0;
}

/* Animations */
@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive Styles */
@media (max-width: 768px) {
  .contact-container {
    flex-direction: column;
  }

  .contact-form,
  .contact-info {
    padding: 30px 20px;
  }

  .contact-header h2 {
    font-size: 36px;
  }
}

/* General Footer Styles */
footer {
  background-color: #1a1a1a;
  color: #fff;
  padding: 40px 20px 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Footer Container */
.footer-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: 0 auto;
}

/* Footer Columns */
.footer-column {
  flex: 1 1 300px;
  margin: 20px;
}

.footer-column h4 {
  font-size: 20px;
  margin-bottom: 15px;
  border-bottom: 2px solid #00ffd0;
  display: inline-block;
  padding-bottom: 5px;
}

.footer-column p,
.footer-column a,
.footer-column li {
  color: #ccc;
  font-size: 14px;
  line-height: 1.8;
  text-decoration: none;
}

.footer-column a:hover {
  color: #0fffd3;
}

/* Quick Links */
.footer-column ul {
  list-style: none;
  padding: 0;
}

.footer-column ul li {
  margin-bottom: 10px;
}

/* Social Icons */
.footer-social-icons a {
  display: inline-block;
  color: #fff;
  font-size: 18px;
  margin-right: 15px;
  transition: color 0.3s;
}

.footer-social-icons a:hover {
  color: #00ffc8;
}

/* Footer Bottom */
.footer-bottom {
  text-align: center;
  padding: 15px 0;
  border-top: 1px solid #333;
  font-size: 14px;
  color: #999;
  margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    align-items: center;
  }

  .footer-column {
    margin: 10px 0;
    text-align: center;
  }

  .footer-social-icons a {
    margin: 0 10px;
  }
}

  </style>
</head>
<body>
    <header>
  <a href="index.html" class="logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
  <img src="assets/images/logo.png" alt="Bannari Amman Spinning Mills" style="height: 50px;">
  <span style="font-size: 1.2rem; font-weight: bold; color: #000;">Bannari Amman Spinning Mills LTD.</span>
</a>


    <div class="navbar-container">
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html" class="active">About</a></li>

          <li>
            <a href="#">Product</a>
            <ul class="dropdown">
              <li><a href="Product.html">Home Textile</a></li>
            </ul>
          </li>

          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </div>

  </header>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const menuItem = document.querySelector("nav ul li:nth-child(3)"); // The "Menu" item
      const dropdown = menuItem.querySelector(".dropdown");
  
      let timeout;
  
      menuItem.addEventListener("mouseenter", () => {
        clearTimeout(timeout);
        dropdown.style.display = "flex";
      });
  
      menuItem.addEventListener("mouseleave", () => {
        timeout = setTimeout(() => {
          dropdown.style.display = "none";
        }, 200); // Delay in ms
      });
  
      dropdown.addEventListener("mouseenter", () => {
        clearTimeout(timeout);
      });
  
      dropdown.addEventListener("mouseleave", () => {
        timeout = setTimeout(() => {
          dropdown.style.display = "none";
        }, 200);
      });
    });
  </script>

  <section class="contact-section">
    <div class="contact-header">
      <h2>Let’s Connect</h2>
      <p>We’d love to hear from you. Reach out for inquiries, collaborations, or support.</p>
    </div>

    <div class="contact-container">
      <div class="contact-info">
        <div class="info-box">
          <h4>Corporate Office</h4>
          <p>Bannari Amman Spinning Mills Ltd.<br>
          252, Mettupalayam Road,<br>
          Coimbatore – 641043, Tamil Nadu, India</p>
        </div>

        <div class="info-box">
          <h4>Phone</h4>
          <p>+91 422 4233550 / 4513550</p>
        </div>

        <div class="info-box">
          <h4>Email</h4>
          <p>info@bannarimills.com</p>
        </div>
      </div>

     <form action="contact.php" method="post">
  <input type="text" name="name" placeholder="Your Name" required />
  <input type="email" name="email" placeholder="Your Email" required />
  <input type="text" name="subject" placeholder="Subject" />
  <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
  <button type="submit">Send Message</button>
</form>

      </div>
    </div>

    <div class="map-container">
      <iframe
        src="https://maps.google.com/maps?q=252%2C%20Mettupalayam%20Road%2C%20Coimbatore%20%E2%80%93%20641043&t=&z=15&ie=UTF8&iwloc=&output=embed"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </section>

  <footer>
    <div class="footer-container">
      <div class="footer-column">
        <h4>Contact Us</h4>
        <p>252, Mettupalayam Road<br>Coimbatore 641043, Tamil Nadu, India</p>
        <p>Phone: +91 (422) 2435555</p>
        <p>Email: <a href="mailto:shares@bannarimills.com">shares@bannarimills.com</a></p>
      </div>
      <div class="footer-column">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About Us</a></li>
          <li><a href="Product.html">Products</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>Follow Us</h4>
        <div class="footer-social-icons">
          <a href="https://www.facebook.com/p/BANNARI-AMMAN-SPINNING-MILLS-LTD-100064781976493/"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.linkedin.com/company/bannari-amman-spinning-mills-ltd/?originalSubdomain=in"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2025 Bannari Amman Spinning Mills Ltd. All Rights Reserved.
    </div>
  </footer>
</body>
</html>
