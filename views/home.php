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
  
</head>
<body>
<?php
  include_once base_path() . '/views/layouts/nav-top.php';
?>
    <div class="containers">
    <?php include_once base_path() . '/views/layouts/navbar-link.php';?>
            <div class="link">
                
            </div>
            <div class="box-out">
                <ul>
                    <li>
                        <a href="?out">
                            <div class="icon">
                                <i class="fa-duotone fa-solid fa-right-from-bracket"></i>
                            </div>
                            <div class="text"><samp>SinOut</samp></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="body" id="body-item">
            <div class="box-infos">
                <div class="row" id="box_infos">

                    <div class="box-nifo">
                        <div class="box-l">
                            new

                        </div>
                        <div class="box-c" data-info="user">
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
            <div class="box-items">
                
                <div class="dashboard-stats">
                    
                <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-table"></i>
            </div>
            <div class="stat-info">
            <h3>Total Accounts</h3>
                <div class="count" id="totalAccounts">0</div>
            </div>

            </div>
            <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-table"></i>
            </div>
            <div class="stat-info">
                <h3>Total Tables</h3>
                <div class="count" id="totalOrders">0</div>
            </div>

            </div>
            <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-table"></i>
            </div>
            <div class="stat-info">
                <h3>total Expenses</h3>
                <div class="count" id="totalExpenses">0</div>
            </div>

            </div>
                    
                </div>

        </div>
      
    </div>
    
    </div>
    <?php include_once base_path() . '/views/layouts/footer.php';?>

    <script src="js/all.min.js"></script>   
    <script src="js/admin/_min.js"></script>   
    <script src="js/home.js"></script>
    
</body>
</html>