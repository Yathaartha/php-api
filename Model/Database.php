<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// require 'PHPMailerAutoload.php';

//Load Composer's autoloader
require 'C:\xampp\htdocs\php-api\vendor\autoload.php';

class Database
{
    protected $connection = null;
 
    public function __construct()
    {
        try {
            // connect oci database
            $this->connection = oci_connect(DB_USERNAME, DB_PASSWORD, DB_HOST);
         
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
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_execute($stmt);
            oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }

    // function for login statement
    public function login($query, $username, $password)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ':username', $username);
            oci_bind_by_name($stmt, ':password', $password);
            oci_execute($stmt);
            oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }

    // function for getting user
    public function getUserProfile($query, $id)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ':CUSTOMERID', $id);
            oci_execute($stmt);
            oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
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
    public function insert($query, $firstname, $lastname, $username, $address, $phone, $email, $password, $image , $status)
    {
        $mail = new PHPMailer();
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':firstname', $firstname);
            oci_bind_by_name($stmt, ':lastname', $lastname);
            oci_bind_by_name($stmt, ':username', $username);
            oci_bind_by_name($stmt, ':address', $address);
            oci_bind_by_name($stmt, ':phone', $phone);
            oci_bind_by_name($stmt, ':email', $email);
            oci_bind_by_name($stmt, ':password', $password);
            oci_bind_by_name($stmt, ':image', $image);
            oci_bind_by_name($stmt, ':status', $status);

            oci_execute($stmt);
            
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            // set host mail
            $mail->Host       = 'tls://smtp.gmail.com';                    
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'chhemart@gmail.com';                     //SMTP username
            $mail->Password   = 'chhemart@123';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('chhemart@gmail.com', 'Mailer');
            $mail->addAddress($email, $firstname);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Welcome To CHH E-Mart';
            $mail->Body    = 'We are excited to welcome you to the <b>CHH Emart</b> Family. Below you will find your username and password to login to your account. <br> <br> Username: '.$username.' <br> Password: '.$password.' <br> <br> Thank you for joining us!';
            $mail->AltBody = 'We are excited to welcome you to the CHH Emart Family. Below you will find your username and password to login to your account. Username: '.$username.' Password: '.$password.' Thank you for joining us!';

            try{
                $mail->send();
                echo 'Message has been sent';
            }catch(Exception $e) {
                echo $e;
            }

            // create 2d array with all form values
            $result = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'username' => $username,
                'address' => $address,
                'phone' => $phone,
                'email' => $email,
                'password' => $password,
                'image' => $image,
                'status' => $status
            );

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
            $stmt = oci_parse($this->connection, $query);
            oci_execute($stmt);
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