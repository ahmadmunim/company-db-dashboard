
<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewEmptoManager'])) {
    $ManagerViewEmpBtn = $_SESSION['viewEmptoManager'];
} else {
    $ManagerViewEmpBtn = [];
}

?>

<html>
    <head>
        <title>View Employee Information </title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <h1>Hello Manager!</h1>
        <div class="container">
            <form class="menu-btn" method ="POST" action="../../controller.php">
                <!--Paystub Button-->
                <button type="submit" name="paystubBtn" >Paystub</button>
                <!--Get Employee  contact information button-->
                <button type="submit" name = "ManagerViewEmpBtn">View Employee Information</button>
                <!--View Client information -->
                <button type="submit" name="viewClientBtn">View Client Information</button>
                <!--Assign project--> 
                <button type = "submit" name="assignProject">Assign Projects</button>
            </form>   
        
            <div class="right-content">
                <h2>View Your Employees</h2>
                <!--Display the project results-->
                <?php if (!empty($ManagerViewEmpBtn)): ?>
                        <table id="table">
                            <thead>
                                <tr>
                                    <th>Employee SSN</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Role Number</th>
                                    <th>Gender</th>
                                    <th>Department Name</th>
                                    <th>Project</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ManagerViewEmpBtn as $row): ?>
                                    <tr>
                                        <td data-title="Employee SSN"><?php echo $row["ssn"]; ?></td>
                                        <td data-title="First Name"><?php echo ($row["fname"]); ?></td>
                                        <td data-title="Last Name"><?php echo ($row["lname"]); ?></td>
                                        <td data-title="Role Number"><?php echo ($row["RNo"]); ?></td>
                                        <td data-title="Gender"><?php echo ($row["Sex"]); ?></td>
                                        <td data-title="Department Name"><?php echo ($row["Dname"]); ?></td>
                                        <td data-title="Project Name"><?php echo ($row["Pname"]); ?></td>
                                        <td data-title="Phone Number"><?php echo ($row["Phone"]); ?></td>
                                        <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                                        <td data-title="Address"><?php echo ($row["Address"]); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No employee information data available. </p>
                    <?php endif; ?>
                    <form class="save-exit-btn" method ="POST" action="../../controller.php">
                        <!--Exit Button: Goes back to main.php-->
                        <button type="submit" name="exitPayBtn">Exit</button>
                        <!--Edit Button: Goes back to editEmployeeInfo.php-->
                        <button type="submit" name="EditEmployeeBtn">Edit</button>
                    </form>                        
            </div>
        </div>
    </body>
</html>
