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
            <div class="box-infos">
                <div class="row" id="box_infos">
                
                    <div class="box-nifo">
                        <div class="box-l">
                            new

                        </div>
                        <div class="box-c" data-info="Cut">
                            5000
                        </div>
                        <div class="box-r">
                            <div class="icon">
                                <i class="fa-duotone fa-solid fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'partials/addcustomer.php' ?>
            <div class="box-items">

            <div class="row-search">
                    <div class="input">
                        <div class="icon">
                            <i class="fa-regular fa-magnifying-glass"></i>
                        </div>
                        <div class="values">
                            <input type="text" id="search"  placeholder="Search">
                        </div>
                    </div>
                    <button id="ButAddCustomers">
                    <i class="fa-thin fa-user-plus"></i>
                     
                        <samp> AddCustomers</samp>
                    </button>
                </div>
                <div class="table">
                    <div class="header">
                        <div class="name">
                            Name
                        </div>
                        <div class="show">
                        Address
                        </div>
                        <div class="edit">
                        countOrders
                        </div>
                        <div class="delete">
                        Control
                        </div>
                    </div>
                    <div class="body" id="boxBody">
                        
                    </div>
                   </div>
                  
                     </div>


            </div>
        </div>
      
    </div>
    <?php include_once base_path() . '/views/layouts/footer.php';?>

    <script src="js/all.min.js"></script>
    <script src="js/admin/_min.js"></script>  
    <script src="js/admin/_Customers.js"></script>  
    
</body>
</html>