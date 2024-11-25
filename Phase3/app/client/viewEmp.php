<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewEmp'])) {
    $viewEmp = $_SESSION['viewEmp'];
} else {
    $viewEmp = [];
}

?>

<html>
    <head>
        <title>Employee Informtion</title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <h1>Hello Client!</h1>
        <!--Display the project results-->
        <div class="container">
            <form class="menu-btn" method ="POST" action="../../controller.php">
                <!--Project Button-->
                <button type="submit" name="projectBtn" >Projects</button>
                <!--View Employee information button-->
                <button type="submit" name = "viewEmpBtn">View Employee Information</button>
                <!--View Manager information button -->
                <button type="submit" name="viewManagerBtn">View Manager Information</button>
            </form>  
            
            <div class="right-content">
                <h2>View Your Employees</h2>
                <?php if (!empty($viewEmp)): ?>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($viewEmp as $row): ?>
                                <tr>
                                    <td data-title="Project Name"><?php echo ($row["Pname"]); ?></td>
                                    <td data-title="First Name"><?php echo ($row["Fname"]); ?></td>
                                    <td data-title="Last Name"><?php echo ($row["Lname"]); ?></td>
                                    <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                                    <td data-title="Address"><?php echo ($row["Address"]); ?></td>
                                    <td data-title="Phone"><?php echo ($row["Phone"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No employee data available. </p>
                <?php endif; ?>
                <form class="save-exit-btn" method ="POST" action="../../controller.php">
                    <!--Exit Button: Goes back to main.php-->
                    <input type="hidden" name="source" value="client">
                    <button type="submit" name="exitBtn">Exit</button>
                </form>
            </div>
        </div>


        <!--Employee Buttons--> 
        <div class ="container">
            
        </div>
    </body>
</html>
