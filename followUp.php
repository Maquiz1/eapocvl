<?php

require 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        if ($_GET['site']) {
            $data = $override->FollowUpList7($_GET['start_date'], $_GET['end_date'], $_GET['site']);
            $dataCount = $override->FollowUpList7Count($_GET['start_date'], $_GET['end_date'], $_GET['site']);

            // $data1 = $override->FollowUpList7($_GET['start_date'], $_GET['end_date'], $_GET['site']);
            $dataCount1 = $override->FollowUpList7Count1($_GET['start_date'], $_GET['end_date'], $_GET['site'],1);
            $dataCount0 = $override->FollowUpList7Count1($_GET['start_date'], $_GET['end_date'], $_GET['site'],0);
            $dataCount2 = $override->FollowUpList7Count1($_GET['start_date'], $_GET['end_date'], $_GET['site'],2);


        } else {
            $data = $override->FollowUpList6($_GET['start_date'], $_GET['end_date']);
            $dataCount = $override->FollowUpList6Count($_GET['start_date'], $_GET['end_date']);

            $dataCount1 = $override->FollowUpList6Count1($_GET['start_date'], $_GET['end_date'],1);
            $dataCount0 = $override->FollowUpList6Count1($_GET['start_date'], $_GET['end_date'],0);
            $dataCount2 = $override->FollowUpList6Count1($_GET['start_date'], $_GET['end_date'],2);

        }
        $successMessage = 'Report Successful Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}

if ($_GET['site'] == 1) {
    $title = 'EAPOCVL FOLOW UP LIST FOR SINZA HOSPITAL';
} elseif ($_GET['site'] == 2) {
    $title = 'EAPOCVL FOLOW UP LIST FOR MNAZI MMOJA HOSPITAL';
} elseif ($_GET['site'] == 3) {
    $title = 'EAPOCVL FOLOW UP LIST FOR AMANA HOSPITAL';
} elseif ($_GET['site'] == 4) {
    $title = 'EAPOCVL FOLOW UP LIST FOR MWANANYAMALA HOSPITAL';
} else {
    $title = 'EAPOCVL FOLOW UP LIST FOR ALL NIMR SITES';
}

$sub_title = 'FROM ' . $_GET['start_date'] . '  TO  ' . $_GET['end_date'];


$pdf = new Pdf();

// $title = 'NIMREGENIN SUMMARY REPORT_'. date('Y-m-d');
$file_name = $title . '.pdf';

$output = ' ';

$output .= '
<html>
    <head>
        <style>
            @page { margin: 50px;}
            header { position: fixed; top: -50px; left: 0px; right: 0px; height: 100px;}
            footer { position: fixed; bottom: -50px; left: 0px; right: 0px; height: 50px; }
            

            .tittle {
                position: fixed;
                right: 20px;
                top: -30px;
             }

            .reportTitle {
                position: fixed;
                left: 20px;
                top: -30px;
             }             

            .period {
                position: fixed;
                right: 470px;
                top: -30px;
                color: blue;
             }
            
            .NotDone {
                color: red;
             }
            .Done {
                color: green;
             }
        </style>
    </head>
    <body>
        <header>
            <div><span class="page"></span></div>
            <div class="reportTitle">EAPOC-VL Report</div>
            <div class="tittle">National Institute For Medical Research (NIMR)</div>
            <div class="period">' . date('Y-m-d') . '</div>
        </header>
';

$output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="20" align="center" style="font-size: 18px">
                        <b>' . $title . '</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="20" align="center" style="font-size: 18px">
                        <b>' . $sub_title . '</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="20" align="center" style="font-size: 18px">
                        <b>Total Follow Up ( ' . $dataCount . ' ):Done ( ' . $dataCount1 . ' ):Not Done ( ' . $dataCount0 . ' ):Missed ( ' . $dataCount2 . ' ):</b>
                    </td>
                </tr>    
                <tr>
                    <th colspan="1">No.</th>
                    <th colspan="2">Enrollment Date</th>
                    <th colspan="2">PATIENT ID</th>
                    <th colspan="2">Name</th>        
                    <th colspan="2">PHONE NUMBER</th>
                    <th colspan="2">EXPECTED DATE</th>
                    <th colspan="2">VISIT DATE</th>
                    <th colspan="2">VISIT STATUS</th>
                    <th colspan="2">VISIT NAME</th>
                    <th colspan="3">SITE NAME</th>
                </tr>    
     ';

// Load HTML content into dompdf
$x = 1;
foreach ($data as $client) {
    if ($client['SITE_NAME'] == 1) {
        $SITE_NAME = 'SINZA';
    } elseif ($client['SITE_NAME'] == 2) {
        $SITE_NAME = 'MNAZI';
    } elseif ($client['SITE_NAME'] == 3) {
        $SITE_NAME = 'AMANA';
    } elseif ($client['SITE_NAME'] == 4) {
        $SITE_NAME = 'MWANANYAMALA';
    }

    if ($client['VISIT_STATUS'] == 1) {
        $VISIT_STATUS = 'DONE';
        $status = 'Done';
    } elseif ($client['VISIT_STATUS'] == 2) {
        $VISIT_STATUS = 'MISSED';
        $status = '';
    } else {
        $VISIT_STATUS = 'NOT DONE';
        $status = 'NotDone';
    }

    $output .= '
            <tr>
                <td colspan="1">' . $x . '</td>
                <td colspan="2">' . $client['ENROLLMENT_DATE'] . '</td>
                <td colspan="2">' . $client['PATIENT_ID'] . '</td>
                <td colspan="2">' . $client['FIRST_NAME'] . ' - ' . $client['LAST_NAME'] . '</td>
                <td colspan="2">' . $client['PHONE_NUMBER'] . '</td>
                <td colspan="2">' . $client['EXPECTED_DATE'] . '</td>
                <td colspan="2">' . $client['VISIT_DATE'] . '</td>
                <td colspan="2" class="' . $status . '">' . $VISIT_STATUS . '</td>
                <td colspan="2">' . $client['VISIT_NAME'] . '</td>
                <td colspan="3">' . $SITE_NAME . '</td>
            </tr>
            ';
    $x += 1;
}

$output .= '
        </table>  
    ';





// $output = '<html><body><h1>Hello, dompdf!' . $row . '</h1></body></html>';
$pdf->loadHtml($output);

// SetPaper the HTML as PDF
$pdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$pdf->render();

// Output the generated PDF
$pdf->stream($file_name, array("Attachment" => false));
