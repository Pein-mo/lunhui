<?php
namespace app\api\controller;

class Hook
{
    public function index()
    {
    	$secret = "q20031120";
    	$path = "/www/wwwroot/lh.mo1120.com";
		// Headers deliveried from GitHub
		$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
		if ($signature) {
		  $hash = "sha1=".hash_hmac('sha1', file_get_contents("php://input"), $secret);
		  if (strcmp($signature, $hash) == 0) {
		    echo shell_exec("cd {$path} && /usr/bin/git reset --hard origin/master && /usr/bin/git clean -f && /usr/bin/git pull 2>&1");
		    exit();
		  }
		}
		http_response_code(404);
    }
}
