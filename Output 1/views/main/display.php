<?php require_once(APP_ROOT . '/views/includes/header.php'); ?>

<div class="container mt-3">
    <?php
        if(!(count($data) == 0)) { ?>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th width="30px">Action</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                        foreach($data as $value) { ?>
                            <tr>
                                <td><?php echo $value->student_fname; ?></td>
                                <td><?php echo $value->student_mname; ?></td>
                                <td><?php echo $value->student_lname; ?></td>
                                <td><?php echo $value->student_gender; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" onclick="edit(<?php echo $value->student_id; ?>)">Edit</button>
                                        <button type="button" class="btn btn-danger" onclick="del(<?php echo $value->student_id; ?>)">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
            </tbody>
        </table>

        <?php
        }
    ?>

</div>

<?php require_once('./views/includes/modals/index.php');?>
<?php require_once('./views/includes/scripts/mandatory_script.php');?>
<?php require_once('./views/includes/scripts/main_script.php');?>
<?php require_once(APP_ROOT . '/views/includes/footer.php'); ?>