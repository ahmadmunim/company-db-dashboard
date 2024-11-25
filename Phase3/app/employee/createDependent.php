<html>
    <head>
        <title>Create Dependent</title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <div class="form-container">
            <h2>Create Dependent</h2>
            <form class="create-form" method="POST" action="../../controller.php">
                <label for="dependentName">Dependent Name:</label>
                <input type="text" name="Dependent_name" id="dependentName">

                <label for="sex">Sex:</label>
                <input type="text" name="Sex" id="dependentName">

                <label for="birthday">Date of Birth:</label>
                <input type="date" name="Bdate" id="birthday">

                <label for="relationship">Relationship:</label>
                <input type="text" name="Relationship" id="relationship">

                <button type="submit" name="submitDependent">Save</button>

                <input type="hidden" name="source" value="dependents">
                <button type="submit" name="exitBtn">Exit</button>
            </form>
        </div>
    </body>
</html>