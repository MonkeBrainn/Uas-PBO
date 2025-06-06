<?php
    session_start();

    //Page Title
    $pageTitle = 'Cars';

    //Includes
    include 'connect.php';
    include 'Includes/functions/functions.php'; 

    //Check If user is already logged in
    if(isset($_SESSION['username_yahya_car_rental']) && isset($_SESSION['password_yahya_car_rental']))
    {
        // Handle form submissions BEFORE any HTML output
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // ADD NEW CAR SUBMITTED
            if (isset($_POST['add_car_sbmt']))
            {
                $car_id = test_input($_POST['car_id']);
                $car_name = test_input($_POST['car_name']);
                $car_brand = test_input($_POST['car_brand']);
                $car_type = test_input($_POST['car_type']);
                $car_color = test_input($_POST['car_color']);
                $car_model = test_input($_POST['car_model']);
                $car_description = test_input($_POST['car_description']);

                try
                {
                    $stmt = $con->prepare("INSERT INTO cars(id, car_name, brand_id, type_id, color, model, description) VALUES(?,?,?,?,?,?,?) ");
                    $stmt->execute(array($car_id, $car_name, $car_brand, $car_type, $car_color, $car_model, $car_description));
                    
                    // Redirect to prevent form resubmission on refresh
                    header("Location: cars.php?success=1");
                    exit();
                }
                catch(Exception $e)
                {
                    $error_message = 'Error occurred: ' .$e->getMessage();
                }
            }

            // DELETE CAR SUBMITTED
            if (isset($_POST['delete_car_sbmt']))
            {
                $car_id = $_POST['car_id'];
                try
                {
                    $stmt = $con->prepare("DELETE FROM cars WHERE id = ?");
                    $stmt->execute(array($car_id));
                    
                    // Redirect to prevent form resubmission on refresh
                    header("Location: cars.php?deleted=1");
                    exit();
                }
                catch(Exception $e)
                {
                    $error_message = 'Error occurred: ' .$e->getMessage();
                }
            }

            // EDIT CAR SUBMITTED
            if (isset($_POST['edit_car_sbmt']))
            {
                $car_id = $_POST['edit_car_id'];
                $car_name = test_input($_POST['edit_car_name']);
                $car_brand = test_input($_POST['edit_car_brand']);
                $car_type = test_input($_POST['edit_car_type']);
                $car_color = test_input($_POST['edit_car_color']);
                $car_model = test_input($_POST['edit_car_model']);
                $car_description = test_input($_POST['edit_car_description']);

                try
                {
                    $stmt = $con->prepare("UPDATE cars SET car_name=?, brand_id=?, type_id=?, color=?, model=?, description=? WHERE id=?");
                    $stmt->execute(array($car_name, $car_brand, $car_type, $car_color, $car_model, $car_description, $car_id));
                    
                    // Redirect to prevent form resubmission on refresh
                    header("Location: cars.php?updated=1");
                    exit();
                }
                catch(Exception $e)
                {
                    $error_message = 'Error occurred: ' .$e->getMessage();
                }
            }
        }

        // Include header AFTER handling redirects
        include 'Includes/templates/header.php';
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
    
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Cars</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    Generate Report
                </a>
            </div>

            <!-- Status Messages -->
            <?php
                // Display success messages from redirects
                if(isset($_GET['success'])) {
                    echo "<div class = 'alert alert-success'>";
                        echo 'New Car has been inserted successfully';
                    echo "</div>";
                }
                if(isset($_GET['deleted'])) {
                    echo "<div class = 'alert alert-success'>";
                        echo 'Car has been deleted successfully';
                    echo "</div>";
                }
                if(isset($_GET['updated'])) {
                    echo "<div class = 'alert alert-success'>";
                        echo 'Car has been updated successfully';
                    echo "</div>";
                }
                
                // Display error messages if any
                if(isset($error_message)) {
                    echo "<div class = 'alert alert-danger'>";
                        echo $error_message;
                    echo "</div>";
                }
            ?>

            <!-- Cars Table -->
            <?php
                $stmt = $con->prepare("SELECT * FROM cars");
                $stmt->execute();
                $rows_cars = $stmt->fetchAll();

                $stmt = $con->prepare("SELECT * FROM car_brands");
                $stmt->execute();
                $rows_brands = $stmt->fetchAll(); 

                $stmt = $con->prepare("SELECT * FROM car_types");
                $stmt->execute();
                $rows_types = $stmt->fetchAll(); 
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cars</h6>
                </div>
                <div class="card-body">

                    <!-- ADD NEW CAR BUTTON -->
                    <button class="btn btn-success btn-sm" style="margin-bottom: 10px;" type="button" data-toggle="modal" data-target="#add_new_car" data-placement="top">
                        <i class="fa fa-plus"></i> 
                        Add New Car
                    </button>
                    <!-- Add New Car Modal -->
                    <div class="modal fade" id="add_new_car" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Car</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="cars.php" method = "POST" v-on:submit = "checkForm">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="car_id">Car ID</label>
                                            <input type="number" class="form-control" placeholder="Car ID" name="car_id" v-model = "car_id" required>
                                            <div class="invalid-feedback" style = "display:block" v-if="car_id === null">
                                                Car ID is required
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="car_name">Car Name</label>
                                            <input type="text" class="form-control" placeholder="Car Name" name="car_name" v-model = "car_name" required>
                                            <div class="invalid-feedback" style = "display:block" v-if="car_name === null">
                                                Car name is required
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="car_brand">Car Brand</label>
                                            <select name="car_brand" class = "custom-select" required>
                                                <?php
                                                    foreach($rows_brands as $brand)
                                                    {
                                                        echo "<option value = ".$brand['brand_id'].">";
                                                            echo $brand['brand_name'];
                                                        echo "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="car_type">Car Type</label>
                                            <select name="car_type" class = "custom-select" required>
                                                <?php
                                                    foreach($rows_types as $type)
                                                    {
                                                        echo "<option value = ".$type['type_id'].">";
                                                            echo $type['type_label'];
                                                        echo "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="car_color">Car Color</label>
                                            <input type="text" class="form-control" placeholder="Car Color" name="car_color" v-model = "car_color" required>
                                            <div class="invalid-feedback" style = "display:block" v-if="car_color === null">
                                                Car color is required
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="car_model">Car Model</label>
                                            <input type="text" class="form-control" placeholder="Car Model" name="car_model" v-model = "car_model" required>
                                            <div class="invalid-feedback" style = "display:block" v-if="car_model === null">
                                                Car model is required
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="car_description">Car Description</label>
                                            <textarea class="form-control" name="car_description" v-model = "car_description" required></textarea>
                                            <div class="invalid-feedback" style = "display:block" v-if="car_description === null">
                                                Car description is required
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-info" name="add_car_sbmt">Add Car</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Cars Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Car ID</th>
                                    <th>Car Name</th>
                                    <th>Brand</th>
                                    <th>Car Type</th>
                                    <th>Color</th>
                                    <th>Model</th>
                                    <th style = "width:30%">Description</th>
                                    <th>Manage</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                foreach($rows_cars as $car)
                                {
                                    echo "<tr>";
                                        echo "<td>";
                                            echo $car['id'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $car['car_name'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $car['brand_id'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $car['type_id'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $car['color'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $car['model'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $car['description'];
                                        echo "</td>";
                                        echo "<td>";
                                            $delete_data = "delete_".$car["id"];
                                            $edit_data = "edit_".$car["id"];
                                            ?>
                                            <!-- MANAGE BUTTONS -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item" data-toggle="tooltip" title="Edit">
                                                    <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $edit_data; ?>"><i class="fa fa-edit"></i></button>
                                                </li>
                                                <li class="list-inline-item" data-toggle="tooltip" title="Delete">
                                                    <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $delete_data; ?>" data-placement="top"><i class="fa fa-trash"></i></button>
                                                </li>
                                            </ul>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="<?php echo $edit_data; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Car</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="cars.php" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="edit_car_id" value="<?php echo $car['id']; ?>">
                                                                <div class="form-group">
                                                                    <label for="edit_car_name">Car Name</label>
                                                                    <input type="text" class="form-control" name="edit_car_name" value="<?php echo $car['car_name']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_car_brand">Car Brand</label>
                                                                    <select name="edit_car_brand" class="custom-select" required>
                                                                        <?php
                                                                            foreach($rows_brands as $brand)
                                                                            {
                                                                                $selected = ($brand['brand_id'] == $car['brand_id']) ? 'selected' : '';
                                                                                echo "<option value='".$brand['brand_id']."' $selected>";
                                                                                    echo $brand['brand_name'];
                                                                                echo "</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_car_type">Car Type</label>
                                                                    <select name="edit_car_type" class="custom-select" required>
                                                                        <?php
                                                                            foreach($rows_types as $type)
                                                                            {
                                                                                $selected = ($type['type_id'] == $car['type_id']) ? 'selected' : '';
                                                                                echo "<option value='".$type['type_id']."' $selected>";
                                                                                    echo $type['type_label'];
                                                                                echo "</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_car_color">Car Color</label>
                                                                    <input type="text" class="form-control" name="edit_car_color" value="<?php echo $car['color']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_car_model">Car Model</label>
                                                                    <input type="text" class="form-control" name="edit_car_model" value="<?php echo $car['model']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_car_description">Car Description</label>
                                                                    <textarea class="form-control" name="edit_car_description" required><?php echo $car['description']; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-info" name="edit_car_sbmt">Update Car</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="<?php echo $delete_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $delete_data; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Car</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="cars.php" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                                                Are you sure you want to delete this Car: <strong><?php echo $car['car_name']; ?></strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger" name="delete_car_sbmt">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  
<?php 
        
        //Include Footer
        include 'Includes/templates/footer.php';
    }
    else
    {
        header('Location: index.php');
        exit();
    }

?>

<script>

new Vue({
    el: "#add_new_car",
    data: {
        car_id: '',
        car_name: '',
        car_color: '',
        car_model: '',
        car_description: ''
    },
    methods:{
        checkForm: function(event){
            if(this.car_id && this.car_name && this.car_color && this.car_model && this.car_description)
            {
                return true;
            }
            
            if (!this.car_id)
            {
                this.car_id = null;
            }

            if (!this.car_name)
            {
                this.car_name = null;
            }

            if (!this.car_color)
            {
                this.car_color = null;
            }

            if (!this.car_model)
            {
                this.car_model = null;
            }

            if (!this.car_description)
            {
                this.car_description = null;
            }
            
            event.preventDefault();
        },
    }
})

</script>