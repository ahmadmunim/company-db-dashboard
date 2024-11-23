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

if (isset($_POST['submit-emp'])) { // Check if post action
    $conditions = [
        ":Bdate" => date("Y-m-d")
    ];
    $message = "Success";
    $errors = [];
    $attributes = [ // array of name fields in the create employee form
        "Ssn",
        "Fname",
        "Lname",
        "Rno",
        "Bdate",
        "Sex",
        "Dno"
    ];

    print_r($attributes);

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute]; // gets inputted value in each form entry and assigns it
        if ($value) {
            $conditions[":$attribute"] = $value; // adds inputted value in conditions array
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add employee - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO employee (Ssn, Fname, Lname, Rno, Bdate, Sex, Dno) VALUES (:Ssn, :Fname, :Lname, :Rno, :Bdate, :Sex, :Dno)";
        // Insert data from post action
        $result = $db->insert_employee($sql, $conditions); // goes to insert_employee function in model.php

        if (is_string($result)) {
            $message = "Could not add employee - " . $result;
        } else {
            $data['employee'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;
} elseif (isset($_GET['submit-emp'])) {
    $conditions = [];
    $where = "";
    $ssn = $_GET['ssn'] ?? null;
    
    if ($ssn) {
        $conditions[':Ssn'] = $ssn;
        $where = "Ssn = :Ssn";
    }
    
    $sql = "SELECT Ssn, Fname, Lname, Rno, Bdate, Sex, Dno FROM employee";
    $sql .= $where ? " WHERE $where" : "";
    
    // Execute query to fetch the matching employee
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Employee Found',
        'employee' => $result[0] ?? null // Get the first result if there's a match
    ];

    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/employee.php?" . http_build_query($data));
    
} elseif (isset($_POST['submit-client'])) {
    $conditions = [];
    $message = "Success";
    $errors = [];
    $attributes = [
        "Cid",
        "Fname",
        "Lname",
        "Works_for",
        "Email",
        "Phone"
    ];

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute];
        if ($value) {
            $conditions[":$attribute"] = $value;
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add client - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO client (Cid, Fname, Lname, Works_for, Email, Phone) VALUES (:Cid, :Fname, :Lname, :Works_for, :Email, :Phone)";
        // Insert data from post action
        $result = $db->insert_client($sql, $conditions);

        if (is_string($result)) {
            $message = "Could not add client - " . $result;
        } else {
            $data['client'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;
} elseif (isset($_GET['submit-client'])) {
    $conditions = [];
    $where = "";
    $cid = $_GET['cid'] ?? null;
    
    if ($cid) {
        $conditions[':Cid'] = $cid;
        $where = "Cid = :Cid";
    }
    
    $sql = "SELECT Cid, Fname, Lname, Works_for, Email, Phone FROM client";
    $sql .= $where ? " WHERE $where" : "";
    
    // Execute query to fetch the matching employee
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Client Found',
        'client' => $result[0] ?? null // Get the first result if there's a match
    ];

    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/client.php?" . http_build_query($data));
    
} elseif (isset($_POST['submit-project'])) {
    $conditions = [];
    $message = "Success";
    $errors = [];
    $attributes = [
        "Pnumber",
        "Pname",
        "Dnum",
        "Pstart_date"
    ];

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute];
        if ($value) {
            $conditions[":$attribute"] = $value;
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add project - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO project (Pnumber, Pname, Dnum, Pstart_date) VALUES (:Pnumber, :Pname, :Dnum, :Pstart_date)";
        // Insert data from post action
        $result = $db->insert_project($sql, $conditions);

        if (is_string($result)) {
            $message = "Could not add project - " . $result;
        } else {
            $data['project'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;

} elseif (isset($_GET['submit-project'])) {
    $conditions = [];
    $where = "";
    $pnumber = $_GET['pnumber'] ?? null;
    
    if ($pnumber) {
        $conditions[':Pnumber'] = $pnumber;
        $where = "Pnumber = :Pnumber";
    }
    
    $sql = "SELECT Pnumber, Pname, Dnum, Pstart_date FROM project";
    $sql .= $where ? " WHERE $where" : "";
    
    // Execute query to fetch the matching employee
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Project Found',
        'project' => $result[0] ?? null // Get the first result if there's a match
    ];

    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/project.php?" . http_build_query($data));
    
} elseif (isset($_GET['submit-employee-projects'])) {
    $ssn = $_GET['ssn'] ?? null;
    $conditions = [];
    
    if ($ssn) {
        $conditions[':ssn'] = $ssn;
        
        // SQL query to get employee's projects
        $sql = "SELECT E.Fname, E.Lname, P.Pname
                FROM employee E
                JOIN works_on W ON E.Ssn = W.Essn
                JOIN project P ON W.Pno = P.Pnumber
                WHERE E.Ssn = :ssn";
        
        // Execute query
        $result = $db->query($sql, $conditions);

        // Check if there are results and prepare data
        $data = [
            'message' => $result ? '' : 'No Projects Found for this Employee',
            'employeeProject' => $result
        ];
    } else {
        $data['message'] = 'No SSN provided';
    }

    // Redirect to a specific HTML page to display results
    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/employeeProject.php?" . http_build_query($data));

} elseif (isset($_GET['submit-employee-netpay'])) {
    
    // Handle GET request to retrieve net pay for a specific employee

    $ssn = $_GET['ssn'] ?? null;
    $conditions = [];
    
    if ($ssn) {
        $conditions[':ssn'] = $ssn;
        
        // SQL query to get employee's net pay details
        $sql = "SELECT E.Fname, E.Lname, P.Net_pay, P.Start_date, P.End_date
                FROM employee E
                JOIN paystub P ON E.Ssn = P.Essn
                WHERE E.Ssn = :ssn";
        
        // Execute query
        $result = $db->query($sql, $conditions);

        // Check if there are results and prepare data
        $data = [
            'message' => $result ? '' : 'No Paystub Found for this Employee',
            'employeeNetpay' => $result
        ];
    } else {
        $data['message'] = 'No SSN provided';
    }

    // Redirect to a specific HTML page to display results
    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/employeeNetpay.php?" . http_build_query($data));
    exit;
} elseif (isset($_POST['submit-employee-paystub'])) {
    $conditions = [];
    $message = "Success";
    $errors = [];
    $attributes = [
        "Paystub_id",
        "Essn",
        "Start_date",
        "End_date",
        "Gross_pay",
        "Deductions",
        "Net_pay"
    ];

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute];
        if ($value) {
            $conditions[":$attribute"] = $value;
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add paystubs - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO paystub (Paystub_id, Essn, Start_date, End_date, Gross_pay, Deductions, Net_pay) VALUES (:Paystub_id, :Essn, :Start_date, :End_date, :Gross_pay, :Deductions, :Net_pay)";
        // Insert data from post action
        $result = $db->insert_paystub($sql, $conditions);

        if (is_string($result)) {
            $message = "Could not add paystub - " . $result;
        } else {
            $data['paystub'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;

//Project Button Selected from Client folder --> Main.php
}elseif(isset($_POST['projectBtn'])) {
    //view projects
    session_start();
    $clientId = $_SESSION['user'];

    $projectData = $db ->query("SELECT Pname,Pstart_date,d.Dname AS Dept_Name FROM project JOIN department d ON d.Dnumber = Dnum;");

    $projectData = $db->query("SELECT p.Pname, p.Pstart_date, d.Dname AS Dept_Name 
                               FROM project p
                               JOIN client_project cp ON cp.Gave_project = p.Pnumber
                               JOIN department d ON d.Dnumber = p.Dnum
                               WHERE cp.Cid = ?", [$clientId]); 
    // Use the logged-in client's ID to filter projects

    $_SESSION['projectData'] = $projectData;
    //Redirect from the main client page to projects.php
    header("Location:http://localhost/company-db-dashboard/Phase3/app/client/projects.php");
    exit;

//Exit button selected from projects.php
}elseif(isset($_POST['exitBtn'])){
    //redirects from projects.php to main.php
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/main.php");
    exit;

//Edit button selected from projects.php
}elseif(isset($_POST['editBtn'])){
    //redirects from projects.php to editProjects.php
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/editProjects.php");
    exit;


//Save button selected from editProjects.php
}elseif(isset($_POST['saveBtn'])){
    //Get old project name from client
    $oldProject = $_POST['oldProjectName'];

    //Get the new project name from client
    $newProject = $_POST['newProjectName'];
    //Update the name of the project from Project table
    $updateProjName = $db -> query("UPDATE project SET Pname = '$newProject' WHERE Pname = '$oldProject'");

    //get updated table:
    $projectData = $db ->query("SELECT Pname,Pstart_date,d.Dname AS Dept_Name FROM project JOIN department d ON d.Dnumber = Dnum;");
    session_start();
    $_SESSION['projectData'] = $projectData;

    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/projects.php");
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
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/viewEmp.php");
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
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/viewManager.php");
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

    $createDependent = $db->query("INSERT INTO dependent (Essn, Dependent_name, Sex, Bdate, Relationship)
                                  VALUES (?, ?, ?, ?, ?);", 
                                  [$employeeId, $name, $sex, $bdate, $relationship]);

    $viewDependents = $db->query("SELECT d.Dependent_name, d.Sex, d.Bdate, d.Relationship 
                                  FROM dependent d
                                  WHERE d.Essn = ?;", [$employeeId]);

    $_SESSION['viewDependents'] = $viewDependents;

    header("location: app/employee/dependents.php");
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


