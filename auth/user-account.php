<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Management</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <div class="container">
    <div class="sidebar">
      <h1 class="primary-color">Account</h1>
      <ul>
        <li><a href="#" class="nav-link" data-target="personal-info">Personal Information</a></li>
        <li><a href="#" class="nav-link" data-target="security-privacy">Security & Privacy</a></li>
        <li><a href="#" class="nav-link" data-target="support-returns">Support & Returns</a></li>
        <li><a href="#" class="nav-link" data-target="logout-delete">Logout / Account Deletion</a></li>
      </ul>
    </div>

    <div class="main-content">
      <!-- Personal Information Section -->
      <section id="personal-info" class="section active">
        <h2 class="secondary-color">Personal Information</h2>
        <form id="personal-info-form">
          <label for="name">Full Name:</label>
          <input type="text" id="name">

          <label for="email">Email Address:</label>
          <input type="email" id="email">

          <label for="phone">Phone Number:</label>
          <input type="text" id="phone">

          <label for="address">Shipping Address:</label>
          <textarea id="address"></textarea>

          <button type="submit" class="btn-primary">Update Info</button>
        </form>
      </section>

      <!-- Security and Privacy Section -->
      <section id="security-privacy" class="section">
        <h2 class="secondary-color">Security and Privacy</h2>
        <form id="security-form">
          <label for="current-password">Current Password:</label>
          <input type="password" id="current-password" placeholder="Enter current password">

          <label for="password">Change Password:</label>
          <input type="password" id="password" placeholder="Enter new password">

          <label for="confirm-password">Confirm Password:</label>
          <input type="password" id="confirm-password" placeholder="Confirm new password">

          <button type="submit" class="btn-primary">Save Changes</button>
        </form>
      </section>

      <!-- Support and Returns Section -->
      <section id="support-returns" class="section">
        <h2 class="secondary-color">Support and Returns</h2>
        <div>
          <p>If you have any issues with your orders or products, contact our support team:</p>
          <button class="btn-primary" onclick="contactSupport()">Contact Support</button>
        </div>
      </section>

      <!-- Logout / Account Deletion Section -->
      <section id="logout-delete" class="section">
        <h2 class="secondary-color">Account Management</h2>
        <button class="btn-danger" onclick="logout()">Logout</button>
        <button class="btn-danger" onclick="deleteAccount()">Delete Account</button>
      </section>
    </div>
  </div>

  <script src="script.js"></script>
</body>

</html>