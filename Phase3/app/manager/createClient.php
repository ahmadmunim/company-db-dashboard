

<html>
    <head>
        <title>Create Client </title>
    </head>

    <body>
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <!--Get Client ID-->
                <label>Client ID</label>
                <input type="text" name="getCid">
                <p></p>
                <!--Get first name-->
                <label>Client First Name</label>
                <input type ="text" name="getClientFname">
                <!--Get Last name-->
                <p></p>
                <label>Client Last Name</label>
                <input type="text" name="getClientLname">
                <p></p>
                <!--Get Client Email-->
                <label>Client Email</label>
                <input type="text" name="getClientEmail">
                <p></p>
                <!--Get Client Phone Number-->
                <label>Client Phone Number</label>
                <input type="text" name="getClientPhoneNumber">
                <p></p>
                <!--Get Client Project Name-->
                <label>Client Project Name</label>
                <input type="text" name="getClientProjectName">
                <p></p>
                <p></p>
                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitPayBtn">Exit</button>
                <p></p>
                <!--Save Button: create a new client-->
                <button type="submit" name="saveClientBtn">Save</button>
                <p></p>
            </form>
            
        </div>
    </body>
</html>
