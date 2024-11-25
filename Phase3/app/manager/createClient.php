

<html>
    <head>
        <title>Create Client </title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <h1>Hello Manager!</h1>
        <div class ="form-container">
            <h2>Add a Client</h2>
            <form class="create-form" method ="POST" action="../../controller.php">
                <!--Get Client ID-->
                <label>Client ID</label>
                <input type="text" name="getCid">

                <!--Get first name-->
                <label>Client First Name</label>
                <input type ="text" name="getClientFname">
                
                <!--Get Last name-->
                <label>Client Last Name</label>
                <input type="text" name="getClientLname">


                <!--Get Client Email-->
                <label>Client Email</label>
                <input type="text" name="getClientEmail">

                <!--Get Client Phone Number-->
                <label>Client Phone Number</label>
                <input type="text" name="getClientPhoneNumber">

                <!--Get Client Project Name-->
                <label>Client Project Name</label>
                <input type="text" name="getClientProjectName">

                <!--Exit Button: Goes back to main.php-->
                <button type="submit" name="exitPayBtn">Exit</button>

                <!--Save Button: create a new client-->
                <button type="submit" name="saveClientBtn">Save</button>
            </form>
        </div>
    </body>
</html>
