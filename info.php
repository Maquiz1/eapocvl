<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$numRec = 35;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        $validate = new validate();
        if (Input::get('edit_position')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->updateRecord('position', array(
                        'name' => Input::get('name'),
                    ), Input::get('id'));
                    $successMessage = 'Position Successful Updated';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('edit_access_level')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->updateRecord('access_level', array(
                        'name' => Input::get('name'),
                    ), Input::get('id'));
                    $successMessage = 'Access level Successful Updated';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('edit_power')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->updateRecord('power', array(
                        'name' => Input::get('name'),
                    ), Input::get('id'));
                    $successMessage = 'Power Successful Updated';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('edit_staff')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'firstname' => array(
                    'required' => true,
                ),
                'lastname' => array(
                    'required' => true,
                ),
                'position' => array(
                    'required' => true,
                ),
                'phone_number' => array(
                    'required' => true,
                ),
                'email_address' => array(),
            ));
            if ($validate->passed()) {
                $salt = $random->get_rand_alphanumeric(32);
                $password = '12345678';
                switch (Input::get('position')) {
                    case 1:
                        $accessLevel = 1;
                        break;
                    case 2:
                        $accessLevel = 2;
                        break;
                    case 3:
                        $accessLevel = 3;
                        break;
                }
                try {
                    $user->updateRecord('user', array(
                        'firstname' => Input::get('firstname'),
                        'lastname' => Input::get('lastname'),
                        'username' => Input::get('username'),
                        'position' => Input::get('position'),
                        'site_id' => Input::get('site_id'),
                        'accessLevel' => Input::get('accessLevel'),
                        'power' => Input::get('power'),
                        'phone_number' => Input::get('phone_number'),
                        'email_address' => Input::get('email_address'),
                        // 'accessLevel' => $accessLevel,
                        'user_id' => $user->data()->id,
                    ), Input::get('id'));

                    $successMessage = 'Account Updated Successful';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('reset_pass')) {
            $salt = $random->get_rand_alphanumeric(32);
            $password = '12345678';
            $user->updateRecord('user', array(
                'password' => Hash::make($password, $salt),
                'salt' => $salt,
            ), Input::get('id'));
            $successMessage = 'Password Reset Successful';
        } elseif (Input::get('reactivate_user')) {
            $user->updateRecord('user', array(
                'count' => 0,
            ), Input::get('id'));
            $successMessage = 'User Re-activated Successful';
        } elseif (Input::get('deactivate_user')) {
            $user->updateRecord('user', array(
                'count' => 4,
            ), Input::get('id'));
            $successMessage = 'User Re-activated Successful';
        } elseif (Input::get('delete_staff')) {
            $user->updateRecord('user', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'User Deleted Successful';
        } elseif (Input::get('delete_site')) {
            $user->updateRecord('site', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Site Deleted Successful';
        } elseif (Input::get('update_site')) {
            $validate = $validate->check($_POST, array(
                // 'name' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                try {
                    $override->UpdateSiteStaus('site', 'status', 1);
                    $successMessage = 'Site Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('delete_client')) {
            $user->updateRecord('clients', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'User Deleted Successful';
        } elseif (Input::get('edit_study')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
                'code' => array(
                    'required' => true,
                ),
                'sample_size' => array(
                    'required' => true,
                ),
                'start_date' => array(
                    'required' => true,
                ),
                'end_date' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->updateRecord('study', array(
                        'name' => Input::get('name'),
                        'code' => Input::get('code'),
                        'sample_size' => Input::get('sample_size'),
                        'start_date' => Input::get('start_date'),
                        'end_date' => Input::get('end_date'),
                    ), Input::get('id'));
                    $successMessage = 'Study Successful Updated';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('edit_site')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->updateRecord('site', array(
                        'name' => Input::get('name'),
                    ), Input::get('id'));
                    $successMessage = 'Site Successful Updated';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('edit_client')) {
            $validate = $validate->check($_POST, array(
                'clinic_date' => array(
                    'required' => true,
                ),
                'firstname' => array(
                    'required' => true,
                ),
                'lastname' => array(
                    'required' => true,
                ),
                'dob' => array(
                    'required' => true,
                ),
                'street' => array(
                    'required' => true,
                ),
                'phone_number' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $attachment_file = Input::get('image');
                    if (!empty($_FILES['image']["tmp_name"])) {
                        $attach_file = $_FILES['image']['type'];
                        if ($attach_file == "image/jpeg" || $attach_file == "image/jpg" || $attach_file == "image/png" || $attach_file == "image/gif") {
                            $folderName = 'clients/';
                            $attachment_file = $folderName . basename($_FILES['image']['name']);
                            if (@move_uploaded_file($_FILES['image']["tmp_name"], $attachment_file)) {
                                $file = true;
                            } else { {
                                    $errorM = true;
                                    $errorMessage = 'Your profile Picture Not Uploaded ,';
                                }
                            }
                        } else {
                            $errorM = true;
                            $errorMessage = 'None supported file format';
                        } //not supported format
                    } else {
                        $attachment_file = '';
                    }
                    if (!empty($_FILES['image']["tmp_name"])) {
                        $image = $attachment_file;
                    } else {
                        $image = Input::get('client_image');
                    }
                    if ($errorM == false) {
                        $age = $user->dateDiffYears(date('Y-m-d'), Input::get('dob'));
                        $user->updateRecord('clients', array(
                            'participant_id' => Input::get('participant_id'),
                            'study_id' => Input::get('study_id'),
                            'clinic_date' => Input::get('clinic_date'),
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'dob' => Input::get('dob'),
                            'initials' => Input::get('initials'),
                            'age' => $age,
                            'vl' => Input::get('vl'),
                            'vl_date' => Input::get('vl_date'),
                            'recent_vl' => Input::get('recent_vl'),
                            'recent_vl_date' => Input::get('recent_vl_date'),
                            'id_number' => Input::get('id_number'),
                            'ctc_number' => Input::get('ctc_number'),
                            'enrollment_id' => Input::get('enrollment_id'),
                            'gender' => Input::get('gender'),
                            'marital_status' => Input::get('marital_status'),
                            'education_level' => Input::get('education_level'),
                            'workplace' => Input::get('workplace'),
                            'occupation' => Input::get('occupation'),
                            'phone_number' => Input::get('phone_number'),
                            'other_phone' => Input::get('other_phone'),
                            'street' => Input::get('street'),
                            'ward' => Input::get('ward'),
                            'district' => Input::get('district'),
                            'block_no' => Input::get('block_no'),
                            'client_image' => $image,
                            'comments' => Input::get('comments'),
                        ), Input::get('id'));

                        $successMessage = 'Client Updated Successful';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('edit_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'visit_status' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->updateRecord('visit', array(
                        'visit_date' => Input::get('visit_date'),
                        'created_on' => date('Y-m-d'),
                        'status' => 1,
                        'visit_status' => Input::get('visit_status'),
                    ), Input::get('id'));

                    if (Input::get('seq') == 2) {
                        $user->createRecord('visit', array(
                            'visit_name' => 'Visit 3',
                            'visit_code' => 'V3',
                            'visit_window' => 14,
                            'status' => 0,
                            'seq_no' => 3,
                            'client_id' => Input::get('cid'),
                        ));
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_screening')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                $eligibility = 0;
                if (
                    Input::get('age_18') == 1 && Input::get('tr_pcr') == 1 && Input::get('hospitalized') == 1 &&
                    Input::get('moderate_severe') == 1 && Input::get('peptic_ulcers') == 2 && Input::get('consented') == 1 && (Input::get('pregnant') == 2 || Input::get('pregnant') == 3)
                ) {
                    $eligibility = 1;
                }
                try {
                    if ($override->get('screening', 'client_id', Input::get('cid'))) {
                        $cl_id = $override->get('screening', 'client_id', Input::get('cid'))[0]['id'];
                        $user->updateRecord('screening', array(
                            'sample_date' => Input::get('sample_date'),
                            'results_date' => Input::get('results_date'),
                            'covid_result' => Input::get('covid_result'),
                            'age_18' => Input::get('age_18'),
                            'tr_pcr' => Input::get('tr_pcr'),
                            'hospitalized' => Input::get('hospitalized'),
                            'moderate_severe' => Input::get('moderate_severe'),
                            'peptic_ulcers' => Input::get('peptic_ulcers'),
                            'pregnant' => Input::get('pregnant'),
                            'eligibility' => $eligibility,
                            'consented' => Input::get('consented'),
                            'created_on' => date('Y-m-d'),
                            'staff_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                            'status' => 1,
                            'client_id' => Input::get('cid'),
                        ), $cl_id);
                    } else {
                        $user->createRecord('screening', array(
                            'sample_date' => Input::get('sample_date'),
                            'results_date' => Input::get('results_date'),
                            'covid_result' => Input::get('covid_result'),
                            'age_18' => Input::get('age_18'),
                            'tr_pcr' => Input::get('tr_pcr'),
                            'hospitalized' => Input::get('hospitalized'),
                            'moderate_severe' => Input::get('moderate_severe'),
                            'peptic_ulcers' => Input::get('peptic_ulcers'),
                            'pregnant' => Input::get('pregnant'),
                            'eligibility' => $eligibility,
                            'consented' => Input::get('consented'),
                            'created_on' => date('Y-m-d'),
                            'staff_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                            'status' => 1,
                            'client_id' => Input::get('cid'),
                        ));
                    }
                    $user->updateRecord('clients', array('consented' => Input::get('consented')), Input::get('cid'));
                    $successMessage = 'Screening Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_lab')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                $eligibility = 0;
                $clnt = $override->get('clients', 'id', Input::get('cid'))[0];
                $sc_e = $override->get('screening', 'client_id', Input::get('cid'))[0];
                $std_id = $override->getNews('study_id', 'site_id', $user->data()->site_id, 'status', 0)[0];
                if ((Input::get('wbc') >= 1.5 && Input::get('wbc') <= 11.0) && (Input::get('hb') >= 8.5 && Input::get('hb') <= 16.5)
                    && (Input::get('plt') >= 50 && Input::get('plt') <= 1000) && (Input::get('alt') >= 2.0 && Input::get('alt') <= 195.0)
                    && (Input::get('ast') >= 2.0 && Input::get('ast') <= 195.0)
                ) {
                    if ($clnt['gender'] == 'male' && (Input::get('sc') >= 44.0 && Input::get('sc') <= 158.4) && $sc_e['eligibility'] == 1) {
                        $eligibility = 1;
                        if ($override->getCount('visit', 'client_id', Input::get('cid')) == 1) {
                            $user->visit(Input::get('cid'), 0);
                            $user->updateRecord('study_id', array('status' => 1, 'client_id' => Input::get('cid')), $std_id['id']);
                            $user->updateRecord('clients', array('study_id' => $std_id['study_id'], 'enrolled' => 1), Input::get('cid'));
                        }
                    } elseif ($clnt['gender'] == 'female' && (Input::get('sc') >= 62.0 && Input::get('sc') <= 190.8) && $sc_e['eligibility'] == 1) {
                        $eligibility = 1;
                        if ($override->getCount('visit', 'client_id', Input::get('cid')) == 1) {
                            $user->visit(Input::get('cid'), 0);
                            $user->updateRecord('study_id', array('status' => 1, 'client_id' => Input::get('cid')), $std_id['id']);
                            $user->updateRecord('clients', array('study_id' => $std_id['study_id'], 'enrolled' => 1), Input::get('cid'));
                        }
                    }
                }
                try {
                    if ($override->get('lab', 'client_id', Input::get('cid'))) {
                        $l_id = $override->get('lab', 'client_id', Input::get('cid'))[0]['id'];
                        $user->updateRecord('lab', array(
                            'wbc' => Input::get('wbc'),
                            'hb' => Input::get('hb'),
                            'plt' => Input::get('plt'),
                            'alt' => Input::get('alt'),
                            'ast' => Input::get('ast'),
                            'sc' => Input::get('sc'),
                            'eligibility' => $eligibility,
                            'created_on' => date('Y-m-d'),
                            'staff_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                            'status' => 1,
                            'client_id' => Input::get('cid'),
                        ), $l_id);
                    } else {
                        $user->createRecord('lab', array(
                            'wbc' => Input::get('wbc'),
                            'hb' => Input::get('hb'),
                            'plt' => Input::get('plt'),
                            'alt' => Input::get('alt'),
                            'ast' => Input::get('ast'),
                            'sc' => Input::get('sc'),
                            'eligibility' => $eligibility,
                            'created_on' => date('Y-m-d'),
                            'staff_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                            'status' => 1,
                            'client_id' => Input::get('cid'),
                        ));
                    }

                    $successMessage = 'Screening Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'visit_status' => array(
                    'required' => true,
                ),
                'visit_status' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    if (Input::get('visit_code') == 1) {
                        $user->updateRecord('visit', array(
                            'visit_date' => Input::get('visit_date'),
                            'status' => Input::get('visit_status'),
                            'visit_status' => Input::get('visit_status'),
                            'sample_date6' => Input::get('sample_date6'),
                            'vl_results6' => Input::get('vl_results6'),
                            'sample_date' => Input::get('sample_date'),
                            'vl_results' => Input::get('vl_results'),
                            'reasons' => Input::get('reasons'),
                            'staff_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                            'seq_no' => Input::get('visit_code'),
                        ), Input::get('id'));
                    } elseif (Input::get('visit_code') == 2 | Input::get('visit_code') == 3) {
                        $user->updateRecord('visit', array(
                            'visit_date' => Input::get('visit_date'),
                            'status' => Input::get('visit_status'),
                            'visit_status' => Input::get('visit_status'),
                            'sample_date' => Input::get('sample_date'),
                            'vl_results' => Input::get('vl_results'),
                            'reasons' => Input::get('reasons'),
                            'staff_id' => $user->data()->id,
                            'site_id' => $user->data()->site_id,
                            'seq_no' => Input::get('visit_code'),
                        ), Input::get('id'));
                    }

                    // $user->updateRecord('visit', array(
                    //     'visit_date' => Input::get('visit_date'),
                    //     'status' => Input::get('visit_status'),
                    //     'visit_status' => Input::get('visit_status'),
                    //     'sample_date' => Input::get('sample_date'),
                    //     'vl_results' => Input::get('vl_results'),
                    //     'reasons' => Input::get('reasons'),
                    //     'staff_id' => $user->data()->id,
                    //     'site_id' => $user->data()->site_id,
                    //     'seq_no' => Input::get('visit_code'),
                    // ), Input::get('id'));
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('search_by_site')) {
            $validate = $validate->check($_POST, array(
                'site' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $url = 'info.php?id=3&sid=' . Input::get('site');
                Redirect::to($url);
                $pageError = $validate->errors();
            }
        } elseif (Input::get('fect_list_all')) {
            $validate = $validate->check($_POST, array(
                // 'name' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                try {
                    $override->FollowUpList(Input::get('date'));
                    $successMessage = 'Site Successful Listed';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('fect_list')) {
            $validate = $validate->check($_POST, array(
                // 'name' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                try {
                    $override->FollowUpList1(Input::get('site'), Input::get('date'));
                    $successMessage = 'Site Successful Listed';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }

        if ($_GET['id'] == 9) {
            $data = null;
            $filename = null;
            if (Input::get('clients')) {
                $data = $override->getData('clients');
                $filename = 'Clients';
            } elseif (Input::get('visits')) {
                $data = $override->getData('visit');
                $filename = 'Visits';
            } elseif (Input::get('visits')) {
                $data = $override->getData('visit');
                $filename = 'Visits';
            } elseif (Input::get('lab')) {
                $data = $override->getData('lab');
                $filename = 'Laboratory Results';
            } elseif (Input::get('study_id')) {
                $data = $override->getData('study_id');
                $filename = 'Study IDs';
            } elseif (Input::get('sites')) {
                $data = $override->getData('site');
                $filename = 'Sites';
            } elseif (Input::get('screening')) {
                $data = $override->getData('screening');
                $filename = 'Screening';
            }
            $user->exportData($data, $filename);
        }

        // if ($_GET['id'] == 12) {
        //     $data = null;
        //     $filename = null;
        //     if (Input::get('followUp')) {
        //         $data = $override->FollowUpList3();
        //         $filename = 'Follow Up List';
        //     }
        //     $user->exportData($data, $filename);
        // }
    }

    if ($user->data()->power == 1) {
        $screened = $override->getCount('clients', 'status', 1);
        $enrolled = $override->getCount1('clients', 'enrollment_status', 1, 'status', 1);
    } else {
        $screened = $override->countData('clients', 'status', 1, 'site_id', $user->data()->site_id);
        $enrolled = $override->countData1('clients', 'enrollment_status', 1, 'status', 1, 'site_id', $user->data()->site_id);
    }
} else {
    Redirect::to('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> Info - Eapocvl </title>
    <?php include "head.php"; ?>
</head>

<body>
    <div class="wrapper">

        <?php include 'topbar.php' ?>
        <?php include 'menu.php' ?>
        <div class="content">


            <div class="breadLine">

                <ul class="breadcrumb">
                    <li><a href="#">Info</a> <span class="divider"></span></li>
                </ul>
                <?php include 'pageInfo.php' ?>
            </div>

            <div class="workplace">
                <?php if ($errorMessage) { ?>
                    <div class="alert alert-danger">
                        <h4>Error!</h4>
                        <?= $errorMessage ?>
                    </div>
                <?php } elseif ($pageError) { ?>
                    <div class="alert alert-danger">
                        <h4>Error!</h4>
                        <?php foreach ($pageError as $error) {
                            echo $error . ' , ';
                        } ?>
                    </div>
                <?php } elseif ($successMessage) { ?>
                    <div class="alert alert-success">
                        <h4>Success!</h4>
                        <?= $successMessage ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <?php if ($_GET['id'] == 1 && ($user->data()->position == 1 || $user->data()->position == 2)) { ?>
                        <div class="col-md-12">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of Staff</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <?php if ($user->data()->power == 1) {
                                    $users = $override->get('user', 'status', 1);
                                } else {
                                    $users = $override->getNews('user', 'site_id', $user->data()->site_id, 'status', 1);
                                } ?>
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkall" /></th>
                                            <th width="20%">Name</th>
                                            <th width="20%">Username</th>
                                            <th width="20%">Position</th>
                                            <th width="20%">Site</th>
                                            <th width="20%">Status</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $staff) {
                                            $position = $override->get('position', 'id', $staff['position'])[0];
                                            $site = $override->get('site', 'id', $staff['site_id'])[0];
                                            $access = $override->get('access_level', 'id', $staff['accessLevel'])[0];
                                            $power = $override->get('power', 'id', $staff['power'])[0];

                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkbox" /></td>
                                                <td> <?= $staff['firstname'] . ' ' . $staff['lastname'] ?></td>
                                                <td><?= $staff['username'] ?></td>
                                                <td><?= $position['name'] ?></td>
                                                <td><?= $site['name'] ?></td>
                                                <?php if ($staff['count'] < 4) { ?>
                                                    <td>Active</td>
                                                <?php } elseif ($staff['count'] == 4) { ?>
                                                    <td>De-activated</td>
                                                <?php } ?>
                                                <td>
                                                    <a href="#user<?= $staff['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a>
                                                    <a href="#reset<?= $staff['id'] ?>" role="button" class="btn btn-warning" data-toggle="modal">Reset</a>
                                                    <a href="#reactivate_user<?= $staff['id'] ?>" role="button" class="btn btn-success" data-toggle="modal">Re-Activate</a>
                                                    <a href="#deactivate_user<?= $staff['id'] ?>" role="button" class="btn btn-warning" data-toggle="modal">De-Activate</a>
                                                    <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                </td>

                                            </tr>
                                            <div class="modal fade" id="user<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit User Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">First name:</div>
                                                                            <div class="col-md-9"><input type="text" name="firstname" value="<?= $staff['firstname'] ?>" required /></div>
                                                                        </div>
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">Last name:</div>
                                                                            <div class="col-md-9"><input type="text" name="lastname" value="<?= $staff['lastname'] ?>" required /></div>
                                                                        </div>
                                                                        <?php
                                                                        if ($user->data()->power == 1) {
                                                                        ?>
                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">User name:</div>
                                                                                <div class="col-md-9"><input type="text" name="username" value="<?= $staff['username'] ?>" required /></div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">Position</div>
                                                                            <div class="col-md-9">
                                                                                <select name="position" style="width: 100%;" required>
                                                                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                                                                    <?php foreach ($override->getData('position') as $position) { ?>
                                                                                        <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        if ($user->data()->power == 1) {
                                                                        ?>

                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">Access level</div>
                                                                                <div class="col-md-9">
                                                                                    <select name="accessLevel" style="width: 100%;" required>
                                                                                        <option value="<?= $access['id'] ?>"><?= $access['name'] ?></option>
                                                                                        <?php foreach ($override->getData('access_level') as $access) { ?>
                                                                                            <option value="<?= $access['id'] ?>"><?= $access['name'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">Power</div>
                                                                                <div class="col-md-9">
                                                                                    <select name="power" style="width: 100%;" required>
                                                                                        <option value="<?= $power['id'] ?>"><?= $power['name'] ?></option>
                                                                                        <?php foreach ($override->getData('power') as $power) { ?>
                                                                                            <option value="<?= $power['id'] ?>"><?= $power['name'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>


                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">Site</div>
                                                                                <div class="col-md-9">
                                                                                    <select name="site_id" style="width: 100%;" required>
                                                                                        <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                                                        <?php foreach ($override->getData('site') as $site) { ?>
                                                                                            <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">Phone Number:</div>
                                                                            <div class="col-md-9"><input value="<?= $staff['phone_number'] ?>" class="" type="text" name="phone_number" id="phone" required /> <span>Example: 0700 000 111</span></div>
                                                                        </div>

                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">E-mail Address:</div>
                                                                            <div class="col-md-9"><input value="<?= $staff['email_address'] ?>" class="validate[required,custom[email]]" type="text" name="email_address" id="email" /> <span>Example: someone@nowhere.com</span></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                <input type="submit" name="edit_staff" value="Save updates" class="btn btn-warning">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="reset<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Reset Password</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to reset password to default (12345678)</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                <input type="submit" name="reset_pass" value="Reset" class="btn btn-warning">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="reactivate_user<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Re-activate User Acount</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to re-activate This User Acount</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                <input type="submit" name="reactivate_user" value="Reactivate User" class="btn btn-info">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="deactivate_user<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>De-activate User Acount</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to De-activate This User Acount</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                <input type="submit" name="deactivate_user" value="Deactivate User" class="btn btn-warning">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Delete User</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <strong style="font-weight: bold;color: red">
                                                                    <p>Are you sure you want to delete this user</p>
                                                                </strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } elseif ($_GET['id'] == 2 && $user->data()->accessLevel == 1) { ?>
                        <div class="col-md-4">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of Positions</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th width="25%">Name</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($override->getData('position') as $position) { ?>
                                            <tr>
                                                <td> <?= $position['name'] ?></td>
                                                <td><a href="#position<?= $position['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                                <!-- EOF Bootrstrap modal form -->
                                            </tr>
                                            <div class="modal fade" id="position<?= $position['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Position Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">Name:</div>
                                                                            <div class="col-md-9"><input type="text" name="name" value="<?= $position['name'] ?>" required /></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $position['id'] ?>">
                                                                <input type="submit" name="edit_position" class="btn btn-warning" value="Save updates">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>Studies</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th width="30%">Name</th>
                                            <th width="10%">Code</th>
                                            <th width="10%">Sample Size</th>
                                            <th width="15%">Start Date</th>
                                            <th width="15%">End Date</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($override->getData('study') as $study) { ?>
                                            <tr>
                                                <td><?= $study['name'] ?></td>
                                                <td><?= $study['code'] ?></td>
                                                <td><?= $study['sample_size'] ?></td>
                                                <td><?= $study['start_date'] ?></td>
                                                <td><?= $study['end_date'] ?></td>
                                                <td><a href="#study<?= $study['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                                <!-- EOF Bootrstrap modal form -->
                                            </tr>
                                            <div class="modal fade" id="study<?= $study['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="row-form clearfix">
                                                                        <div class="col-md-3">Name:</div>
                                                                        <div class="col-md-9">
                                                                            <input value="<?= $study['name'] ?>" class="validate[required]" type="text" name="name" id="name" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row-form clearfix">
                                                                        <div class="col-md-3">Code:</div>
                                                                        <div class="col-md-9">
                                                                            <input value="<?= $study['code'] ?>" class="validate[required]" type="text" name="code" id="code" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row-form clearfix">
                                                                        <div class="col-md-3">Sample Size:</div>
                                                                        <div class="col-md-9">
                                                                            <input value="<?= $study['sample_size'] ?>" class="validate[required]" type="number" name="sample_size" id="sample_size" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row-form clearfix">
                                                                        <div class="col-md-3">Start Date:</div>
                                                                        <div class="col-md-9">
                                                                            <input value="<?= $study['start_date'] ?>" class="validate[required,custom[date]]" type="text" name="start_date" id="start_date" /> <span>Example: 2010-12-01</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row-form clearfix">
                                                                        <div class="col-md-3">End Date:</div>
                                                                        <div class="col-md-9">
                                                                            <input value="<?= $study['end_date'] ?>" class="validate[required,custom[date]]" type="text" name="end_date" id="end_date" /> <span>Example: 2010-12-01</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $study['id'] ?>">
                                                                <input type="submit" name="edit_study" class="btn btn-warning" value="Save updates">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of Sites</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th width="25%">Name</th>
                                            <th width="5%">Action</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($override->get('site', 'status', 1) as $site) { ?>
                                            <tr>
                                                <td> <?= $site['name'] ?></td>
                                                <td><a href="#site<?= $site['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                                <td><a href="#delete<?= $site['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a></td>
                                                <!-- EOF Bootrstrap modal form -->
                                            </tr>
                                            <div class="modal fade" id="site<?= $site['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Site Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">Name:</div>
                                                                            <div class="col-md-9"><input type="text" name="name" value="<?= $site['name'] ?>" required /></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $site['id'] ?>">
                                                                <input type="submit" name="edit_site" class="btn btn-warning" value="Save updates">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete<?= $site['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Delete Site</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <strong style="font-weight: bold;color: red">
                                                                    <p>Are you sure you want to delete this Site</p>
                                                                </strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $site['id'] ?>">
                                                                <input type="submit" name="delete_site" value="Delete" class="btn btn-danger">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of access Level</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th width="25%">Name</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($override->getData('access_level') as $position) { ?>
                                            <tr>
                                                <td> <?= $position['name'] ?></td>
                                                <td><a href="#access_level<?= $position['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                                <!-- EOF Bootrstrap modal form -->
                                            </tr>
                                            <div class="modal fade" id="access_level<?= $position['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Access level Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">Name:</div>
                                                                            <div class="col-md-9"><input type="text" name="name" value="<?= $position['name'] ?>" required /></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $position['id'] ?>">
                                                                <input type="submit" name="edit_access_level" class="btn btn-warning" value="Save updates">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of Powers</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th width="25%">Name</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($override->getData('power') as $position) { ?>
                                            <tr>
                                                <td> <?= $position['name'] ?></td>
                                                <td><a href="#power<?= $position['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a></td>
                                                <!-- EOF Bootrstrap modal form -->
                                            </tr>
                                            <div class="modal fade" id="power<?= $position['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Power Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row-form clearfix">
                                                                            <div class="col-md-3">Name:</div>
                                                                            <div class="col-md-9"><input type="text" name="name" value="<?= $position['name'] ?>" required /></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $position['id'] ?>">
                                                                <input type="submit" name="edit_power" class="btn btn-warning" value="Save updates">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } elseif ($_GET['id'] == 3) { ?>
                        <div class="col-md-12">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="wBlock red clearfix">
                                        <div class="dSpace">
                                            <h3>Registered</h3>
                                            <span class="mChartBar" sparkType="bar" sparkBarColor="white">
                                                <!--130,190,260,230,290,400,340,360,390-->
                                            </span>
                                            <a href="info.php?id=3">
                                                <span class="number"><?= $screened ?></span>
                                            </a>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="wBlock green clearfix">
                                        <div class="dSpace">
                                            <h3>Enrolled</h3>
                                            <span class="mChartBar" sparkType="bar" sparkBarColor="white">
                                                <!--5,10,15,20,23,21,25,20,15,10,25,20,10-->
                                            </span>
                                            <a href="info.php?id=3">
                                                <span class="number"><?= $enrolled ?></span>
                                            </a>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="wBlock blue clearfix">
                                        <div class="dSpace">
                                            <h3>End of study</h3>
                                            <span class="mChartBar" sparkType="bar" sparkBarColor="white">
                                                <!--240,234,150,290,310,240,210,400,320,198,250,222,111,240,221,340,250,190-->
                                            </span>
                                            <a href="#">
                                                <span class="number">0</span>
                                            </a>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <?php if ($user->data()->power == 1) { ?>
                                <div class="head clearfix">
                                    <div class="isw-ok"></div>
                                    <h1>Search by Site</h1>
                                </div>
                                <div class="block-fluid">
                                    <form id="validation" method="post">
                                        <div class="row-form clearfix">
                                            <div class="col-md-1">Site:</div>
                                            <div class="col-md-4">
                                                <select name="site" required>
                                                    <option value="">Select Site</option>
                                                    <?php foreach ($override->get('site', 'status', 1) as $site) { ?>
                                                        <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" name="search_by_site" value="Search" class="btn btn-info">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of Clients</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <?php if ($user->data()->power == 1 || $user->data()->power == 2 || $user->data()->accessLevel == 4) {
                                if ($_GET['sid'] != null) {
                                    $pagNum = 0;
                                    $pagNum = $override->countData('clients', 'status', 1, 'site_id', $_GET['sid']);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $clients = $override->getWithLimit1('clients', 'site_id', $_GET['sid'], 'status', 1, $page, $numRec);
                                } else {
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('clients', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $clients = $override->getWithLimit('clients', 'status', 1, $page, $numRec);
                                }
                            } else {
                                $pagNum = 0;
                                $pagNum = $override->countData('clients', 'site_id', $user->data()->site_id, 'status', 1);
                                $pages = ceil($pagNum / $numRec);
                                if (!$_GET['page'] || $_GET['page'] == 1) {
                                    $page = 0;
                                } else {
                                    $page = ($_GET['page'] * $numRec) - $numRec;
                                }
                                $clients = $override->getWithLimit1('clients', 'site_id', $user->data()->site_id, 'status', 1, $page, $numRec);
                            } ?>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkall" /></th>
                                            <td width="20">#</td>
                                            <th width="40">Picture</th>
                                            <th width="40">Enrollment Date</th>
                                            <th width="8%">Enrollment id</th>
                                            <th width="8%">Recent Viral Load within 6 months (copies/ml)</th>
                                            <th width="8%">Recent DATE (within 6 months)<span></span></th>
                                            <th width="8%">Viral Load (At Enrollment)(copies/ml)</th>
                                            <th width="8%">Viral Load DATE(At Enrollment)</th>
                                            <th width="8%">Site</th>
                                            <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2 ||  $user->data()->accessLevel == 3) { ?>
                                                <th width="8%">Name</th>
                                            <?php } ?>
                                            <th width="8%">Gender</th>
                                            <th width="8%">Age</th>
                                            <?php if ($user->data()->position == 1) { ?>

                                                <th width="8%">Staff</th>
                                            <?php } ?>

                                            <th width="40%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 1;
                                        foreach ($clients as $client) {
                                            $site = $override->getData2('site', 'id', $client['site_id'])[0];
                                            $staff = $override->getData2('user', 'id', $client['staff_id'])[0];
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkbox" /></td>
                                                <td><?= $x ?></td>
                                                <td width="100">
                                                    <?php if ($client['client_image'] != '' || is_null($client['client_image'])) {
                                                        $img = $client['client_image'];
                                                    } else {
                                                        $img = 'img/users/blank.png';
                                                    } ?>
                                                    <a href="#img<?= $client['id'] ?>" data-toggle="modal"><img src="<?= $img ?>" width="90" height="90" class="" /></a>
                                                </td>
                                                <td><?= $client['enrollment_date'] ?></td>
                                                <td><?= $client['enrollment_id'] ?></td>
                                                <td><?= $client['recent_vl'] ?><br><br><span>(copies/ml)</span></td>
                                                <td><?= $client['recent_vl_date'] ?></td>
                                                <td><?= $client['vl'] ?><br><br><span>(copies/ml)</span></td>
                                                <td><?= $client['vl_date'] ?></td>
                                                <td><?= $site['name'] ?></td>
                                                <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2 ||  $user->data()->accessLevel == 3) { ?>
                                                    <td> <?= $client['firstname'] . ' ' . $client['lastname'] ?></td>
                                                <?php } ?>
                                                <td><?= $client['gender'] ?></td>
                                                <td><?= $client['age'] ?></td>
                                                <?php if ($user->data()->position == 1) { ?>

                                                    <td><?= $staff['username'] ?></td>
                                                <?php } ?>

                                                <td>
                                                    <a href="#clientView<?= $client['id'] ?>" role="button" class="btn btn-default" data-toggle="modal">View</a>

                                                    <?php if ($user->data()->position == 1 || $user->data()->position == 3 || $user->data()->position == 4 || $user->data()->position == 5) { ?>
                                                        <a href="#client<?= $client['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a>
                                                    <?php } ?>
                                                    <?php if (!$user->data()->accessLevel == 4) { ?>

                                                        <a href="id.php?cid=<?= $client['id'] ?>" class="btn btn-warning">Patient ID</a>
                                                    <?php } ?>

                                                    <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                                        <a href="#delete<?= $client['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                    <?php } ?>
                                                    <a href="info.php?id=4&cid=<?= $client['id'] ?>" role="button" class="btn btn-warning">Schedule</a>
                                                </td>

                                            </tr>
                                            <div class="modal fade" id="clientView<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Client View</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Study</label>
                                                                                        <select name="position" style="width: 100%;" disabled>
                                                                                            <?php foreach ($override->getData('study') as $study) { ?>
                                                                                                <option value="<?= $study['id'] ?>"><?= $study['name'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Entry</label>
                                                                                        <input value="<?= $client['clinic_date'] ?>" class="validate[required,custom[date]]" type="text" name="clinic_date" id="clinic_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment ID</label>
                                                                                        <input value="<?= $client['enrollment_id'] ?>" type="text" name="enrollment_id" id="enrollment_id" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            // if (!$user->data()->accessLevel == 4) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Hospital ID Number</label>
                                                                                        <input value="<?= $client['id_number'] ?>" type="text" name="id_number" id="id_number" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            //  }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                        // if (!$user->data()->accessLevel == 4) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>CTC-ID Number:</label>
                                                                                        <input value="<?= $client['ctc_number'] ?>" type="text" name="ctc_number" id="ctc_number" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>First Name</label>
                                                                                        <input value="<?= $client['firstname'] ?>" type="text" name="firstname" id="firstname" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Middle Name</label>
                                                                                        <input value="<?= $client['middlename'] ?>" type="text" name="middlename" id="middlename" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Last Name</label>
                                                                                        <input value="<?= $client['lastname'] ?>" type="text" name="lastname" id="lastname" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <?php
                                                                        // }
                                                                        ?>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Birth</label>
                                                                                        <input value="<?= $client['dob'] ?>" type="text" name="dob" id="dob" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent Viral Load (within 6 months):</label>
                                                                                        <input value="<?= $client['recent_vl'] ?>" type="text" name="recent_vl" id="recent_vl" disabled />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent DATE (within 6 months)</label>
                                                                                        <input value="<?= $client['recent_vl_date'] ?>" type="text" name="recent_vl_date" id="recent_vl_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load (AT Enrollment):</label>
                                                                                        <input value="<?= $client['vl'] ?>" type="text" name="vl" id="vl" disabled />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load DATE(At Enrollment)</label>
                                                                                        <input value="<?= $client['vl_date'] ?>" type="text" name="vl_date" id="vl_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Initials:</label>
                                                                                        <input value="<?= $client['initials'] ?>" type="text" name="initials" id="initials" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Gender</label>
                                                                                        <select name="gender" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['gender'] ?>"><?= $client['gender'] ?></option>
                                                                                            <option value="male">Male</option>
                                                                                            <option value="female">Female</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Marital Status:</label>
                                                                                        <select name="marital_status" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['marital_status'] ?>"><?= $client['marital_status'] ?></option>
                                                                                            <option value="Single">Single</option>
                                                                                            <option value="Married">Married</option>
                                                                                            <option value="Divorced">Divorced</option>
                                                                                            <option value="Separated">Separated</option>
                                                                                            <option value="Widower">Widower/Widow</option>
                                                                                            <option value="Cohabit">Cohabit</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Education Level</label>
                                                                                        <select name="education_level" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['education_level'] ?>"><?= $client['education_level'] ?></option>
                                                                                            <option value="Not attended school">Not attended school</option>
                                                                                            <option value="Primary">Primary</option>
                                                                                            <option value="Secondary">Secondary</option>
                                                                                            <option value="Certificate">Certificate</option>
                                                                                            <option value="Diploma">Diploma</option>
                                                                                            <option value="Undergraduate degree">Undergraduate degree</option>
                                                                                            <option value="Postgraduate degree">Postgraduate degree</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Workplace/station site:</label>
                                                                                        <input value="<?= $client['workplace'] ?>" class="" type="text" name="workplace" id="workplace" disabled />

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Occupation</label>
                                                                                        <input value="<?= $client['occupation'] ?>" class="" type="text" name="occupation" id="occupation" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            // if (!$user->data()->accessLevel == 4) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Phone Number:</label>
                                                                                        <input value="<?= $client['phone_number'] ?>" class="" type="text" name="phone_number" id="phone" disabled /> <span>Example: 0700 000 111</span>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            //  }
                                                                            ?>
                                                                        </div>


                                                                        <div class="row">
                                                                            <?php
                                                                            // if (!$user->data()->accessLevel == 4) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Relative's Phone Number:</label>
                                                                                        <input value="<?= $client['other_phone'] ?>" class="" type="text" name="other_phone" id="other_phone" disabled /> <span>Example: 0700 000 111</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                            //  }
                                                                            ?>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Residence Street::</label>
                                                                                        <input value="<?= $client['street'] ?>" class="" type="text" name="street" id="street" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Ward</label>
                                                                                        <input value="<?= $client['ward'] ?>" class="" type="text" name="ward" id="ward" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>District:</label>
                                                                                        <input value="<?= $client['district'] ?>" class="" type="text" name="district" id="district" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <?php
                                                                            // if (!$user->data()->accessLevel == 4) {
                                                                            ?>
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>House Number:</label>
                                                                                        <input value="<?= $client['block_no'] ?>" class="" type="text" name="block_no" id="block_no" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            //  }
                                                                            ?>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Status::</label>
                                                                                        <select name="enrollment_status" id="enrollment_status" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['enrollment_status'] ?>"><?php if ($client['enrollment_status']) {
                                                                                                                                                    if ($client['enrollment_status'] == 1) {
                                                                                                                                                        echo 'Enrolled';
                                                                                                                                                    } elseif ($client['enrollment_status'] == 2) {
                                                                                                                                                        echo 'Not Enrolled';
                                                                                                                                                    }
                                                                                                                                                } else {
                                                                                                                                                    echo 'Select';
                                                                                                                                                } ?>
                                                                                            </option>
                                                                                            <option value="1">Enrolled</option>
                                                                                            <option value="2">Not Enrolled</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Date:</label>
                                                                                        <input value="<?= $client['enrollment_date'] ?>" type="text" name="enrollment_date" id="enrollment_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Comments:</label>
                                                                                        <textarea name="comments" rows="4"><?= $client['comments'] ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="client<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form id="validation" enctype="multipart/form-data" method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Client Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Study</label>
                                                                                        <select name="position" style="width: 100%;" required>
                                                                                            <?php foreach ($override->getData('study') as $study) { ?>
                                                                                                <option value="<?= $study['id'] ?>"><?= $study['name'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Entry</label>
                                                                                        <input value="<?= $client['clinic_date'] ?>" class="validate[required,custom[date]]" type="text" name="clinic_date" id="clinic_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment ID</label>
                                                                                        <input value="<?= $client['enrollment_id'] ?>" type="text" name="enrollment_id" id="enrollment_id" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Hospital ID Number</label>
                                                                                        <input value="<?= $client['id_number'] ?>" type="text" name="id_number" id="id_number" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>CTC-ID Number:</label>
                                                                                        <input value="<?= $client['ctc_number'] ?>" type="text" name="ctc_number" id="ctc_number" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>First Name</label>
                                                                                        <input value="<?= $client['firstname'] ?>" class="validate[required]" type="text" name="firstname" id="firstname" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Middle Name</label>
                                                                                        <input value="<?= $client['middlename'] ?>" class="validate[required]" type="text" name="middlename" id="middlename" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Last Name</label>
                                                                                        <input value="<?= $client['lastname'] ?>" class="validate[required]" type="text" name="lastname" id="lastname" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Birth</label>
                                                                                        <input value="<?= $client['dob'] ?>" class="validate[required,custom[date]]" type="text" name="dob" id="dob" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent Viral Load (within 6 months):</label>
                                                                                        <input value="<?= $client['recent_vl'] ?>" type="text" name="recent_vl" id="recent_vl" />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent DATE (within 6 months)</label>
                                                                                        <input value="<?= $client['recent_vl_date'] ?>" type="text" name="recent_vl_date" id="recent_vl_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load (AT Enrollment):</label>
                                                                                        <input value="<?= $client['vl'] ?>" type="text" name="vl" id="vl" />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load DATE(At Enrollment)</label>
                                                                                        <input value="<?= $client['vl_date'] ?>" type="text" name="vl_date" id="vl_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Initials:</label>
                                                                                        <input value="<?= $client['initials'] ?>" class="validate[required]" type="text" name="initials" id="initials" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Gender</label>
                                                                                        <select name="gender" style="width: 100%;" required>
                                                                                            <option value="<?= $client['gender'] ?>"><?= $client['gender'] ?></option>
                                                                                            <option value="male">Male</option>
                                                                                            <option value="female">Female</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Marital Status:</label>
                                                                                        <select name="marital_status" style="width: 100%;" required>
                                                                                            <option value="<?= $client['marital_status'] ?>"><?= $client['marital_status'] ?></option>
                                                                                            <option value="Single">Single</option>
                                                                                            <option value="Married">Married</option>
                                                                                            <option value="Divorced">Divorced</option>
                                                                                            <option value="Separated">Separated</option>
                                                                                            <option value="Widower">Widower/Widow</option>
                                                                                            <option value="Cohabit">Cohabit</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Education Level</label>
                                                                                        <select name="education_level" style="width: 100%;" required>
                                                                                            <option value="<?= $client['education_level'] ?>"><?= $client['education_level'] ?></option>
                                                                                            <option value="Not attended school">Not attended school</option>
                                                                                            <option value="Primary">Primary</option>
                                                                                            <option value="Secondary">Secondary</option>
                                                                                            <option value="Certificate">Certificate</option>
                                                                                            <option value="Diploma">Diploma</option>
                                                                                            <option value="Undergraduate degree">Undergraduate degree</option>
                                                                                            <option value="Postgraduate degree">Postgraduate degree</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Workplace/station site:</label>
                                                                                        <input value="<?= $client['workplace'] ?>" class="" type="text" name="workplace" id="workplace" required />

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Occupation</label>
                                                                                        <input value="<?= $client['occupation'] ?>" class="" type="text" name="occupation" id="occupation" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Phone Number:</label>
                                                                                        <input value="<?= $client['phone_number'] ?>" class="" type="text" name="phone_number" id="phone" required /> <span>Example: 0700 000 111</span>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Relative's Phone Number:</label>
                                                                                        <input value="<?= $client['other_phone'] ?>" class="" type="text" name="other_phone" id="other_phone" /> <span>Example: 0700 000 111</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Residence Street::</label>
                                                                                        <input value="<?= $client['street'] ?>" class="" type="text" name="street" id="street" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Ward</label>
                                                                                        <input value="<?= $client['ward'] ?>" class="" type="text" name="ward" id="ward" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>District:</label>
                                                                                        <input value="<?= $client['district'] ?>" class="" type="text" name="district" id="district" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>House Number:</label>
                                                                                        <input value="<?= $client['block_no'] ?>" class="" type="text" name="block_no" id="block_no" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Status::</label>
                                                                                        <select name="enrollment_status" id="enrollment_status" style="width: 100%;">
                                                                                            <option value="<?= $client['enrollment_status'] ?>"><?php if ($client['enrollment_status']) {
                                                                                                                                                    if ($client['enrollment_status'] == 1) {
                                                                                                                                                        echo 'Enrolled';
                                                                                                                                                    } elseif ($client['enrollment_status'] == 2) {
                                                                                                                                                        echo 'Not Enrolled';
                                                                                                                                                    }
                                                                                                                                                } else {
                                                                                                                                                    echo 'Select';
                                                                                                                                                } ?>
                                                                                            </option>
                                                                                            <option value="1">Enrolled</option>
                                                                                            <option value="2">Not Enrolled</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Date:</label>
                                                                                        <input value="<?= $client['enrollment_date'] ?>" class="validate[custom[date]]" type="text" name="enrollment_date" id="enrollment_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Comments:</label>
                                                                                        <textarea name="comments" rows="4"><?= $client['comments'] ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="client_image" value="<?= $client['client_image'] ?>" />
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <input type="submit" name="edit_client" value="Save updates" class="btn btn-warning">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Delete User</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <strong style="font-weight: bold;color: red">
                                                                    <p>Are you sure you want to delete this user</p>
                                                                </strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <input type="submit" name="delete_client" value="Delete" class="btn btn-danger">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="img<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Client Image</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= $img ?>" width="350">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php $x++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="info.php?id=3&sid=&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                            echo $_GET['page'] - 1;
                                                                        } else {
                                                                            echo 1;
                                                                        } ?>" class="btn btn-default">
                                        < </a>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <a href="info.php?id=3&sid=<?= $_GET['sid'] ?>&page=<?= $_GET['id'] ?>&page=<?= $i ?>" class="btn btn-default <?php if ($i == $_GET['page']) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>"><?= $i ?></a>
                                            <?php } ?>
                                            <a href="info.php?id=3&sid=<?= $_GET['sid'] ?>&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>" class="btn btn-default"> > </a>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($_GET['id'] == 4) { ?>
                        <div class="col-md-12">
                            <?php $patient = $override->get('clients', 'id', $_GET['cid'])[0] ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="ucard clearfix">
                                        <div class="right">
                                            <div class="image">
                                                <?php if ($patient['client_image'] != '' || is_null($patient['client_image'])) {
                                                    $img = $patient['client_image'];
                                                } else {
                                                    $img = 'img/users/blank.png';
                                                } ?>
                                                <a href="#"><img src="<?= $img ?>" width="300" class="img-thumbnail"></a>
                                            </div>
                                            <h5><?= 'Name: ' . $patient['firstname'] . ' ' . $patient['lastname'] . ' Age: ' . $patient['age'] ?></h5>
                                            <h4><strong style="font-size: medium">Screening ID: <?= $patient['participant_id'] ?></strong></h4>
                                            <h4><strong style="font-size: larger">Study ID: <?= $patient['study_id'] ?></strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="head clearfix">
                                        <div class="isw-grid"></div>
                                        <h1>Schedule</h1>
                                        <ul class="buttons">
                                            <li><a href="#" class="isw-download"></a></li>
                                            <li><a href="#" class="isw-attachment"></a></li>
                                            <li>
                                                <a href="#" class="isw-settings"></a>
                                                <ul class="dd-list">
                                                    <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                                    <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                                    <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="block-fluid">
                                        <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="15%">Visit Name</th>
                                                    <th width="15%">Visit Code</th>
                                                    <th width="15%">Expected Date</th>
                                                    <th width="15%">Visit Date</th>
                                                    <th width="10%">Status</th>
                                                    <th width="35%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $x = 1;
                                                $btn = 'Add';
                                                if ($user->data()->accessLevel == 4) {
                                                    $btn = 'View';
                                                }
                                                foreach ($override->get('visit', 'client_id', $_GET['cid']) as $visit) { ?>
                                                    <tr>
                                                        <td><?= $x ?></td>
                                                        <td> <?= $visit['visit_name'] ?></td>
                                                        <td> <?= $visit['visit_code'] ?></td>
                                                        <td> <?= $visit['expected_date'] ?></td>
                                                        <td> <?= $visit['visit_date'] ?></td>
                                                        <td>
                                                            <?php if ($visit['status'] == 1) { ?>
                                                                <a href="#" role="button" class="btn btn-success">Done</a>
                                                            <?php } elseif ($visit['status'] == 0) { ?>
                                                                <a href="#" role="button" class="btn btn-warning">Pending</a>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($visit['visit_code'] == 'D0') {
                                                                $visit_code = 1 ?>
                                                                <a href="#visit<?= $visit['id'] ?>" role="button" class="btn btn-info" data-toggle="modal"><?= $btn ?> Visit V1</a>
                                                            <?php } elseif ($visit['visit_code'] == 'M6') {
                                                                $visit_code = 2 ?>
                                                                <a href="#visit<?= $visit['id'] ?>" role="button" class="btn btn-info" data-toggle="modal"><?= $btn ?> Visit V2</a>
                                                            <?php } elseif ($visit['visit_code'] = 'M12') {
                                                                $visit_code = 3 ?>
                                                                <a href="#visit<?= $visit['id'] ?>" role="button" class="btn btn-info" data-toggle="modal"><?= $btn ?> Visit V3</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $Add = 'Add View';
                                                    if ($user->data()->accessLevel == 4) {
                                                        $Add = 'View Visits';
                                                    } ?>
                                                    <div class="modal fade" id="visit<?= $visit['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="post">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4><?= $Add ?></h4>
                                                                    </div>
                                                                    <div class="modal-body modal-body-np">
                                                                        <div class="row">
                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">Visit Status</div>
                                                                                <div class="col-md-9">
                                                                                    <select name="visit_status" id="visit_status" style="width: 100%;">
                                                                                        <option value="<?= $visit['visit_status'] ?>"><?php if ($visit['visit_status']) {
                                                                                                                                            if ($visit['visit_status'] == 1) {
                                                                                                                                                echo 'Attended';
                                                                                                                                            } elseif ($visit['visit_status'] == 2) {
                                                                                                                                                echo 'Missed';
                                                                                                                                            }
                                                                                                                                        } else {
                                                                                                                                            echo 'Select';
                                                                                                                                        } ?>
                                                                                        </option>
                                                                                        <option value="1">Attended</option>
                                                                                        <option value="2">Missed</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">Visit Date:</div>
                                                                                <div class="col-md-9">
                                                                                    <input class="validate[required,custom[date]]" type="text" name="visit_date" id="visit_date" value="<?= $visit['visit_date'] ?>" />
                                                                                    <span>Example: 2010-12-01</span>
                                                                                </div>
                                                                            </div>

                                                                            <?php if ($visit_code == 1) { ?>
                                                                                <div class="row-form clearfix">
                                                                                    <div class="col-md-3">Date sample for the viral load taken?(six previous month):</div>
                                                                                    <div class="col-md-9">
                                                                                        <input value="<?= $visit['sample_date6'] ?>" class="validate[required,custom[date]]" type="text" name="sample_date6" id="sample_date6" />
                                                                                        <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row-form clearfix">
                                                                                    <div class="col-md-3">What is the viral load result for the Six previous months?:</div>
                                                                                    <div class="col-md-9">
                                                                                        <input value="<?= $visit['vl_results6'] ?>" type="text" name="vl_results6" id="vl_results6" />
                                                                                    </div>
                                                                                </div>

                                                                            <?php } ?>
                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">Date sample for the viral load taken (POC)?:</div>
                                                                                <div class="col-md-9">
                                                                                    <input value="<?= $visit['sample_date'] ?>" class="validate[required,custom[date]]" type="text" name="sample_date" id="sample_date" />
                                                                                    <span>Example: 2010-12-01</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row-form clearfix">
                                                                                <div class="col-md-3">What is the viral load result for the sample taken at today's visit(POC):</div>
                                                                                <div class="col-md-9">
                                                                                    <input value="<?= $visit['vl_results'] ?>" type="text" name="vl_results" id="vl_results" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="dr"><span></span></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2 ||  $user->data()->accessLevel == 3) { ?>
                                                                        <div class="modal-footer">
                                                                            <input type="hidden" name="id" value="<?= $visit['id'] ?>">
                                                                            <input type="hidden" name="visit_code" value="<?= $visit_code ?>">
                                                                            <input type="submit" name="add_visit" class="btn btn-warning" value="Save updates">
                                                                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                        </div>
                                                                    <?php } ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($_GET['id'] == 5) { ?>
                        <div class="col-md-6">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of IDs</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkall" /></th>
                                            <td width="40">#</td>
                                            <th width="70">STUDY ID</th>
                                            <th width="80%">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 1;
                                        $pagNum = $override->getCount('study_id', 'site_id', $user->data()->site_id);
                                        $pages = ceil($pagNum / $numRec);
                                        if (!$_GET['page'] || $_GET['page'] == 1) {
                                            $page = 0;
                                        } else {
                                            $page = ($_GET['page'] * $numRec) - $numRec;
                                        }
                                        foreach ($override->getWithLimit('study_id', 'site_id', $user->data()->site_id, $page, $numRec) as $study_id) { ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkbox" /></td>
                                                <td><?= $x ?></td>
                                                <td><?= $study_id['study_id'] ?></td>
                                                <td>
                                                    <?php if ($study_id['status'] == 1) { ?>
                                                        <a href="#" role="button" class="btn btn-success">Assigned</a>
                                                    <?php } else { ?>
                                                        <a href="#" role="button" class="btn btn-warning">Not Assigned</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php $x++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pull-left">
                                <div class="btn-group">
                                    <a href="info.php?id=5&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                    echo $_GET['page'] - 1;
                                                                } else {
                                                                    echo 1;
                                                                } ?>" class="btn btn-default">
                                        < </a>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <a href="info.php?id=5&page=<?= $_GET['id'] ?>&page=<?= $i ?>" class="btn btn-default <?php if ($i == $_GET['page']) {
                                                                                                                                            echo 'active';
                                                                                                                                        } ?>"><?= $i ?></a>
                                            <?php } ?>
                                            <a href="info.php?id=5&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                            echo $_GET['page'] + 1;
                                                                        } else {
                                                                            echo $i - 1;
                                                                        } ?>" class="btn btn-default"> > </a>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($_GET['id'] == 6) { ?>
                        <div class="col-md-12">
                            <?php if ($user->data()->power == 1 || $user->data()->power == 2) { ?>
                                <div class="head clearfix">
                                    <div class="isw-ok"></div>
                                    <h1>Search by Site</h1>
                                </div>
                                <div class="block-fluid">
                                    <form id="validation" method="post">
                                        <div class="row-form clearfix">
                                            <div class="col-md-1">Site:</div>
                                            <div class="col-md-4">
                                                <select name="site" required>
                                                    <option value="">Select Site</option>
                                                    <?php foreach ($override->getData('site') as $site) { ?>
                                                        <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" name="search_by_site" value="Search" class="btn btn-info">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of Clients Suppressed Viral Loads</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <?php if ($user->data()->power == 1 || $user->data()->power == 2) {
                                if ($_GET['sid'] != null) {
                                    $pagNum = 0;
                                    $pagNum = $override->countData3('clients', 'vl', 50, 'status', 1, 'site_id', $_GET['sid']);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $clients = $override->getWithLimit3('clients', 'vl', 50, 'site_id', $_GET['sid'], 'status', 1, $page, $numRec);
                                } else {
                                    $pagNum = 0;
                                    $pagNum = $override->countData2('clients', 'vl', 50, 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $clients = $override->getWithLimit3('clients', 'vl', 50, 'status', 1, $page, $numRec);
                                }
                            } else {
                                $pagNum = 0;
                                $pagNum = $override->countData3('clients', 'vl', 50, 'site_id', $user->data()->site_id, 'status', 1);
                                $pages = ceil($pagNum / $numRec);
                                if (!$_GET['page'] || $_GET['page'] == 1) {
                                    $page = 0;
                                } else {
                                    $page = ($_GET['page'] * $numRec) - $numRec;
                                }
                                $clients = $override->getWithLimit4('clients', 'vl', 50, 'site_id', $user->data()->site_id, 'status', 1, $page, $numRec);
                            } ?>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkall" /></th>
                                            <td width="20">#</td>
                                            <th width="40">Picture</th>
                                            <th width="40">Enrollment Date</th>
                                            <th width="8%">Enrollment id</th>
                                            <th width="8%">Recent Viral Load within 6 months (copies/ml)</th>
                                            <th width="8%">Recent DATE (within 6 months)<span></span></th>
                                            <th width="8%">Viral Load (At Enrollment)(copies/ml)</th>
                                            <th width="8%">Viral Load DATE(At Enrollment)</th>
                                            <th width="8%">Site</th>
                                            <th width="8%">Name</th>
                                            <th width="8%">Gender</th>
                                            <th width="8%">Age</th>
                                            <th width="8%">Staff</th>
                                            <th width="40%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 1;
                                        foreach ($clients as $client) {
                                            $site = $override->getData2('site', 'id', $client['site_id'])[0];
                                            $staff = $override->getData2('user', 'id', $client['staff_id'])[0];
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkbox" /></td>
                                                <td><?= $x ?></td>
                                                <td width="100">
                                                    <?php if ($client['client_image'] != '' || is_null($client['client_image'])) {
                                                        $img = $client['client_image'];
                                                    } else {
                                                        $img = 'img/users/blank.png';
                                                    } ?>
                                                    <a href="#img<?= $client['id'] ?>" data-toggle="modal"><img src="<?= $img ?>" width="90" height="90" class="" /></a>
                                                </td>
                                                <td><?= $client['enrollment_date'] ?></td>
                                                <td><?= $client['enrollment_id'] ?></td>
                                                <td><?= $client['recent_vl'] ?><br><br><span>(copies/ml)</span></td>
                                                <td><?= $client['recent_vl_date'] ?></td>
                                                <td><?= $client['vl'] ?><br><br><span>(copies/ml)</span></td>
                                                <td><?= $client['vl_date'] ?></td>
                                                <td><?= $site['name'] ?></td>
                                                <td> <?= $client['firstname'] . ' ' . $client['lastname'] ?></td>
                                                <td><?= $client['gender'] ?></td>
                                                <td><?= $client['age'] ?></td>
                                                <td><?= $staff['username'] ?></td>
                                                <td>
                                                    <a href="#clientView<?= $client['id'] ?>" role="button" class="btn btn-default" data-toggle="modal">View</a>

                                                    <?php if ($user->data()->position == 1 || $user->data()->position == 3 || $user->data()->position == 4 || $user->data()->position == 5) { ?>
                                                        <a href="#client<?= $client['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a>
                                                    <?php } ?>

                                                    <a href="id.php?cid=<?= $client['id'] ?>" class="btn btn-warning">Patient ID</a>
                                                    <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                                        <a href="#delete<?= $client['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                    <?php } ?>
                                                    <a href="info.php?id=4&cid=<?= $client['id'] ?>" role="button" class="btn btn-warning">Schedule</a>
                                                </td>

                                            </tr>
                                            <div class="modal fade" id="clientView<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Client View</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Study</label>
                                                                                        <select name="position" style="width: 100%;" disabled>
                                                                                            <?php foreach ($override->getData('study') as $study) { ?>
                                                                                                <option value="<?= $study['id'] ?>"><?= $study['name'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Entry</label>
                                                                                        <input value="<?= $client['clinic_date'] ?>" class="validate[required,custom[date]]" type="text" name="clinic_date" id="clinic_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment ID</label>
                                                                                        <input value="<?= $client['enrollment_id'] ?>" type="text" name="enrollment_id" id="enrollment_id" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Hospital ID Number</label>
                                                                                        <input value="<?= $client['id_number'] ?>" type="text" name="id_number" id="id_number" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>CTC-ID Number:</label>
                                                                                        <input value="<?= $client['ctc_number'] ?>" type="text" name="ctc_number" id="ctc_number" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>First Name</label>
                                                                                        <input value="<?= $client['firstname'] ?>" type="text" name="firstname" id="firstname" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Middle Name</label>
                                                                                        <input value="<?= $client['middlename'] ?>" type="text" name="middlename" id="middlename" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Last Name</label>
                                                                                        <input value="<?= $client['lastname'] ?>" type="text" name="lastname" id="lastname" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Birth</label>
                                                                                        <input value="<?= $client['dob'] ?>" type="text" name="dob" id="dob" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent Viral Load (within 6 months):</label>
                                                                                        <input value="<?= $client['recent_vl'] ?>" type="text" name="recent_vl" id="recent_vl" disabled />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent DATE (within 6 months)</label>
                                                                                        <input value="<?= $client['recent_vl_date'] ?>" type="text" name="recent_vl_date" id="recent_vl_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load (AT Enrollment):</label>
                                                                                        <input value="<?= $client['vl'] ?>" type="text" name="vl" id="vl" disabled />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load DATE(At Enrollment)</label>
                                                                                        <input value="<?= $client['vl_date'] ?>" type="text" name="vl_date" id="vl_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Initials:</label>
                                                                                        <input value="<?= $client['initials'] ?>" type="text" name="initials" id="initials" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Gender</label>
                                                                                        <select name="gender" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['gender'] ?>"><?= $client['gender'] ?></option>
                                                                                            <option value="male">Male</option>
                                                                                            <option value="female">Female</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Marital Status:</label>
                                                                                        <select name="marital_status" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['marital_status'] ?>"><?= $client['marital_status'] ?></option>
                                                                                            <option value="Single">Single</option>
                                                                                            <option value="Married">Married</option>
                                                                                            <option value="Divorced">Divorced</option>
                                                                                            <option value="Separated">Separated</option>
                                                                                            <option value="Widower">Widower/Widow</option>
                                                                                            <option value="Cohabit">Cohabit</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Education Level</label>
                                                                                        <select name="education_level" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['education_level'] ?>"><?= $client['education_level'] ?></option>
                                                                                            <option value="Not attended school">Not attended school</option>
                                                                                            <option value="Primary">Primary</option>
                                                                                            <option value="Secondary">Secondary</option>
                                                                                            <option value="Certificate">Certificate</option>
                                                                                            <option value="Diploma">Diploma</option>
                                                                                            <option value="Undergraduate degree">Undergraduate degree</option>
                                                                                            <option value="Postgraduate degree">Postgraduate degree</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Workplace/station site:</label>
                                                                                        <input value="<?= $client['workplace'] ?>" class="" type="text" name="workplace" id="workplace" disabled />

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Occupation</label>
                                                                                        <input value="<?= $client['occupation'] ?>" class="" type="text" name="occupation" id="occupation" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Phone Number:</label>
                                                                                        <input value="<?= $client['phone_number'] ?>" class="" type="text" name="phone_number" id="phone" disabled /> <span>Example: 0700 000 111</span>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Relative's Phone Number:</label>
                                                                                        <input value="<?= $client['other_phone'] ?>" class="" type="text" name="other_phone" id="other_phone" disabled /> <span>Example: 0700 000 111</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Residence Street::</label>
                                                                                        <input value="<?= $client['street'] ?>" class="" type="text" name="street" id="street" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Ward</label>
                                                                                        <input value="<?= $client['ward'] ?>" class="" type="text" name="ward" id="ward" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>District:</label>
                                                                                        <input value="<?= $client['district'] ?>" class="" type="text" name="district" id="district" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>House Number:</label>
                                                                                        <input value="<?= $client['block_no'] ?>" class="" type="text" name="block_no" id="block_no" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Status::</label>
                                                                                        <select name="enrollment_status" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['enrollment_status'] ?>"><?= $client['enrollment_status'] ?></option>
                                                                                            <option value="1">Enrolled</option>
                                                                                            <option value="2">Not Enrolled</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Date:</label>
                                                                                        <input value="<?= $client['enrollment_date'] ?>" type="text" name="enrollment_date" id="enrollment_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Comments:</label>
                                                                                        <textarea name="comments" rows="4"><?= $client['comments'] ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="client<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form id="validation" enctype="multipart/form-data" method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Client Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Study</label>
                                                                                        <select name="position" style="width: 100%;" required>
                                                                                            <?php foreach ($override->getData('study') as $study) { ?>
                                                                                                <option value="<?= $study['id'] ?>"><?= $study['name'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Entry</label>
                                                                                        <input value="<?= $client['clinic_date'] ?>" class="validate[required,custom[date]]" type="text" name="clinic_date" id="clinic_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment ID</label>
                                                                                        <input value="<?= $client['enrollment_id'] ?>" type="text" name="enrollment_id" id="enrollment_id" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Hospital ID Number</label>
                                                                                        <input value="<?= $client['id_number'] ?>" type="text" name="id_number" id="id_number" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>CTC-ID Number:</label>
                                                                                        <input value="<?= $client['ctc_number'] ?>" type="text" name="ctc_number" id="ctc_number" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>First Name</label>
                                                                                        <input value="<?= $client['firstname'] ?>" class="validate[required]" type="text" name="firstname" id="firstname" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Middle Name</label>
                                                                                        <input value="<?= $client['middlename'] ?>" class="validate[required]" type="text" name="middlename" id="middlename" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Last Name</label>
                                                                                        <input value="<?= $client['lastname'] ?>" class="validate[required]" type="text" name="lastname" id="lastname" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Birth</label>
                                                                                        <input value="<?= $client['dob'] ?>" class="validate[required,custom[date]]" type="text" name="dob" id="dob" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent Viral Load (within 6 months):</label>
                                                                                        <input value="<?= $client['recent_vl'] ?>" type="text" name="recent_vl" id="recent_vl" />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent DATE (within 6 months)</label>
                                                                                        <input value="<?= $client['recent_vl_date'] ?>" type="text" name="recent_vl_date" id="recent_vl_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load (AT Enrollment):</label>
                                                                                        <input value="<?= $client['vl'] ?>" type="text" name="vl" id="vl" />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load DATE(At Enrollment)</label>
                                                                                        <input value="<?= $client['vl_date'] ?>" type="text" name="vl_date" id="vl_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Initials:</label>
                                                                                        <input value="<?= $client['initials'] ?>" class="validate[required]" type="text" name="initials" id="initials" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Gender</label>
                                                                                        <select name="gender" style="width: 100%;" required>
                                                                                            <option value="<?= $client['gender'] ?>"><?= $client['gender'] ?></option>
                                                                                            <option value="male">Male</option>
                                                                                            <option value="female">Female</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Marital Status:</label>
                                                                                        <select name="marital_status" style="width: 100%;" required>
                                                                                            <option value="<?= $client['marital_status'] ?>"><?= $client['marital_status'] ?></option>
                                                                                            <option value="Single">Single</option>
                                                                                            <option value="Married">Married</option>
                                                                                            <option value="Divorced">Divorced</option>
                                                                                            <option value="Separated">Separated</option>
                                                                                            <option value="Widower">Widower/Widow</option>
                                                                                            <option value="Cohabit">Cohabit</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Education Level</label>
                                                                                        <select name="education_level" style="width: 100%;" required>
                                                                                            <option value="<?= $client['education_level'] ?>"><?= $client['education_level'] ?></option>
                                                                                            <option value="Not attended school">Not attended school</option>
                                                                                            <option value="Primary">Primary</option>
                                                                                            <option value="Secondary">Secondary</option>
                                                                                            <option value="Certificate">Certificate</option>
                                                                                            <option value="Diploma">Diploma</option>
                                                                                            <option value="Undergraduate degree">Undergraduate degree</option>
                                                                                            <option value="Postgraduate degree">Postgraduate degree</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Workplace/station site:</label>
                                                                                        <input value="<?= $client['workplace'] ?>" class="" type="text" name="workplace" id="workplace" required />

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Occupation</label>
                                                                                        <input value="<?= $client['occupation'] ?>" class="" type="text" name="occupation" id="occupation" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Phone Number:</label>
                                                                                        <input value="<?= $client['phone_number'] ?>" class="" type="text" name="phone_number" id="phone" required /> <span>Example: 0700 000 111</span>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Relative's Phone Number:</label>
                                                                                        <input value="<?= $client['other_phone'] ?>" class="" type="text" name="other_phone" id="other_phone" /> <span>Example: 0700 000 111</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Residence Street::</label>
                                                                                        <input value="<?= $client['street'] ?>" class="" type="text" name="street" id="street" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Ward</label>
                                                                                        <input value="<?= $client['ward'] ?>" class="" type="text" name="ward" id="ward" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>District:</label>
                                                                                        <input value="<?= $client['district'] ?>" class="" type="text" name="district" id="district" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>House Number:</label>
                                                                                        <input value="<?= $client['block_no'] ?>" class="" type="text" name="block_no" id="block_no" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Status::</label>
                                                                                        <select name="enrollment_status" style="width: 100%;" required>
                                                                                            <option value="<?= $client['enrollment_status'] ?>"><?= $client['enrollment_status'] ?></option>
                                                                                            <option value="1">Enrolled</option>
                                                                                            <option value="2">Not Enrolled</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Date:</label>
                                                                                        <input value="<?= $client['enrollment_date'] ?>" class="validate[custom[date]]" type="text" name="enrollment_date" id="enrollment_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Comments:</label>
                                                                                        <textarea name="comments" rows="4"><?= $client['comments'] ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="client_image" value="<?= $client['client_image'] ?>" />
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <input type="submit" name="edit_client" value="Save updates" class="btn btn-warning">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Delete User</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <strong style="font-weight: bold;color: red">
                                                                    <p>Are you sure you want to delete this user</p>
                                                                </strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <input type="submit" name="delete_client" value="Delete" class="btn btn-danger">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="img<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Client Image</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= $img ?>" width="350">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php $x++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="info.php?id=3&sid=&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                            echo $_GET['page'] - 1;
                                                                        } else {
                                                                            echo 1;
                                                                        } ?>" class="btn btn-default">
                                        < </a>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <a href="info.php?id=3&sid=<?= $_GET['sid'] ?>&page=<?= $_GET['id'] ?>&page=<?= $i ?>" class="btn btn-default <?php if ($i == $_GET['page']) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>"><?= $i ?></a>
                                            <?php } ?>
                                            <a href="info.php?id=3&sid=<?= $_GET['sid'] ?>&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>" class="btn btn-default"> > </a>
                                </div>
                            </div>
                        </div>

                    <?php } elseif ($_GET['id'] == 7) { ?>
                        <div class="col-md-12">
                            <?php if ($user->data()->power == 1 || $user->data()->power == 2) { ?>
                                <div class="head clearfix">
                                    <div class="isw-ok"></div>
                                    <h1>Search by Site</h1>
                                </div>
                                <div class="block-fluid">
                                    <form id="validation" method="post">
                                        <div class="row-form clearfix">
                                            <div class="col-md-1">Site:</div>
                                            <div class="col-md-4">
                                                <select name="site" required>
                                                    <option value="">Select Site</option>
                                                    <?php foreach ($override->getData('site') as $site) { ?>
                                                        <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" name="search_by_site" value="Search" class="btn btn-info">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>List of Clients Suppressed Viral Loads</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <?php if ($user->data()->power == 1 || $user->data()->power == 2) {
                                if ($_GET['sid'] != null) {
                                    $pagNum = 0;
                                    $pagNum = $override->countData3('clients', 'vl', 50, 'status', 1, 'site_id', $_GET['sid']);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $clients = $override->getWithLimit3('clients', 'vl', 50, 'site_id', $_GET['sid'], 'status', 1, $page, $numRec);
                                } else {
                                    $pagNum = 0;
                                    $pagNum = $override->countData2('clients', 'vl', 50, 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $clients = $override->getWithLimit3('clients', 'vl', 50, 'status', 1, $page, $numRec);
                                }
                            } else {
                                $pagNum = 0;
                                $pagNum = $override->countData3('clients', 'vl', 50, 'site_id', $user->data()->site_id, 'status', 1);
                                $pages = ceil($pagNum / $numRec);
                                if (!$_GET['page'] || $_GET['page'] == 1) {
                                    $page = 0;
                                } else {
                                    $page = ($_GET['page'] * $numRec) - $numRec;
                                }
                                $clients = $override->getWithLimit4('clients', 'vl', 50, 'site_id', $user->data()->site_id, 'status', 1, $page, $numRec);
                            } ?>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkall" /></th>
                                            <td width="20">#</td>
                                            <th width="40">Picture</th>
                                            <th width="40">Enrollment Date</th>
                                            <th width="8%">Enrollment id</th>
                                            <th width="8%">Recent Viral Load within 6 months (copies/ml)</th>
                                            <th width="8%">Recent DATE (within 6 months)<span></span></th>
                                            <th width="8%">Viral Load (At Enrollment)(copies/ml)</th>
                                            <th width="8%">Viral Load DATE(At Enrollment)</th>
                                            <th width="8%">Site</th>
                                            <th width="8%">Name</th>
                                            <th width="8%">Gender</th>
                                            <th width="8%">Age</th>
                                            <th width="8%">Staff</th>
                                            <th width="40%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 1;
                                        foreach ($clients as $client) {
                                            $site = $override->getData2('site', 'id', $client['site_id'])[0];
                                            $staff = $override->getData2('user', 'id', $client['staff_id'])[0];
                                            // print_r($staff);
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkbox" /></td>
                                                <td><?= $x ?></td>
                                                <td width="100">
                                                    <?php if ($client['client_image'] != '' || is_null($client['client_image'])) {
                                                        $img = $client['client_image'];
                                                    } else {
                                                        $img = 'img/users/blank.png';
                                                    } ?>
                                                    <a href="#img<?= $client['id'] ?>" data-toggle="modal"><img src="<?= $img ?>" width="90" height="90" class="" /></a>
                                                </td>
                                                <td><?= $client['enrollment_date'] ?></td>
                                                <td><?= $client['enrollment_id'] ?></td>
                                                <td><?= $client['recent_vl'] ?><br><br><span>(copies/ml)</span></td>
                                                <td><?= $client['recent_vl_date'] ?></td>
                                                <td><?= $client['vl'] ?><br><br><span>(copies/ml)</span></td>
                                                <td><?= $client['vl_date'] ?></td>
                                                <td><?= $site['name'] ?></td>
                                                <td> <?= $client['firstname'] . ' ' . $client['lastname'] ?></td>
                                                <td><?= $client['gender'] ?></td>
                                                <td><?= $client['age'] ?></td>
                                                <td><?= $staff['username'] ?></td>
                                                <td>
                                                    <a href="#clientView<?= $client['id'] ?>" role="button" class="btn btn-default" data-toggle="modal">View</a>

                                                    <?php if ($user->data()->position == 1 || $user->data()->position == 3 || $user->data()->position == 4 || $user->data()->position == 5) { ?>
                                                        <a href="#client<?= $client['id'] ?>" role="button" class="btn btn-info" data-toggle="modal">Edit</a>
                                                    <?php } ?>

                                                    <a href="id.php?cid=<?= $client['id'] ?>" class="btn btn-warning">Patient ID</a>
                                                    <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                                        <a href="#delete<?= $client['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                    <?php } ?>
                                                    <a href="info.php?id=4&cid=<?= $client['id'] ?>" role="button" class="btn btn-warning">Schedule</a>
                                                </td>

                                            </tr>
                                            <div class="modal fade" id="clientView<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Client View</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Study</label>
                                                                                        <select name="position" style="width: 100%;" disabled>
                                                                                            <?php foreach ($override->getData('study') as $study) { ?>
                                                                                                <option value="<?= $study['id'] ?>"><?= $study['name'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Entry</label>
                                                                                        <input value="<?= $client['clinic_date'] ?>" class="validate[required,custom[date]]" type="text" name="clinic_date" id="clinic_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment ID</label>
                                                                                        <input value="<?= $client['enrollment_id'] ?>" type="text" name="enrollment_id" id="enrollment_id" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Hospital ID Number</label>
                                                                                        <input value="<?= $client['id_number'] ?>" type="text" name="id_number" id="id_number" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>CTC-ID Number:</label>
                                                                                        <input value="<?= $client['ctc_number'] ?>" type="text" name="ctc_number" id="ctc_number" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>First Name</label>
                                                                                        <input value="<?= $client['firstname'] ?>" type="text" name="firstname" id="firstname" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Middle Name</label>
                                                                                        <input value="<?= $client['middlename'] ?>" type="text" name="middlename" id="middlename" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Last Name</label>
                                                                                        <input value="<?= $client['lastname'] ?>" type="text" name="lastname" id="lastname" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Birth</label>
                                                                                        <input value="<?= $client['dob'] ?>" type="text" name="dob" id="dob" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent Viral Load (within 6 months):</label>
                                                                                        <input value="<?= $client['recent_vl'] ?>" type="text" name="recent_vl" id="recent_vl" disabled />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent DATE (within 6 months)</label>
                                                                                        <input value="<?= $client['recent_vl_date'] ?>" type="text" name="recent_vl_date" id="recent_vl_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load (AT Enrollment):</label>
                                                                                        <input value="<?= $client['vl'] ?>" type="text" name="vl" id="vl" disabled />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load DATE(At Enrollment)</label>
                                                                                        <input value="<?= $client['vl_date'] ?>" type="text" name="vl_date" id="vl_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Initials:</label>
                                                                                        <input value="<?= $client['initials'] ?>" type="text" name="initials" id="initials" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Gender</label>
                                                                                        <select name="gender" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['gender'] ?>"><?= $client['gender'] ?></option>
                                                                                            <option value="male">Male</option>
                                                                                            <option value="female">Female</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Marital Status:</label>
                                                                                        <select name="marital_status" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['marital_status'] ?>"><?= $client['marital_status'] ?></option>
                                                                                            <option value="Single">Single</option>
                                                                                            <option value="Married">Married</option>
                                                                                            <option value="Divorced">Divorced</option>
                                                                                            <option value="Separated">Separated</option>
                                                                                            <option value="Widower">Widower/Widow</option>
                                                                                            <option value="Cohabit">Cohabit</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Education Level</label>
                                                                                        <select name="education_level" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['education_level'] ?>"><?= $client['education_level'] ?></option>
                                                                                            <option value="Not attended school">Not attended school</option>
                                                                                            <option value="Primary">Primary</option>
                                                                                            <option value="Secondary">Secondary</option>
                                                                                            <option value="Certificate">Certificate</option>
                                                                                            <option value="Diploma">Diploma</option>
                                                                                            <option value="Undergraduate degree">Undergraduate degree</option>
                                                                                            <option value="Postgraduate degree">Postgraduate degree</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Workplace/station site:</label>
                                                                                        <input value="<?= $client['workplace'] ?>" class="" type="text" name="workplace" id="workplace" disabled />

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Occupation</label>
                                                                                        <input value="<?= $client['occupation'] ?>" class="" type="text" name="occupation" id="occupation" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Phone Number:</label>
                                                                                        <input value="<?= $client['phone_number'] ?>" class="" type="text" name="phone_number" id="phone" disabled /> <span>Example: 0700 000 111</span>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Relative's Phone Number:</label>
                                                                                        <input value="<?= $client['other_phone'] ?>" class="" type="text" name="other_phone" id="other_phone" disabled /> <span>Example: 0700 000 111</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Residence Street::</label>
                                                                                        <input value="<?= $client['street'] ?>" class="" type="text" name="street" id="street" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Ward</label>
                                                                                        <input value="<?= $client['ward'] ?>" class="" type="text" name="ward" id="ward" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>District:</label>
                                                                                        <input value="<?= $client['district'] ?>" class="" type="text" name="district" id="district" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>House Number:</label>
                                                                                        <input value="<?= $client['block_no'] ?>" class="" type="text" name="block_no" id="block_no" disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Status::</label>
                                                                                        <select name="enrollment_status" style="width: 100%;" disabled>
                                                                                            <option value="<?= $client['enrollment_status'] ?>"><?= $client['enrollment_status'] ?></option>
                                                                                            <option value="1">Enrolled</option>
                                                                                            <option value="2">Not Enrolled</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Date:</label>
                                                                                        <input value="<?= $client['enrollment_date'] ?>" type="text" name="enrollment_date" id="enrollment_date" disabled /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Comments:</label>
                                                                                        <textarea name="comments" rows="4"><?= $client['comments'] ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="client<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form id="validation" enctype="multipart/form-data" method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Edit Client Info</h4>
                                                            </div>
                                                            <div class="modal-body modal-body-np">
                                                                <div class="row">
                                                                    <div class="block-fluid">
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Study</label>
                                                                                        <select name="position" style="width: 100%;" required>
                                                                                            <?php foreach ($override->getData('study') as $study) { ?>
                                                                                                <option value="<?= $study['id'] ?>"><?= $study['name'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Entry</label>
                                                                                        <input value="<?= $client['clinic_date'] ?>" class="validate[required,custom[date]]" type="text" name="clinic_date" id="clinic_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment ID</label>
                                                                                        <input value="<?= $client['enrollment_id'] ?>" type="text" name="enrollment_id" id="enrollment_id" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Hospital ID Number</label>
                                                                                        <input value="<?= $client['id_number'] ?>" type="text" name="id_number" id="id_number" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>CTC-ID Number:</label>
                                                                                        <input value="<?= $client['ctc_number'] ?>" type="text" name="ctc_number" id="ctc_number" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>First Name</label>
                                                                                        <input value="<?= $client['firstname'] ?>" class="validate[required]" type="text" name="firstname" id="firstname" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Middle Name</label>
                                                                                        <input value="<?= $client['middlename'] ?>" class="validate[required]" type="text" name="middlename" id="middlename" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Last Name</label>
                                                                                        <input value="<?= $client['lastname'] ?>" class="validate[required]" type="text" name="lastname" id="lastname" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Date of Birth</label>
                                                                                        <input value="<?= $client['dob'] ?>" class="validate[required,custom[date]]" type="text" name="dob" id="dob" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent Viral Load (within 6 months):</label>
                                                                                        <input value="<?= $client['recent_vl'] ?>" type="text" name="recent_vl" id="recent_vl" />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Recent DATE (within 6 months)</label>
                                                                                        <input value="<?= $client['recent_vl_date'] ?>" type="text" name="recent_vl_date" id="recent_vl_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load (AT Enrollment):</label>
                                                                                        <input value="<?= $client['vl'] ?>" type="text" name="vl" id="vl" />
                                                                                        <span>(copies/ml)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Viral Load DATE(At Enrollment)</label>
                                                                                        <input value="<?= $client['vl_date'] ?>" type="text" name="vl_date" id="vl_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Initials:</label>
                                                                                        <input value="<?= $client['initials'] ?>" class="validate[required]" type="text" name="initials" id="initials" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Gender</label>
                                                                                        <select name="gender" style="width: 100%;" required>
                                                                                            <option value="<?= $client['gender'] ?>"><?= $client['gender'] ?></option>
                                                                                            <option value="male">Male</option>
                                                                                            <option value="female">Female</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Marital Status:</label>
                                                                                        <select name="marital_status" style="width: 100%;" required>
                                                                                            <option value="<?= $client['marital_status'] ?>"><?= $client['marital_status'] ?></option>
                                                                                            <option value="Single">Single</option>
                                                                                            <option value="Married">Married</option>
                                                                                            <option value="Divorced">Divorced</option>
                                                                                            <option value="Separated">Separated</option>
                                                                                            <option value="Widower">Widower/Widow</option>
                                                                                            <option value="Cohabit">Cohabit</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Education Level</label>
                                                                                        <select name="education_level" style="width: 100%;" required>
                                                                                            <option value="<?= $client['education_level'] ?>"><?= $client['education_level'] ?></option>
                                                                                            <option value="Not attended school">Not attended school</option>
                                                                                            <option value="Primary">Primary</option>
                                                                                            <option value="Secondary">Secondary</option>
                                                                                            <option value="Certificate">Certificate</option>
                                                                                            <option value="Diploma">Diploma</option>
                                                                                            <option value="Undergraduate degree">Undergraduate degree</option>
                                                                                            <option value="Postgraduate degree">Postgraduate degree</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Workplace/station site:</label>
                                                                                        <input value="<?= $client['workplace'] ?>" class="" type="text" name="workplace" id="workplace" required />

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Occupation</label>
                                                                                        <input value="<?= $client['occupation'] ?>" class="" type="text" name="occupation" id="occupation" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Phone Number:</label>
                                                                                        <input value="<?= $client['phone_number'] ?>" class="" type="text" name="phone_number" id="phone" required /> <span>Example: 0700 000 111</span>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Relative's Phone Number:</label>
                                                                                        <input value="<?= $client['other_phone'] ?>" class="" type="text" name="other_phone" id="other_phone" /> <span>Example: 0700 000 111</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Residence Street::</label>
                                                                                        <input value="<?= $client['street'] ?>" class="" type="text" name="street" id="street" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Ward</label>
                                                                                        <input value="<?= $client['ward'] ?>" class="" type="text" name="ward" id="ward" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>District:</label>
                                                                                        <input value="<?= $client['district'] ?>" class="" type="text" name="district" id="district" required />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>House Number:</label>
                                                                                        <input value="<?= $client['block_no'] ?>" class="" type="text" name="block_no" id="block_no" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Status::</label>
                                                                                        <select name="enrollment_status" style="width: 100%;" required>
                                                                                            <option value="<?= $client['enrollment_status'] ?>"><?= $client['enrollment_status'] ?></option>
                                                                                            <option value="1">Enrolled</option>
                                                                                            <option value="2">Not Enrolled</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Enrollment Date:</label>
                                                                                        <input value="<?= $client['enrollment_date'] ?>" class="validate[custom[date]]" type="text" name="enrollment_date" id="enrollment_date" /> <span>Example: 2010-12-01</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="row-form clearfix">
                                                                                    <!-- select -->
                                                                                    <div class="form-group">
                                                                                        <label>Comments:</label>
                                                                                        <textarea name="comments" rows="4"><?= $client['comments'] ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="dr"><span></span></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="client_image" value="<?= $client['client_image'] ?>" />
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <input type="submit" name="edit_client" value="Save updates" class="btn btn-warning">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Delete User</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <strong style="font-weight: bold;color: red">
                                                                    <p>Are you sure you want to delete this user</p>
                                                                </strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                                <input type="submit" name="delete_client" value="Delete" class="btn btn-danger">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="img<?= $client['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4>Client Image</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?= $img ?>" width="350">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php $x++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="info.php?id=3&sid=&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                            echo $_GET['page'] - 1;
                                                                        } else {
                                                                            echo 1;
                                                                        } ?>" class="btn btn-default">
                                        < </a>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <a href="info.php?id=3&sid=<?= $_GET['sid'] ?>&page=<?= $_GET['id'] ?>&page=<?= $i ?>" class="btn btn-default <?php if ($i == $_GET['page']) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>"><?= $i ?></a>
                                            <?php } ?>
                                            <a href="info.php?id=3&sid=<?= $_GET['sid'] ?>&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>" class="btn btn-default"> > </a>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($_GET['id'] == 8) { ?>

                    <?php } elseif ($_GET['id'] == 9) { ?>
                        <div class="col-md-6">
                            <div class="head clearfix">
                                <div class="isw-grid"></div>
                                <h1>Download Data</h1>
                                <ul class="buttons">
                                    <li><a href="#" class="isw-download"></a></li>
                                    <li><a href="#" class="isw-attachment"></a></li>
                                    <li>
                                        <a href="#" class="isw-settings"></a>
                                        <ul class="dd-list">
                                            <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                            <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                            <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="block-fluid">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="25%">Name</th>
                                            <th width="25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                        <td>1</td>
                                        <td>Clients Suprresed Viral Load</td>
                                        <td><form method="post"><input type="submit" name="suprresed_viral_load" value="Download"></form> </td>
                                    </tr> -->
                                        <tr>
                                            <td>1</td>
                                            <td>Clients</td>
                                            <td>
                                                <form method="post"><input type="submit" name="clients" value="Download"></form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Visit</td>
                                            <td>
                                                <form method="post"><input type="submit" name="visits" value="Download"></form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Laboratory</td>
                                            <td>
                                                <form method="post"><input type="submit" name="lab" value="Download"></form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Study IDs</td>
                                            <td>
                                                <form method="post"><input type="submit" name="study_id" value="Download"></form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Sites</td>
                                            <td>
                                                <form method="post"><input type="submit" name="sites" value="Download"></form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Screening</td>
                                            <td>
                                                <form method="post"><input type="submit" name="screening" value="Download"></form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php } elseif ($_GET['id'] == 10) { ?>
                        <div class="col-md-offset-1 col-md-8">
                            <div class="head clearfix">
                                <div class="isw-ok"></div>
                                <h1>Add Site Status</h1>
                            </div>
                            <div class="block-fluid">
                                <form id="validation" method="post">
                                    <!-- <div class="row-form clearfix">
                                        <div class="col-md-3">Name:</div>
                                        <div class="col-md-9">
                                            <input value="" class="validate[required]" type="text" name="name" id="name" />
                                        </div>
                                    </div> -->

                                    <div class="footer tar">
                                        <input type="submit" name="update_site" value="Update Site Status" class="btn btn-default">
                                    </div>
                                </form>
                            </div>
                        </div>

                    <?php } elseif ($_GET['id'] == 11) { ?>
                        <div class="col-md-offset-1 col-md-8">
                            <div class="head clearfix">
                                <div class="isw-ok"></div>
                                <h1>Fetch ALL List To Follow Up Site Status</h1>
                            </div>
                            <div class="block-fluid">
                                <form id="validation" method="post">
                                    <div class="row-form clearfix">
                                        <div class="col-md-3">Up to Date</div>
                                        <div class="col-md-9">
                                            <input value="" class="validate[required]" type="text" name="date" id="date" />
                                        </div>
                                    </div>

                                    <div class="footer tar">
                                        <input type="submit" name="fect_list_all" value="Fetch Site List" class="btn btn-default">
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } elseif ($_GET['id'] == 12) { ?>
                        <div class="head clearfix">
                            <?php if ($user->data()->power == 1 || $user->data()->power == 2 || $user->data()->accessLevel == 4) { ?>

                            <?php } ?>
                            <div class="isw-grid"></div>
                            <?php if (Input::get('site') == 1) { ?>
                                <h1>EAPOCVL FOLOW UP LIST FOR SINZA HOSPITAL</h1>
                            <?php } elseif (Input::get('site') == 2) { ?>
                                <h1>EAPOCVL FOLOW UP LIST FOR MNAZI MMOJA HOSPITAL</h1>
                            <?php } elseif (Input::get('site') == 3) { ?>
                                <h1>EAPOCVL FOLOW UP LIST FOR AMANA HOSPITAL</h1>
                            <?php } elseif (Input::get('site') == 4) { ?>
                                <h1>'EAPOCVL FOLOW UP LIST FOR MWANANYAMALA HOSPITAL</h1>
                            <?php } else { ?>
                                <h1>EAPOCVL FOLOW UP LIST FOR ALL NIMR SITES</h1>
                            <?php } ?>
                            <ul class="buttons">
                                <li><a href="followUp.php?start_date=<?= Input::get('start_date') ?>&end_date=<?= Input::get('end_date') ?>&site=<?= Input::get('site') ?>" class="isw-download"></a></li>
                                <li><a href="followUp2.php?start_date=<?= Input::get('start_date') ?>&end_date=<?= Input::get('end_date') ?>&site=<?= Input::get('site') ?>" class="isw-download"></a></li>
                                <li><a href="#" class="isw-attachment"></a></li>
                                <li>
                                    <a href="#" class="isw-settings"></a>
                                    <ul class="dd-list">
                                        <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                        <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                        <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Search by Site</h1>
                        </div>
                        <tr>
                            <td>
                                <form id="validation" method="post">

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="row-form clearfix">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Start Date:</label>
                                                    <input type="text" name="start_date" id="start_date" required /> <span>Example: 04/10/2012</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="row-form clearfix">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Start Date:</label>
                                                    <input type="text" name="end_date" id="end_date" required /> <span>Example: 04/10/2012</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="row-form clearfix">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Site</label>
                                                    <select name="site">
                                                        <option value="">Select Site</option>
                                                        <?php foreach ($override->get('site', 'status', 1) as $site) { ?>
                                                            <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="submit" name="followUp" value="Search" class="btn btn-info">
                                        </div>
                                    </div>

                                </form>
                            </td>
                        </tr>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <td width="2%">#</td>
                                        <th width="8%">Enrollment Date</th>
                                        <th width="8%">PATIENT ID</th>
                                        <th width="8%">CTC ID</th>
                                        <th width="8%">Name</th>
                                        <th width="8%">PHONE NUMBER</th>
                                        <th width="8%">EXPECTED DATE</th>
                                        <th width="8%">VISIT DATE</th>
                                        <th width="8%">STATUS</th>
                                        <th width="8%">VISIT NAME</th>
                                        <th width="8%">SITE NAME</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $x = 1;
                                    // print_r($_POST);
                                    if (Input::get('site')) {
                                        $data = $override->FollowUpList7(Input::get('start_date'), Input::get('end_date'), Input::get('site'));
                                    } else {
                                        $data = $override->FollowUpList6(Input::get('start_date'), Input::get('end_date'));
                                    }

                                    foreach ($data as $value) {

                                        if ($value['SITE_NAME'] == 1) {
                                            $SITE_NAME = 'SINZA HOSPITAL';
                                        } elseif ($value['SITE_NAME'] == 2) {
                                            $SITE_NAME = 'MNAZI MMOJA HOSPITAL';
                                        } elseif ($value['SITE_NAME'] == 3) {
                                            $SITE_NAME = 'AMANA HOSPITAL';
                                        } elseif ($value['SITE_NAME'] == 4) {
                                            $SITE_NAME = 'MWANANYAMALA HOSPITAL';
                                        } else {
                                            $SITE_NAME = 'ALL NIMR SITES';
                                        }


                                        if ($value['VISIT_STATUS'] == 1) {
                                            $VISIT_STATUS = 'DONE';
                                        } elseif ($value['VISIT_STATUS'] == 2) {
                                            $VISIT_STATUS = 'MISSED';
                                        } else {
                                            $VISIT_STATUS = 'NOT DONE';
                                        }

                                    ?>
                                        <tr>
                                            <td><?= $x ?></td>
                                            <td><?= $value['ENROLLMENT_DATE'] ?></td>
                                            <td><?= $value['PATIENT_ID'] ?></td>
                                            <td><?= $value['CTC_ID'] ?></td>
                                            <td> <?= $value['FIRST_NAME'] . ' ' . $client['LAST_NAME'] ?></td>
                                            <td><?= $value['PHONE_NUMBER'] ?></td>
                                            <td><?= $value['EXPECTED_DATE'] ?></td>
                                            <td><?= $value['VISIT_DATE'] ?></td>
                                            <td><?= $VISIT_STATUS ?></td>
                                            <td><?= $value['VISIT_NAME'] ?></td>
                                            <td><?= $SITE_NAME ?></td>
                                        </tr>
                                    <?php
                                        $x++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    <?php } elseif ($_GET['id'] == 13) { ?>
                        <div class="head clearfix">
                            <?php if ($user->data()->power == 1 || $user->data()->power == 2 || $user->data()->accessLevel == 4) { ?>

                            <?php } ?>
                            <div class="isw-grid"></div>
                            <?php if (Input::get('site') == 1) { ?>
                                <h1>EAPOCVL FOLOW UP SCHEDULE FOR SINZA HOSPITAL</h1>
                            <?php } elseif (Input::get('site') == 2) { ?>
                                <h1>EAPOCVL FOLOW UP SCHEDULE FOR MNAZI MMOJA HOSPITAL</h1>
                            <?php } elseif (Input::get('site') == 3) { ?>
                                <h1>EAPOCVL FOLOW UP SCHEDULE FOR AMANA HOSPITAL</h1>
                            <?php } elseif (Input::get('site') == 4) { ?>
                                <h1>'EAPOCVL FOLOW UP SCHEDULE FOR MWANANYAMALA HOSPITAL</h1>
                            <?php } else { ?>
                                <h1>EAPOCVL FOLOW UP SCHEDULE FOR ALL NIMR SITES</h1>
                            <?php } ?>
                            <ul class="buttons">
                                <?php if ($user->data()->power == 1) { ?>
                                    <li><a href="schedule.php?site=<?= Input::get('site') ?>" class="isw-download"></a></li>

                                <?php } ?>

                                <li><a href="schedule2.php?site=<?= Input::get('site') ?>" class="isw-download"></a></li>
                                <li><a href="schedule3.php?site=<?= Input::get('site') ?>" class="isw-download"></a></li>

                                <li><a href="#" class="isw-attachment"></a></li>
                                <li>
                                    <a href="#" class="isw-settings"></a>
                                    <ul class="dd-list">
                                        <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                        <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                        <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Search by Site</h1>
                        </div>
                        <tr>
                            <td>
                                <form id="validation" method="post">

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="row-form clearfix">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Site</label>
                                                    <select name="site">
                                                        <option value="">Select Site</option>
                                                        <?php foreach ($override->get('site', 'status', 1) as $site) { ?>
                                                            <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="submit" name="schedule" value="Search" class="btn btn-info">
                                        </div>
                                    </div>

                                </form>
                            </td>
                        </tr>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <td width="2%">#</td>
                                        <th width="8%">Enrollment Date v1</th>
                                        <th width="8%">PATIENT ID</th>
                                        <th width="8%">CTC ID</th>
                                        <th width="8%">Name</th>
                                        <th width="8%">Birth</th>
                                        <th width="8%">Age</th>
                                        <th width="8%">PHONE NUMBER</th>
                                        <th width="8%">EXPECTED DATE v2 ( Months 6)</th>
                                        <th width="8%">VISIT DATE v2 ( Month 6)</th>
                                        <th width="8%">EXPECTED DATE v3 ( Month 12)</th>
                                        <th width="8%">VISIT DATE v3 ( Month 12)</th>
                                        <th width="8%">SITE NAME</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $x = 1;
                                    // print_r($_POST);
                                    if (Input::get('site')) {
                                        $data = $override->getNews('clients', 'status', 1, 'site_id', Input::get('site'));
                                    } else {
                                        $data = $override->get('clients', 'status', 1);
                                    }

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



                                    ?>
                                        <tr>
                                            <td><?= $x ?></td>
                                            <td><?= $value['clinic_date'] ?></td>
                                            <td><?= $value['enrollment_id'] ?></td>
                                            <td><?= $value['ctc_number'] ?></td>
                                            <td> <?= $value['firstname'] . ' ' . $value['middlename'] . ' ' . $value['lastname'] ?></td>
                                            <td><?= $value['dob'] ?></td>
                                            <td><?= $value['age'] ?></td>
                                            <td><?= $value['phone_number'] ?></td>
                                            <td><?= $expected_date2 ?></td>
                                            <td><?= $visit_date2 ?></td>
                                            <td><?= $expected_date3 ?></td>
                                            <td><?= $visit_date3 ?></td>
                                            <td><?= $SITE_NAME ?></td>
                                        </tr>
                                    <?php
                                        $x++;
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                    <?php }
                    ?>
                </div>

                <div class="dr"><span></span></div>
            </div>
        </div>
    </div>
</body>
<script>
    <?php if ($user->data()->pswd == 0) { ?>
        $(window).on('load', function() {
            $("#change_password_n").modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        });
    <?php } ?>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>