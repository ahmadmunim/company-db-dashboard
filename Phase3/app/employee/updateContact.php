<?php
    session_start();
    
    if(isset($_SESSION['viewContact'])) {
        $getContact = $_SESSION['viewContact'];
    } else {
        $getContact = [];
    }
?>

<html>
    <head>
        <title>Change Contact</title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <h1>Hello Employee!</h1>
        <h2>Your Contact Information</h2>
        <?php if(!empty($getContact)): ?>
            <table id="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($getContact as $row): ?>
                        <tr>
                            <td data-title="Email"><?php echo ($row["Email"]); ?></td>
                            <td data-title="Phone Number"><?php echo ($row["Phone"]); ?></td>
                            <td data-title="Address"><?php echo ($row["Address"]); ?></td>                        
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No contact data available. </p>    
        <?php endif; ?>  

        <div class="form-container">
            <form class="create-form" method="POST" action="../../controller.php">
                <label for="Email">New Email Address</label>
                <input type="email" name="Email" id="">
                
                <label for="Phone">New Phone Number</label>
                <input type="text" name="Phone" id="">
                
                <label for="Address">New Address</label>
                <input type="text" name="Address" id="">

                <button type="submit" name="changeContactBtn">Update</button>
            </form>
        </div>
    </body>
</html>