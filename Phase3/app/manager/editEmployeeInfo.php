
<?php
session_start();
//fetch projects data
if (isset($_SESSION['editEmployeeInfo'])) {
    $editEmployeeInfo = $_SESSION['editEmployeeInfo'];


} else {
    $editEmployeeInfo = [];
}



?>

<html>
    <head>
        <title>Edit Employee Information </title>
    </head>

    <body>


        <!--View Client Based on ID-->
        <?php if (!empty($editEmployeeInfo)): ?>
            <table id="table">
            <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role Number</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th>Department Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($editEmployeeInfo as $row): ?>
                        <tr>
                            <td data-title="Employee ID"><?php echo $row["ssn"]; ?></td>
                            <td data-title="First Name"><?php echo ($row["fname"]); ?></td>
                            <td data-title="Last Name"><?php echo ($row["lname"]); ?></td>
                            <td data-title="Role Number"><?php echo ($row["RNo"]); ?></td>
                            <td data-title="Birthday"><?php echo ($row["Bdate"]); ?></td>
                            <td data-title="Gender"><?php echo ($row["Sex"]); ?></td>
                            <td data-title="Department Name"><?php echo ($row["Dname"]); ?></td>
                            <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                            <td data-title="Address"><?php echo ($row["Address"]); ?></td>
                            <td data-title="Phone Number"><?php echo ($row["Phone"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No employee information data available. </p>
        <?php endif; ?>
    
            <!--Buttons--> 
            <div class ="container">
            <form method ="POST" action="../../controller.php">
                <!--Edit Changes-->
                <label>Enter Employee ID</label>
                <input type="text" name="getEmpSSN">
                <!--<button type="submit" name="EmpSSN">Submit</button>-->
                <p></p>
                <!--Edit Role Number-->
                <p></p>
                <label>Edit Role Number</label>
                <input type="text" name="getNewRoleNumber" >
                
                <!--Edit Department Name-->
                <p></p>
                <label>Edit Department Number</label>
                <input type="text" name="getNewDeptNum" >

                <p></p>
                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitPayBtn">Exit</button>
                <p></p>
                <!--Save Button: create a new client-->
                <button type="submit" name="saveNewEmployeeInfo">Save</button>
                <p></p>

            </form>
            
        </div>
    </body>
</html>
