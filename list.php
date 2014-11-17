<?php

// http://zhifei.com/list.php?page=1$pagesize=12
// 

require_once("./response.php");
require_once("./db.php");
require_once("./file.php");

$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (!is_numeric($page)) {

	echo Response::showJSON(404, "参数格式错误");

	die();
}


$pageSize = 2;
$offset = ($page - 1) * $pageSize;
$get_data_sql_str = "select * from vedio.v order by id asc limit " . $offset . "," . $pageSize;


// 从数据库查找数据
// 

try {

	$db = Db::shareInstance();
	$conn = $db -> connect();

} catch (EXception $e) {

	echo Response::showJSON(404,"连接数据库错误");	

	return;
}




$result = $conn -> query($get_data_sql_str);

$obj = array();

if ($result -> num_rows > 0) {

	while ($row_obj = $result -> fetch_assoc()) {
		
		$obj[] = $row_obj;
	}
}

$file_cache = new File();

$file_cache -> cacheData("key", $obj, 20);

if ($obj) {
	
	echo Response::showJSON(200,"数据成功",$obj);	
} else {

	echo Response::showJSON(404,"没有数据");	
}
 

?>