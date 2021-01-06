<?php
	define('PRIVATE_KEY', '../private/private_key');

	require_once(dirname(__FILE__) . '/vendor/autoload.php');

	use \Firebase\JWT\JWT;
	use \Firebase\JWT\JWK;

	$json = null;
	if (isset($_REQUEST['json'])) {
		$json = json_decode($_REQUEST['json']);
	}
	if (!$json) {
		$json = (object) [
			'iss' => 'mintopia',
			'iat' => time(),
			'nbf' => time() - 300,
			'exp' => time() + 86400,
			'sub' => 'Jessica',
		];
	}

	$jwt = '';
	if ($json) {
		$jwt = JWT::encode($json, file_get_contents(PRIVATE_KEY), 'RS256');
	}

?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>JWT Generator</title>
	</head>
	<body>
		<form method="POST">
			<p>
				<label>Payload</label>
				<textarea name="json" rows="10" style="width: 500px;"><?php echo htmlentities(json_encode($json, JSON_PRETTY_PRINT)); ?></textarea>
			</p>
			<p>
			<label>JWT</label>
			<textarea rows="10" style="width: 500px;"><?php echo $jwt; ?></textarea>
		</p>
		<p>
			<input type="submit" name="Submit" />
		</p>
	</form>
	</body>
</html>