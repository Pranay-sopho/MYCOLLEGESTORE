<?php
    
    //configuration
    require('config.php');
    require('../models/models.php');
    
    //array to store all the information of a particular item
    $item = get_item($_GET["item"]);
    
    render ('product.php',["title" => "View Item : " . $item["title"] , "item" => $item ]);
    
?> 
