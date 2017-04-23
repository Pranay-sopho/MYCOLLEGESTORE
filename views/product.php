<?php 
	//item view should have image, title , description , date , price and a contact info field 
	echo '<div class="product"><div class="image">';
	echo '<img src="' .$item["image"]. '" alt="product-image"><h2><span>';
	if ($item["price"] == 0)
		echo 'On Donation</span></h2></div><main>';
	else
		echo 'On Sell</span></h2></div><main>';
	echo '<span class="catego">Category - ' .$item["category"]. '</span>';
	echo '<h2>' .$item["title"]. '</h2>';
	if (!$item["price"] == 0)
		echo '<span class="price">&#8377;'.$item["price"]. '</span>';
	echo '<div class="descriptionp"><div class="descriptionh"><span><span>Description</span></span></div><div>';
	echo '<div id="descrip" class="descriptionn"><span>' .$item["desc"]. '</span></div></div></div>';
	echo '<div class="seller"><div class="sellerh"><span><span>Contact</span></span></div><div class="sellern"><span><span>'.$item["contact"].'</span></span></div><div>';
	echo '<div id="sellerName" class="sellero"><a href="index.php?sid=' .$item["uid"]. '"><span>Other Items From Seller</span></a></div></div></div>';
	echo '<div class="date"><div class="dateh"><span><span>Posted</span></span></div><div><div id="datep" class="daten"><span>'.$item["date"].'</span></div></div></div>';
	echo '<div class="collegep"><div class="collegeh"><span><span>College</span></span></div><div><div class="collegen"><span>' .$item["cname"]. '</span></div></div></div></main>';
	echo '</div>';
?>
