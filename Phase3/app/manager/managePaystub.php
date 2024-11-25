<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewPaystub'])) {
    $viewPaystub = $_SESSION['viewPaystub'];
} else {
    $viewPaystub = [];
}

?>

<html>
    <head>
        <title>Manage Employee Paystub </title>
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
            </form>  
            <div class="right-content">
                <!--Display the project results-->
                <h2>View Your Employee's Paystubs</h2>
                <?php if (!empty($viewPaystub)): ?>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Paystub ID</th>
                                <th>Employee SSN</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Gross Pay</th>
                                <th>Deductions</th>
                                <th>Netpay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($viewPaystub as $row): ?>
                                <tr>
                                    <td data-title="Paystub ID"><?php echo $row["Paystub_id"]; ?></td>
                                    <td data-title="Ssn"><?php echo ($row["Ssn"]); ?></td>
                                    <td data-title="Start_date"><?php echo ($row["Start_date"]); ?></td>
                                    <td data-title="End_date"><?php echo ($row["End_date"]); ?></td>
                                    <td data-title="Gross_pay"><?php echo ($row["Gross_pay"]); ?></td>
                                    <td data-title="Deductions"><?php echo ($row["Deductions"]); ?></td>
                                    <td data-title="Netpay"><?php echo ($row["Net_pay"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No employee paystub data available. </p>
                <?php endif; ?>
                <form class="save-exit-btn" method ="POST" action="../../controller.php">
                    
                    <!--Delete Button: Goes back to main.php-->
                    <Label>Enter Paystub ID to remove</Label>
                    <input name="getPayID" type = "text">
                    <button type="submit" name="toDelBtn">Delete</button>                    
                    
                    <!--Exit Button: Goes back to main.php-->
                    <button type="submit" name="exitPayBtn">Exit</button>

                    <!--Create Button: Goes back to createPaystub.php-->
                    <button type="submit" name="createBtn">Create</button>
                
                </form>
            </div>            
        </div>

        <!--Employee Buttons--> 
    </body>
</html>
