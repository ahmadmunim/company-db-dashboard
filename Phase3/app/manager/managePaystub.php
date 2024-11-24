<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewPaystub'])) {
    $viewPaystub = $_SESSION['viewPaystub'];
    unset($_SESSION['viewPaystub']);
} else {
    $viewPaystub = [];
}



?>

<html>
    <head>
        <title>Manage Employee Paystub </title>
    </head>

    <body>
        <!--Display the project results-->
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

        <!--Employee Buttons--> 
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <p></p>
                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitPayBtn">Exit</button>
                <p></p>

                <!--Create Button: Goes back to createPaystub.php-->
                <button type="submit" name="createBtn">Create</button>
                <p></p>


            
                <!--Delete Button: Goes back to main.php
                   
                -->
                <Label>Enter Paystub ID to remove</Label>
                <input name="getPayID" type = "text">
                <button type="submit" name="toDelBtn">Delete</button>
                <p></p>

            </form>
            
        </div>
    </body>
</html>
