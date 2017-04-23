<div>
    <h1 class="name-heading">Welcome , <?php echo $_SESSION["name"] ; ?></h1>
</div>

<?php 
    
    if (isset($message))
    {
        echo '<p class="message-text">' .$message. '</p>';
    }
    else
    {
        echo '<p class="message-text">You have ' .sizeof($items). ' items for Sale.';
    }

    $size = sizeof($items)/3;
    
    //to show only 3 products per row
    for ($i = 0; $i <= intval($size) ; $i++)
    {    
        echo '<div class="row">';
        if ($i == intval($size))
            $count = sizeof($items)%3 + 3*$i;
        else 
            $count = ($i+1)*3;
        for ($j = $i*3 ; $j < $count ; $j++)
        {
            echo '<div class="item">';
            echo '<div class="product-card">';
            echo '<a href="items.php?item=' .$items[$j]["id"]. '"><img src="' .$items[$j]["image"]. '" alt="Item Image" ></a>';
            echo '</div>';
            echo '<div class="product-info">';
            echo '<h5>' .$items[$j]["title"]. '</h5>';
            if ( $items[$j]["price"] == 0 )
            {
                echo '<span>On Donation</span>';
            }
            else 
            {
                echo '<span>&#8377;' .$items[$j]["price"]. '</span>';
            }
            
            echo '<form method="POST" action="delete.php">';
            echo '<button id="remove" name="delete" class="delete" value=' .$items[$j]["id"]. '>Remove Item</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
?>
