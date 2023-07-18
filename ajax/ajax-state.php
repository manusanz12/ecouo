<?php

require_once "../controllers/curl.controller.php";

class StateController{

	public $state;
	public $idnoticie;
	public $token;

	public function dataState(){

		$url = "noticies?id=".$this->idnoticie."&nameId=id_noticie&token=".$this->token."&table=users&suffix=user";
		$method = "PUT";
		$fields = "state_noticie=".$this->state;

		$response = CurlController::request($url, $method, $fields)->status;

		echo json_encode($response);
		
	}

}

if(isset($_POST["state"])){
	$state = new StateController();
	$state -> state = $_POST["state"];
	$state -> idnoticie = $_POST["idnoticie"];
	$state -> token = $_POST["token"];
	$state -> dataState();
}