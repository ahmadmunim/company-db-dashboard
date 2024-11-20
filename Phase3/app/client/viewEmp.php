<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewEmp'])) {
    $viewEmp = $_SESSION['viewEmp'];
    unset($_SESSION['viewEmp']);
} else {
    $viewEmp = [];
}

?>

<html>
    <head>
        <title>Employee Informtion</title>
    </head>

    <body>
        <!--Display the project results-->
        <?php if (!empty($viewEmp)): ?>
            <table id="table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>SSN</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($viewEmp as $row): ?>
                        <tr>
                            <td data-title="Project Name"><?php echo ($row["Pname"]); ?></td>
                            <td data-title="SSN"><?php echo ($row["Ssn"]); ?></td>
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

        <!--Employee Buttons--> 
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <p></p>
                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitBtn">Exit</button>
                <p></p>
            </form>
            
        </div>
    </body>
</html>
