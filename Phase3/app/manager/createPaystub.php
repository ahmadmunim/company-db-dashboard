

<html>
    <head>
        <title>Create Employee Paystub </title>
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
       
        <!--Create Paystub Form--> 
        <div class ="form-container">
            <h2>Create Paystub</h2>
            <form class="create-form" method ="POST" action="../../controller.php">
                <!--Enter Employee SSN-->
                <label>Enter Employee SSN</label>
                <input type ="text" name="getSsn">
                
                <!--Enter start date-->
                <label>Enter Start Date</label>
                <input type="text" name = "getStartDate">

                <!--Enter End date-->
                <label>Enter End Date</label>
                <input type="text" name="getEndDate">

                <!--Enter gross pay-->
                <label>Enter Gross pay</label>
                <input type="text" name="getGrossPay">

                <!--Enter deductions-->
                <label>Enter total deductions</label>
                <input type = "text" name = "getDeductions">

                <!--Save Button: Goes back to managePaystub.php-->
                <button type="submit" name="savePayBtn">Save</button>

                <!--Exit Button: Goes back to managePaystub.php-->
                <button type="submit" name="exitPayBtn">Exit</button>
            </form>
            
        </div>
    </body>
</html>
