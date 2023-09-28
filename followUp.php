<?php

require 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        // if (!$_GET['site_id']) {
        //     $data = $override->FollowUpList4('2023-10-05');
        //     $dataCount = $override->FollowUpList4Count('2023-10-05');
        // } else {
        //     $data = $override->FollowUpList5($_GET['site_id'], '2023-10-05');
        //     $dataCount = $override->FollowUpList5Count($_GET['site_id'],'2023-10-05');
        // }

        $data = $override->FollowUpList5(4, '2023-10-05');
        $dataCount = $override->FollowUpList5Count(4, '2023-10-05');
        $successMessage = 'Report Successful Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}

$title = 'EAPOCVL FOLOW UP LIST FOR MONTH SEPTEMBER AND OCTOBER UP TO 2023-10-05';

$pdf = new Pdf();

// $title = 'NIMREGENIN SUMMARY REPORT_'. date('Y-m-d');
$file_name = $title . '.pdf';

$output = ' ';


$output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="18" align="center" style="font-size: 18px">
                        <b>' . $title . '</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="18" align="center" style="font-size: 18px">
                        <b>Total Follow Up ( ' . $dataCount . ' ):</b>
                    </td>
                </tr>    
                <tr>
                    <th colspan="2">No.</th>
                    <th colspan="2">Enrollment Date</th>
                    <th colspan="2">PATIENT ID</th>
                    <th colspan="2">Name</th>        
                    <th colspan="2">PHONE NUMBER</th>
                    <th colspan="2">EXPECTED DATE</th>
                    <th colspan="2">VISIT DATE</th>
                    <th colspan="2">VISIT NAME</th>
                    <th colspan="2">SITE NAME</th>
                </tr>    
     ';

        // Load HTML content into dompdf
        $x = 1;
        foreach ($data as $client) {
            if ($client['SITE_NAME'] == 1) {
        $SITE_NAME = 'SINZA';
            } elseif($client['SITE_NAME'] == 2) {
        $SITE_NAME = 'MNAZI';
            } elseif ($client['SITE_NAME'] == 3) {
        $SITE_NAME = 'AMANA';
            } elseif ($client['SITE_NAME'] == 4) {
        $SITE_NAME = 'MWANANYAMALA';
            }

        $output .= '
            <tr>
                <td colspan="2">' . $x . '</td>
                <td colspan="2">' . $client['ENROLLMENT_DATE'] . '</td>
                <td colspan="2">' . $client['PATIENT_ID'] . '</td>
                <td colspan="2">' . $client['FIRST_NAME'] . ' - ' . $client['LAST_NAME'] . '</td>
                <td colspan="2">' . $client['PHONE_NUMBER'] . '</td>
                <td colspan="2">' . $client['EXPECTED_DATE'] . '</td>
                <td colspan="2">' . $client['VISIT_DATE'] . '</td>
                <td colspan="2">' . $client['VISIT_NAME'] . '</td>
                <td colspan="2">' . $SITE_NAME . '</td>
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
