<?php require_once(APP_ROOT . '/views/includes/header.php'); ?>

<?php print_r(isset($data) ? $data : null);?>

<div class="container mt-3">
        <form id="frmInsert">
            <div class="card">
                <div class="card-header">
                    Student's Registration Form
                </div>

                <div class="card-body">
            
                    <div class="mb-3 mt-3">
                        <label for="fname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="mname" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" id="mname" placeholder="Enter Middle Name" name="mname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="lname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="gender" class="form-label">Gender:</label>
                        <select class="form-select" name="gender">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </form>
    </div>

<?php require_once('./views/includes/scripts/mandatory_script.php');?>
<?php require_once('./views/includes/scripts/main_script.php');?>
<?php require_once(APP_ROOT . '/views/includes/footer.php'); ?>