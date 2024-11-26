
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
                <!--Logout-->
                <button type="submit" name="logout">Logout</button>
            </form>   
            <div class="right-content">
                <h2>View Your Clients</h2>
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
                <form class="save-exit-btn" method ="POST" action="../../controller.php">
                    <!--Delete Button: delete by client id-->                        
                    <label>Enter Client ID to remove</label>
                    <input name="delClientID" type = "text">
                    <button type="submit" name="delClientBtn">Delete Client</button>
                    <!--Exit Button: Goes back to main.php-->
                    <button type="submit" name="exitPayBtn">Exit</button>
                    <!--Create Button: create a new client-->
                    <button type="submit" name="createClientBtn">Create</button>
                </form>              
            </div>          
        </div>


        <!--Employee Buttons--> 
        <div class ="container">
            
        </div>
    </body>
</html>
