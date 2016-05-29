<?php 

require __DIR__ . '/vendor/autoload.php';

$pwc = new \tox2ik\PasswordCracker;
$pwc->dictionary('zumbaworkoutmedhelle ');
$pwc->min(24)->max(24);
$pwc->checkPassCallback(function($word) {
	system("gpg --yes --batch --passphrase=$word  --decrypt message.gpg   2>/dev/null", $ret);
	return $ret == 0;
});
$pwc->crack();



