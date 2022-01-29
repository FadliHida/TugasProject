<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/DataTables/datatables.min.css')?>"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/DataTables/dataTables.foundation.css')?>"/>

    <link href="<?php echo base_url('assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('assets/css/sb-admin-2.min.css')?>" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

		<?php $this->load->view('_partials/sidebar.php')?>
        

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                
                <?php $this->load->view('_partials/navbar.php')?>
                
                <!-- Begin Page Content -->
                <div class="container-fluid">

                <!-- Page Heading -->
				<h4 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Project </h4>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <?php if($this->session->flashdata('msg_berhasil')){ ?>
                            <div class="alert alert-success alert-dismissible" style="width:100%">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
							</div>
						<?php } ?>

                        <?php if($this->session->flashdata('msg_berhasil_gambar')){ ?>
                            <div class="alert alert-success alert-dismissible" style="width:100%">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil_gambar');?>
							</div>
						<?php } ?>

                        <a href="<?=site_url('project/form_insert_project')?>" style="margin-bottom:10px;" type="button"
								class="btn btn-primary" name="tambah_data"><i class="fa fa-plus-circle"
									aria-hidden="true"></i> Tambah Data </a>
                    
                    <!-- Begin Table -->
                    <div class="">
								<table class="display" id="dataTable">
									<thead>
										<tr>
											<th>Project ID</th>
											<th>Nama Project</th>
											<th>Asset</th>
											<th>Lokasi</th>
											<th>Status</th>
											<th>Update</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<tr>
                                            <?php if(is_array($list_project)){?>
                                            <?php foreach($list_project as $item): ?>
                                            <td><?=$item->id_project?></td>
                                            <td><?=$item->nama_project?></td>
                                            <td><?=$item->asset?></td>
                                            <td><?=$item->lokasi?></td>
                                            <td><?=$item->status?></td>
                                            <td><a type="button" class="btn btn-info"
													href="<?=site_url('project/projectViewUpdate/'.$item->id_project)?>"
													name="btn_update" style="margin:auto;"><i class="fas fa-pen"
														aria-hidden="true"></i></a></td>
											<td><a class="btn btn-danger btn-delete" data-toggle="modal" data-target="#deleteModal<?=$item->id_project;?>"><i class="fa fa-trash"
														aria-hidden="true"></i></a></td>
                                        </tr>
                                        <?php endforeach;?>
										<?php }else { ?>
										<td colspan="7" align="center"><strong>Data Kosong</strong></td>
										<?php } ?>
									</tbody>
								</table>
							</div>
                    <!-- End Table -->
                    </div>
                </div>
                

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal-->
	<?php
	foreach($list_project as $dd):
	?>
	<div class="modal fade" id="deleteModal<?=$dd->id_project;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<form action="<?=site_url('project/DeleteData/'.$dd->id_project)?>">
				<div class="modal-body">
					<h3>Are you sure to delete? <h3>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<button class="btn btn-danger">Delete</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<!-- Delete Modal-->

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assets/js/sb-admin-2.min.js')?>"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url('assets/vendor/chart.js/Chart.min.js')?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo base_url('assets/js/demo/chart-area-demo.js')?>"></script>
    <script src="<?php echo base_url('assets/js/demo/chart-pie-demo.js')?>"></script>

    <script type="text/javascript" src="<?= base_url('assets/DataTables/datatables.min.js')?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/DataTables/dataTables.foundation.js')?>"></script>
    <script type="text/javascript">
        $(document).ready( function () {
        $('#dataTable').DataTable();
        } );
    </script>

</body>

</html>