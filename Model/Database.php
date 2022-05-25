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
            // throw new Exception($e->getMessage());
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
    public function removeFromWishlist($query, $wishlistId, $productId)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ':wishlistid', $wishlistId);
            oci_bind_by_name($stmt, ':productid', $productId);
            if(false === oci_execute($stmt)) {
                return oci_error($stmt);
            }else{
                $result = array(
                    'product'=> $productId,
                    'wishlist' => $wishlistId
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
    public function deleteFromCart($query, $cartid)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ':cartid', $cartid);
            if(false === oci_execute($stmt)) {
                return oci_error($stmt);
            }else{
                return "Deleted";
            }
            // oci_execute($stmt);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            return ;  
        }
    }
    // insert function
    public function insertReview($query, $productId, $content, $rating, $customerid)
    {
        try {

            $check = oci_parse($this->connection, 'SELECT * FROM REVIEW WHERE PRODUCT = :productid AND CUSTOMER = :customerid');
            oci_bind_by_name($check, ':productid', $productId);
            oci_bind_by_name($check, ':customerid', $customerid);
            if(false === oci_execute($check)) {
                return oci_error($check);
            }else{
                oci_fetch_all($check, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                if(count($result) > 0){
                    return ['message' => "You have already reviewed this product"];
                }else{
                    $stmt = oci_parse($this->connection, $query);
                    $refcur = oci_new_cursor($this->connection);
                    oci_bind_by_name($stmt, ':productid', $productId);
                    oci_bind_by_name($stmt, ':content', $content);
                    oci_bind_by_name($stmt, ':rating', $rating);
                    oci_bind_by_name($stmt, ':customer', $customerid);
                    if(false === oci_execute($stmt)) {
                        return oci_error($stmt);
                    }else{
                        return "Review Added";
                    }
                    
                }
            }

            // oci_execute($stmt);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            return ;  
        }
    }
    // update function
    public function updateReview($query, $reviewId, $reportReason, $customerId)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt, ':reportreason', $reportReason);
            oci_bind_by_name($stmt, ':customer', $customerId);
            oci_bind_by_name($stmt, ':reviewid', $reviewId);
            if(false === oci_execute($stmt)) {
                return oci_error($stmt);
            }else{
                return "Review Reported";
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
            

            if(false === oci_execute($stmt)){
                return oci_error($stmt);
            }else{
                $mail->send();
                
                $stmt1 = oci_parse($this->connection, 'SELECT * FROM CUSTOMER WHERE USERNAME = :username');
                $refcur = oci_new_cursor($this->connection);
                oci_bind_by_name($stmt1, ':username', $username);
                oci_execute($stmt1);
                oci_fetch_all($stmt1, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    
                return $result;

            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
    // insert function
    public function insertTrader($query, $firstname, $lastname, $username, $address, $phone, $email, $password, $category)
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
            oci_bind_by_name($stmt, ':category', $category);

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
            $mail->Body    = 'We are excited to welcome you to the <b>CHH E-Mart</b> Trader Family. Below you will find your username and password to login to your account. <br> <br> Username: '.$username.' <br> Password: '.$password.' <br> <br> Thank you for joining us! Be sure to follow the trader guidelines.';
            $mail->AltBody = 'We are excited to welcome you to the CHH E-Mart Trader Family. Below you will find your username and password to login to your account. Username: '.$username.' Password: '.$password.' Thank you for joining us! Be sure to follow the trader guidelines.';
            
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
    public function updateTrader($query, $firstname, $lastname, $username, $address, $phone, $email, $category, $password, $image, $status, $id)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':firstname', $firstname);
            oci_bind_by_name($stmt, ':lastname', $lastname);
            oci_bind_by_name($stmt, ':username', $username);
            oci_bind_by_name($stmt, ':address', $address);
            oci_bind_by_name($stmt, ':phone', $phone);
            oci_bind_by_name($stmt, ':email', $email);
            oci_bind_by_name($stmt, ':password', $password);
            oci_bind_by_name($stmt, ':salescategory', $category);            
            oci_bind_by_name($stmt, ':image', $image);            
            oci_bind_by_name($stmt, ':status', $status);            
            oci_bind_by_name($stmt, ':id', $id);            
            try{
                if(false === oci_execute($stmt)){
                    return oci_error($stmt);
                }else{
                    $stmt1 = oci_parse($this->connection, 'SELECT * FROM TRADER WHERE TRADERID = :id');
                    $refcur = oci_new_cursor($this->connection);
                    oci_bind_by_name($stmt1, ':id', $id);
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
    // update function
    public function update($query, $id, $firstname, $lastname, $username, $address, $phone, $email, $password, $image)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':id', $id);
            oci_bind_by_name($stmt, ':firstname', $firstname);
            oci_bind_by_name($stmt, ':lastname', $lastname);
            oci_bind_by_name($stmt, ':username', $username);
            oci_bind_by_name($stmt, ':address', $address);
            oci_bind_by_name($stmt, ':phone', $phone);
            oci_bind_by_name($stmt, ':email', $email);
            oci_bind_by_name($stmt, ':password', $password);
            oci_bind_by_name($stmt, ':image', $image);
            
            if(false === oci_execute($stmt)) {
                return oci_error($stmt);
            }else{
                $result = array(
                    'id' => $id,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username,
                    'address' => $address,
                    'phone' => $phone,
                    'email' => $email,
                    'password' => $password,
                    'image' => $image
                );
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
    // insert function
    public function insertOrder($query, $cartid, $customerid, $orderdate, $total, $collectiondate, $collectionslot, $email)
    {
        $mail = new PHPMailer();
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':cartid', $cartid);
            oci_bind_by_name($stmt, ':customerid', $customerid);
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
            
            if(false === oci_execute($stmt)){
                return oci_error($stmt);
            }else{
            $mail->send();
    
            $stmt1 = oci_parse($this->connection, 'SELECT * FROM ORDERS WHERE CART = :cartid');
            $refcur = oci_new_cursor($this->connection);
            oci_bind_by_name($stmt1, ':cartid', $cartid);
            oci_execute($stmt1);

            $stmt2 = oci_parse($this->connection, 'INSERT INTO CART VALUES (null, :customerid)');
            oci_bind_by_name($stmt2, ':customerid', $customerid);
            oci_execute($stmt2);

            oci_fetch_all($stmt1, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    
            return $result;
            }
               
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
    // insert function
    public function insertPayment($query, $customerId, $orderId, $total, $paydate)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':id', $customerId);
            oci_bind_by_name($stmt, ':orderid', $orderId);
            oci_bind_by_name($stmt, ':total', $total);
            oci_bind_by_name($stmt, ':paydate', $paydate);
            
            if( false === oci_execute($stmt)){
                return oci_error($stmt);
            }else{
                return "Payment Successful";
            }

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
    // insert function
    public function insertOffer($query, $offername, $discount, $traderid, $startdate, $enddate)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':offername', $offername);
            oci_bind_by_name($stmt, ':discount', $discount);
            oci_bind_by_name($stmt, ':traderid', $traderid);
            oci_bind_by_name($stmt, ':startdate', $startdate);
            oci_bind_by_name($stmt, ':enddate', $enddate);

            try{
                if(false == oci_execute($stmt)){
                    echo $enddate;
                    $err = oci_error(($stmt));
                    return $err;
                }else{
                    
                    $stmt1 = oci_parse($this->connection, 'SELECT * FROM OFFER WHERE OFFERNAME = :offername');
                    $refcur = oci_new_cursor($this->connection);
                    oci_bind_by_name($stmt1, ':offername', $offername);
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
    // insert function
    public function insertProduct($query, $name, $description, $price, $image, $stock, $shop, $category, $offer)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':name', $name);
            oci_bind_by_name($stmt, ':description', $description);
            oci_bind_by_name($stmt, ':price', $price);
            oci_bind_by_name($stmt, ':image', $image);
            oci_bind_by_name($stmt, ':stock', $stock);
            oci_bind_by_name($stmt, ':shop', $shop);
            oci_bind_by_name($stmt, ':category', $category);
            oci_bind_by_name($stmt, ':offer', $offer);

            try{
                if(false == oci_execute($stmt)){
                    $err = oci_error(($stmt));
                    return $err;
                }else{
                    
                    $stmt1 = oci_parse($this->connection, 'SELECT * FROM PRODUCT WHERE PRODUCTNAME = :name');
                    $refcur = oci_new_cursor($this->connection);
                    oci_bind_by_name($stmt1, ':name', $name);
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
    // insert function
    public function insertProductNoOffer($query, $name, $description, $price, $image, $stock, $shop, $category)
    {
        try {
            $stmt = oci_parse($this->connection, $query);
            oci_bind_by_name($stmt, ':name', $name);
            oci_bind_by_name($stmt, ':description', $description);
            oci_bind_by_name($stmt, ':price', $price);
            oci_bind_by_name($stmt, ':image', $image);
            oci_bind_by_name($stmt, ':stock', $stock);
            oci_bind_by_name($stmt, ':shop', $shop);
            oci_bind_by_name($stmt, ':category', $category);

            try{
                if(false == oci_execute($stmt)){
                    $err = oci_error(($stmt));
                    return $err;
                }else{
                    
                    $stmt1 = oci_parse($this->connection, 'SELECT * FROM PRODUCT WHERE PRODUCTNAME = :name');
                    $refcur = oci_new_cursor($this->connection);
                    oci_bind_by_name($stmt1, ':name', $name);
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