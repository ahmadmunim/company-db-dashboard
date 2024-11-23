<?php
    session_start();

    if(isset($_SESSION['viewEmpInDept'])) {
        $viewEmpInDept = $_SESSION['viewEmpInDept'];
    } else {
        $viewEmpInDept = [];
    }
?>

<html>
    <head>
        <title>Your Employees</title>
    </head>

    <body>
        <h1>Your Fellow Employees</h1>
        <?php if(!empty($viewEmpInDept)): ?>
                <table id="table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Assigned Project</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewEmpInDept as $row): ?>
                            <tr>
                                <td data-title="First Name"><?php echo ($row["Fname"]); ?></td>
                                <td data-title="Last Name"><?php echo ($row["Lname"]); ?></td>
                                <td data-title="Role Name"><?php echo ($row["Rname"]); ?></td>
                                <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                                <td data-title="Phone Number"><?php echo ($row["Phone"]); ?></td>
                                <td data-title="Address"><?php echo ($row["Address"]); ?></td>
                                <td data-title="Assigned Project"><?php echo ($row["Pname"]); ?></td>                        
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No employee data available. </p>    
        <?php endif; ?>        
    </body>
</html>