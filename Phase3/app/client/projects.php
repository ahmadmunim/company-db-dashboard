<?php
session_start();
//fetch projects data
if (isset($_SESSION['projectData'])) {
    $projectData = $_SESSION['projectData'];
    unset($_SESSION['projectData']);
} else {
    $projectData = [];
}

?>
<html>
    <head>
        <title>Client Projects</title>
    </head>

    <body>
        <!--Display the project results-->
        <?php if (!empty($projectData)): ?>
            <table id="table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Start Date</th>
                        <th>Department Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projectData as $row): ?>
                        <tr>
                            <td data-title="Project Name"><?php echo ($row["Pname"]); ?></td>
                            <td data-title="Start Date"><?php echo ($row["Pstart_date"]); ?></td>
                            <td data-title="Department Name"><?php echo ($row["Dept_Name"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No project data available. </p>
        <?php endif; ?>

        <!--Projects Buttons--> 
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <p></p>
                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitBtn">Exit</button>
                <p></p>
                <!--Edit Button-->
                <button type="submit" name = "editBtn">Edit</button>
                <p></p>
            </form>
            
        </div>
    </body>
</html>
