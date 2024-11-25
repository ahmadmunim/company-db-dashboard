<?php
session_start();
//fetch projects data
if (isset($_SESSION['projectData'])) {
    $projectData = $_SESSION['projectData'];
} else {
    $projectData = [];
}

?>
<html>
    <head>
        <title>Client Projects</title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <h1>Hello Client!</h1>
        <div class="container">
            <form class="menu-btn" method ="POST" action="../../controller.php">
                <!--Project Button-->
                <button type="submit" name="projectBtn" >Projects</button>
                <!--View Employee information button-->
                <button type="submit" name = "viewEmpBtn">View Employee Information</button>
                <!--View Manager information button -->
                <button type="submit" name="viewManagerBtn">View Manager Information</button>
            </form>  
            
            <div class="right-content">
                <h2>View Your Projects</h2>
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
                <form class="save-exit-btn" method ="POST" action="../../controller.php">
                    <!--Exit Button: Goes back to main.php-->
                    <button type="submit" name="exitBtn">Exit</button>
                    <!--Edit Button-->
                    <button type="submit" name = "editBtn">Edit</button>
                </form>
            </form>                
            </div>
        </div>
    </body>
</html>
