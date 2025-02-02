<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->data()->accessLevel == 1) {
} else {
}

$sinza = $override->getCount1('clients', 'status', 1, 'site_id', 1);
$mnazi = $override->getCount1('clients', 'status', 1, 'site_id', 2);
$amana = $override->getCount1('clients', 'status', 1, 'site_id', 3);
$mwanany = $override->getCount1('clients', 'status', 1, 'site_id', 4);


?>
<div class="menu">

    <div class="breadLine">
        <div class="arrow"></div>
        <div class="adminControl active">
            Hi, <?= $user->data()->firstname . ' - ' . $user->data()->lastname ?>
        </div>
    </div>

    <div class="admin">
        <div class="image">
            <img src="img/users/blank.png" class="img-thumbnail" />
        </div>
        <ul class="control">
            <li><span class="glyphicon glyphicon-comment"></span> <a href="#">Messages</a></li>
            <li><span class="glyphicon glyphicon-cog"></span> <a href="profile.php">Profile</a></li>
            <li><span class="glyphicon glyphicon-share-alt"></span> <a href="logout.php">Logout</a></li>
        </ul>
        <div class="info">
            <span>Welcome back! Your last visit: <?= $user->data()->last_login ?></span>
        </div>
    </div>

    <ul class="navigation">
        <li class="active">
            <a href="dashboard.php">
                <span class="isw-grid"></span><span class="text">Dashboard</span>
            </a>
        </li>
        
        <?php if ($user->data()->accessLevel == 1) { ?>
            <li class="openable">
                <a href="#"><span class="isw-user"></span><span class="text">Staff</span></a>
                <ul>
                    <li>
                        <a href="add.php?id=1">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Add staff</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php?id=1">
                            <span class="glyphicon glyphicon-registration-mark"></span><span class="text">Manage staff</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable">
                <a href="#"><span class="isw-tag"></span><span class="text">Extra</span></a>
                <ul>
                    <li>
                        <a href="add.php?id=2">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Add Position</span>
                        </a>
                    </li>
                    <li>
                        <a href="add.php?id=8">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Add Access Level</span>
                        </a>
                    </li>
                    <li>
                        <a href="add.php?id=9">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Add Power</span>
                        </a>
                    </li>
                    <li>
                        <a href="add.php?id=10">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Add Site Status</span>
                        </a>
                    </li>
                    <li>
                        <a href="add.php?id=5">
                            <span class="glyphicon glyphicon-floppy-disk"></span><span class="text">Study</span>
                        </a>
                    </li>
                    <li>
                        <a href="add.php?id=6">
                            <span class="glyphicon glyphicon-floppy-disk"></span><span class="text">Site</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php?id=5">
                            <span class="glyphicon glyphicon-list"></span><span class="text">Study IDs</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php?id=2">
                            <span class="glyphicon glyphicon-share"></span><span class="text">Manage</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="openable">
                <a href="#"><span class="isw-tag"></span><span class="text">View Reports</span></a>
                <ul>
                    <li class="active">
                        <a href="report.php">
                            <span class="text">Report 0 ( SUMMARY ) </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="report1.php">
                            <span class="text">Report 1 ( SUMMARY ) </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="report2.php">
                            <span class="text">Report 2 ( ENROLLMENT LOGS )</span>
                        </a>
                    </li>

                </ul>
            </li>

        <?php } ?>

        <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2 || $user->data()->accessLevel == 3) { ?>

            <li class="openable">
                <a href="#"><span class="isw-users"></span><span class="text">Clients</span></a>
                <ul>

                    <li>
                        <a href="add.php?id=4">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Add Client</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php?id=3">
                            <span class="glyphicon glyphicon-registration-mark"></span><span class="text">Clients</span>
                        </a>
                    </li>

                </ul>
            </li>
        <?php } ?>

        <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 4) { ?>

            <li class="openable">
                <a href="#"><span class="isw-users"></span><span class="text">Clients Registered</span></a>
                <ul>
                    <?php if ($user->data()->site_id == 1) { ?>

                        <li>
                            <a href="info.php?id=3&sid=1">
                                <span class="glyphicon glyphicon-registration-mark"></span><span class="text">Sinza Clients</span>
                                <span class="badge badge-secondary badge-pill"><?= $sinza ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($user->data()->site_id == 2) { ?>
                        <li>
                            <a href="info.php?id=3&sid=2">
                                <span class="glyphicon glyphicon-registration-mark"></span><span class="text">Mnazi mmoja Clients</span>
                                <span class="badge badge-secondary badge-pill"><?= $mnazi ?></span>

                            </a>
                        </li>

                    <?php } ?>
                    <?php if ($user->data()->site_id == 3) { ?>

                        <li>
                            <a href="info.php?id=3&sid=3">
                                <span class="glyphicon glyphicon-registration-mark"></span><span class="text">Amana Clients</span>
                                <span class="badge badge-secondary badge-pill"><?= $amana ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($user->data()->site_id == 4) { ?>
                        <li>
                            <a href="info.php?id=3&sid=4">
                                <span class="glyphicon glyphicon-registration-mark"></span><span class="text">Mwananyamala Clients</span>
                                <span class="badge badge-secondary badge-pill"><?= $mwanany ?></span>

                            </a>
                        </li>
                    <?php } ?>


                </ul>
            </li>
        <?php } ?>

        <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
            <li class="openable">
                <a href="#"><span class="isw-users"></span><span class="text">Summary Report</span></a>
                <ul>
                    <li>
                        <a href="info.php?id=6">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Suppressed Viral Load Clients</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php?id=7">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Failed Viral Load Test Clients</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php?id=8">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Dropped Clients</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="info.php?id=9" target="_blank">
                            <span class="isw-download"></span><span class="text">Download Data</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="openable">
                <a href="#"><span class="isw-users"></span><span class="text">Foll Up List</span></a>
                <ul>
                    <li>
                        <a href="info.php?id=12">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Fetch List</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php?id=13">
                            <span class="glyphicon glyphicon-user"></span><span class="text">Fetch Schedule</span>
                        </a>
                    </li>

                </ul>
            </li>
        <?php } ?>
    </ul>

    <div class="dr"><span></span></div>

    <div class="widget-fluid">
        <div id="menuDatepicker"></div>
    </div>

    <div class="dr"><span></span></div>

    <div class="widget">

        <div class="input-group">
            <input id="appendedInputButton" class="form-control" type="text">
            <div class="input-group-btn">
                <button class="btn btn-default" type="button">Search</button>
            </div>
        </div>

    </div>

    <div class="dr"><span></span></div>

    <div class="widget-fluid">

        <div class="wBlock clearfix">
            <div class="dSpace">
                <h3>Studies</h3>
                <span class="number"></span>
                <span><b>Ongoing</b></span>
                <span><b>Ended</b></span>
            </div>
        </div>

    </div>

    <div class="modal fade" id="fModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4>Search Report</h4>
                </div>
                <form method="post">
                    <div class="modal-body modal-body-np">
                        <div class="row">
                            <div class="block-fluid">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Start Date:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required,custom[date]]" type="text" name="start" id="date" />
                                        <span>Example: 2010-12-01</span>
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">End Date:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required,custom[date]]" type="text" name="start" id="date" />
                                        <span>Example: 2010-12-01</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-info" value="Search" aria-hidden="true">
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>