<?php
// Controller action for both Post action and getting list. Can be made into a class for more complex actions
require "model.php";
$data = [];
$db = new SimpleDB();

if (isset($_POST['login-manager'])) {

    $id = $_POST['id'];
    $email = $_POST['email'];
    
    $conditions = [];

    $sql = "SELECT ec.Essn, ec.Email FROM emp_contact ec, employee e WHERE Essn = '$id' AND ec.Essn = e.Ssn AND e.Rno = 1";

    $result = $db->query($sql, $conditions);
    print_r($result);
    
    if($result) {
        if ($result[0]['Email'] == $email) {
            session_start();
            $_SESSION["user"] = $id;
            header("Location: app/manager/main.php");
            die();
        }
        else {
            header("Location: login.php");     
            echo "wrong credentials";       
        }
    } else {
        header("Location: login.php");
        echo "wrong credentials";
    }

}

if (isset($_POST['login-employee'])) {

    $id = $_POST['id'];
    $email = $_POST['email'];
    
    $conditions = [];

    $sql = "SELECT ec.Essn, ec.Email FROM emp_contact ec, employee e WHERE Essn = '$id' AND ec.Essn = e.Ssn AND e.Rno != 1";

    $result = $db->query($sql, $conditions);
    print_r($result[0]);
    
    if($result) {
        if ($result[0]['Email'] == $email) {
            session_start();
            $_SESSION["user"] = $id;        
            header("Location: app/employee/main.php");
            die();
        }
        else {
            $error_msg = "Invalid credentials";
            include 'login.php';
            header("Location: login.php");         
        }
    } else {
        $error_msg = "Invalid credentials";
        include 'login.php';
        header("Location: login.php");
    }

}

