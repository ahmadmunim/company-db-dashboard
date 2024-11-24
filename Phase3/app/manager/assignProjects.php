<?php
session_start();
//fetch projects data
if (isset($_SESSION['viewClientProject'])) {
    $viewClientProject = $_SESSION['viewClientProject'];
    //unset($_SESSION['viewClientProject']);
} else {
    $viewClientProject = [];
}

?>

<html>
    <head>
        <title>Assign Client to Project </title>
    </head>

    <body>
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <!--Get Client ID-->
                <label>Client ID</label>
                <input type="text" name="getAssignCid">
                <p></p>
                <!--Get Project name-->
                <label>Project Name</label>
                <input type ="text" name="getAssignProjectName">
                <p></p>
                <!--Assign Button: Assign a client to project-->
                <button type="submit" name="assignClientToProject">Assign</button>
                <p></p>
            </form>
            
        </div>

        <!--Display the project results-->
        <?php if (!empty($viewClientProject)): ?>
            <table id="table">
                <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Gave Project</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($viewClientProject as $row): ?>
                        <tr>
                            <td data-title="Client ID"><?php echo ($row["Cid"]); ?></td>
                            <td data-title="Gave Project"><?php echo ($row["Gave_project"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No client project information data available. </p>
        <?php endif; ?>

    </body>
</html>
