<?php session_start(); ?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us - AfriLink</title>
  <link rel="stylesheet" href="assets/css/styles.css" />
  <style>
    body {
      font-family: 'Spartan', sans-serif;
      background: #f9f9f9;
      padding: 40px 80px;
    }
    .contact-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      max-width: 900px;
      margin: auto;
    }
    h1 {
      text-align: center;
      color: #ba4593;
      margin-bottom: 30px;
    }
    form {
      display: grid;
      gap: 20px;
    }
    input, textarea {
      width: 100%;
      padding: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
    button {
      background-color: #088178;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0aa58f;
    }
    .info {
      margin-top: 30px;
      background: #f2f2f2;
      padding: 20px;
      border-radius: 8px;
    }
    .info p {
      margin: 10px 0;
      color: #444;
    }
    iframe {
      margin-top: 20px;
      width: 100%;
      height: 300px;
      border: none;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<!--<?php include 'includes/navbar.php'; ?>-->

<div class="contact-container">
  <h1>📞 Contact AfriLink</h1>

  <form action="#" method="post">
    <input type="text" name="name" placeholder="Your Full Name" required>
    <input type="email" name="email" placeholder="Your Email Address" required>
    <textarea name="message" placeholder="Your Message..." rows="6" required></textarea>
    <button type="submit">Send Message</button>
  </form>

  <div class="info">
    <h3>Our Contact Details</h3>
    <p><strong>Address:</strong> 382 Rivonia Road, Sandton, Johannesburg</p>
    <p><strong>Phone:</strong> 011 446 3584</p>
    <p><strong>Email:</strong> support@afrilink.co.za</p>
    <p><strong>Hours:</strong> Monday to Saturday, 9am – 5pm</p>
  </div>

  <!-- Embeded Google Maps -->
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.6476394946947!2d28.05420831502314!3d-26.071481283491066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e950e6f43e248f3%3A0x847a6c70c2ec7f47!2sRivonia%20Rd%2C%20Sandton!5e0!3m2!1sen!2sza!4v1660000000000"
    allowfullscreen="" loading="lazy">
  </iframe>

</div>

</body>
</html>