if (isset($_POST['login-client'])) {

    $id = $_POST['id'];
    $email = $_POST['email'];
    
    $conditions = [];

    $sql = "SELECT c.Cid, c.Email FROM client c WHERE Cid = '$id'";

    $result = $db->query($sql, $conditions);
    print_r($result);
    
    if($result) {
        if ($result[0]['Email'] == $email) {
            session_start();
            $_SESSION["user"] = $id;            
            header("Location: app/client/main.php");
            die();
        }
        else {
            header("Location: login.php");     
            echo "wrong credentials";       
        }
    } else {
        header("Location: login.php");
        echo "wrong credentials";
    }

}
/*Client Buttons */
//Project Button Selected from Client folder --> Main.php
elseif(isset($_POST['projectBtn'])) {
    //view projects
    session_start();
    $clientId = $_SESSION['user'];

    $projectData = $db->query("SELECT p.Pname, p.Pstart_date, d.Dname AS Dept_Name 
                               FROM project p
                               JOIN client_project cp ON cp.Gave_project = p.Pnumber
                               JOIN department d ON d.Dnumber = p.Dnum
                               WHERE cp.Cid = ?", [$clientId]); 
    // Use the logged-in client's ID to filter projects

    $_SESSION['projectData'] = $projectData;
    //Redirect from the main client page to projects.php
    header("Location: app/client/projects.php");
    exit;

//Exit button selected from projects.php
}elseif(isset($_POST['exitBtn'])){
    if ($_POST['source'] == 'employee') {
        header("Location: app/employee/main.php");
        exit;
    }

    if ($_POST['source'] == 'dependents') {
        header("Location: app/employee/dependents.php");
        exit;        
    }

    if ($_POST['source'] == 'contact') {
        header("Location: app/employee/main.php");
        exit;
    }

    if ($_POST['source'] == 'client') {
        header("Location: app/client/main.php");
        exit;
    }

    if ($_POST['source'] == 'client-project') {
        header("Location: app/client/projects.php");
        exit;
    }

//Edit button for Client
}elseif(isset($_POST['editBtn'])){
    //redirects from projects.php to editProjects.php
    header("Location:app/client/editProjects.php");
    exit;

//Save button selected from editProjects.php
}elseif(isset($_POST['saveBtn'])){

    session_start();
    $clientId = $_SESSION['user'];
    
    //Get old project name from client
    $oldProject = $_POST['oldProjectName'];

    //Get the new project name from client
    $newProject = $_POST['newProjectName'];
    //Update the name of the project from Project table
    $updateProjName = $db -> query("UPDATE project SET Pname = '$newProject' WHERE Pname = '$oldProject'");

    //get updated table:
    $projectData = $db->query("SELECT p.Pname, p.Pstart_date, d.Dname AS Dept_Name 
                               FROM project p
                               JOIN client_project cp ON cp.Gave_project = p.Pnumber
                               JOIN department d ON d.Dnumber = p.Dnum
                               WHERE cp.Cid = ?", [$clientId]); 

    $_SESSION['projectData'] = $projectData;

    header("Location:app/client/projects.php");
    exit;
}
//view emplpoyee information button selected from projects.php
elseif(isset($_POST['viewEmpBtn'])){

    session_start();
    $clientId = $_SESSION['user'];

    $viewEmp =  $db->query("SELECT p.Pname, e.Fname, e.Lname, ec.Email, ec.Address, ec.Phone
                            FROM client_project cp
                            JOIN project p ON cp.Gave_project = p.Pnumber
                            JOIN works_on wo ON wo.Pno = p.Pnumber
                            JOIN employee e ON e.Ssn = wo.Essn
                            JOIN emp_contact ec ON ec.Essn = e.Ssn
                            WHERE cp.Cid = ?", [$clientId]);
    
    //create a session 
    $_SESSION['viewEmp']= $viewEmp;

    //redirect to view employee information page
    header("Location:app/client/viewEmp.php");
    exit();
}
//view manager information button selected from projects.php
elseif(isset($_POST['viewManagerBtn'])){
    
    session_start();
    $clientId = $_SESSION['user'];
    
    //get manager info 
    $viewManager = $db->query("SELECT e.Fname, e.Lname, ec.Email, ec.Phone, ec.Address, p.Pname FROM client_project cp JOIN project p ON cp.Gave_project = p.Pnumber JOIN works_on wo ON wo.Pno = p.Pnumber JOIN employee e ON e.Ssn = wo.Essn JOIN emp_contact ec ON ec.Essn = e.Ssn JOIN roles r ON r.Rno = e.Rno WHERE cp.Cid = ? AND r.Rno = 1;", [$clientId]);
    
    //create a session
    $_SESSION['viewManager'] = $viewManager;

    //redirect to view manager info page:
    header("Location:app/client/viewManager.php");
    exit();
}

elseif(isset($_POST['viewDependentsBtn'])) {
    session_start();
    $employeeId = $_SESSION['user'];

    $viewDependents = $db->query("SELECT d.Dependent_name, d.Sex, d.Bdate, d.Relationship 
                                  FROM dependent d
                                  WHERE d.Essn = ?;", [$employeeId]);

    $_SESSION['viewDependents'] = $viewDependents;
    header("Location: app/employee/dependents.php");    
}

elseif(isset($_POST['createDependent'])) {
    header("Location: app/employee/createDependent.php");
}

elseif(isset($_POST['submitDependent'])) {
    
    session_start();
    $employeeId = $_SESSION['user'];
    $name = $_POST['Dependent_name'];
    $sex = $_POST['Sex'];
    $bdate = $_POST['Bdate'];
    $relationship = $_POST['Relationship'];

    if ($name == "" && $sex == "" && $bdate == "" && $relationship == "") {
        header("location: app/employee/dependents.php");
        exit;
    }

    $createDependent = $db->query("INSERT INTO dependent (Essn, Dependent_name, Sex, Bdate, Relationship)
                                  VALUES (?, ?, ?, ?, ?);", 
                                  [$employeeId, $name, $sex, $bdate, $relationship]);

    $viewDependents = $db->query("SELECT d.Dependent_name, d.Sex, d.Bdate, d.Relationship 
                                  FROM dependent d
                                  WHERE d.Essn = ?;", [$employeeId]);

    $_SESSION['viewDependents'] = $viewDependents;
}

elseif(isset($_POST['viewContactBtn'])) {
    session_start();
    $employeeId = $_SESSION['user'];

    $getContact = $db->query("SELECT ec.Email, ec.Phone, ec.Address
                              FROM emp_contact ec
                              WHERE ec.Essn = ?;", [$employeeId]);

    $_SESSION['viewContact'] = $getContact;
    header("Location: app/employee/updateContact.php");
}

elseif(isset($_POST['changeContactBtn'])) {
    session_start();
    $employeeId = $_SESSION['user'];

    // Build the update query dynamically based on filled fields
    $updates = [];
    $params = [];

    if (!empty($_POST['Email'])) {
        $updates[] = "Email = ?";
        $params[] = $_POST['Email'];
    }
    if (!empty($_POST['Phone'])) {
        $updates[] = "Phone = ?";
        $params[] = $_POST['Phone'];
    }
    if (!empty($_POST['Address'])) {
        $updates[] = "Address = ?";
        $params[] = $_POST['Address'];
    }

    // Only execute the query if there are updates to make
    if (!empty($updates)) {
        $updateQuery = "UPDATE emp_contact SET " . implode(", ", $updates) . " WHERE Essn = ?";
        $params[] = $employeeId; // Add employee ID as the last parameter

        // Execute the update query
        $db->query($updateQuery, $params);

        $getContact = $db->query("SELECT ec.Email, ec.Phone, ec.Address
                                  FROM emp_contact ec
                                  WHERE ec.Essn = ?;", [$employeeId]);

        $_SESSION['viewContact'] = $getContact;        

        // Redirect after successful update
        header("Location: app/employee/updateContact.php");
        exit;
    }

    else {
        header("Location: app/employee/updateContact.php");
        exit;
    }

}

elseif(isset($_POST['viewPaystubsBtn'])) {
    session_start();
    $employeeId = $_SESSION['user'];

    $viewPaystubs = $db->query("SELECT ps.Start_date, ps.End_date, ps.Gross_pay, ps.Deductions, ps.Net_pay
                                FROM paystub ps
                                WHERE ps.Essn = ?;", [$employeeId]);
    
    $_SESSION['viewPaystubs'] = $viewPaystubs;

    $avgPaystub = $db->query("SELECT AVG(Net_pay)
                              FROM PAYSTUB
                              WHERE (Essn, End_date) IN (
                                  SELECT Essn, MAX(End_date)
                                  FROM PAYSTUB
                                  GROUP BY Essn);");
    
    array_push($_SESSION['viewPaystubs'], $avgPaystub[0]);
    header("Location: app/employee/viewPaystubs.php"); 
}

elseif(isset($_POST['viewClientsBtn'])) {
    session_start();
    $employeeId = $_SESSION['user'];

    $viewClients = $db->query("SELECT c.Fname, c.Lname, c.Works_for, c.Email, c.Phone, p.Pname
                               FROM employee e
                               JOIN works_on wo ON e.Ssn = wo.Essn
                               JOIN project p ON wo.Pno = p.Pnumber
                               JOIN client_project cp ON p.Pnumber = cp.Gave_project
                               JOIN client c ON cp.Cid = c.Cid
                               WHERE e.Ssn = ?;", [$employeeId]);

    $_SESSION['viewClients'] = $viewClients;
    header("Location: app/employee/viewClients.php");
}

elseif(isset($_POST['viewEmpInDeptBtn'])) {
    session_start();
    $employeeId = $_SESSION['user'];

    $empDept = $db->query("SELECT e.Dno FROM employee e WHERE e.Ssn = ?;", [$employeeId]);

    $viewEmpInDept = $db->query("SELECT e.Fname, e.Lname, r.Rname, ec.Email, ec.Phone, ec.Address,                     GROUP_CONCAT(DISTINCT p.Pname SEPARATOR ', ') AS Pname
                                 FROM employee e
                                 JOIN emp_contact ec ON e.Ssn = ec.Essn
                                 JOIN roles r ON e.Rno = r.Rno
                                 JOIN works_on wo ON e.Ssn = wo.Essn
                                 JOIN project p ON wo.Pno = p.Pnumber
                    			 WHERE e.Dno = ?
                                 GROUP BY e.Fname, e.Lname, r.Rname, ec.Email, ec.Phone, ec.Address;", [$empDept[0]['Dno']]);

    $_SESSION['viewEmpInDept'] = $viewEmpInDept;
    header("Location: app/employee/viewEmpInSameDept.php");
}

/* Manager Buttons:*/

//view paystub button selected from main.php
elseif(isset($_POST['paystubBtn'])){

     //get the manager id
     session_start();
     $managerID = $_SESSION['user'];
     //print($managerID);
     
    $viewPaystub = $db -> query("  SELECT p.Paystub_id,e.Ssn, p.Start_date, p.End_date, p.Gross_pay, p.Deductions, p.Net_pay
                                        FROM employee  e
                                        JOIN department d ON e.Dno = d.Dnumber
                                        JOIN paystub p ON p.Essn = e.Ssn  
                                        WHERE d.Mgr_ssn = ? AND e.Ssn != ?;", [$managerID , $managerID]);
    //create a session
  
    $_SESSION['viewPaystub'] = $viewPaystub;
    //print_r($viewPaystub);
    //redirect to employee paystub 
    header("Location:app/manager/managePaystub.php");
}

//Exit button for Manager
elseif(isset($_POST['exitPayBtn'])){
    //redirects from managePaystub.php to main.php
    header("Location:app/manager/main.php");
    exit;
}

//ToCreate button for Manager
//Direct manager to the create paystub page
elseif(isset($_POST['createBtn'])){
    header("Location:app/manager/createPaystub.php");
    exit;
}
//create and insert paystub
elseif(isset($_POST['savePayBtn'])){

    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];

    $newPaystubId = $db->query("SELECT MAX(Paystub_id) AS id FROM paystub;");
    $newPaystubId = $newPaystubId[0]['id'] + 1;

     //Insert Sql statment 
     $sql = "INSERT INTO paystub (Paystub_id, Essn, Start_date, End_date, Gross_pay, Deductions) VALUES (:Paystub_id, :Essn, :Start_date, :End_date, :Gross_pay, :Deductions)";
     // Get data from post action
     $createPay = $db->query($sql, [
     ":Paystub_id"=>$newPaystubId,   
     ":Essn"=>$_POST["getSsn"],
     ":Start_date"=>$_POST["getStartDate"],
     ":End_date"=>$_POST["getEndDate"],
     ":Gross_pay"=>$_POST["getGrossPay"],
     ":Deductions"=>$_POST["getDeductions"],
     ]);

    //Net_pay = Gross_pay - Deductions
    $addNetpay = $db -> query("UPDATE paystub SET Net_pay = Gross_pay - Deductions");

    //if inserting query into paystub successful then

    //display the updated table??
    $viewPaystub = $db -> query("  SELECT p.Paystub_id, e.Ssn, p.Start_date, p.End_date, p.Gross_pay, p.Deductions, p.Net_pay
                                        FROM employee  e
                                        JOIN department d ON e.Dno = d.Dnumber
                                        JOIN paystub p ON p.Essn = e.Ssn
                                        WHERE d.Mgr_ssn = ? AND e.Ssn != ?;",[$managerID , $managerID]);


    $_SESSION['viewPaystub'] = $viewPaystub;
    //view the updated paystub
    header("Location:app/manager/managePaystub.php");
    exit;

}

//delete paystub button - redirects to delete page
elseif(isset($_POST['toDelBtn'])){
    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];

    //get the selected paystub id to remove
    $getPayID = $_POST['getPayID']; 

    //remove the selected paystub 
    $removePaystub = $db -> query("DELETE FROM paystub WHERE Paystub_id = $getPayID");

    //display the updated table??
    $viewPaystub = $db -> query("  SELECT p.Paystub_id, e.Ssn, p.Start_date, p.End_date, p.Gross_pay, p.Deductions, p.Net_pay
                                        FROM employee  e
                                        JOIN department d ON e.Dno = d.Dnumber
                                        JOIN paystub p ON p.Essn = e.Ssn
                                        WHERE d.Mgr_ssn = ? AND e.Ssn != ?;", [$managerID , $managerID]);


    $_SESSION['viewPaystub'] = $viewPaystub;
    //view the updated paystub
    header("Location:app/manager/managePaystub.php");
    exit;

}
//manager view employee button:
elseif(isset($_POST['ManagerViewEmpBtn'])){
    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];

    //get the employee
    $viewEmptoManager = $db->query("SELECT e.ssn, e.fname, e.lname,e.RNo,e.Bdate, e.Sex, d.Dname, ec.Phone, ec.Email, ec.Address
                                    FROM employee e 
                                    JOIN department d ON d.Dnumber = e.Dno  
                                    JOIN emp_contact ec ON ec.Essn = e.Ssn
                                    WHERE d.Mgr_ssn = ? AND e.Ssn != ?;", [$managerID , $managerID]);

    $_SESSION ['viewEmptoManager'] = $viewEmptoManager;

    header("Location:app/manager/viewEmptoManager.php");
    exit;

}

//manager view their client information
elseif(isset($_POST['viewClientBtn'])){

    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];

    //get client information for manager:
    $viewClientToManager = $db -> query("  SELECT c.cid, c.fname, c.lname, c.Email, c.Phone, p.Pname 
                                                FROM client c
                                                JOIN client_project cp ON c.cid = cp.cid
                                                JOIN project p ON cp.Gave_project = p.Pnumber
                                                JOIN department d ON p.Dnum = d.Dnumber
                                                WHERE d.Mgr_ssn = ?;",[$managerID]);
    //create session
    $_SESSION['viewClientToManager'] = $viewClientToManager;

    //display:
    header("Location:app/manager/viewClientToManager.php");
    exit;
}
//Direct Manager to Manager Create Client  Page
elseif(isset($_POST['createClientBtn'])){
    header("Location:app/manager/createClient.php");
}

//Save the new client information
elseif(isset($_POST['saveClientBtn'])){

    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];
    //insert client information to Client table
    $sql = "INSERT INTO client (Cid, Fname, Lname, Email, Phone) VALUES (:Cid, :Fname, :Lname, :Email, :Phone)";
    // Get data from post action
    $createClient = $db->query($sql, [
    ":Cid"=>$_POST["getCid"],
    ":Fname"=>$_POST["getClientFname"],
    ":Lname"=>$_POST["getClientLname"],
    ":Email"=>$_POST["getClientEmail"],
    ":Phone"=>$_POST["getClientPhoneNumber"]
    ]);

    //get the project name into project number
    $rProjectName = $_POST['getClientProjectName'];

    //get project number to insert into client project
    $getProjectNumber = $db ->query("   SELECT p.Pnumber
                                        FROM project p
                                        JOIN client_project cp ON cp.Gave_project = p.Pnumber
                                        WHERE p.Pname = $rProjectName");


    //insert into client project
    $sqlProject = "INSERT INTO client_project (Cid, Gave_project) VALUES (:Cid, :Gave_project)";

    //get client information for manager:
        $viewClientToManager = $db -> query("  SELECT c.cid, c.fname, c.lname, c.Email, c.Phone, p.Pname 
                                                    FROM client c
                                                    JOIN client_project cp ON c.cid = cp.cid
                                                    JOIN project p ON cp.Gave_project = p.Pnumber
                                                    JOIN department d ON p.Dnum = d.Dnumber
                                                    WHERE d.Mgr_ssn = ?;",[$managerID]);
                                                    
    //create session
    $_SESSION['viewClientToManager'] = $viewClientToManager;

    //display:
    header("Location:app/manager/viewClientToManager.php");
    exit;

}

//Manager Assigns project
elseif(isset($_POST['assignProject']))
{
    header("Location:app/manager/assignProjects.php");
    exit;
}

elseif(isset($_POST['assignClientToProject'])){
    //Add it to client_project
    //get the assigned client id
    $sql = "INSERT INTO client_project (Cid, Gave_project) VALUES (:Cid, :Gave_project)";
    // Get data from post action
    $assignClientProject = $db->query($sql, [
    ":Cid"=>$_POST["getAssignCid"],
    ":Gave_project"=>$_POST["getAssignProjectName"]
    ]);

    $viewClientProject = $db->query("SELECT Cid, Gave_project FROM client_project");
    //create a session to view the client_project table:
    session_start();
    $_SESSION['viewClientProject'] = $viewClientProject;

    //print_r($assignClientProject);

    header("Location:app/manager/assignProjects.php");
    exit;
}
//Edit Employee Information
elseif(isset($_POST['EditEmployeeBtn'])){

    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];
    //get the employee
    $editEmployeeInfo = $db->query("SELECT e.ssn, e.fname, e.lname,e.RNo,e.Bdate, e.Sex, d.Dname, ec.Phone, ec.Email, ec.Address
                                    FROM employee e 
                                    JOIN department d ON d.Dnumber = e.Dno  
                                    JOIN emp_contact ec ON ec.Essn = e.Ssn
                                    WHERE d.Mgr_ssn = ? AND e.Ssn != ?;",[$managerID , $managerID] );

    //create session
    $_SESSION ['editEmployeeInfo'] = $editEmployeeInfo;
    //redirect manager to editEmployeeInfo.php
    header("Location:app/manager/editEmployeeInfo.php");

}
//update employee info:
elseif(isset($_POST['saveNewEmployeeInfo'])){

    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];
    //get employee ssn 
    $getEmpSSN = $_POST['getEmpSSN'];

    if(!empty($getEmpSSN)){
        //get updated info:

        $newRoleNumber = $_POST['getNewRoleNumber'];

        $newDeptNum = $_POST['getNewDeptNum'];

        //Role number
        if(!empty($newRoleNumber)){
            $updateRole = $db->query("UPDATE employee SET RNo = '$newRoleNumber' WHERE Ssn = '$getEmpSSN'");
        }
    
        //dept number
        if(!empty($newDeptNum)){
            $updateDeptNum = $db->query("UPDATE employee SET Dno = '$newDeptNum' WHERE Ssn = '$getEmpSSN'");
        }
    
        // After saving, fetch updated employee info and store it back in the session
        $getNewEmpInfo = $db->query("SELECT e.ssn, e.fname, e.lname, e.RNo, e.Bdate, e.Sex, d.Dname, ec.Phone, ec.Email, ec.Address
                                    FROM employee e
                                    JOIN department d ON d.Dnumber = e.Dno
                                    JOIN emp_contact ec ON ec.Essn = e.Ssn
                                    WHERE e.Ssn = '$getEmpSSN' AND d.Mgr_ssn = ? AND e.Ssn != ?;", [$managerID , $managerID]);

        
        $_SESSION['editEmployeeInfo'] = $getNewEmpInfo;

        //print_r($getNewEmpInfo);
        //var_dump($getNewEmpInfo);
        // Redirect to the edit page to show updated info
        header("Location: app/manager/editEmployeeInfo.php");
        exit;

    }
    else{
        print("Enter Employee ID");
    }

    
} 


//delete client
elseif(isset($_POST['delClientBtn'])){
    //get the manager id
    session_start();
    $managerID = $_SESSION['user'];

    //get the selected paystub id to remove
    $delClientID = $_POST['delClientID']; 

    //remove the selected paystub 
    $removePaystub = $db -> query("DELETE FROM client WHERE cid = $delClientID");

    //display the updated table??
    $viewPaystub = $db -> query("  SELECT p.Paystub_id, e.Ssn, p.Start_date, p.End_date, p.Gross_pay, p.Deductions, p.Net_pay
                                        FROM employee  e
                                        JOIN department d ON e.Dno = d.Dnumber
                                        JOIN paystub p ON p.Essn = e.Ssn
                                        WHERE d.Mgr_ssn = ? AND e.Ssn != ?", [$managerID, $managerID]);
    //get client information for manager:
        $viewClientToManager = $db -> query("  SELECT c.cid, c.fname, c.lname, c.Email, c.Phone, p.Pname 
        FROM client c
        JOIN client_project cp ON c.cid = cp.cid
        JOIN project p ON cp.Gave_project = p.Pnumber
        JOIN department d ON p.Dnum = d.Dnumber
        WHERE d.Mgr_ssn = ?;", [$managerID]);

    //create session
    $_SESSION['viewClientToManager'] = $viewClientToManager;

    //display:
    header("Location:app/manager/viewClientToManager.php");
    exit;

}