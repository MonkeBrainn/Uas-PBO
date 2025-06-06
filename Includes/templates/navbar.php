<!-- START NAVBAR SECTION -->
<header  id="header" class="nav-header">
    <div class = "above_navbar">
        <div class = "container">
            <div class = "bar_content">
                <div class = "company_details">
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            184 Main Street East 8007
                        </li>
                        <li>
                            <i class="fas fa-mobile-alt"></i>
                            1.800.456.6743
                        </li>
                        <li>
                            <i class="far fa-clock"></i>
                            Mon-Fri 09.00 - 17.00
                        </li>
                    </ul>
                </div>
                <div class = "company_social">
                    <ul>
	 	                <li><a target="_blank" href="#" title="Facebook"><i class="fab fa-facebook-square"></i></a></li>
	 	 	            <li><a target="_blank" href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
	    	    	    <li><a target="_blank" title="Instagram" href="#"><i class="fab fa-instagram"></i></a></li>
	    	    	</ul>
                </div>
            </div>
        </div>
    </div>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class = "container">
            <a class="navbar-brand" href="#">
                R's<span style = "color:#04DBC0">Car</span>&nbsp;Rent
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#R'sNavbar" aria-controls="R'sNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="R'sNavbar">
                <ul class="navbar-nav" style = "margin-left: auto!important;">
                    <li class="nav-item active">
                        <a class="nav-link" href="./">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./#brands">Brands</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./#reserve">Reserve</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./#contact-us">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- CSS for Modals -->
<style>
.modal.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}

.modal {
    transition: none !important;
}

.modal.fade {
    transition: none !important;
}

.modal.fade .modal-dialog {
    transition: none !important;
    transform: none !important;
}

.modal-dialog {
    margin: 0;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    transition: none !important;
    transform: none !important;
}

.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    background: linear-gradient(135deg, #04DBC0, #02a693);
    color: white;
    border-radius: 15px 15px 0 0;
    border-bottom: none;
    text-align: center;
}

.modal-title {
    font-weight: 600;
    font-family: 'Arial', sans-serif;
    font-size: 1.5rem;
    margin: 0 auto;
    text-align: center;
    width: 100%;
}

.modal-body {
    padding: 30px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.form-control:focus {
    border-color: #04DBC0;
    box-shadow: 0 0 0 0.2rem rgba(4, 219, 192, 0.25);
}

.btn-primary {
    background: #2c2c2c;
    border: none;
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    transition: transform 0.2s;
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    background: #1a1a1a;
    color: white;
}

.btn-secondary {
    background: #2c2c2c;
    border: none;
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    transition: transform 0.2s;
    color: white;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    background: #1a1a1a;
    color: white;
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
    border-radius: 0 0 15px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-footer a {
    color: #04DBC0;
    text-decoration: none;
}

.modal-footer a:hover {
    text-decoration: underline;
}
</style>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login to Access Your Bookings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm" action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
            <div class="modal-footer">
                <small><a href="#">Forgot Password?</a></small>
                <button type="button" class="btn btn-secondary btn-sm" onclick="switchToRegister()">Register</button>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Create New Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registerForm" action="register.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reg_email">Email</label>
                        <input type="email" class="form-control" id="reg_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="reg_password">Password</label>
                        <input type="password" class="form-control" id="reg_password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" target="_blank">Terms and Conditions</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                </form>
            </div>
            <div class="modal-footer">
                <small>Already have an account? <a href="#" onclick="switchToLogin()">Login here</a></small>
            </div>
        </div>
    </div>
</div>

<script>
// Handle login form submission
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    
    // Send to PHP
    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Close modal and redirect
            $('#loginModal').modal('hide');
            window.location.href = 'my-bookings.php';
        } else {
            alert('Login failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during login');
    });
});

// Handle register form submission
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Check if passwords match
    const password = document.getElementById('reg_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
    }
    
    // Get form data
    const formData = new FormData(this);
    
    // Send to PHP
    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Registration successful! You can now login.');
            $('#registerModal').modal('hide');
            $('#loginModal').modal('show');
            // Clear register form
            document.getElementById('registerForm').reset();
        } else {
            alert('Registration failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during registration');
    });
});

// Switch between login and register modals
function switchToLogin() {
    $('#registerModal').modal('hide');
    $('#loginModal').modal('show');
}

function switchToRegister() {
    $('#loginModal').modal('hide');
    $('#registerModal').modal('show');
}
</script>