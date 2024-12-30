// script.js

// Simple form validation and "user session" management
document.getElementById('loginForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
  
    if (email === "user@example.com" && password === "password123") {
      localStorage.setItem('user', JSON.stringify({ name: "John Doe", email: "user@example.com" }));
      window.location.href = "user-account.php";
    } else {
      alert("Invalid email or password.");
    }
  });
  
  document.getElementById('signupForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    const name = document.getElementById('signupName').value;
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;
  
    if (name && email && password) {
      localStorage.setItem('user', JSON.stringify({ name, email }));
      window.location.href = "user-account.php";
    }
  });
  
  function logout() {
    localStorage.removeItem('user');
    window.location.href = "login.php";
  }
  

// Function to switch between sections based on tab clicks
const navLinks = document.querySelectorAll('.nav-link');
const sections = document.querySelectorAll('.section');

navLinks.forEach(link => {
  link.addEventListener('click', (event) => {
    event.preventDefault();

    // Hide all sections
    sections.forEach(section => section.classList.remove('active'));

    // Remove 'active' class from all nav links
    navLinks.forEach(link => link.classList.remove('active'));

    // Show the clicked section
    const targetSection = document.getElementById(link.getAttribute('data-target'));
    targetSection.classList.add('active');

    // Highlight the active tab
    link.classList.add('active');
  });
});

// Function to handle Personal Information form submission
document.getElementById('personal-info-form')?.addEventListener('submit', function(event) {
  event.preventDefault();
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;
  const address = document.getElementById('address').value;

  console.log('Updated Personal Info:', { name, email, phone, address });
  alert('Personal information updated successfully!');
});

// Handle Security and Privacy form submission
document.getElementById('security-form')?.addEventListener('submit', function(event) {
  event.preventDefault();
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm-password').value;
  const twoFA = document.getElementById('twofa').checked;

  if (password !== confirmPassword) {
    alert('Passwords do not match!');
  } else {
    console.log('Password Updated:', password);
    console.log('2FA Enabled:', twoFA);
    alert('Security settings updated successfully!');
  }
});

// Handle Notifications form submission
document.getElementById('notifications-form')?.addEventListener('submit', function(event) {
  event.preventDefault();
  const emailNotifications = document.getElementById('email-notifications').checked;
  const smsNotifications = document.getElementById('sms-notifications').checked;
  const pushNotifications = document.getElementById('push-notifications').checked;

  console.log('Email Notifications:', emailNotifications);
  console.log('SMS Notifications:', smsNotifications);
  console.log('Push Notifications:', pushNotifications);
  alert('Notification preferences saved successfully!');
});

// Contact Support function
function contactSupport() {
  alert('Redirecting to support page...');
  // Add your support page URL here
}

// Initiate Return function
function initiateReturn() {
  alert('Redirecting to return process...');
  // Add return process page URL here
}


// Delete Account function
function deleteAccount() {
  const confirmation = confirm('Are you sure you want to delete your account? This action cannot be undone.');
  if (confirmation) {
    alert('Account deleted!');
    // Add account deletion logic here
  }
}
