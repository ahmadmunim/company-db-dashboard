<?php
    session_start();

    if(isset($_SESSION['viewPaystubs'])) {
        $viewPaystubs = $_SESSION['viewPaystubs'];
    } else {
        $viewPaystubs = [];
    }
?>

<html>
    <head>
        <title>Your Paystubs</title>
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
                <h2>View Your Paystubs</h2>
                <?php if(!empty($viewPaystubs)): ?>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Gross Pay</th>
                                <th>Deductions</th>
                                <th>Netpay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($viewPaystubs as $row): 
                                if (!(in_array("AVG(Net_pay)", array_keys($row)))) {?>
                                    <tr>
                                        <td data-title="Start Date"><?php echo ($row["Start_date"]); ?></td>
                                        <td data-title="End Date"><?php echo ($row["End_date"]); ?></td>
                                        <td data-title="Gross Pay"><?php echo ($row["Gross_pay"]); ?></td>
                                        <td data-title="Deductions"><?php echo ($row["Deductions"]); ?></td>
                                        <td data-title="Netpay"><?php echo ($row["Net_pay"]); ?></td>                        
                                    </tr>
                                <?php } ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p><?php echo "The average pay of all employees is: " . number_format(end($viewPaystubs)["AVG(Net_pay)"], 2); ?></p>
                <?php else: ?>
                    <p>No paystubs data available. </p>
                <?php endif; ?>
                <form class="save-exit-btn" method="POST" action="../../controller.php">
                    <button type="submit" name="exitBtn">Exit</button>
                </form>                 
            </div>
        </div>                      
    </body>
</html>