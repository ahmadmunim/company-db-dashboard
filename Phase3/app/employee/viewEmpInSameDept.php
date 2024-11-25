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
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
    <h1>Hello Employee!</h1>
    <div class="container">
        <!-- Left Buttons Section -->
        <form class="menu-btn" method="POST" action="../../controller.php">
            <button type="submit" name="viewDependentsBtn">Dependent</button>
            <button type="submit" name="viewContactBtn">Change Contact Information</button>
            <button type="submit" name="viewPaystubsBtn">View Paystubs</button>
            <button type="submit" name="viewClientsBtn">View Client Information</button>
            <button type="submit" name="viewEmpInDeptBtn">View Employee Information</button>
        </form>

        <!-- Right Content Section -->
        <div class="right-content">
            <h2>View Employees in your Department</h2>
            <?php if(!empty($viewEmpInDept)): ?>
                <table id="table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($viewEmpInDept as $row): ?>
                            <tr>
                                <td data-title="First Name"><?php echo ($row["Fname"]); ?></td>
                                <td data-title="Last Name"><?php echo ($row["Lname"]); ?></td>
                                <td data-title="Role Name"><?php echo ($row["Rname"]); ?></td>
                                <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                                <td data-title="Phone"><?php echo ($row["Phone"]); ?></td>
                                <td data-title="Address"><?php echo ($row["Address"]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No employee data available. </p>
            <?php endif; ?>
            <form class="save-exit-btn" method="POST" action="../../controller.php">
                <input type="hidden" name="source" value="employee">
                <button type="submit" name="exitBtn">Exit</button>
            </form>             
        </div>
    </div>
</body>
</html>