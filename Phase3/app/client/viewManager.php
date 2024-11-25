<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewManager'])) {
    $viewManager = $_SESSION['viewManager'];
} else {
    $viewManager = [];
}

?>

<html>
    <head>
        <title>Manager Leading your Project </title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <h1>Hello Client!</h1>
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
                <h2>View Your Managers</h2>
                <?php if (!empty($viewManager)): ?>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Project Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($viewManager as $row): ?>
                                <tr>
                                    <td data-title="First Name"><?php echo ($row["Fname"]); ?></td>
                                    <td data-title="Last Name"><?php echo ($row["Lname"]); ?></td>
                                    <td data-title="Project Name"><?php echo ($row["Pname"]); ?></td>
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
                <form class="save-exit-btn" method ="POST" action="../../controller.php">
                    <!--Exit Button: Goes back to main.php-->
                    <input type="hidden" name="source" value="client">
                    <button type="submit" name="exitBtn">Exit</button>
                </form>
            </div>
        </div>
    </body>
</html>
