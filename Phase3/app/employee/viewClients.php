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
    </head>

    <body>
        <h1>Your Clients</h1>
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
    </body>
</html>