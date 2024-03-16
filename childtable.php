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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recive Data Form Mother Form
    $patientName = $_POST['patientName'];
    $patientage = $_POST['patientage'];
    $systolicbp = $_POST['systolicbp'];
    $diastolicbp = $_POST['diastolicbp'];
    $bs = $_POST['bs'];
    $bodyTemp = $_POST['bodyTemp'];
    $heartRate = $_POST['heartRate'];
    $gender = $_POST['gender'];

    // Recive Data Form Foetus Data

    $baseline_value = $_POST['baseline_value'];
    $accelerations = $_POST['accelerations'];
    $fetal_movement = $_POST['fetal_movement'];
    $uterine_contractions = $_POST['uterine_contractions'];
    $light_decelerations = $_POST['light_decelerations'];
    $severe_decelerations = $_POST['severe_decelerations'];
    $prolonged_decelerations = $_POST['prolonged_decelerations'];
    $abnormal_short_term_variability = $_POST['abnormal_short_term_variability'];
    $mean_value_of_short_term_variability = $_POST['mean_value_of_short_term_variability'];
    $percentage_of_time_with_abnormal_long_term_variability = $_POST['percentage_of_time_with_abnormal_long_term_variability'];
    $mean_value_of_long_term_variability = $_POST['mean_value_of_long_term_variability'];
    $histogram_width = $_POST['histogram_width'];
    $histogram_min = $_POST['histogram_min'];
    $histogram_max = $_POST['histogram_max'];
    $histogram_number_of_peaks = $_POST['histogram_number_of_peaks'];
    $histogram_number_of_zeroes = $_POST['histogram_number_of_zeroes'];
    $histogram_mode = $_POST['histogram_mode'];
    $histogram_mean = $_POST['histogram_mean'];
    $histogram_median = $_POST['histogram_median'];
    $histogram_variance = $_POST['histogram_variance'];
    $histogram_tendency = $_POST['histogram_tendency'];
    $fetal_health = $_POST['fetal_health'];

    // Recive data Form Parent Health

    $entity = $_POST['entity'];
    $cCode = $_POST['Code'];
    $Year = $_POST['Year'];
    $Schizo_Dis = $_POST['Schizo_Dis'];
    $Depr_Dis = $_POST['Depr_Dis'];
    $Anx_Dis = $_POST['Anx_Dis'];
    $Bip_Dis = $_POST['Bip_Dis'];
    $Eat_Dis = $_POST['Eat_Dis'];
   



    // Insert Data Into Database table `tbl_patient`

    $insert = mysqli_query($conn, "INSERT INTO `tbl_patient` (`PatientName` , `Gender` , `Age` , `SystolicBP` ,  `DiastolicBP` , `BS` , `BodyTemp` , `HeartRate` , `RiskLevel` , `Date`) VALUES ('$patientName' , '$gender', '$patientage' , '$systolicbp' , '$diastolicbp' , '$bs' , '$bodyTemp' , '$heartRate' , 'null' , 'current_timestamp()' )");



    // Insert data Into `tbl_childhealth`

    $finsert = "INSERT INTO `tbl_childhealth` (
        baseline_value,
        accelerations,
        fetal_movement,
        uterine_contractions,
        light_decelerations,
        severe_decelerations,
        prolonged_decelerations,
        abnormal_short_term_variability,
        mean_value_of_short_term_variability,
        percentage_of_time_with_abnormal_long_term_variability,
        mean_value_of_long_term_variability,
        histogram_width,
        histogram_min,
        histogram_max,
        histogram_number_of_peaks,
        histogram_number_of_zeroes,
        histogram_mode,
        histogram_mean,
        histogram_median,
        histogram_variance,
        histogram_tendency       
    ) VALUES (
        $baseline_value, 
        $accelerations, 
        $fetal_movement, 
        $uterine_contractions,   
        $light_decelerations, 
        $severe_decelerations,
        $prolonged_decelerations,
        $abnormal_short_term_variability,  
        $mean_value_of_short_term_variability,   
        $percentage_of_time_with_abnormal_long_term_variability,  
        $mean_value_of_long_term_variability, 
        $histogram_width,  
        $histogram_min,  
        $histogram_max, 
        $histogram_number_of_peaks,   
        $histogram_number_of_zeroes,   
        $histogram_mode, 
        $histogram_mean, 
        $histogram_median, 
        $histogram_variance,  
        $histogram_tendency        
    )";

    // echo $finsert; exit();

    $exeFoetus = mysqli_query($conn, $finsert);



    // Insert data To `parent` 
    $pinsert = "INSERT INTO `parent` (Entity, Code, Year, Schizo_Dis, Depr_Dis, Anx_Dis, Bip_Dis, Eat_Dis)
    VALUES ('$entity', '$cCode', $Year, $Schizo_Dis , $Depr_Dis , $Anx_Dis , $Bip_Dis , $Eat_Dis)";
    
    $final = mysqli_query($conn , $pinsert);
   

    if ($exeFoetus && $insert && $final) {
        header("location: childtable.php?msg=success");
    }
    
}




