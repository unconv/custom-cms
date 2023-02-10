<?php
namespace Unconv\CustomCms;
use PDO;

require(__DIR__ . "/../vendor/autoload.php");

$db = new PDO( "mysql:host=localhost;dbname=customcms", "admin", "admin" );
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

?>
<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Solid State by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="templates/solid-state/assets/css/main.css" />
		<noscript><link rel="stylesheet" href="templates/solid-state/assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

        <?php
        $page = Page::from_db( 1, $db );
        echo $page->render();
        ?>

		<!-- Scripts -->
			<script src="templates/solid-state/assets/js/jquery.min.js"></script>
			<script src="templates/solid-state/assets/js/jquery.scrollex.min.js"></script>
			<script src="templates/solid-state/assets/js/browser.min.js"></script>
			<script src="templates/solid-state/assets/js/breakpoints.min.js"></script>
			<script src="templates/solid-state/assets/js/util.js"></script>
			<script src="templates/solid-state/assets/js/main.js"></script>

	</body>
</html>
<?php
$page->save( $db );
?>