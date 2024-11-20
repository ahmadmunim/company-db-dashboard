<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewManager'])) {
    $viewManager = $_SESSION['viewManager'];
    unset($_SESSION['viewManager']);
} else {
    $viewManager = [];
}

?>

<html>
    <head>
        <title>Manager Leading your Project </title>
    </head>

    <body>
        <!--Display the project results-->
        <?php if (!empty($viewManager)): ?>
            <table id="table">
                <thead>
                    <tr>
                        <th>Mgr_ssn</th>
                        <th>Project Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($viewManager as $row): ?>
                        <tr>
                            <td data-title="Mgr_ssn"><?php echo ($row["Mgr_ssn"]); ?></td>
                            <td data-title="Pname"><?php echo ($row["Pname"]); ?></td>
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
