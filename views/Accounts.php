<?php session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/_min.css">
    <link rel="stylesheet" href="../css/_category.css">
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
                        <div class="box-c">
                            <div class="cont" data-info="exp">
                                5000
                            </div>

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
                <div class="action">
                    <div class="search">
                        <div class="icon">
                            <i class="fa-regular fa-magnifying-glass"></i>
                        </div>
                        <div class="value">
                            <input type="search" name="search" id="search" placeholder="search...">
                        </div>
                        <div class="date">
                            <input type="date" name="date" id="date">
                        </div>
                    </div>
                    <div class="add-cate">
                        <button class="btn-add">
                            <i class="fa-light fa-plus"></i>
                            <samp>Add Accounts</samp></button>
                    </div>
                </div>
        

           <div class="form-edit-cat">
            <form id="Cate_edit">
                <div class="input">
                    <div class="icon">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="Category" name="account_name" placeholder="Enter Accounts Name">
                    </div>
                </div>
                <div class="input">
                    <div class="icon">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="Description" name="account_type" placeholder="Enter Accounts Type">
                    </div>
                </div>
                <div class="input">
                    <div class="icon">
                   <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="Amount" name="amount" placeholder="Enter Amount ">
                    </div>
                </div>
                <div class="input">
                    <div class="icon">
                   <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="PaymentMethod" name="balance" placeholder="Enter balance ">
                    </div>
                </div>
                <div class="button">
                    <button type="submit" class="btn-add">
                        <i class="fa-light fa-floppy-disk"></i>
                        <samp>save</samp>
                    </button>
                    <button type="button" class="btn-Close">
                        <i class="fa-light fa-xmark"></i>
                        <samp>Close</samp></button>
                </div>
            </form>

           </div>
           <div class="form-add-cat">
            <form id="Category">
            
            <div class="input">
                    <div class="icon">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="name" name="account_name" placeholder="Enter Accounts Name">
                    </div>
                </div>
                <div class="input">
                    <div class="icon">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="name" name="account_type" placeholder="Enter Accounts Type">
                    </div>
                </div>
                <div class="input">
                    <div class="icon">
                   <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="Price" name="amount" placeholder="Enter Amount ">
                    </div>
                </div>
                <div class="input">
                    <div class="icon">
                   <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="value">
                        <input type="text" class="Price" name="balance" placeholder="Enter balance ">
                    </div>
                </div>
                <div class="button">
                    <button type="submit" class="btn-add">
                        <i class="fa-light fa-floppy-disk"></i>
                        <samp>save</samp>
                    </button>
                    <button type="button" class="btn-Close">
                        <i class="fa-light fa-xmark"></i>
                        <samp>Close</samp></button>
                </div>
            </form>

           </div>
           <div class="table">
            <div class="header">
                <div class="name">
                Category
                </div>
                <div class="name">
                Description
                </div>

                <div class="name">
                Amount
            </div>
       
                <div class="edit">
                    Edit
                </div>
                <div class="delete">
                    Delete
                </div>
            </div>
            <div class="body">
                <div class="row">
                    <div class="name">
                        <samp>Accounts 1</samp>
                    </div>
                    <div class="edit">
                        <button class="btn-edit">
                            <i class="fa-light fa-pen-to-square"></i>
                            <samp>Edit</samp>
                        </button>
                    </div>
                    <div class="delete">
                        <button class="btn-edit">
                            <i class="fa-light fa-pen-to-square"></i>
                            <samp>Delete</samp>
                        </button>
                    </div>
                </div>
            </div>
           </div>
 </div>
 </div>
</div>
<?php include_once base_path() . '/views/layouts/footer.php';?>




    <script src="../js/all.min.js"></script>
    <script src="../js/admin/_min.js"></script>
    <script src="../js/admin/_Accounts.js"></script>
</body>
</html>