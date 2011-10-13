<?php

require 'TorrentReader.php';

$debug = 0;

if ( !empty($_FILES['torrent']) ) {
	if ( !empty($_FILES['torrent']) && empty($_FILES['torrent']['error']) && file_exists($_FILES['torrent']['tmp_name']) ) {
		$szTorrentFile = $_FILES['torrent']['tmp_name'];
		$szTorrentFileName = $_FILES['torrent']['name'];
		$szTorrentContent = file_get_contents($szTorrentFile);
	}
}

if ( !empty($_POST['content']) ) {
	if ( !empty($_POST['content']) ) {
		$szTorrentFile = $szTorrentFileName = 'custom';
		$szTorrentContent = $_POST['content'];
	}
}

?>
<!DOCTYPE html>
<!--
	See http://www.answers.com/topic/bencode for encoding algorithm
-->
<!--
	Example input:
	d3:inti5000e5:floatf10.12e6:string4:oele10:dictionaryd3:kut6:jammie4:cock3:bahe4:listl4:val14:val24:val3ee
	Output:
	Array
	(
		[int] => 5000
		[float] => 10.12
		[string] => oele
		[dictionary] => Array
			(
				[kut] => jammie
				[cock] => bah
			)

		[list] => Array
			(
				[0] => val1
				[1] => val2
				[2] => val3
			)

	)
-->
<html>

<head>
<title></title>
<style>
::selection { background-color:#000; color:#fff; }
.debug { color:red; opacity:0.3; }
</style>
</head>

<body>
<form method="post" action="" enctype="multipart/form-data">
	<fieldset>
		<legend>Upload .torrent</legend>
		<p>Torrent: <input type=file name=torrent></p>
		<p>or Data: <textarea name=content rows="2" cols="90"><?=isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''?></textarea></p>
		<p><input type=submit value=Upload></p>
	</fieldset>
</form>

<?php isset($szTorrentContent, $szTorrentFileName) or exit; ?>

<h1><?=$szTorrentFileName?></h1>

<pre><?php

$output = TorrentReader::parse($szTorrentContent, $reader);

echo 'Iterations: '.$reader->iterations."\n\n";

print_r($output);

?></pre>

</body>

</html>
