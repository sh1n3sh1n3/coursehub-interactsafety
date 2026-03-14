<?php include('session.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Students Register</title>
    <?php include('includes/head.php'); ?>
    <style>
        .users-table th,
        .users-table td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php include('includes/header.php'); ?>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Registered Students</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Registered Students</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title" style="padding:0">
                                <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;">Registered Students</h5>
                            </div>
                            <div class="ibox-content">
                                <form method="post" enctype="multipart/form-data" id="form">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-3 row">
                                                    <label class="col-sm-2 col-form-label">Status</label>
                                                    <div class="col-sm-10"><select class="form-control" name="status">
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">Inactive</option>
                                                            <option value="all">All</option>
                                                        </select></div>
                                                </div>
                                                <div class="col-lg-3 row">
                                                    <label class="col-sm-2 col-form-label">Order</label>
                                                    <div class="col-sm-10"><select class="form-control" name="sort_order">
                                                            <option value="latest" selected>Latest</option>
                                                            <option value="oldest">Oldest</option>
                                                        </select></div>
                                                </div>
                                                <div class="col-sm-2 col-sm-offset-2">
                                                    <button class="btn btn-primary btn-sm" type="submit" id="submit">Filter</button>
                                                    <button class="btn btn-info btn-sm" type="button" id="overall">Overall</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example users-table">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th>E-mail</th>
                                                <th>Position</th>
                                                <th>Company</th>
                                                <th>Latest Course Enrolled</th>
                                                <th>Certificate Issued</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablebody">
                                            <?php $count = 0;
                                            $contact = $conn->query("SELECT * FROM registration WHERE status='1' order by id desc");
                                            while ($fetch = $contact->fetch_assoc()) {
                                                $count++;
                                                $id = $fetch['id'];
                                                $sale = $conn->query("SELECT * FROM sale WHERE user=" . $id)->num_rows;
                                                $order = $conn->query("SELECT * FROM sale WHERE user='" . $id . "' ORDER BY id DESC")->fetch_assoc();
                                                $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='" . $order['courseid'] . "'")->fetch_assoc();
                                                if ($order['generateCertificate'] == '1') {
                                                    $gencert = 'Yes';
                                                } else {
                                                    $gencert = 'No';
                                                }
                                                $msg = "'Are you sure?'";
                                                $deleteMsg = "'Are you sure you want to delete this student?'";
                                            ?>
                                                <tr>
                                                    <td><?php echo $count; ?>. </td>
                                                    <td><?php echo strtoupper($fetch['generated_code']); ?></td>
                                                    <td><?php echo $fetch['title'] . ' ' . $fetch['fname'] . ' ' . $fetch['lname']; ?></td>
                                                    <td><?php echo $fetch['email']; ?></td>
                                                    <td><?php echo $fetch['position']; ?></td>
                                                    <td><?php echo $fetch['company']; ?></td>
                                                    <td><?php echo $sqlcourses['title']; ?></td>
                                                    <td><?php echo $gencert; ?></td>
                                                    <td><?php if ($fetch['status'] == '1') {
                                                            echo '<span class="label label-primary" style="padding: 5px 10px;">Active</span>';
                                                        } else {
                                                            echo '<span class="label label-default" style="padding: 5px 10px;">Not Active</span>';
                                                        } ?></td>
                                                    <td>
                                                        <a title="Click to view user details" href="user-details.php?id=<?php echo $fetch['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                                                        <?php if ($fetch['status'] == '1') {
                                                            echo '<a onclick="return confirm(' . $msg . ');" href="deleteUser.php?id=' . $id . '" class="btn btn-white btn-sm"><i class="fa fa-cross"></i> Deactivate </a>';
                                                        } else {
                                                            echo '<a onclick="return confirm(' . $msg . ');" href="deleteUser.php?id=' . $id . '" class="btn btn-white btn-sm"><i class="fa fa-check"></i> Activate </a>';
                                                        } ?>
                                                        <a onclick="return confirm(<?php echo $deleteMsg; ?>);" href="deleteUserPermanent.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <?php include('includes/foot.php'); ?>
    <script>
        $(document).ready(function() {
            $("#overall").click(function() {
                $.ajax({
                    type: 'POST',
                    url: "getusers.php",
                    data: {},
                    success: function(resultData) {
                        $("#tablebody").html('').html(resultData);
                    }
                });
            });
            $("#form").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);

                $.ajax({
                    type: "POST",
                    url: 'filterusers.php',
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data) {
                        $("#tablebody").html('').html(data);
                    }
                });

            });
        });
    </script>
</body>

</html>