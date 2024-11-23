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
    </head>

    <body>
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
        <form method="POST" action="../../controller.php">
            <button type="submit" name="createDependent">Create Dependent</button>
        </form>    
    </body>
</html>