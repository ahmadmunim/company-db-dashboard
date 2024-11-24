
<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewClientToManager'])) {
    $viewClientToManager = $_SESSION['viewClientToManager'];
} else {
    $viewClientToManager = [];
}

?>

<html>
    <head>
        <title>View Client Information </title>
    </head>

    <body>
        <!--Display the project results-->
        <?php if (!empty($viewClientToManager)): ?>
            <table id="table">
                <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Project Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($viewClientToManager as $row): ?>
                        <tr>
                            <td data-title="Client ID"><?php echo ($row["cid"]); ?></td>
                            <td data-title="First Name"><?php echo ($row["fname"]); ?></td>
                            <td data-title="Last Name"><?php echo ($row["lname"]); ?></td>
                            <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                            <td data-title="Phone Number"><?php echo ($row["Phone"]); ?></td>
                            <td data-title="Project Name"><?php echo ($row["Pname"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No client information data available. </p>
        <?php endif; ?>

        <!--Employee Buttons--> 
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <p></p>
                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitPayBtn">Exit</button>
                <p></p>
                <!--Create Button: create a new client-->
                <button type="submit" name="createClientBtn">Create</button>
                <p></p>
                <label>Enter Client ID to remove</label>
                <input name="delClientID" type = "text">
                <!--Delete Button: delete by client id-->
                <button type="submit" name="delClientBtn">Delete Client</button>
            </form>
            
        </div>
    </body>
</html>
