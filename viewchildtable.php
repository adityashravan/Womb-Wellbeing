<?php
error_reporting(0);
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "foetus1";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Input Form Doctor And Save Into Database

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Child Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?<?= Date("H:s:ia") ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
</head>

<body>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Womb Wellness</h1>
        <p>Taking Regular And Intensive Care of Baby and the Mother</p>

        <?php
        if ($_SESSION['isLoggedIn'] == true && $_SESSION['LoggedInUid'] > 0) {
        ?>
            <span style="color:#ffffff;float:right;">Welcome <i><?php print $_SESSION['LoggedInUsr']; ?></i>
                | <a href="logout.php" style="color:#ffffff;">Log out</a>
            </span>
        <?php } else {
            header("location:logout.php");
        }
        ?>

    </div>


    <section class="section123" style="padding: 30px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="viewAll">
                        <table style="width: 100%;" id="ViewChildtable" class="display nowrap">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Patient Name</th>
                                    <th>Gender</th>
                                    <th>Patient Age</th>
                                    <th>Systolic BP</th>
                                    <th>Diastolic BP</th>
                                    <th>BS</th>
                                    <th>Body Temperature</th>
                                    <th>HeartRate</th>
                                    <th>View Details</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                // Select Table and Featch All data
                                $sql = mysqli_query($conn, "SELECT * FROM `tbl_patient` ORDER BY `PatientID` desc");
                                $i = 1;
                                while ($dataRow = mysqli_fetch_assoc($sql)) {

                                ?>
                                    <tr>
                                        <td><?= $i ?></td>

                                        <td><?= $dataRow['PatientName'] ?></td>
                                        <td><?= $dataRow['Gender'] ?></td>
                                        <td><?= $dataRow['Age'] ?></td>
                                        <td><?= $dataRow['SystolicBP'] ?></td>
                                        <td><?= $dataRow['DiastolicBP'] ?></td>
                                        <td><?= $dataRow['BS'] ?></td>
                                        <td><?= $dataRow['BodyTemp'] ?></td>
                                        <td><?= $dataRow['HeartRate'] ?></td>
                                        <td>
                                            <a href="viewchildtable.php?id=<?= $dataRow['PatientID'] ?>&mid=<?= $dataRow['PatientID'] ?>" class="btn btn-primary">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php $i++;
                                } ?>
                            </tbody>
                        </table>
                    </div>


                    <div id="viewAll2">
                        <?php

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $distinct = $_POST['distinct'];

                            header("location: ?dist=$distinct");
                        }

                        ?>

                        <h2>Parent Mental Status</h2>
                        <div>
                            <form method="post">
                                <select class="form-select" name="distinct" aria-label="Default select example">
                                    <option selected hidden>-- Select Distinct Entity --</option>
                                    <option value="IND">IND</option>
                                    <option value="USA">USA</option>
                                    <option value="Others">Others</option>
                                </select>

                                <div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <table style="width: 100%;" id="Viewdistincttable" class="display nowrap">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Entity</th>
                                    <th>Code</th>
                                    <th>Year</th>
                                    <th>Schizophrenia disorders</th>
                                    <th>Depressive disorders</th>
                                    <th>Anxiety disorders</th>
                                    <th>Eating disorders</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                // Select Table and Featch All data
                                if (isset($_GET['dist'])) {
                                    $dist = $_GET['dist'];
                                    if (isset($_GET['dist']) && $_GET['dist'] == "Others") {
                                        $sql2 = mysqli_query($conn, "SELECT * FROM `parent` WHERE `Code` not in ('USA' , 'IND')  ORDER BY `Code` ASC");
                                    } else {
                                        $sql2 = mysqli_query($conn, "SELECT * FROM `parent` WHERE `Code` = '$dist'  ORDER BY `Code` ASC");
                                    }

                                    $i = 1;
                                    while ($dataRow2 = mysqli_fetch_assoc($sql2)) {

                                ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $dataRow2['Entity'] ?></td>
                                            <td><?= $dataRow2['Code'] ?></td>
                                            <td><?= $dataRow2['Year'] ?></td>
                                            <td><?= $dataRow2['Schizo_Dis'] ?></td>
                                            <td><?= $dataRow2['Depr_Dis'] ?></td>
                                            <td><?= $dataRow2['Anx_Dis'] ?></td>
                                            <td><?= $dataRow2['Bip_Dis'] ?></td>
                                            <td><?= $dataRow2['Eat_Dis'] ?></td>
                                        </tr>
                                    <?php $i++;
                                    } ?>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>


                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        // $sql = "select t1.PatientID,t1.PatientName,t1.Age,t1.SystolicBP,t1.DiastolicBP,t1.BS,t1.BodyTemp,t1.HeartRate,t1.Date,t2.RiskLevel from tbl_patient as t1 inner join patientdata as t2 on t1.Age = t2.Age WHERE t1.PatientID = $id";                       
                        $sql = "select t1.PatientID,t1.PatientName,t1.Gender,t1.Age,t1.SystolicBP,t1.DiastolicBP,t1.BS,t1.BodyTemp,t1.HeartRate,t1.Date,t2.RiskLevel from tbl_patient as t1 inner join patientdata as t2 on t1.Age = t2.Age and t1.SystolicBP = t2.SystolicBP and t1.DiastolicBP = t2.DiastolicBP  WHERE t1.PatientID = $id";
                        $feach = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($feach);
                    ?>

                        <div>
                            <div style="display: flex;justify-content: right;align-items: center;margin: 0.75rem 0;">
                                <a href="javascript: void(0)" class="btn btn-primary mx-12">Check Health</a>
                                <a href="viewchildtable.php" class="btn btn-primary mx-12">Go Back</a>
                            </div>
                            <table style="width: 100%;" id="ViewChildtable2" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Patient Name</th>
                                        <th>Gender</th>
                                        <th>Patient Age</th>
                                        <th>Systolic BP</th>
                                        <th>Diastolic BP</th>
                                        <th>BS</th>
                                        <th>Body Temperature</th>
                                        <th>HeartRate</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><?= $row['PatientName'] ?></td>
                                        <td><?= $row['Gender'] ?></td>
                                        <td><?= $row['Age'] ?></td>
                                        <td><?= $row['SystolicBP'] ?></td>
                                        <td><?= $row['DiastolicBP'] ?></td>
                                        <td><?= $row['BS'] ?></td>
                                        <td><?= $row['BodyTemp'] ?></td>
                                        <td><?= $row['HeartRate'] ?></td>
                                        <td>
                                            <?php if ($row['RiskLevel'] == "high risk") { ?>
                                                <div class="alert alert-danger" style="padding:0.25rem 0.75rem;margin:0;">
                                                    High Risk
                                                </div>
                                            <?php } ?>
                                            <?php if ($row['RiskLevel'] == "low risk") { ?>
                                                <div class="alert alert-secondary" style="padding:0.25rem 0.75rem;margin:0;">
                                                    Low Risk
                                                </div>
                                            <?php } ?>
                                            <?php if ($row['RiskLevel'] == "mid risk") { ?>
                                                <div class="alert alert-warning" style="padding:0.25rem 0.75rem;margin:0;">
                                                    Mid Risk
                                                </div>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                    <?php } ?>


                    <?php
                    if (isset($_GET['id']) && isset($_GET['mid'])) {
                        $mid = $_GET['mid'];
                        $fcheck = "select  case 
                        when t2.fetal_health =1 then 'Normal'
                        when  t2.fetal_health =2 then 'Suspected'
                        when  t2.fetal_health =3 then 'Pathelogical'  
                        else 'To be Determined'
                        END as STATUS1,
                                      t1.baseline_value , 
                                             t1.accelerations ,
                                             t1.fetal_movement ,
                                             t1.uterine_contractions ,
                                             t1.light_decelerations ,
                                             t1.severe_decelerations ,
                                             t1.prolonged_decelerations ,
                                             t1.abnormal_short_term_variability ,
                                             t1.mean_value_of_short_term_variability ,
                                             t1.percentage_of_time_with_abnormal_long_term_variability ,
                                             t1.mean_value_of_long_term_variability ,
                                              t1.histogram_width, 
                                              t1.histogram_min ,
                                              t1.histogram_max,
                                              t1.histogram_number_of_peaks,
                                              t1.histogram_number_of_zeroes,
                                              t1.histogram_mode,
                                              t1.histogram_mean ,
                                              t1.histogram_median,
                                              t1.histogram_variance ,
                                              t1.histogram_tendency,
                                               t2.fetal_health 
                     from tbl_childhealth as t1,
                          featus_data as t2 
                     where t1.baseline_value = t2.baseline_value  
                     and  t1.accelerations = t2.accelerations 
                     and t1.uterine_contractions = t2.uterine_contractions 
                     and `PatientID` = $mid limit 1";
                        // $childHealth = mysqli_query($conn, "SELECT * FROM `tbl_childhealth` WHERE `PatientID` = $mid");
                        $childHealth = mysqli_query($conn, $fcheck);
                        $childFeach = mysqli_fetch_assoc($childHealth);
                    ?>

                        <div id="viewfdata">
                            <div class="patientForm">
                                <h2 class="headding">Foetus Data</h2>
                                <div class="mb-3 row">
                                    <label for="baseline_value " class="col-sm-2 col-form-label">Baseline Value</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="baseline_value" id="baseline_value" value="<?= $childFeach['baseline_value'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="accelerations" class="col-sm-2 col-form-label">Accelerations</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="accelerations" id="accelerations" value="<?= $childFeach['accelerations'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="fetal_movement " class="col-sm-2 col-form-label">fetal_movement </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="fetal_movement" id="fetal_movement " value="<?= $childFeach['fetal_movement'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="uterine_contractions" class="col-sm-2 col-form-label">uterine_contractions</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="uterine_contractions" id="uterine_contractions" value="<?= $childFeach['uterine_contractions'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="light_decelerations" class="col-sm-2 col-form-label">light_decelerations</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="light_decelerations" id="light_decelerations" value="<?= $childFeach['light_decelerations'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="severe_decelerations" class="col-sm-2 col-form-label">severe_decelerations</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="severe_decelerations" id="severe_decelerations" value="<?= $childFeach['severe_decelerations'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="prolonged_decelerations" class="col-sm-2 col-form-label">prolonged_decelerations</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="prolonged_decelerations" id="prolonged_decelerations" value="<?= $childFeach['prolonged_decelerations'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="abnormal_short_term_variability" class="col-sm-2 col-form-label">abnormal_short_term_variability</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="abnormal_short_term_variability" id="abnormal_short_term_variability" value="<?= $childFeach['abnormal_short_term_variability'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="mean_value_of_short_term_variability" class="col-sm-2 col-form-label">mean_value_of_short_term_variability</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mean_value_of_short_term_variability" id="mean_value_of_short_term_variability " value="<?= $childFeach['mean_value_of_short_term_variability'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="percentage_of_time_with_abnormal_long_term_variability" class="col-sm-2 col-form-label">percentage_of_time_with_abnormal_long_term_variability </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="percentage_of_time_with_abnormal_long_term_variability" id="percentage_of_time_with_abnormal_long_term_variability " value="<?= $childFeach['percentage_of_time_with_abnormal_long_term_variability'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="mean_value_of_long_term_variability" class="col-sm-2 col-form-label">mean_value_of_long_term_variability</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mean_value_of_long_term_variability" id="mean_value_of_long_term_variability " value="<?= $childFeach['mean_value_of_long_term_variability'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_width" class="col-sm-2 col-form-label">histogram_width</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_width" id="histogram_width" value="<?= $childFeach['histogram_width'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_min" class="col-sm-2 col-form-label">histogram_min</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_min" id="histogram_min" value="<?= $childFeach['histogram_min'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_max" class="col-sm-2 col-form-label">histogram_max</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_max" id="histogram_max" value="<?= $childFeach['histogram_max'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_number_of_peaks" class="col-sm-2 col-form-label">histogram_number_of_peaks </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_number_of_peaks" id="histogram_number_of_peaks" value="<?= $childFeach['histogram_number_of_peaks'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_number_of_zeroes" class="col-sm-2 col-form-label">histogram_number_of_zeroes </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_number_of_zeroes" id="histogram_number_of_zeroes" value="<?= $childFeach['histogram_number_of_zeroes'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_mode" class="col-sm-2 col-form-label">histogram_mode </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_mode" id="histogram_mode" value="<?= $childFeach['histogram_mode'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_mean" class="col-sm-2 col-form-label">histogram_mean </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_mean" id="histogram_mean" value="<?= $childFeach['histogram_mean'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_median" class="col-sm-2 col-form-label">histogram_median </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_median" id="histogram_median" value="<?= $childFeach['histogram_median'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_variance" class="col-sm-2 col-form-label">histogram_variance </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_variance" id="histogram_variance" value="<?= $childFeach['histogram_variance'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="histogram_tendency" class="col-sm-2 col-form-label">histogram_tendency </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="histogram_tendency" id="histogram_tendency" value="<?= $childFeach['histogram_tendency'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="fetal_health" class="col-sm-2 col-form-label">fetal_health </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="fetal_health" id="fetal_health" value="<?= $childFeach['STATUS1'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>

                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
    <script>
        new DataTable('#ViewChildtable', {
            layout: {
                topStart: {
                    buttons: ['csv', 'excel', 'pdf']
                }
            }
        });
        new DataTable('#ViewChildtable2', {
            layout: {
                topStart: {
                    buttons: ['csv', 'excel', 'pdf']
                }
            }
        });
        new DataTable('#Viewdistincttable', {
            layout: {
                topStart: {
                    buttons: ['csv', 'excel', 'pdf']
                }
            }
        });
    </script>

    <?php if (isset($_GET['id'])) { ?>
        <script>
            document.getElementById('viewAll').style.display = "none";
            document.getElementById('viewAll2').style.display = "none";
        </script>
    <?php } ?>

</body>

</html>