<?php

//initialize a session
session_start();

// Include config file
include "../config/db_conn.php";

class Employee {




        public function Display_All_Employees(){
             //creating an instance of db_connection 
            $db = new DB_connection();

            //a query to select all employees data from the DB
            $sql = "SELECT 
            Person.FirstName,
            Person.LastName,
            STAFF.job,
            STAFF.email,
            STAFF.StaffId
            FROM
            STAFF, PERSON WHERE STAFF.PersonId = Person.PersonID";

             //executing the query
            $result = $db->connect()->query($sql);

            //Checking if rows have been affected 
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {

                    //Saving data in an associative array
                    $data[] = $row;
                }

                //returning the data
                return $data;

                }else{
                echo "No found records";
                }

        }



        public function DisplayEmployee($id){
            //creating an instance of db_connection 
            $db = new DB_connection();

            //Depending on the id in the Database if id = 3 is in the database it will return a true 
            //Else a false on testing
            //$id=7;


             //query the record of an employee with this id
            $sql = "SELECT * FROM STAFF WHERE StaffId = '$id'";

            $result =  $db->connect()->query($sql);
            

                //checking if the query affected any row then is a success
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row;

                }else{
                    echo "Record not found";
                }
           
        }

        //A function to delete a specific visitor data from the DB
        public function DeleteEmployee($id){
            //creating an instance of db_connection 
            $db = new DB_connection();

            //Depending on the id in the Database if 4 is in the database it will return a true 
            //Else a false on testing
            //$id = 6;

            //a query to delete the employee record with this id
            $sql = "DELETE FROM Employees where Employee_ID='$id'";

            $result = mysqli_query($db->connect(),$sql);

            //checking if the query was successful and redirecting to the visitor page
            if($result){
                return true;
            }else{
                return false;
            }
        }


       






}