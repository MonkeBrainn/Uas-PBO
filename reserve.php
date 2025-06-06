<?php
	session_start();
    include "connect.php";
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";
	include "Includes/functions/functions.php";

	if (isset($_POST['reserve_car']) && $_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$_SESSION['pickup_location'] = test_input($_POST['pickup_location']);
		$_SESSION['return_location'] = test_input($_POST['return_location']);
		$_SESSION['pickup_date'] = test_input($_POST['pickup_date']);
		$_SESSION['return_date'] = test_input($_POST['return_date']);
	}
?>

<!-- Link to external CSS file -->
<link rel="stylesheet" href="Design/css/reserve-styles.css">

<!-- HERO SECTION WITH BACKGROUND -->
<div class="hero-section">
	<div class="hero-overlay">
		<div class="container">
			<div class="hero-content">
				<h1 class="hero-title">RESERVE YOUR CAR</h1>
			</div>
		</div>
	</div>
</div>

<!-- RESERVATION SECTION -->
<section class="reservation-section">
	<div class="container">
		<?php
			if(isset($_POST['submit_reservation']) && $_SERVER['REQUEST_METHOD'] === 'POST')
			{
				$selected_car = $_POST['selected_car'];
				$full_name = test_input($_POST['full_name']);
				$client_email = test_input($_POST['client_email']);
				$client_phonenumber = test_input($_POST['client_phonenumber']);
				$pickup_location = $_SESSION['pickup_location'];
				$return_location = $_SESSION['return_location'];
				$pickup_date = $_SESSION['pickup_date'];
				$return_date = $_SESSION['return_date'];
				
				$con->beginTransaction();

                try
                {
					//Getting Client Table Current ID
					$stmtgetCurrentClientID = $con->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'car_rental' AND TABLE_NAME = 'clients'");
            
					$stmtgetCurrentClientID->execute();
					$client_id = $stmtgetCurrentClientID->fetch();
					
					//Inserting Client Details
					$stmtClient = $con->prepare("insert into clients(full_name,client_email,client_phone) 
									values(?,?,?)");
					$stmtClient->execute(array($full_name,$client_email,$client_phonenumber));

					//Inserting Reservation Details
					$stmt_appointment = $con->prepare("insert into reservations(client_id, car_id, pickup_date, return_date, pickup_location, return_location ) values(?, ?, ?, ?, ?, ?)");
                    $stmt_appointment->execute(array($client_id[0],$selected_car,$pickup_date,$return_date,$pickup_location,$return_location));
					
					echo "<div class='success-message'>";
                        echo "<i class='fas fa-check-circle'></i>";
                        echo "<h3>Reservation Successful!</h3>";
                        echo "<p>Great! Your reservation has been created successfully.</p>";
                    echo "</div>";

					$con->commit();
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    echo "<div class='error-message'>"; 
                        echo "<i class='fas fa-exclamation-triangle'></i>";
                        echo "<h3>Reservation Failed</h3>";
                        echo "<p>" . $e->getMessage() . "</p>";
                    echo "</div>";
                }
			}
			elseif (isset($_SESSION['pickup_date']) && isset($_SESSION['return_date']))
			{
				$pickup_location = $_SESSION['pickup_location'];
				$return_location = $_SESSION['return_location'];
				$pickup_date = $_SESSION['pickup_date'];
				$return_date = $_SESSION['return_date'];

				$stmt = $con->prepare("SELECT *
				from cars, car_brands, car_types
				where cars.brand_id = car_brands.brand_id and cars.type_id = car_types.type_id and 
						cars.id not in (select car_id 
									 from reservations
									 where (? between pickup_date and return_date 
										 or ? BETWEEN pickup_date and return_date )
										 and canceled = 0
									 )");
                $stmt->execute(array($pickup_date, $return_date));
                $available_cars = $stmt->fetchAll();
				?>
				
				<!-- RESERVATION DETAILS -->
				<div class="reservation-details">
					<div class="detail-cards">
						<div class="detail-card">
							<i class="fas fa-calendar-alt"></i>
							<div class="detail-info">
								<span class="detail-label">Pickup Date :</span>
								<span class="detail-value"><?php echo date('Y-m-d', strtotime($_SESSION['pickup_date'])); ?></span>
							</div>
						</div>
						<div class="detail-card">
							<i class="fas fa-calendar-alt"></i>
							<div class="detail-info">
								<span class="detail-label">Return Date :</span>
								<span class="detail-value"><?php echo date('Y-m-d', strtotime($_SESSION['return_date'])); ?></span>
							</div>
						</div>
						<div class="detail-card">
							<i class="fas fa-map-marker-alt"></i>
							<div class="detail-info">
								<span class="detail-label">Pickup Location :</span>
								<span class="detail-value"><?php echo $_SESSION['pickup_location']; ?></span>
							</div>
						</div>
						<div class="detail-card">
							<i class="fas fa-map-marker-alt"></i>
							<div class="detail-info">
								<span class="detail-label">Return Location :</span>
								<span class="detail-value"><?php echo $_SESSION['return_location']; ?></span>
							</div>
						</div>
					</div>
				</div>

				<!-- RESERVATION FORM -->
				<div class="reservation-form-container">
					<div class="form-section">
						<form action="reserve.php" method="POST" id="reservation_second_form" v-on:submit="checkForm">
							<div class="form-content">
								
								<!-- CAR SELECTION SECTION -->
								<div class="car-selection-section">
									<h3>Select Your Vehicle</h3>
									<div class="cars-grid">
										<?php
											if(count($available_cars) > 0) {
												foreach($available_cars as $car)
												{
													echo "<div class='car-card'>";
														echo "<div class='car-info'>";
															echo "<h4>" . $car['car_name'] . "</h4>";
															echo "<p class='car-brand'>" . $car['brand_name'] . " - " . $car['type_label'] . "</p>";
														echo "</div>";
														echo "<div class='car-select'>";
															echo "<label class='car-radio'>";
																echo "<input type='radio' name='selected_car' v-model='selected_car' value='" . $car['id'] . "'>";
																echo "<span class='radio-custom'></span>";
																echo "<span class='select-text'>Select</span>";
															echo "</label>";
														echo "</div>";
													echo "</div>";
												}
											} else {
												echo "<div class='no-cars-message'>";
													echo "<i class='fas fa-car'></i>";
													echo "<p>No vehicles available for the selected dates.</p>";
												echo "</div>";
											}
										?>
									</div>
									<div class="error-message" v-if="selected_car === null && formSubmitted">
										<i class="fas fa-exclamation-circle"></i>
										Please select a vehicle
									</div>
								</div>

								<!-- CLIENT DETAILS SECTION -->
								<div class="client-details-section">
									<h3>Customer Information</h3>
									<div class="form-fields">
										<div class="form-group">
											<label for="full_name">Full Name</label>
											<input type="text" class="form-control" placeholder="John Doe" name="full_name" v-model="full_name">
											<div class="error-message" v-if="full_name === null && formSubmitted">
												<i class="fas fa-exclamation-circle"></i>
												Full name is required
											</div>
										</div>
										
										<div class="form-group">
											<label for="client_email">E-mail</label>
											<input type="email" class="form-control" name="client_email" placeholder="abc@mail.xyz" v-model="client_email">
											<div class="error-message" v-if="client_email === null && formSubmitted">
												<i class="fas fa-exclamation-circle"></i>
												E-mail is required
											</div>
										</div>
										
										<div class="form-group">
											<label for="client_phonenumber">Phone Number</label>
											<input type="text" name="client_phonenumber" placeholder="0123456789" class="form-control" v-model="client_phonenumber">
											<div class="error-message" v-if="client_phonenumber === null && formSubmitted">
												<i class="fas fa-exclamation-circle"></i>
												Phone number is required
											</div>
										</div>
									</div>
									
									<button type="submit" class="btn-book-instantly" name="submit_reservation">
										<i class="fas fa-car"></i>
										Book Instantly
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<?php
			}
			else
			{
				?>
				<div class="no-dates-container">
					<div class="no-dates-message">
						<i class="fas fa-calendar-times"></i>
						<h3>Missing Reservation Details</h3>
						<p>Please select pickup and return dates first.</p>
						<a href="./#reserve" class="btn-homepage">
							<i class="fas fa-home"></i>
							Go to Homepage
						</a>
					</div>
				</div>
				<?php
			}
		?>
	</div>
</section>

<?php include "Includes/templates/footer.php"; ?>

<!-- Link to external JavaScript file -->
<script src="Design/js/reserve-script.js"></script>