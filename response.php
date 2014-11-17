<?php

/**
* 
*/
class Response
{
	static public function showJSON($code, $message = "", $data = array())
	{
		$result = array(
			"code" => $code,
			"message" => $message,
			"data" => $data);

		return json_encode($result);
	}
}

?>