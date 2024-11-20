

<html>
    <head>
        <title>Client Projects</title>
    </head>

    <body>
        <div class="editProjects">
            <h3>Edit Projects: </h3>

            <form method ="Post" action="../../controller.php">
                <!--Get old project name-->
                <p></p>
                <label for="oldProject">Enter a project you want to rename: </label>
                <!--use select html tag instead-->
                <input type="text" name="oldProjectName">
                
                <!--get new project name-->
                <p></p>
                <label for="newProject">Enter new name: </label>
                <input type="text" name ="newProjectName">

                <!--save button-->
                <p></p>
                <button type="submit" name="saveBtn">Save</button>
                <!--exit button-->
                <button type="submit" name="exitBtn">Exit</button>
                <p></p>
            </form>
        </div>
    </body>




    
</html>
