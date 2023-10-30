<?php

require 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        if ($_GET['site']) {
            $data = $override->getNewsAscEnrollmentID('clients', 'status', 1, 'site_id', Input::get('site'));
            $dataCount = $override->FollowUpList7Count($_GET['start_date'], $_GET['end_date'], $_GET['site']);

            // $data1 = $override->FollowUpList7($_GET['start_date'], $_GET['end_date'], $_GET['site']);
            $dataCount1 = $override->FollowUpList7Count1($_GET['start_date'], $_GET['end_date'], $_GET['site'],1);
            $dataCount0 = $override->FollowUpList7Count1($_GET['start_date'], $_GET['end_date'], $_GET['site'],0);
            $dataCount2 = $override->FollowUpList7Count1($_GET['start_date'], $_GET['end_date'], $_GET['site'],2);


        } else {
            $data = $override->get('clients', 'status', 1);
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
    $title = 'EAPOCVL FOLOW UP SCHEDULE FOR SINZA HOSPITAL';
} elseif ($_GET['site'] == 2) {
    $title = 'EAPOCVL FOLOW UP SCHEDULE FOR MNAZI MMOJA HOSPITAL';
} elseif ($_GET['site'] == 3) {
    $title = 'EAPOCVL FOLOW UP SCHEDULE FOR AMANA HOSPITAL';
} elseif ($_GET['site'] == 4) {
    $title = 'EAPOCVL FOLOW UP SCHEDULE FOR MWANANYAMALA HOSPITAL';
} else {
    $title = 'EAPOCVL FOLOW UP SCHEDULE FOR ALL NIMR SITES';
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
                    <td colspan="12" align="center" style="font-size: 18px">
                        <b>' . $title . '</b>
                    </td>
                </tr>   
                <tr>
                    <th colspan="2">Enrollment Date ( V1 )</th>
                    <th colspan="2">PATIENT ID</th>
                    <th colspan="2">EXPECTED DATE V2 ( Months 6)</th>
                    <th colspan="2">VISIT DATE V2 ( Month 6)</th>
                    <th colspan="2">EXPECTED DATE V3 ( Months 12)</th>
                    <th colspan="2">VISIT DATE V3 ( Month 12)</th>
                </tr>    
     ';

// Load HTML content into dompdf
$x = 1;
foreach ($data as $value) {
    if ($value['site_id'] == 1) {
        $SITE_NAME = 'SINZA HOSPITAL';
    } elseif ($value['site_id'] == 2) {
        $SITE_NAME = 'MNAZI MMOJA HOSPITAL';
    } elseif ($value['site_id'] == 3) {
        $SITE_NAME = 'AMANA HOSPITAL';
    } elseif ($value['site_id'] == 4) {
        $SITE_NAME = 'MWANANYAMALA HOSPITAL';
    } else {
        $SITE_NAME = 'ALL NIMR SITES';
    }


    $visit = $override->get('visit', 'client_id', $value['id']);

    foreach ($visit as $value2) {

        if ($value2['visit_status'] == 1) {
            $VISIT_STATUS = 'DONE';
        } elseif ($value2['visit_status'] == 2) {
            $VISIT_STATUS = 'MISSED';
        } else {
            $VISIT_STATUS = 'NOT DONE';
        }

        if ($value2['visit_code'] == 'D0') {
            $visit_code1 = 'MONTH 0 ( V1 )';
            $expected_date1 = $value2['expected_date'];
            $visit_date1 = $value2['visit_date'];
        }
        if ($value2['visit_code'] == 'M6') {
            $visit_code2 = 'MONTH 6 ( V2 )';
            $expected_date2 = $value2['expected_date'];
            $visit_date2 = $value2['visit_date'];
        }
        if ($value2['visit_code'] == 'M12') {
            $visit_code3 = 'MONTH 12 ( V3 )';
            $expected_date3 = $value2['expected_date'];
            $visit_date3 = $value2['visit_date'];
        }
    }

    $output .= '
            <tr>
                <td colspan="2">' . $value['clinic_date'] . '</td>
                <td colspan="2">' . $value['enrollment_id'] . '</td>
                <td colspan="2">' . $expected_date2 . '</td>
                <td colspan="2">' . $visit_date2 . '</td>
                <td colspan="2">' . $expected_date3 . '</td>
                <td colspan="2">' . $visit_date3 . '</td>     
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
