<?php 
    if (!isset($_SESSION['Authenticated']) || $_SESSION['Authenticated'] != true) {
        header("Location: index.php");
        exit();
    }
?>

<div class="row   col-xs-8">
<label class="control-label col-sm-1" for="type">Filter</label>   
<div class="col-sm-4">
    <select class="form-control" name="mode" id="slt1">
        <option value="#tab_1">All</option>
        <option value="#tab_2">Finished</option>
        <option value="#tab_3">Not Finish</option>
        <option value="#tab_4">Cancel</option>
    </select>
    <tr></tr>
    <tr></tr>
    <form action="select_my_order.php" method="get" id="form2">
        <button type="submit" class="btn btn-danger" data-toggle="modal" id="form2" name="buttonValue" value="cancel">Cancel</button>
    </form>
</div>
<div class="row" id="tab_1">
    <div class="col-xs-8">
        <table class="table" style=" margin-top: 15px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Start</th>           
                    <th scope="col">End</th>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Order Details</th>
                    <th scope="col"> Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    session_start();
                    $dbservername = "localhost"; 
                    $dbname = "DB_HW"; 
                    $dbusername = "dev"; 
                    $dbpassword = "devpasswd";
                    
                    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $stmt = $conn -> prepare("select ID from user where account=:account");
                    $stmt -> execute(array("account" => $_SESSION["account"]));
                    $row = $stmt->fetch();
                    $UID = $row["ID"];
                    $stmt = $conn -> prepare("select * from `order` where UID=:UID");
                    $stmt -> execute(array("UID" => $UID));
                    $result = $stmt -> fetchAll();
                    $cnt=1;
                    echo <<< EOT
                        <input type="hidden" name="UID" value="$UID" form="form2">
                    EOT;
                    foreach ($result as &$row) {
                        $OID = $row['ID'];
                        $status = $row['status'];
                        $start_time = $row['start_time'];
                        $finish_time = $row['finish_time'];
                        $payment = $row['payment'];
                        $SID = $row['SID'];
                        $stmt = $conn -> prepare("select name from `store` where ID=:SID");
                        $stmt -> execute(array("SID" => $SID));
                        $shopInfo = $stmt -> fetch();
                        $shopName = $shopInfo['name'];
                        if ($status == "Not finish") {
                            echo <<< EOT
                            <tr>
                                <td><input type="checkbox" name="$OID" value="yes" form="form2"></td>
                                
                            EOT;
                        }
                        else {
                            echo <<< EOT
                            <tr>
                                <td></td>
                            EOT;
                        }
                    
                        echo <<< EOT
                                <th scope="row">$cnt</th>
                                <td>$OID</td>
                                <td>$status</td>
                                <td>$start_time</td>
                                <td>$finish_time</td>
                                <td>$shopName</td>
                                <td>$payment</td>
                                <td><button type="submit" class="btn btn-info" data-toggle="modal"  data-target="#order$OID">Order Details</button></td>
                                
                        EOT;
                        if ($status == "Not finish") {
                            echo <<< EOT
                                <form action="calcel_user_order.php" method="post">
                                    <input type="hidden" name="OID" value="$OID">
                                    <td><button type="submit" class="btn btn-danger">Cancel</button></td>
                                </form>
                            EOT;
                        }
                        echo <<< EOT
                            </tr>
                        EOT;
                        $cnt++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row" id="tab_2">
    <div class="col-xs-8">
        <table class="table" style=" margin-top: 15px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Start</th>           
                    <th scope="col">End</th>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Order Details</th>
                    <th scope="col"> Action</th>
                </tr>
            </thead>
            <?php
                session_start();
                $dbservername = "localhost"; 
                $dbname = "DB_HW"; 
                $dbusername = "dev"; 
                $dbpassword = "devpasswd";
                
                $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn -> prepare("select ID from user where account=:account");
                $stmt -> execute(array("account" => $_SESSION["account"]));
                $row = $stmt->fetch();
                $UID = $row["ID"];
                $stmt = $conn -> prepare("select * from `order` where status=:status and UID=:UID");
                $stmt -> execute(array("status" => "Finished", "UID" => $UID));
                $result = $stmt -> fetchAll();
                $cnt=1;
                foreach ($result as &$row) {
                    $OID = $row['ID'];
                    $status = $row['status'];
                    $start_time = $row['start_time'];
                    $finish_time = $row['finish_time'];
                    $payment = $row['payment'];
                    $SID = $row['SID'];
                    $stmt = $conn -> prepare("select name from `store` where ID=:SID");
                    $stmt -> execute(array("SID" => $SID));
                    $shopInfo = $stmt -> fetch();
                    $shopName = $shopInfo['name'];

                    echo <<< EOT
                        <tr>
                            <th scope="row">$cnt</th>
                            <td>$OID</td>
                            <td>$status</td>
                            <td>$start_time</td>
                            <td>$finish_time</td>
                            <td>$shopName</td>
                            <td>$payment</td>
                            <td><button type="submit" class="btn btn-info" data-toggle="modal"  data-target="#order$OID">Order Details</button></td>
                        </tr>
                    EOT;
                    $cnt++;
                }
            ?>
        </table>
    </div>
</div>

<div class="row" id="tab_3">
    <div class="col-xs-8">
        <table class="table" style=" margin-top: 15px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Start</th>           
                    <th scope="col">End</th>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Order Details</th>
                    <th scope="col"> Action</th>
                </tr>
            </thead>
            <?php
                session_start();
                $dbservername = "localhost"; 
                $dbname = "DB_HW"; 
                $dbusername = "dev"; 
                $dbpassword = "devpasswd";
                
                $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn -> prepare("select ID from user where account=:account");
                $stmt -> execute(array("account" => $_SESSION["account"]));
                $row = $stmt->fetch();
                $UID = $row["ID"];
                $stmt = $conn -> prepare("select * from `order` where status=:status and UID=:UID");
                $stmt -> execute(array("status" => "Not finish", "UID" => $UID));
                $result = $stmt -> fetchAll();
                $cnt=1;
                foreach ($result as &$row) {
                    $OID = $row['ID'];
                    $status = $row['status'];
                    $start_time = $row['start_time'];
                    $finish_time = $row['finish_time'];
                    $payment = $row['payment'];
                    $SID = $row['SID'];
                    $stmt = $conn -> prepare("select name from `store` where ID=:SID");
                    $stmt -> execute(array("SID" => $SID));
                    $shopInfo = $stmt -> fetch();
                    $shopName = $shopInfo['name'];

                    echo <<< EOT
                        <tr>
                            <td><input type="checkbox" name="$OID" value="yes" form="form2"></td>
                            <th scope="row">$cnt</th>
                            <td>$OID</td>
                            <td>$status</td>
                            <td>$start_time</td>
                            <td>$finish_time</td>
                            <td>$shopName</td>
                            <td>$payment</td>
                            <td><button type="submit" class="btn btn-info" data-toggle="modal"  data-target="#order$OID">Order Details</button></td>
                            <form action="calcel_user_order.php" method="post">
                                <input type="hidden" name="OID" value="$OID">
                                <td><button type="submit" class="btn btn-danger">Cancel</button></td>
                            </form>
                        </tr>
                    EOT;
                    $cnt++;
                }
            ?>
        </table>
    </div>
</div>

<div class="row" id="tab_4">
    <div class="col-xs-8">
        <table class="table" style=" margin-top: 15px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Start</th>           
                    <th scope="col">End</th>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Order Details</th>
                    <th scope="col"> Action</th>
                </tr>
            </thead>
            <?php
                session_start();
                $dbservername = "localhost"; 
                $dbname = "DB_HW"; 
                $dbusername = "dev"; 
                $dbpassword = "devpasswd";
                
                $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn -> prepare("select ID from user where account=:account");
                $stmt -> execute(array("account" => $_SESSION["account"]));
                $row = $stmt->fetch();
                $UID = $row["ID"];
                $stmt = $conn -> prepare("select * from `order` where status=:status and UID=:UID");
                $stmt -> execute(array("status" => "Cancel", "UID" => $UID));
                $result = $stmt -> fetchAll();
                $cnt=1;
                foreach ($result as &$row) {
                    $OID = $row['ID'];
                    $status = $row['status'];
                    $start_time = $row['start_time'];
                    $finish_time = $row['finish_time'];
                    $payment = $row['payment'];
                    $SID = $row['SID'];
                    $stmt = $conn -> prepare("select name from `store` where ID=:SID");
                    $stmt -> execute(array("SID" => $SID));
                    $shopInfo = $stmt -> fetch();
                    $shopName = $shopInfo['name'];
                    echo <<< EOT
                        <tr>
                            <th scope="row">$cnt</th>
                            <td>$OID</td>
                            <td>$status</td>
                            <td>$start_time</td>
                            <td>$finish_time</td>
                            <td>$shopName</td>
                            <td>$payment</td>
                            <td><button type="submit" class="btn btn-info" data-toggle="modal"  data-target="#order$OID">Order Details</button></td>
                        </tr>
                    EOT;
                    $cnt++;
                }
            ?>
        </table>
    </div>
</div>



<div class="row   col-xs-8" id="myOrderModal">
<?php
    session_start();
    $dbservername = "localhost"; 
    $dbname = "DB_HW"; 
    $dbusername = "dev"; 
    $dbpassword = "devpasswd";
     
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
    $stmt = $conn -> prepare("select ID from user where account=:account");
    $stmt -> execute(array("account" => $_SESSION["account"]));
    $row = $stmt->fetch();
    $UID = $row["ID"];
    $stmt = $conn -> prepare("select * from `order` where UID=:UID");
    $stmt -> execute(array("UID" => $UID));
    while ($order = $stmt -> fetch()) {
        // product part
        $OID = $order["ID"];
        $contain = $conn -> prepare("select * from contains where OID=:OID");
        $contain -> execute(array("OID" => $OID));
        $result = $contain -> fetchAll();

        $orderstmt = $conn -> prepare("select * from `order` where ID=:OID");
        $orderstmt -> execute(array("OID" => $OID));
        $ORDER = $orderstmt -> fetch();
        $distance = $ORDER["distance"];
        $payment = $ORDER["payment"];
        $cnt = 1;
        echo <<< EOT
            <div class="modal fade" id="order$OID"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Details</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="  col-xs-12">
                                    <table class="table" style=" margin-top: 15px;">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Picture</th>                                 
                                            <th scope="col">Meal Name</th>
                                            <th scope="col">price</th>
                                            <th scope="col">Order Quantity</th>
                                            </tr>
                                        </thead>
                                    <tbody>
            EOT;
            foreach ($result as &$row) {
                $PHID = $row['PHID'];
                $number = $row['number'];
                $phstmt = $conn -> prepare("select * from product_history where ID=:PHID");
                $phstmt -> execute(array("PHID" => $PHID));
                $product = $phstmt -> fetch();
                $picture = $product["image"];
                $price = $product["price"];
                $picture_type = $product['picture_type'];
                $img = $product["image"];
                $name = $product["name"];
                echo <<< EOT
                                        <tr>
                                            <th scope="row">$cnt</th>
                                            <td><img style="max-width:50%; max-height:100px" src="data:$picture_type;base64,$picture"  alt="$name"/></td>
                                            <td>$name</td>
                                            <td>$price </td>
                                            <td>$number</td>
                                        </tr>
                EOT;
                $cnt++;
            }  
            $subTotal = $payment - $distance;
            echo <<< EOT
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                        <div class="modal-footer">
                            <div><label>Subtotal $$subTotal</label></div>  
                            <div><label>Delivery Fee $$distance</label></div>  
                            <div><label>Total Price $$payment</label></div>  
                        </div>
                    </div>
                </div>
            </div>
        EOT;
    }
?> 

</div>
</div>

<script>
    $(function() {
        $('div[id^="tab_2"]').hide();
        $('div[id^="tab_3"]').hide();
        $('div[id^="tab_4"]').hide();
        $('#slt1').change(function() {
            let sltValue=$(this).val();
            console.log(sltValue);
            $('div[id^="tab_"]').hide();
            $(sltValue).show();
        });  
    });
</script>