<?php
// File: my-bookings.php
include "connect.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";
include "Includes/functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
    $cancel_id = intval($_POST['cancel_id']);
    $cancel_sql = "UPDATE reservations SET canceled = 1, cancellation_reason = 'Canceled by user' WHERE reservation_id = $cancel_id";
    $conn->query($cancel_sql);
}

$sql = "
SELECT r.reservation_id, c.full_name, car.car_name, r.pickup_date, r.return_date, 
       r.pickup_location, r.return_location, r.canceled
FROM reservations r
LEFT JOIN clients c ON r.client_id = c.client_id
LEFT JOIN cars car ON r.car_id = car.id
ORDER BY r.pickup_date DESC
";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        table { width: 90%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #f5f5f5; }
        .canceled { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2 style="text-align:center; margin-top:20px;">Your Reservations</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Client Name</th>
                    <th>Car Name</th>
                    <th>Pickup Date</th>
                    <th>Return Date</th>
                    <th>Pickup Location</th>
                    <th>Return Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['reservation_id'] ?></td>
                        <td><?= $row['client_name'] ?? 'Unknown Client' ?></td>
                        <td><?= $row['car_name'] ?? 'Unknown Car' ?></td>
                        <td><?= $row['pickup_date'] ?></td>
                        <td><?= $row['return_date'] ?></td>
                        <td><?= $row['pickup_location'] ?></td>
                        <td><?= $row['return_location'] ?></td>
                        <td class="<?= $row['canceled'] ? 'canceled' : '' ?>">
                            <?= $row['canceled'] ? 'Canceled' : 'Active' ?>
                        </td>
                        <td>
                            <?php if (!$row['canceled']): ?>
                                <form method="post" style="margin:0;">
                                    <input type="hidden" name="cancel_id" value="<?= $row['reservation_id'] ?>">
                                    <button type="submit">Cancel</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No reservations found.</p>
    <?php endif; ?>
</body>
</html>
        

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #000;
        }
        .banner {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center;
            background-size: cover;
            padding: 20px 0;
            color: white;
            text-align: center;
            position: relative;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .banner h1 {
            font-size: 2em;
            margin: 0;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        .container {
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }
        .card-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            color: #000;
        }
        .card i {
            font-size: 1.5em;
            color: #000;
        }
        .card span {
            display: block;
            font-weight: bold;
            margin-top: 5px;
        }
        .booking {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(40, 41, 42, 0.87);
            margin-bottom: 20px;
            color: #000;
        }
        .booking h3 {
            margin-top: 0;
        }
        .actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .actions button, .actions a {
            padding: 8px 16px;
            border: none;
            background-color: #000;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }
        .actions button:hover, .actions a:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }
        .actions button.cancel {
            background-color: #e74c3c;
        }
        .actions button.cancel:hover {
            background-color: #c0392b;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { 
                transform: translateY(-50px);
                opacity: 0;
            }
            to { 
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .modal-content {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            margin: auto;
            padding: 0;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            width: 500px;
            max-width: 90%;
            text-align: center;
            color: #000;
            animation: slideIn 0.3s ease-out;
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 25px;
            position: relative;
        }
        
        .modal-header h3 {
            margin: 0;
            font-size: 1.5em;
            font-weight: 600;
        }
        
        .modal-header i {
            font-size: 3em;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .modal-body {
            padding: 30px;
        }
        
        .modal-body p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        
        .modal-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .modal-actions button {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }
        
        .modal-actions button[type="submit"] {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        
        .modal-actions button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }
        
        .modal-actions button[type="button"] {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3);
        }
        
        .modal-actions button[type="button"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(149, 165, 166, 0.4);
        }
        
        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        
        .close:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        
        .warning-icon {
            color: #f39c12;
            font-size: 4em;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .modal.show {
            display: block;
        }
        
        @media (max-width: 600px) {
            .modal-content {
                width: 95%;
                margin: 20px auto;
            }
            
            .modal-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .modal-actions button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Banner Section -->
    <div class="banner">
        <h1>Your Bookings</h1>
    </div>

    <div class="container">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="booking">
                <h3><?= htmlspecialchars($row['full_name']) ?> - <?= htmlspecialchars($row['car_name']) ?></h3>
                <div class="card-row">
                    <div class="card"><i class="fas fa-calendar-alt"></i> Pickup Date:<span><?= htmlspecialchars($row['pickup_date']) ?></span></div>
                    <div class="card"><i class="fas fa-calendar-alt"></i> Return Date:<span><?= htmlspecialchars($row['return_date']) ?></span></div>
                    <div class="card"><i class="fas fa-map-marker-alt"></i> Pickup Location:<span><?= htmlspecialchars($row['pickup_location']) ?></span></div>
                    <div class="card"><i class="fas fa-map-marker-alt"></i> Return Location:<span><?= htmlspecialchars($row['return_location']) ?></span></div>
                </div>
                <div class="actions">
                    <?php if (!$row['canceled']): ?>
                        <button class="cancel" onclick="openModal(<?= $row['reservation_id'] ?>)">Cancel</button>
                        <a href="payment.php?reservation_id=<?= $row['reservation_id'] ?>">Proceed to Payment</a>
                    <?php else: ?>
                        <span style="color:red">Canceled</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
    </div>

    <!-- Modal -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">&times;</span>
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Cancel Reservation</h3>
            </div>
            <div class="modal-body">
                <div class="warning-icon">
                    <i class="fas fa-ban"></i>
                </div>
                <p>Are you sure you want to cancel this reservation?<br>
                <small style="color: #888;">This action cannot be undone.</small></p>
                <form method="POST">
                    <input type="hidden" id="cancel_id" name="cancel_id" value="">
                    <div class="modal-actions">
                        <button type="submit">Yes, Cancel</button>
                        <button type="button" onclick="closeModal()">Keep Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById('cancel_id').value = id;
            const modal = document.getElementById('cancelModal');
            modal.style.display = 'block';
            setTimeout(() => modal.classList.add('show'), 10);
        }

        function closeModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 300);
        }

        window.onclick = function(event) {
            let modal = document.getElementById('cancelModal');
            if (event.target === modal) {
                closeModal();
            }
        }
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>

<?php include "Includes/templates/footer.php"; ?>
</body>
</html>

<?php $conn->close(); ?>