<?php

require_once 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        $site_data = $override->getData('site');
        $Total_registered = $override->getCount('clients', 'status', 1);
        $Total_enrolled = $override->countData('clients', 'status', 1, 'enrollment_status', 1);
        $successMessage = 'Report Successful Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}

$span0 = 8;
$span1 = 4;
$span2 = 4;

$title = 'EA POC-VL SUMMARY REPORT_' . date('Y-m-d');

$pdf = new Pdf();

// $title = 'NIMREGENIN SUMMARY REPORT_'. date('Y-m-d');
$file_name = $title . '.pdf';

$output = ' ';

// if ($_GET['group'] == 2) {
if ($site_data) {

    $output .= '
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="' . $span0 . '" align="center" style="font-size: 18px">
                        <b>DATE  ' . date('Y-m-d') . '</b>
                    </td>
                </tr>


                <tr>
                    <td colspan="' . $span0 . '" align="center" style="font-size: 18px">
                        <b>TABLE 0 </b>
                    </td>
                </tr>

                <tr>
                    <td colspan="' . $span0 . '" align="center" style="font-size: 18px">
                        <b>' . $title . '</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="' . $span0 . '" align="center" style="font-size: 18px">
                        <b>Total Registered ( ' . $Total_registered . ' ):  Total Enrolled( ' . $Total_enrolled . ' )</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="' . $span0 . '">                        
                        <br />
                        <table width="100%" border="1" cellpadding="5" cellspacing="0">
                            <tr>
                                <th rowspan="2">No.</th>
                                <th rowspan="2">SITE</th>
                                <th colspan="1">REGISTERED</th>
                                <th rowspan="2">ENROLLED</th>
                            </tr>
                            <tr>
                                <th rowspan="1">.</th>
                            </tr>
                            '
                            ;
    // Load HTML content into dompdf
    $x = 1;
    foreach ($site_data as $row) {
        $registered = $override->countData('clients', 'status', 1, 'site_id', $row['id']);
        $enrolled = $override->countData1('clients', 'status', 1, 'enrollment_status', 1, 'site_id', $row['id']);
        // $registered_Total = $override->getCount('clients', 'status', 1);
        // $screened = $override->countData2('clients', 'status', 1, 'screened', 1, 'site_id', $row['id']);
        // $screened_Total = $override->countData('clients', 'status', 1, 'screened', 1);
        // $breast_cancer = $override->countData2('screening', 'status', 1, 'breast_cancer', 1, 'site_id', $row['id']);
        // $breast_cancer_Total = $override->countData('screening', 'status', 1, 'breast_cancer', 1);
        // $brain_cancer = $override->countData2('screening', 'status', 1, 'brain_cancer', 1, 'site_id', $row['id']);
        // $brain_cancer_Total = $override->countData('screening', 'status', 1, 'brain_cancer', 1);
        // $cervical_cancer = $override->countData2('screening', 'status', 1, 'cervical_cancer', 1, 'site_id', $row['id']);
        // $cervical_cancer_Total = $override->countData('screening', 'status', 1, 'cervical_cancer', 1);
        // $prostate_cancer = $override->countData2('screening', 'status', 1, 'prostate_cancer', 1, 'site_id', $row['id']);
        // $prostate_cancer_Total = $override->countData('screening', 'status', 1, 'prostate_cancer', 1);
        // $biopsy = $override->countData2('screening', 'status', 1, 'biopsy', 1, 'site_id', $row['id']);
        // $biopsy_Total = $override->countData('screening', 'status', 1, 'biopsy', 1);
        // $eligible = $override->countData2('clients', 'status', 1, 'eligible', 1, 'site_id', $row['id']);
        // $eligible_Total = $override->countData('clients', 'status', 1, 'eligible', 1);
        // $enrolled = $override->countData2('clients', 'status', 1, 'enrolled', 1, 'site_id', $row['id']);
        // $enrolled_Total = $override->countData('clients', 'status', 1, 'enrolled', 1);
        // $end_study = $override->countData2('clients', 'status', 1, 'end_study', 1, 'site_id', $row['id']);
        // $end_study_Total = $override->countData('clients', 'status', 1, 'end_study', 1);

        $output .= '
                <tr>
                    <td>' . $x . '</td>
                    <td>' . $row['name']  . '</td>
                    <td align="right">' . $registered . '</td>
                    <td align="right">' . $enrolled . '</td>
                </tr>
            ';

        $x += 1;
    }

    $output .= '
                <tr>
                    <td align="right" colspan="2"><b>Total</b></td>
                    <td align="right"><b>' . $Total_registered . '</b></td>
                    <td align="right"><b>' . $Total_enrolled . '</b></td>
                </tr>  

    ';

    $output .= '
            </table>    
                <tr>
                    <td colspan="' . $span1 . '" align="center" style="font-size: 18px">
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <p align="right">----' . $user->data()->firstname . ' ' . $user->data()->lastname . '-----<br />Prepared By</p>
                        <br />
                        <br />
                        <br />
                    </td>

                    <td colspan="' . $span2 . '" align="center" style="font-size: 18px">
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <p align="right">-----' . date('Y-m-d') . '-------<br />Date Prepared</p>
                        <br />
                        <br />
                        <br />
                    </td>
                </tr>
        </table>    
';
}

// $output = '<html><body><h1>Hello, dompdf!' . $row . '</h1></body></html>';
$pdf->loadHtml($output);

// SetPaper the HTML as PDF
// $pdf->setPaper('A4', 'portrait');
$pdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$pdf->render();

// Output the generated PDF
$pdf->stream($file_name, array("Attachment" => false));
