

<html>
    <head>
        <title>Client Projects</title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <div class="editProjects">

            <div class="form-container">
                <h1>Edit Project</h1>
                <form class="create-form" method="Post" action="../../controller.php">
                    <!--Get old project name-->
                    <p></p>
                    <label for="oldProject">Enter a project you want to rename: </label>
                    <!--use select html tag instead-->
                    <input type="text" name="oldProjectName">
                    
                    <!--get new project name-->
                    <label for="newProject">Enter new name: </label>
                    <input type="text" name ="newProjectName">

                    <!--save button-->
                    <button type="submit" name="saveBtn">Save</button>
                    <!--exit button-->
                    <button type="submit" name="exitBtn">Exit</button>
                </form>
            </div>
        </div>
    </body>




    
</html>
