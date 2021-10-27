<ul class="navbar-nav bg-gradient-custom sidebar sidebar-dark accordion" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php  echo site_url("Dashboard/index") ?>">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-fire-alt"></i>
		</div>
		<div class="sidebar-brand-text mx-3">ASEI</div>
	</a>
	<hr class="sidebar-divider my-0">
	<li class="nav-item ">
		<a class="nav-link" href="<?php  echo site_url("Dashboard/index") ?>">
			<i class="fas fa-fw fa-home "></i>
			<span>Inicio</span></a>
	</li>
	<?php
	if (!empty($padres)){
			foreach ($padres as $p){
		?>
		<hr class="sidebar-divider">
		<div class="sidebar-heading">
		</div>
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Seccion<?php echo $p->idOpcion?>" aria-expanded="true" aria-controls="collapseUtilities">
				<i class="fas fa-fire"></i>
				<span><?php echo $p->descripcion?></span>
			</a>
			<div id="Seccion<?php echo $p->idOpcion?>" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header">Seleccione:</h6>
			<?php
				if (!empty($hijos)){
					foreach ($hijos as $h){
						if($h->idPadre == $p->idOpcion){
			?>
						<a class="collapse-item" href="<?php echo site_url("$h->url") ?>"><?php echo $h->descripcion?></a>
			<?php
						}
					}
				}
			?>
				</div>
			</div>
		</li>

	<?php
			}
		}
	?>
