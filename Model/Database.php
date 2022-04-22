<?php
class Database
{
    protected $connection = null;
 
    public function __construct()
    {
        try {
            // connect oci database
            $connection = oci_connect(DB_USERNAME, DB_PASSWORD, DB_HOST);
         
            if ( oci_error() ) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }           
    }

    // function for select statement
    public function select($query, $params = array())
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
 
    // public function select($query = "" , $params = [])
    // {
    //     try {
    //         $stmt = $this->executeStatement( $query , $params );
    //         $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
    //         $stmt->close();
 
    //         return $result;
    //     } catch(Exception $e) {
    //         throw New Exception( $e->getMessage() );
    //     }
    //     return false;
    // }

    // insert function
    public function insert($query, $params = array())
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            $result = $stmt->rowCount();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
 
    // // insert function
    // public function insert($query, $user_name, $user_mail, $user_status)
    // {
    //     try {
    //         $stmt = $this->connection->prepare( $query );
    //         $stmt->bind_param('ssi', $user_name, $user_mail, $user_status);
    //         $stmt->execute();

    //         $stmt->close();
 
    //         return true;
    //     } catch(Exception $e) {
    //         throw New Exception( $e->getMessage() );
    //     }
    //     return false;
    // }

    // execute statement
    public function executeStatement($query, $params = array())
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
 
    // private function executeStatement($query = "" , $params = [])
    // {
    //     try {
    //         $stmt = $this->connection->prepare( $query );
 
    //         if($stmt === false) {
    //             throw New Exception("Unable to do prepared statement: " . $query);
    //         }
 
    //         if( $params ) {
    //             $stmt->bind_param($params[0], $params[1]);
    //         }
 
    //         $stmt->execute();
 
    //         return $stmt;
    //     } catch(Exception $e) {
    //         throw New Exception( $e->getMessage() );
    //     }   
    // }
}