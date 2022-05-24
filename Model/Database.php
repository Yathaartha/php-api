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
    public function select($query, $limit)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ":limit", $limit);
            oci_execute($stmt);
            oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }
    // function for select statement
    public function selectById($query, $id)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ":id", $id);
            
            if(false === oci_execute($stmt)){
                $err = oci_error($stmt);
                return $err;
            }else{
                oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }

    // function for select statement
    public function selectSlot($query, $collectiondate, $collectiontime)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ":collectiondate", $collectiondate);
            oci_bind_by_name($stmt, ":collectiontime", $collectiontime);
            if(false === oci_execute($stmt)){
                $err = oci_error($stmt);
                return $err;
            }else{
                oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }

    // function for select all statement
    public function selectAll($query, $params = null)
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

    // function for select statement
    public function search($query, $searchkey)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ":searchkey", $searchkey);
            oci_execute($stmt);
            oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }

    // function for select statement
    public function getSingleProduct($query, $productId)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ":productid", $productId);
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
            if(false === oci_execute($stmt)){
                $err = oci_error($stmt);
                return $err;
            }else{
                oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                return $result;
            }
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
            oci_bind_by_name($stmt, ':id', $id);

            if(false === oci_execute($stmt)){
                $e = oci_error($stmt);
                return $e;
            }else{
                oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);

                return $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());  
        }
    }


    // insert function
    public function createById($query, $id)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':id', $id);
            if(false === oci_execute($stmt)) {
                $err = oci_error($stmt);
                return $err;
            }else{
                return $id;
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }

    // insert function
    public function addToWishlist($query, $wishlist, $product)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ':wishlist', $wishlist);
            oci_bind_by_name($stmt, ':product', $product);
            if(false === oci_execute($stmt)) {
                return oci_error($stmt);
            }else{
                $result = array(
                    'wishlist'=> $wishlist,
                    'product'=> $product
                );
    
                return $result;

            }
            // oci_execute($stmt);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            return ;  
        }
    }

    // insert function
    public function addToCart($query, $cart, $product, $quantity)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ':cart', $cart);
            oci_bind_by_name($stmt, ':product', $product);
            oci_bind_by_name($stmt, ':quantity', $quantity);
            if(false === oci_execute($stmt)) {
                return oci_error($stmt);
            }else{
                $result = array(
                    'cart'=> $cart,
                    'product'=> $product,
                    'quantity' => $quantity
                );
    
                return $result;

            }
            // oci_execute($stmt);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            return ;  
        }
    }
    // insert function
    public function insert($query, $firstname, $lastname, $username, $address, $phone, $email, $password)
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

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Welcome To CHH E-Mart';
            $mail->Body    = 'We are excited to welcome you to the <b>CHH Emart</b> Family. Below you will find your username and password to login to your account. <br> <br> Username: '.$username.' <br> Password: '.$password.' <br> <br> Thank you for joining us!';
            $mail->AltBody = 'We are excited to welcome you to the CHH Emart Family. Below you will find your username and password to login to your account. Username: '.$username.' Password: '.$password.' Thank you for joining us!';
            
            try{
                oci_execute($stmt);
                
                $mail->send();
            }catch(Exception $e) {
                echo $e;
            }

            // create 2d array with all form values
            // $result = array(
            //     'firstname' => $firstname,
            //     'lastname' => $lastname,
            //     'username' => $username,
            //     'address' => $address,
            //     'phone' => $phone,
            //     'email' => $email,
            //     'password' => $password,
            // );

            $stmt1 = oci_parse($this->connection, 'SELECT * FROM CUSTOMER WHERE USERNAME = :username');
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt1, ':username', $username);
            oci_execute($stmt1);
            oci_fetch_all($stmt1, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
    // insert function
    public function insertOrder($query, $cartid, $orderdate, $total, $collectiondate, $collectionslot, $email)
    {
        $mail = new PHPMailer();
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':cartid', $cartid);
            oci_bind_by_name($stmt, ':orderdate', $orderdate);
            oci_bind_by_name($stmt, ':total', $total);
            oci_bind_by_name($stmt, ':collectiondate', $collectiondate);
            oci_bind_by_name($stmt, ':collectionslot', $collectionslot);

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
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Your order is placed!';
            $mail->Body    = 'Hello<br />Thank you for ordering from CHH E-Mart!<br />Were excited for you to receive your order and will notify you once its on its way. If you have ordered from multiple sellers, your items will be delivered in separate packages. We hope you had a great shopping experience! You can check your order status here.';
            $mail->AltBody = 'Hello, Thank you for ordering from CHH E-Mart! Were excited for you to receive your order and will notify you once its on its way. If you have ordered from multiple sellers, your items will be delivered in separate packages. We hope you had a great shopping experience! You can check your order status here.';
            
            try{
                oci_execute($stmt);
                $mail->send();
            }catch(Exception $e) {
                echo $e;
            }

            $stmt1 = oci_parse($this->connection, 'SELECT * FROM ORDERS WHERE CART = :cartid');
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt1, ':cartid', $cartid);
            oci_execute($stmt1);
            oci_fetch_all($stmt1, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
    // insert function
    public function insertShop($query, $shopname, $shopdescription, $shopimage, $bannerimage, $trader)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':shopname', $shopname);
            oci_bind_by_name($stmt, ':shopdescription', $shopdescription);
            oci_bind_by_name($stmt, ':shopimage', $shopimage);
            oci_bind_by_name($stmt, ':bannerimage', $bannerimage);
            oci_bind_by_name($stmt, ':traderid', $trader);

            try{
                if(false == oci_execute($stmt)){
                    $err = oci_error(($stmt));
                    return $err;
                }else{
                    
                    $stmt1 = oci_parse($this->connection, 'SELECT * FROM SHOP WHERE SHOPNAME = :shopname');
                    $refcur = oci_new_cursor($this->connection);
                    oci_bind_by_name($stmt1, ':shopname', $shopname);
                    oci_execute($stmt1);
                    oci_fetch_all($stmt1, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        
                    return $result;
                }
                
            }catch(Exception $e) {
                echo $e;
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }

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