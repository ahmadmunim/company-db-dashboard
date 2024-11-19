<?php

/**
 * Database model for employee. 
 * Inserting and Selecting based on controller statement
 */

require "envLoader.php";

class SimpleDB {
  private $pdo = null;
  private $stmt = null;

  // Establish connection to Database
  function __construct() {
    (new DotEnv(__DIR__ . '/.env'))->load();
    try {
      // Using PDO over Mysqli since PDO works with more than just mysql databases
      // These same aspects can we rearranged for mysqli instances
      $this->pdo = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Error mode to use
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Use associative array instead of object
        ]
      );
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  // Close connection with database
  function __destruct() {
    //Remove existing statements
    if ($this->stmt !== null) {
      $this->stmt = null;
    }
    //Remove pdo instance (close db connection)
    if ($this->pdo !== null) {
      $this->pdo = null;
    }
  }

  /**
   * Select Action
   * @return Array of objects or error statement
   */
  function query($sql, $cond = null) {
    try {
      $this->stmt = $this->pdo->prepare($sql); // Prepare sql statement
      $this->stmt->execute($cond); // Execute sql statement with interpolated data
      return $this->stmt->fetchAll(); // Get selected items
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }

  /**
   * Insert Action
   * @return Integer of last added id or error message
   */
  function insert_employee($sql, $cond = null) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
      $selectCond = [':Ssn' => $cond[':Ssn']];
      return $this->query("SELECT Ssn, Fname, Lname, Rno, Bdate, Sex, Dno 
      FROM employee WHERE Ssn = :Ssn", $selectCond);
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }

  function insert_client($sql, $cond = null) {
    try {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($cond);
        $selectCond = [':Cid' => $cond[':Cid']];
        return $this->query("SELECT Cid, Fname, Lname, Works_for, Email, Phone FROM client WHERE Cid = :Cid", $selectCond);
      } catch (Exception $ex) {
        return $ex->getMessage();
      }
  }

  function insert_project($sql, $cond = null) {
    try {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($cond);
        $selectCond = [':Pnumber' => $cond[':Pnumber']];
        return $this->query("SELECT Pnumber, Pname, Dnum, Pstart_date FROM project WHERE Pnumber = :Pnumber", $selectCond);
      } catch (Exception $ex) {
        return $ex->getMessage();
      }
  }

  function insert_paystub($sql, $cond = null) {
    try {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($cond);
        $selectCond = [':Paystub_id' => $cond[':Paystub_id']];
        return $this->query("SELECT Paystub_id, Essn, Start_date, End_date, Gross_pay, Deductions, Net_pay FROM paystub WHERE Paystub_id = :Paystub_id", $selectCond);
      } catch (Exception $ex) {
        return $ex->getMessage();
      }
  }  
}

