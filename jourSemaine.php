<?php
  // extract projects
  include_once __DIR__."/src/utils.php";
  $pdo = connect();
  $sql = "select t1.*,min(t2.start_date_tache) as start, max(end_date_tache) as end_date,t2.titre_tache from project t1 left join task t2 on t2.project_id=t1.id group by t1.titre,t2.titre_tache";
  $res = $pdo->query($sql);
  if(!$res) {
  	print "<div class='alert'>No data in project table</div>";
  	return;
  }
  $rows = $res->fetchAll();
  if(!count($rows)) {
	print "<div class='alert'>No data in project table</div>";
  	return;
  }
  $plannings = [];

  foreach ($rows as $row) {
  	
  	$plannings[$row['titre']][$row['titre_tache']] = [
  		'start' => $row['start'],
  		'end' => $row['end_date']
  	];
  }
  $dir = $_GET['dir']??0;
  $nbweek = 4;
?>
<table>
     <thead>
         <tr>
             <th rowspan="2">Nom du projet</th>
             <th rowspan="2">Nom de la tâche</th>
             <?php  
             	$weeks_times = [];
                 for($i = $nbweek ; $i > 0 ; $i--) {
                     $weeks_times[] = date('Y-m-d',strtotime("sunday -$i week"));
                 }
                for($i = count($weeks_times) ; $i >0  ; $i--) {
                  $time = strtotime("sunday -$i week");
                  $date = date('Y-m-d',$time);
                  $w = date('W',$time);

             ?>
                  <th colspan="7"><?= $date.'  semaine '.$w ?></th>
         	 <?php } ?>
         </tr>
         <tr>
             <?php
                $times = []; 
                $first = min($weeks_times);
                $last = max($weeks_times);
                $last = strtotime("next saturday",$last);
                while($first <= $last) { 
                  $day = date('d',$first);
                  $times[] = $first;
                  $first = strtotime("+1 day",$first);


             ?>
                  <th><?= $day ?></th>
         	 <?php 
         	} ?>
         </tr>
     </thead>
     <tbody>
        <?php 
        	foreach ($plannings as $key => $values) { ?>
        		<td rowspan="<?= count($values) +1 ?>"><?= $key ?></td>
        		<?php 

        		 foreach ($values as $tache => $value) {
        		
        	 	$start = strtotime($value['start']);
        	 	if(empty($value['end'])) {
        	 		$value['end'] = date('Y-m-d H:i:s');
        	 	}
        	 	$end = strtotime($value['end']);
        	 { ?>
        	 <tr>
        	 	
        	 	<td><?= $tache ?></td>
        	 <?php foreach($times as $time) {
        	 	//print date('Y-m-d H:i:s',$start)." >=".date('Y-m-d H:i:s',$time)." && ".date('Y-m-d H:i:s',$end)."<=".date('Y-m-d H:i:s',$time)  ."<br>";
        	 	$color = ($time >=$start and $time<=$end) ? "style=\"background-color:#452fff!important;\" title=\"Start: ".date('Y-m-d',$start).
                    " | End: ".date('Y-m-d',$end)."\"":"";

        	 	?>
				<td <?= $color ?> ><?= date('d',$time) ?></td>
        	 <?php } } ?>
        	 </tr>
       <?php }} ?>
     </tbody>
</table>

