<?php session_start(); ?>

<?php include 'includes/back_button.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sell on AfriLink</title>
  <link rel="stylesheet" href="assets/css/styles.css" />
  <style>
    .seller-hero {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 60px 80px;
      background-color: #f3f6fb;
    }
    .seller-text {
      flex: 1;
    }
    .seller-text h1 {
      font-size: 48px;
      color: #ba4593;
      margin-bottom: 20px;
    }
    .seller-text p {
      font-size: 18px;
      color: #444;
      margin-bottom: 20px;
    }
    .seller-text button {
      padding: 14px 30px;
      font-size: 16px;
      background-color: #088178;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .seller-text button:hover {
      background-color: #0aa58f;
    }
    .seller-img {
      flex: 1;
      text-align: right;
    }
    .seller-img img {
      width: 90%;
      max-width: 400px;
    }

    .steps {
      padding: 60px 80px;
      background-color: #fff;
    }

    .steps h2 {
      font-size: 32px;
      color: #222;
      margin-bottom: 30px;
    }

    .step {
      margin-bottom: 20px;
    }

    .step h4 {
      color: #ba4593;
      margin-bottom: 8px;
    }

    .step p {
      color: #333;
      font-size: 16px;
    }
  </style>
</head>
<body>



<section class="seller-hero">
  <div class="seller-text">
    <h1>Join SA’s Best Online Marketplace Platform</h1>
    <p>Get the tools you need to increase sales and grow your business online.<br>
    Selling your products online has never been easier. Apply today and easily reach online shoppers across South Africa.</p>
    <a href="register.php"><button>Apply to Sell</button></a>
  </div>
  <div class="seller-img">
    <img src="img/products/seller.jpg" alt="Sell on AfriLink">
  </div>
</section>

<section class="steps">
  <h2>Start selling online in just a few easy steps</h2>

  <div class="step">
    <h4>📄 Application</h4>
    <p>Apply now and tell us about your business and products.</p>
  </div>

  <div class="step">
    <h4>✅ Approval</h4>
    <p>We’ll review your application and get in touch within 10 business days.</p>
  </div>

  <div class="step">
    <h4>🧾 Registration</h4>
    <p>Complete your seller account by supplying all the required information and paperwork.</p>
  </div>

  <div class="step">
    <h4>📚 Onboarding</h4>
    <p>Learn all about our processes and choose your stock model.</p>
  </div>

  <div class="step">
    <h4>💰 Sales</h4>
    <p>Get your products live and start selling.</p>
  </div>

  <div class="step">
    <h4>📈 Growth</h4>
    <p>Boost your online sales via promotions, analyze performance, and scale up!</p>
  </div>
</section>


</body>
</html>
