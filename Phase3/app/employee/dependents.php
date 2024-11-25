<?php
    session_start();
    //fetch dependents data
    if (isset($_SESSION['viewDependents'])) {
        $viewDependents = $_SESSION['viewDependents'];
    } else {
        $viewDependents = [];
    }
?>

<html>
    <head>
        <title>Your Dependents</title>
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
                <h2>View Your Dependents</h2>
                <?php if(!empty($viewDependents)): ?>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Dependent Name</th>
                                <th>Sex</th>
                                <th>Birthday</th>
                                <th>Relationship</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($viewDependents as $row): ?>
                                <tr>
                                    <td data-title="Dependent Name"><?php echo ($row["Dependent_name"]); ?></td>
                                    <td data-title="Sex"><?php echo ($row["Sex"]); ?></td>
                                    <td data-title="Birthday"><?php echo ($row["Bdate"]); ?></td>
                                    <td data-title="Relationship"><?php echo ($row["Relationship"]); ?></td>                        
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No dependents data available. </p>
                <?php endif; ?>
                <form class="save-exit-btn" method="POST" action="../../controller.php">
                    <button type="submit" name="createDependent">Create Dependent</button>
                    <button type="submit" name="exitBtn">Exit</button>
                </form>
            </div>
        </div>    
    </body>
</html>