?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?<?= Date("H:s:ia") ?>">
</head>

<body>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Womb Wellness</h1>
        <p>Resize this responsive page to see the effect!</p>

        <?php
        if ($_SESSION['isLoggedIn'] == true && $_SESSION['LoggedInUtp'] == "Doctor" && $_SESSION['LoggedInUid'] > 0) {
        ?>
            <span style="color:#ffffff;float:right;">Welcome <i><?php print $_SESSION['LoggedInUsr']; ?></i>
                | <a href="logout.php" style="color:#ffffff;">Log out</a>
            </span>
        <?php } else {
            header("location:logout.php");
        }
        ?>
    </div>



    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">


                    <div style="display: flex;justify-content: right;margin-bottom: 15px;align-items: center;">
                        <a href="viewchildtable.php" class="btn btn-primary" target="_blank">
                            View All Documents
                        </a>
                    </div>


                    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") { ?>
                        <div id="msgNone">
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                </symbol>
                                <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                </symbol>
                                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </symbol>
                            </svg>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <div>
                                    SuccessFully Data Added
                                </div>
                            </div>
                        </div>

                        <script>
                            setInterval(() => {
                                document.getElementById('msgNone').style.display = "none";
                            }, 5000);
                        </script>

                    <?php } ?>




                    <form method="post" onsubmit="validateForm()">

                        <div class="patientForm">
                            <h2 class="headding">Mother Data</h2>
                            <div class="mb-3 row">
                                <label for="patientName" class="col-sm-2 col-form-label">Patient Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="patientName" id="patientName" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="gender" class="col-sm-2 col-form-label">Gender</em></label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female" checked>
                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="Other" value="Other">
                                        <label class="form-check-label" for="Other">Other</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="patientage" class="col-sm-2 col-form-label">Patient Age</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control num" name="patientage" id="patientage" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="systolicbp" class="col-sm-2 col-form-label">SystolicBP <em>(in mm Hg)</em></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control num" name="systolicbp" id="systolicbp" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="diastolicbp" class="col-sm-2 col-form-label">DiastolicBP <em>(in mm Hg)</em></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control num" name="diastolicbp" id="diastolicbp" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="BS" class="col-sm-2 col-form-label">BS</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control num" name="bs" id="BS">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="BodyTemp" class="col-sm-2 col-form-label">BodyTemp <em>(in Fahrenheit)</em></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control num" name="bodyTemp" id="BodyTemp" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="HeartRate" class="col-sm-2 col-form-label">HeartRate <em>(in BPM)</em></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control num" name="heartRate" id="HeartRate" required>
                                </div>
                            </div>

                            <!-- <div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> -->
                        </div>
                        <div class="patientForm">
                            <h2 class="headding">Foetus Data</h2>
                            <div class="mb-3 row">
                                <label for="baseline_value " class="col-sm-2 col-form-label">Baseline Value</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="baseline_value" id="baseline_value" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="accelerations" class="col-sm-2 col-form-label">Accelerations</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="accelerations" id="accelerations" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="fetal_movement " class="col-sm-2 col-form-label">fetal_movement </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fetal_movement" id="fetal_movement " required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="uterine_contractions" class="col-sm-2 col-form-label">uterine_contractions</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="uterine_contractions" id="uterine_contractions" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="light_decelerations" class="col-sm-2 col-form-label">light_decelerations</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="light_decelerations" id="light_decelerations" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="severe_decelerations" class="col-sm-2 col-form-label">severe_decelerations</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="severe_decelerations" id="severe_decelerations" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="prolonged_decelerations" class="col-sm-2 col-form-label">prolonged_decelerations</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="prolonged_decelerations" id="prolonged_decelerations" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="abnormal_short_term_variability" class="col-sm-2 col-form-label">abnormal_short_term_variability</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="abnormal_short_term_variability" id="abnormal_short_term_variability" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="mean_value_of_short_term_variability" class="col-sm-2 col-form-label">mean_value_of_short_term_variability</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="mean_value_of_short_term_variability" id="mean_value_of_short_term_variability " required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="percentage_of_time_with_abnormal_long_term_variability" class="col-sm-2 col-form-label">percentage_of_time_with_abnormal_long_term_variability </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="percentage_of_time_with_abnormal_long_term_variability" id="percentage_of_time_with_abnormal_long_term_variability " required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="mean_value_of_long_term_variability" class="col-sm-2 col-form-label">mean_value_of_long_term_variability</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="mean_value_of_long_term_variability" id="mean_value_of_long_term_variability " required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_width" class="col-sm-2 col-form-label">histogram_width</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_width" id="histogram_width" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_min" class="col-sm-2 col-form-label">histogram_min</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_min" id="histogram_min" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_max" class="col-sm-2 col-form-label">histogram_max</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_max" id="histogram_max" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_number_of_peaks" class="col-sm-2 col-form-label">histogram_number_of_peaks </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_number_of_peaks" id="histogram_number_of_peaks" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_number_of_zeroes" class="col-sm-2 col-form-label">histogram_number_of_zeroes </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_number_of_zeroes" id="histogram_number_of_zeroes" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_mode" class="col-sm-2 col-form-label">histogram_mode </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_mode" id="histogram_mode" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_mean" class="col-sm-2 col-form-label">histogram_mean </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_mean" id="histogram_mean" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_median" class="col-sm-2 col-form-label">histogram_median </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_median" id="histogram_median" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_variance" class="col-sm-2 col-form-label">histogram_variance </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_variance" id="histogram_variance" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="histogram_tendency" class="col-sm-2 col-form-label">histogram_tendency </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="histogram_tendency" id="histogram_tendency" required>
                                </div>
                            </div>
                        </div>
                        <div class="patientForm">
                            <h2 class="headding">Parent Health (Both F/M)</h2>
                            <div class="mb-3 row">
                                <label for="Entity" class="col-sm-2 col-form-label">Entity</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="entity" id="Entity" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Code" class="col-sm-2 col-form-label">Contry Code </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Code" id="Code" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Year" class="col-sm-2 col-form-label">Year</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Year" id="Year" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Schizo_Dis" class="col-sm-2 col-form-label">Schizophrenia Disorders</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Schizo_Dis" id="Schizo_Dis" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Depr_Dis" class="col-sm-2 col-form-label">Depressive Disorders</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Depr_Dis" id="Depr_Dis" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Anx_Dis" class="col-sm-2 col-form-label">Anxiety disorders</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Anx_Dis" id="Anx_Dis" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Bip_Dis" class="col-sm-2 col-form-label">Bipolar Disorders</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Bip_Dis" id="Bip_Dis" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Eat_Dis" class="col-sm-2 col-form-label">Eating disorders</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Eat_Dis" id="Eat_Dis" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>

</body>

</html>