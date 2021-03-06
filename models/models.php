<?php
    
    /*
     * Model for checking login
     */
    function login_query($values)
    {
        require('connect.php');
        extract($values);
        $email = mysqli_real_escape_string($con,$email);
        $query = 'SELECT * FROM users WHERE email="' .$email. '"';
        $result=mysqli_query($con,$query);
        if (empty($result))
        {
            return false;
        }
        else
        {
            $row=mysqli_fetch_assoc($result);
            if (password_verify($password,$row["password"]))
            {   
                $_SESSION["id"] = $row["id"];
                $_SESSION["cid"] = $row["college"];
                $_SESSION["name"] = $row["name"];
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    /*
     * Model for Registering user
     */
    function register_query($values)
    {
        require('connect.php');
        extract($values);
        $email = mysqli_real_escape_string($con,$email);
        $fname = mysqli_real_escape_string($con,$fname);
        
        $query = 'INSERT INTO users(name,email,password,college,gender) VALUES';
        $password_hash = password_hash($password,PASSWORD_DEFAULT);
        $query = $query . '("' . $fname . '","' . $email . '","' . $password_hash . '",' . $cid . ',"' . $gender . '")';
        if (mysqli_query($con,$query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /*
     * Model for posting ad
     */
    function postad_query($values)
    {
        require('connect.php');
        extract($values);
        $title = mysqli_real_escape_string($con,$title);
        $desc = mysqli_real_escape_string($con,$desc);
        $contact = mysqli_real_escape_string($con,$contact);
        $query = 'INSERT INTO items(uid,cid,category,title,description,contact,itype,price,date,image) 
                  VALUES(' .$_SESSION["id"]. ',' .$_SESSION["cid"]. ',' .$category. ',"' .$title. '","' .$desc. '","' .$contact. '",' .$choice. ',' .$price. ',"' .date_format(date_create(),'jS F,Y'). '","' .$image. '")';
        if (mysqli_query($con,$query))
        {
            return true;
        }
        else
        {   
            return false;
        }
    }
    
    /*
     * Model for getting college list
     */
    function college_list()
    {
        require('connect.php');
        $query = 'SELECT * FROM colleges';
        if ($rows = mysqli_query($con,$query))
        {   
            while($row = mysqli_fetch_assoc($rows))
            {
                $college_data[] = [
                    "cid" => $row["cid"],
                    "cname" => $row["cname"]
                ];
            }
            
            return $college_data;
        }
    }
    
    /*
     * Model for getting category list
     */
    function category_list()
    {
        require('connect.php');
        $query = 'SELECT * FROM categories ORDER BY id';
        if ($rows = mysqli_query($con,$query))
        {
            while ($row = mysqli_fetch_assoc($rows))
            {
                $category_data[] = [
                    "id" => $row["id"],
                    "name" => $row["name"]
                ];
            }
            return $category_data;
        }
    }
    
    /*
     * Model for getting list of items in store
     */
    
    function store_list_query()
    {
        require('connect.php');
        
        $item_list = [];
        
        if (isset($_GET["sid"]))
        {
            $query = 'SELECT * FROM items WHERE uid=' .$_GET["sid"];
        }
        
        else if (isset($_GET["category"]) && !isset($_GET["prdouct"]) && !isset($_GET["cid"]))
        {   
            $query = 'SELECT * FROM items WHERE category=' .$_GET["category"];
        }
        
        else if (!isset($_GET["category"]) && isset($_GET["prdouct"]) && !isset($_GET["cid"]))
        {
            $query = 'SELECT * FROM items WHERE title LIKE "%' .$_GET["product"]. '%"';
        }
        
        else if (!isset($_GET["category"]) && !isset($_GET["prdouct"]) && isset($_GET["cid"]))
        {
            $query = 'SELECT * FROM items WHERE cid=' .$_GET["cid"];
        }
        
        else if (isset($_GET["cid"]) && isset($_GET["category"]) && !isset($_GET["product"]))
        {
            $query = 'SELECT * FROM items WHERE cid=' .$_GET["cid"]. ' AND ' .'category=' .$_GET["category"];
        }
        
        else if (isset($_GET["cid"]) && isset($_GET["product"]) && !isset($_GET["category"]))
        {
            $query = 'SELECT * FROM items WHERE cid=' .$_GET["cid"]. ' AND ' .'title LIKE "%'. $_GET["product"]. '%"';
        }
        
        else if (isset($_GET["category"]) && isset($_GET["product"]) && !isset($_GET["cid"]))
        {
            $query = 'SELECT * FROM items WHERE category=' .$_GET["category"]. ' AND ' .'title LIKE "%'. $_GET["product"]. '%"';
        }
        
        else if (isset($_GET["category"]) && isset($_GET["cid"]) && isset($_GET["product"]))
        {
            $query = 'SELECT * FROM items WHERE category=' .$_GET["category"]. ' AND ' .'cid=' .$_GET["cid"]. ' AND ' .'title LIKE "%'. $_GET["product"]. '%"';
        }
        
        else
        {
            $query = 'SELECT * FROM items';
        }
        
        if ($rows = mysqli_query($con,$query))
        {
            while($row = mysqli_fetch_assoc($rows))
            {
                
                $college_query = 'SELECT cname FROM colleges,items WHERE colleges.cid = items.cid AND items.uid = ' .$row["uid"];
                $college_rows = mysqli_query($con,$college_query);
                $college_row = mysqli_fetch_assoc($college_rows);
                
                $category_query = 'SELECT name FROM categories,items WHERE categories.id = items.category AND items.id = ' .$row["id"];
                $category_rows = mysqli_query($con,$category_query);
                $category_row = mysqli_fetch_assoc($category_rows);
                
                $item_list[] = [
                    "id" => $row["id"],
                    "image" => $row["image"],
                    "title" => $row["title"],
                    "price" => $row["price"],
                ]; 
            }
            
        }
        else
        {
            $item_list = [];
        }
        
        return $item_list;
    }
    
    /*
     * Model for getting items by each user
     */
    
    function user_item_list()
    {
        require('connect.php');
        $item_data = [];
        $query = 'SELECT * FROM items WHERE uid=' . $_SESSION["id"];
        if ($rows = mysqli_query($con,$query))
        {
            while ($row = mysqli_fetch_assoc($rows))
            {
                $item_data[] = [
                    "id" => $row["id"],
                    "image" => $row["image"],
                    "title" => $row["title"],
                    "price" => $row["price"]
                ];
                
             }
        }
       return $item_data;
    }
    
    /*
     * Model for searching product with typeahead
     */
    
    function search_product()
    {
        require('connect.php');
        
        $products_list = [];
        
        $query = 'SELECT * FROM items WHERE title LIKE "%' .$_GET["product"]. '%"';
        
        if ($rows = mysqli_query($con,$query))
        {   
            while ($row = mysqli_fetch_assoc($rows))
            {
                $products_list[] = [
                    "id" => $row["id"],
                    "title" => $row["title"]
                  ];
            }
        }
        
        return $products_list;
     }
     
    /*
     * Model to get info of a particular item
     */   

    function get_item($id)
    {
        require('connect.php');
        
        $item = [];
        
        $query = 'SELECT uid,name,title,description,image,price,contact,date,cname FROM items,categories,colleges WHERE items.category=categories.id AND items.cid = colleges.cid AND items.id=' .$id ;
        
        if ($rows = mysqli_query($con,$query))
        {
            $row = mysqli_fetch_assoc($rows);
            $item = [
                "uid" => $row["uid"],
                "category" => $row["name"],
                "title" => $row["title"],
                "desc" => $row["description"],
                "image" => $row["image"],
                "price" => $row["price"],
                "contact" => $row["contact"],
                "date" => $row["date"],
                "cname" => $row["cname"]
                ];     
        }
       
        
        return $item;
        
    }
    
    /*
     * Model to remove item from users items
     */
        
    function remove_item($id)
    {
        require('connect.php');
        
        //Remove image of the item
        $img_query = 'SELECT image FROM items WHERE id=' .$id;
        $img_rows = mysqli_query($con,$img_query);
        $img_row = mysqli_fetch_assoc($img_rows);
        
        $img_path = $img_row["image"];
        if ($img_path != '/img/default.png')
        {
            $img_path = '../public/' . $img_path;
            unlink($img_path);
                
        }
        
        $query = 'DELETE FROM items WHERE id=' .$id ;
        if (mysqli_query($con,$query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    
        
        
        
        
            
    
    
?>
