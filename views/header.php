<html>
    <head>
        
            <?php if (isset($title)): ?>
            <title><?= htmlspecialchars($title) ?></title>
            <?php else: ?>
            <title>COLLEGE STORE</title>
            <?php endif ?>
        
        <meta charset="utf-8">
	    <meta name="description" content="CollegeStore">
	    <link href="https://fonts.googleapis.com/css?family=Molengo|Signika+Negative" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Molengo" rel="stylesheet"> 
	    <link rel="stylesheet" type="text/css" href="css/styles.css">
	    <script type="text/javascript" src="js/jquery.min.js"></script>
	    <script type="text/javascript" src="js/typeahead.jquery.min.js"></script>
	    <script type="text/javascript" src="js/underscore-min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
        
    </head>
    <body>
        <nav>
		    <a href="index.php" class="store">COLLEGE STORE</a>
		    <a href="postad.php" class="post">SUBMIT YOUR PRODUCT</a>
		    <?php 
		        if(empty($_SESSION["id"]))
                    echo '<a href="login.php" class="account">SIGN IN</a>';
                else
                {   
                    echo '<a href="dashboard.php" class="dashboard">DASHBOARD</a>';
                    echo '<a href="logout.php" class="account">SIGN OUT</a>';
                }
            ?>
	    </nav>
