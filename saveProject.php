<?php
include_once __DIR__ . "/src/utils.php";
$pdo = connect();
$content = json_decode(trim(file_get_contents("php://input")),true);
$project_title = $content['title'];
$start = $content['start'];
$end = $content['end'];
$created = date('Y-m-d H:i:s');
$active = $content['active'];
$finished = $content['finished'];
$sql = "select * from project where titre='$project_title'";
$res = $pdo->query($sql);
$result = [];
try {
    if($row = $res->fetch()) {
        $id = $row['Id'];
    } else {
        $sql = "insert into project(titre,start_date,created,end_date,active,finished) values ('$project_title','$start','$created',$end,1,0);";
        $pdo->query($sql);
        $id = $pdo->lastInsertId();
    }
    $result['res'] = 'success';
    $result['id'] = $id;
} catch (Exception $e) {
    $result['res'] = 'error';
    $result['id'] = 0;
}
print json_encode($result);