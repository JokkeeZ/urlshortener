<?php
include '../backend/class.core.php';
Core::initialize();

$longUrl = $_POST['longUrl'];
$newLink = '';
$shorterner = Core::getShortener();

$shorterner->createHash($longUrl);

if (!$shorterner->linkExistsOnDatabase()) {
	$shorterner->addLinkToDatabase();
	$newLink = $shorterner->generateNewLink();
} else {
	$newLink = $shorterner->generateNewShortLink(
		$shorterner->getShortLinkByLong($longUrl)
	);
}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Link shortener</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<h1>Link shortener</h1>
				<p>Just an easy example.</p>
			</div>
		</div>

		<div class="container">
			<form>
				<div class="form-group">
					<label>Shortlink</label>
					<input type="text" class="form-control" value="<?= $newLink; ?>">
				</div>
				<a href="<?= $newLink; ?>" class="btn btn-default">Go to shortlink</a>
			</form>
		</div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	</body>
</html>