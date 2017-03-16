<?php
    
    //configuration
    require('config.php');
    require('../models/models.php');
    
    $items = item_list_query($_GET["offset"]);
    $categories = category_list();
    $colleges = college_list();
    render ("store.php" , ["title" => "Store" , "items" => $items, "categories" => $categories, "colleges" => $colleges ] );   

?>