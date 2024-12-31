<?php 
session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/_min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    
    <title>admin</title>
</head>
<body>
<?php
  include_once base_path() . '/views/layouts/nav-top.php';
?>
    <div class="containers">
    <?php include_once base_path() . '/views/layouts/navbar-link.php';?>
            <div class="link">
                
            </div>
            <?php include_once base_path() . '/views/layouts/nav-out.php';?>
        </div>

        <div class="body">
        <div class="order">
            <div class="row">
                <div class="input">
                    <div class="icon">
                    <i class="fa-duotone fa-solid fa-user"></i>
                    </div>
                    <div class="text">
                    CustName

                    </div>
                    <div class="vlaue">
                        <input type="text"  id="CustName">
                        <div class="box-list">
                        <ul id="Custlist">
                            
                        </ul>
                    </div>
                    </div>
                   
                </div>
                <div class="input">
                    <div class="icon">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div class="text">
                        OrderID

                    </div>
                    <div class="vlaue label">
                        <input type="text" name="OrderID" disabled id="OrderID">
                        <label for="AutoID">
                            Auto
                            <input type="checkbox"  id="AutoID">
                        </label>
                        
                    </div>
                    
                </div>
            </div>
            <div class="row">
            <div class="input">
                    <div class="icon">
                        <i class="fa-solid fa-signature"></i>
                    </div>
                    <div class="text">
                        ItemName

                    </div>
                    <div class="vlaue">
                        <input type="text" name="" id="ItemName">
                        <div class="box-list-items">
                        <ul id="boxItems">
                            
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row items">
                
                <div class="input int">
                    <div class="icon">
                    <i class="fa-thin fa-tags"></i>
                    </div>
                    <div class="text">
                    price
                    </div>
                    <div class="vlaue">
                        <input type="text" name="price" id="price">
                    </div>
                </div>
                <div class="input int">
                    <div class="icon">
                    <i class="fa-regular fa-percent"></i>
                    </div>
                    <div class="text">
                    discount
                    </div>
                    <div class="vlaue">
                        <input type="text" name="discount" id="discount">
                    </div>
                </div>
                <div class="input int">
                    <div class="icon">
                    <i class="fa-duotone fa-solid fa-arrow-up-9-1"></i>
                    </div>
                    <div class="text">
                    Quantity
                    </div>
                    <div class="vlaue">
                        <input type="text" name="Quantity" id="Quantity">
                    </div>
                </div>
                <div class="input int">
                    <div class="icon">
                    <i class="fa-thin fa-tags"></i>
                    </div>
                    <div class="text">
                    Talo : 
                    </div>
                    <div class="vlaue samp ">
                        <samp id="talo"></samp>
                    </div>
                </div>
            </div>
            <div class="row items">
            <div class="input int-1">
                    <div class="icon">
                    <i class="fa-duotone fa-solid fa-arrow-up-9-1"></i>
                    </div>
                    <div class="text">
                    QuantityAvailable
                    </div>
                    <div class="vlaue">
                        <input type="text"  id="QuantityAvailable">
                    </div>
                </div>
            </div>
            <div class="button">
                <button type="button" id='Addorder'>
                <i class="fa-solid fa-plus"></i>
                    Add
                </button>
                <button type="button" id="submit">
                submit
                </button>
            </div>
            <div class="table">
                    <div class="header">
                        <div class="name">
                            Name
                        </div>
                        <div class="show">
                            Quantity
                        </div>
                        <div class="edit">
                        price
                        </div>
                        <div class="delete">
                            Edit
                        </div>
                        <div class="delete">
                            Delete
                        </div>
                        
                    </div>
                    <div class="body" id="body-order">
                        <div class="row">
                            <div class="name">
                                items
                            </div>
                            <div >
                                        5
                            </div>
                            <div class="name">
                                items
                            </div>
                            <div >
                                        5
                            </div>
                            <div class="name">
                                items
                            </div>
                          
                          
                        </div>
                    </div>
                   </div>
        </div>
          
        </div>
      
    </div>
    <?php include_once base_path() . '/views/layouts/footer.php';?>

    <script src="js/all.min.js"></script>
    <script src="js/admin/_min.js"></script>  
    <script src="js/admin/_order.js"></script>

    
</body>
</html>