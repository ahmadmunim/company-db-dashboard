

<html>
    <head>
        <title>Create Employee Paystub </title>
    </head>

    <body>
       
        <!--Create Paystub Form--> 
        <div class ="container">
            <form method ="POST" action="../../controller.php">
                <!--Enter Employee SSN-->
                <p></p>
                <label>Enter Employee SSN</label>
                <input type ="text" name="getSsn">
                <!--Enter start date-->
                <p></p>
                <label>Enter Start Date</label>
                <input type="text" name = "getStartDate">
                <!--Enter End date-->
                <p></p>
                <label>Enter End Date</label>
                <input type="text" name="getEndDate">
                <p></p>
                <!--Enter gross pay-->
                <label>Enter Gross pay</label>
                <input type="text" name="getGrossPay">
                <p></p>
                <!--Enter deductions-->
                <label>Enter total deductions</label>
                <input type = "text" name = "getDeductions">
                <p></p>
                <p></p>

                <!--Save Button: Goes back to managePaystub.php-->
                <button type="submit" name="savePayBtn">Save</button>
                <p></p>

                <!--Exit Button: Goes back to managePaystub.php-->
                <button type="submit" name="exitPayBtn">Exit</button>
                <p></p>
            </form>
            
        </div>
    </body>
</html>
