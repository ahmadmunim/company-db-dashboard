<?php 
    session_start();
    if(isset($_SESSION['viewClients'])) {
        $viewClients = $_SESSION['viewClients'];
    } else {
        $viewClients = [];
    }
?>

<html>
    <head>
        <title>Your Clients</title>
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

            <div class="right-content">
                <h2>View Your Clients</h2>
                <?php if(!empty($viewClients)): ?>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Assigned Project</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($viewClients as $row): ?>
                                <tr>
                                    <td data-title="First Name"><?php echo ($row["Fname"]); ?></td>
                                    <td data-title="Last Name"><?php echo ($row["Lname"]); ?></td>
                                    <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                                    <td data-title="Phone Number"><?php echo ($row["Phone"]); ?></td>
                                    <td data-title="Assigned Project"><?php echo ($row["Pname"]); ?></td>                        
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No client data available. </p>    
                <?php endif; ?> 
                <form class="save-exit-btn" method="POST" action="../../controller.php">
                    <input type="hidden" name="source" value="employee">
                    <button type="submit" name="exitBtn">Exit</button>
                </form>                               
            </div>
        </div>
    </body>
</html>