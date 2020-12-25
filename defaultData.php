<?php
  
$database_path = __DIR__."/data/planning.sqlite";
try{
    $pdo = new PDO('sqlite:'.$database_path);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

$planning = [];
print "Start treatment \n";
print "Create table project \n";
// create project table
$pdo->query("CREATE TABLE IF NOT EXISTS project (
	Id INTEGER PRIMARY KEY AUTOINCREMENT,
	titre varchar(255),
	created DATETIME,
	start_date DATETIME,
	end_date DATETIME,
	active INTEGER,
	finished INTEGER)");

print "Create table task \n";
// create task table
$pdo->query(" CREATE TABLE IF NOT EXISTS task (
	Id INTEGER PRIMARY KEY AUTOINCREMENT,
	titre_tache varchar(255),
	start_date_tache DATETIME,
	end_date_tache DATETIME,
	project_id INTEGER not null,
	FOREIGN KEY (project_id)
	REFERENCES project(id)
    ON DELETE CASCADE)");

// create project
for($i = 0; $i< 100 ;$i++)
{
	$project_title = "New Project $i ";
	$start = date('Y-m-d H:i:s');
	$end_date = date('Y-m-d H:i:s',strtotime("+$i day"));
	$id = 0;
	$sql = "select * from project where titre='$project_title'";
	$res = $pdo->query($sql);
	if($row = $res->fetch()) {
		$id = $row['Id'];
	} else {
		$sql = "insert into project(titre,start_date,created,end_date,active,finished) values ('$project_title','$start','$start','$end_date',1,0);";
		print $sql."\n";
		$pdo->query($sql);
		$id = $pdo->lastInsertId();
	}

	for ($j=0; $j < 3 ; $j++) { 
		$task_title = "Task $j";
		$sql = "select * from task where titre_tache='$task_title' and project_id=$id";
		$res = $pdo->query($sql);
		if($row = $res->fetch()) {
			$id = $row['Id'];
			continue;
		}
		$sql = "insert into task(titre_tache,start_date_tache,project_id) values ('$task_title','$start',$id);";
		$pdo->query($sql);
	}
}

?>