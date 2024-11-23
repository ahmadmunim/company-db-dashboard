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
    </head>

    <body>
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
        <div class="emp-avg">

        </div>                       
    </body>
</html>