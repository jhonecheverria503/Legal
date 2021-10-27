<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	If(!empty($_SESSION['usuario'])){
?>
<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="description" content="">
			<meta name="author" content="">
			<title>RAV</title>
			<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
			<link href="<?php echo base_url( "resources/vendor/fontawesome-free/css/all.min.css");?>" rel="stylesheet" type="text/css">
			<link href="<?php echo base_url("resources/vendor/datatables/dataTables.bootstrap4.css");?> "rel="stylesheet">
			<link href="<?php echo base_url("resources/sweetalert-master/dist/sweetalert.css");?> "rel="stylesheet">
			<link href="<?php echo base_url("resources/stacktable/stacktable.css");?> "rel="stylesheet">
			<link href="<?php echo base_url("resources/css/sb-admin-2.css");?>" rel="stylesheet">
			<link href="<?php echo base_url("resources/Animaciones/animate/animate.min.css");?> "rel="stylesheet">
			<link href="<?php echo base_url("resources/Animaciones/animate/animate.css");?> "rel="stylesheet">

		</head>
		<body id="page-top">
			<div id="wrapper">
<?php
	}
	else{
?>
		<script type="text/javascript">
			window.setTimeout(function(){
				location = ('<?php echo site_url("Login")?>');
			} ,20);
		</script>
<?php
	}
?>

