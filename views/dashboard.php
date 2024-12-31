

<?php session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/_min.css">
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <!-- <title>admin</title> -->
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
                        <div class="box-c">
                            <div class="cont">
                                5000
                            </div>
                                <!-- <div class="progress">
                                    <progress value="50" max="100">
                                    </progress>
                                </div> -->
                                `
                           
                            

                        </div>
                        <div class="box-r">
                            <div class="icon">
                                <i class="fa-duotone fa-solid fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                    <div class="box-nifo">
                        <div class="box-l">
                            new

                        </div>
                        <div class="box-c">
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
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Users</h3>
                <div class="count" id="userCount">0</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-database"></i>
            </div>
            <div class="stat-info">
                <h3>Database Size</h3>
                <div class="count" id="dbSize">0 MB</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-table"></i>
            </div>
            <div class="stat-info">
                <h3>Total Tables</h3>
                <div class="count" id="tableCount">0</div>
            </div>
        </div>
    </div>
    
    <div class="dashboard-charts">
        <div class="chart-container">
            <canvas id="dbChart"></canvas>
        </div>

    </div>
    </div>
       
 </div>
    </div>
    <?php include_once base_path() . '/views/layouts/footer.php';?>



    <script src="../js/all.min.js"></script>
    <script src="../js/admin/_min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/dashboard.js"></script>

</body>
</html>