
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
    </head>

    <body>
        <!--Display the project results-->
        <?php if (!empty($ManagerViewEmpBtn)): ?>
            <table id="table">
                <thead>
                    <tr>
                        <th>Employee SSN</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role Number</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th>Department Name</th>
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
                            <td data-title="Birthday"><?php echo ($row["Bdate"]); ?></td>
                            <td data-title="Gender"><?php echo ($row["Sex"]); ?></td>
                            <td data-title="Department Name"><?php echo ($row["Dname"]); ?></td>
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

        <!--Employee Buttons--> 
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <p></p>
                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitPayBtn">Exit</button>
                <p></p>
                <!--Edit Button: Goes back to editEmployeeInfo.php-->
                <button type="submit" name="EditEmployeeBtn">Edit</button>
                <p></p>
            </form>
            
        </div>
    </body>
</html>
