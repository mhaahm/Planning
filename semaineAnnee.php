<?php
// extract projects
include_once __DIR__ . "/src/utils.php";
$pdo = connect();
$sql = "select t1.*,min(t2.start_date_tache) as start, max(end_date_tache) as end_date,t2.titre_tache from project t1 left join task t2 on t2.project_id=t1.id group by t1.titre,t2.titre_tache";
$res = $pdo->query($sql);
if (!$res) {
    print "<div class='alert'>No data in project table</div>";
    return;
}
$rows = $res->fetchAll();
if (!count($rows)) {
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
$nbweek = 0;
$start_year = mktime(0,0,0,1,1,date('Y'));
$end_year = mktime(0,0,0,12,31,date('Y'));
$weeks = [];
$months_week = [];
while ($start_year <= $end_year) {
    $nbweek++;
    $weeks[] = $start_year;
    $months_week[date('M',$start_year)][] = $start_year;
    $start_year = strtotime("+1 week",$start_year);

}
?>
<table>
    <thead>
    <tr>
        <th rowspan="3">Nom du projet</th>
        <th rowspan="3">Nom de la tâche</th>
        <th rowspan="1" colspan="<?= count($weeks) ?>"><?= date('Y') ?></th>
    </tr>
    <tr>
        <?php foreach ($months_week as $m => $w_p_m) {?>
            <th colspan="<?= count($w_p_m)?>"><?= $m ?></th>
        <?php } ?>
    </tr>
    <tr>
        <?php
        foreach ($weeks as $time) {
            $day = date('d', $time);
            ?>
            <th><?= $day ?></th>
            <?php
        } ?>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($plannings as $key => $values) { ?>
        <td rowspan="<?= count($values) + 1 ?>"><?= $key ?></td>
        <?php

        foreach ($values as $tache => $value) {

            $start = strtotime($value['start']);
            if (empty($value['end'])) {
                $value['end'] = date('Y-m-d H:i:s');
            }
            $end = strtotime($value['end']);
            { ?>
                <tr>
                <td><?= $tache ?></td>
                <?php foreach ($weeks as $time) {
                //print date('Y-m-d H:i:s',$start)." >=".date('Y-m-d H:i:s',$time)." && ".date('Y-m-d H:i:s',$end)."<=".date('Y-m-d H:i:s',$time)  ."<br>";
                $color = ($time >= $start and $time <= $end) ? "style=\"background-color:#452fff!important;\" title=\"Start: ".date('Y-m-d',$start).
                    " | End: ".date('Y-m-d',$end)."\"" : "";
                ?>
                <td <?= $color ?> ><?= date('d', $time) ?></td>
            <?php }
            } ?>
            </tr>
        <?php }
    } ?>
    </tbody>
</table>

