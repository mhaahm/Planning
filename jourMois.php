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
$nbweek = 1;
?>
<table>
    <thead>
    <tr>
        <th rowspan="2">Nom du projet</th>
        <th rowspan="2">Nom de la tâche</th>
        <th colspan="<?= date('t') ?>"><?= date('Y-m') ?></th>
    </tr>
    <tr>
        <?php
        $times = [];
        $first = mktime(0,0,0,date('m'),1,date('Y'));
        for ($i = 1; $i <= date('t'); $i++) {
            $day = date('d', $first);
            $times[] = $first;
            $first = strtotime("+1 day", $first);
            ?>
            <th><?= $i ?></th>
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
                <?php foreach ($times as $time) {
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

