	

<?php
/**
 * Template Name: Darlic API
 */
	header('Content-Type: application/json');
	$output = "";
	$errors = array();
	$success_messages = array();

	$_app_id = "";
	$_app_key = "";

		
	$secret_key = "CAX4RYDJBUKM8BSYQEZP";

	$action = trim($_REQUEST['action']);
	$app_id = trim($_REQUEST['app_id']);

	$api_key = trim($_REQUEST['api_key']);
	$input_data = trim($_REQUEST['data']);

	if (!empty($action) && $action == 'import' && !empty($apikey) && $apikey == $secret_key) {
		$survey_data = array();


		

		return json_encode($survey_data);
	} else {
		if ($action != 'import' || $action != 'activate' || $action != 'export') {
			$errors[] = 'Invalid Request';
		}

		if ($apikey != $secret_key) {
			$errors[] = 'Invalid API Key';
		}

		if (empty($input_data)) {
			$errors[] = 'Invalid Data';
		}

		$errors[] = 'Some error occurred.';
	}

	if (empty($errors)) {
		$s_messages = array();
		$i = 0;
		foreach($success_messages as $success_message) {
			$i++;
			$s_messages['m' . $i] = $success_message;
		}

		$api_return = array(
			'status' => "success",
			'messages' => $s_messages
		);
		$output.= json_encode($api_return);
	}

	if (!empty($errors)) {
		$error_messages = array();
		$i = 0;
		foreach($errors as $error) {
			$i++;
			$error_messages['e' . $i] = $error;
		}

		$api_return = array(
			'status' => "error",
			'messages' => $error_messages
		);
		$output.= json_encode($api_return);
	}
	echo $output;