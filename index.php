<?php
include_once __DIR__ . "/src/utils.php";
$pdo = connect();
$sql = "select * from project ";
$res = $pdo->query($sql);
$rows = $res->fetchAll();
$projects = [];
foreach ($rows as $row) {
    $start = $row['start_date'];
    $end = $row['end_date'];
    if(empty($end)) {
        continue;
    }
    $start = new DateTime($start);
    $currentDate = new DateTime();
    $end = new DateTime($end);
    $diff = date_diff($start,$end);
    $diff2 = date_diff($currentDate,$end);
    $nbDay = $diff->days;
    $projects[] = [
        'title' => $row['titre'],
        'start' => $row['start_date'],
        'end' => $row['end_date'],
        'nbday' => $nbDay,
        'nbdayrestant' => $diff2->days
    ];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script type="text/javascript" src="js/utils.js" defer></script>
    <script type="text/javascript" src="js/app.js" defer></script>
    <title>Projet Pratique</title>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="header-left">
            <div class="header-logo">
                <div class="logo">
                    PROJETS-PRATIQUE
                </div>
                <div class="menu">
                    <button class="js-project-list">Liste de projet</button>
                    <button class="js-task-list">Liste des taches</button>
                    <button class="js-parameters">Paramètres</button>
                </div>
            </div>
            <div class="action-header">
                <div class="type-affichage">
                    <label>Type d'affichage</label>
                    <select class="js-type-affichage">
                        <option value="0">Jour + semaines</option>
                        <option value="1">Jour + mois</option>
                        <option value="2">Semaine + années</option>
                        <option value="3">Mois + années</option>
                    </select>
                </div>
                <div class="change-vue">
                    <label> Déplacer la vue :</label>
                    <div class="group-dir">
                        <button class="direction"><<</button>
                        <button class="direction"><</button>
                        <button class="direction">></button>
                        <button class="direction">>></button>
                    </div>

                </div>
                <div class="change-vue">
                    <label>Elargir / réduire la vue :</label>
                    <div class="group-dir">
                        <button class="direction">+</button>
                        <button class="direction">-</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="header-right">
            <a href="#">Copier planning</a>
        </div>
    </div>

</div>
<div class="js-planning">

</div>

<dialog class="js-project-dialog dialog">
    <div id="dialog-container">
        <input id="tab-projet" type="radio" name="tab-group">
        <label for="tab-projet">Projets</label>
        <input id="tab-taches" type="radio" name="tab-group">
        <label for="tab-taches">Tâches</label>
        <input id="tab-parametres" type="radio" name="tab-group">
        <label for="tab-parametres">Paramètres</label>
        <input id="tab-apropos" type="radio" name="tab-group">
        <label for="tab-apropos">A propos</label>
        <div id="content">
            <div id="content-project" tab-content="yes">
                <div class="row">
                    <div class="div-btn">
                        Liste des projets
                    </div>
                    <div class="div-btn">
                        <button class="new-btn js-new-project">Ajout Projet</button>
                        <button class="new-btn js-show-project">Afficher les Projets</button>
                    </div>
                    <div class="project-show-all"><input type="checkbox">Afficher les projets désactivés</div>
                </div>
                <div class="js-listProject">
                    <table>
                        <thead>
                        <tr>
                            <th>Project name</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>NB days</th>
                            <th>NB days restant</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  foreach ($projects as $projet) { ?>
                        <tr>
                            <td><?= $projet['title'] ?></td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>
                                <progress value="40" max="100" contextmenu="40%">40%</progress>
                            </td>
                            <td><span>&#9650;</span><span>&#9660;</span</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="js-newProject" style="display: none;">
                        <div style="width: 60%">
                            <label class="form-label">Nom du projet</label>
                            <input type="text" id="project-name" class="form-control"/></br>
                            <label class="form-label">Date debut</label>
                            <input type="datetime-local" id="project-start" class="form-control"/></br>
                            <label class="form-label">Date Fin</label>
                            <input type="datetime-local" id="project-end" class="form-control"/></br>
                        </div>
                        <div style="width: 40%">
                            <label class="form-label" style="width: 100%;">Projet Active
                            <input type="checkbox" id="project-active"/></label>
                            <label class="form-label" style="width: 100%;">Projet Terminé
                            <input type="checkbox" id="project-finished"/></label>
                            <button class="success-btn js-save-project" style="margin-left: 242px;margin-top: 177px;">Sauvegarder</button>
                        </div>

                    </div>
                    </div>
                    <div id="content-taches" tab-content="yes">
                        <div class="row">
                            <div style="width: 60%;">
                                Choix du projets
                                <select style="width: 60%">
                                    <option value="Projet1">Projet</option>
                                    }
                                </select>
                            </div>
                            <div class="project-show-all"><input type="checkbox">Afficher les projets désactivés</div>
                        </div>
                        <table>
                            <thead>
                            <tr>
                                <th>Tascks name</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>NB days</th>
                                <th>NB days restant</th>
                                <th>Progress</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>data</td>
                                <td>data</td>
                                <td>data</td>
                                <td>data</td>
                                <td>data</td>
                                <td>
                                    <progress value="40" max="100" contextmenu="40%">40%</progress>
                                </td>
                                <td><span>&#9650;</span><span>&#9660;</span</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="content-parametres" tab-content="yes">
                        <p>Coloration des weekends (jours à griser sur les plannings 1 et 2)</p>
                        <span class="day-name"><input type="checkbox">LU</span>
                        <span class="day-name"><input type="checkbox">MA</span>
                        <span class="day-name"><input type="checkbox">ME</span>
                        <span class="day-name"><input type="checkbox">JE</span>
                        <span class="day-name"><input type="checkbox">VE</span>
                        <span class="day-name"><input type="checkbox">SA</span>
                        <span class="day-name"><input type="checkbox">DI</span>
                        <p>Coloration du jour en cours sur les plannings 1 et 2</p>
                        <span class="day-name"><input type="radio">Oui</span> <span class="day-name"><input
                                    type="radio">Non</span>
                        <span class="day-name"><input type="color"></span>
                        <p>Coloration de la semaine en cours du planning 3</p>
                        <span class="day-name"><input type="radio">Oui</span> <span class="day-name"><input
                                    type="radio">Non</span>
                        <span class="day-name"><input type="color"></span>
                        <p>Coloration du mois en cours du planning 4</p>
                        <span class="day-name"><input type="radio">Oui</span> <span class="day-name"><input
                                    type="radio">Non</span>
                        <span class="day-name"><input type="color"></span>
                    </div>
                    <div id="content-apropos" tab-content="yes">
                        <p>Numero de licence: <input type="text" style="width:287px;"></p>
                        <p>Type de licence: </p>
                        <textarea name="" col="10">
CONTRAT DE LICENCE POUR LE LOGICIEL PROJETS-PRATIQUE

AVIS A L'UTILISATEUR : Vous ne devez pas distribuer ou reproduire le logiciel dans son intégralité ou en partie sans l'accord de son auteur (sauf indications contraires prévue dans le présent contrat). Vous ne devez combiner le logiciel avec, ni l'incorporer dans tout autre application (sauf indications contraires prévue dans le présent contrat). Vous ne devez pas transférer, vendre ou louer le logiciel ou toute copie de celui-ci. Vous pouvez utiliser le logiciel sous le présent contrat de licence.

                </textarea>
                        <p><b>INFORMATION DEV</b></p>
                        <p><b>Email: </b> moham.hassen@gmail.com</p>
                    </div>
                </div>
                <div class="dialog-action">
                    <button class="danger-btn js-close">Fermer</button>
                </div>
            </div>

</dialog>
</body>
</html>