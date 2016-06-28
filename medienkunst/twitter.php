<?php
use Abraham\TwitterOAuth\TwitterOAuth;
require_once 'vendor/autoload.php';

class TwitterHelper {
	
	
	private $accessToken;
	private $accessTokenSecret;
	private $consumerKey;
	private $consumerSecret;
	
	public function __construct(){
		$accessKeys = require('twitterKeys.php');
		$this->accessToken = $accessKeys['accessToken'];
		$this->accessTokenSecret = $accessKeys['accessTokenSecret'];
		$this->consumerKey = $accessKeys['consumerKey'];
		$this->consumerSecret = $accessKeys['consumerSecret'];
	}
	
	public function tweetPicture ($path){
		$tw = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);
		$content = $tw->get("account/verify_credentials");
		
		$status = "";
		
		$media1 = $tw->upload('media/upload', array('media' => $path));
		
		$tw->post('statuses/update', array(
				'status' => $status,
				'media_ids' => $media1->media_id_string
				)
		);
	}
}