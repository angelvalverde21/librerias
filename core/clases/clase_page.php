<?php 

class page{

		function __construct(){

		}

		function menu(){
			?>
				
					<li><a href="<?php echo get_option('admin'); ?>/account.php"><span class="glyphicon glyphicon-user fa-fw"></span>Mi cuenta</a></li>
					<li><a href="<?php echo get_option('admin'); ?>/"><span class="glyphicon glyphicon-print fa-fw"></span>Dashboard</a></li>
					<!--<li><a href="#"><span class="glyphicon glyphicon-thumbs-up fa-fw"></span>Ofertas</a></li>-->
					<!--<li><a href="#" href="#"><span class="glyphicon glyphicon-calendar fa-fw"></span>Agenda</a></li>-->
					<li><a href="<?php echo get_option('admin'); ?>/usuarios.php"><span class="glyphicon glyphicon-user fa-fw"></span>Usuarios</a></li>
					<li><a href="<?php echo get_option('admin'); ?>/ventas.php"><span class='glyphicon glyphicon-copy fa-fw'></span>Ventas</a></li>
					<li><a href="<?php echo get_option('admin'); ?>/productos.php"><span class="glyphicon glyphicon-barcode fa-fw"></span>Productos</a></li>
					<li><a href="<?php echo get_option('admin'); ?>/stock.php"><span class="glyphicon glyphicon-th-list fa-fw"></span>Stock</a></li>
					<li><a href="<?php echo get_option('admin'); ?>/direcciones_envio.php"><span class="glyphicon glyphicon-folder-open fa-fw"></span> Direcciones Envio</a></li>					
					<li><a href="#"><span class="glyphicon glyphicon-cog fa-fw"></span>Config.</a></li>
					<!--<li><a href="#"><span class="glyphicon glyphicon-euro fa-fw"></span>Caja</a></li>-->
					<li><a href="<?php echo get_option('admin'); ?>/categorias.php"><span class="glyphicon glyphicon-tasks fa-fw"></span>Categorias</a></li>
					<!--<li><a href="#"><span class="glyphicon glyphicon-bullhorn fa-fw"></span>Campa&ntilde;a</a></li>-->
					<!--<li><a href="#"><span class="glyphicon glyphicon-scale fa-fw"></span>Proveedores</a></li>-->
					<!--<li><a href="#"><span class="glyphicon glyphicon-starglyphicon glyphicon-cog fa-fw"></span>Gastos del dia</a></li>-->
					<li><a href="<?php echo get_option('home'); ?>/logout"><span class="glyphicon glyphicon-starglyphicon glyphicon-cog fa-fw"></span>Salir</a></li>
			
			<?php
		}

		function header_admin(){

		?>
				<nav class="navbar navbar-default" role="navigation">
				  <!-- El logotipo y el icono que despliega el menú se agrupan
				       para mostrarlos mejor en los dispositivos móviles -->
				  <div class="navbar-header">

				   	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-1">
				   		<span class="icon-bar"></span>
				   		<span class="icon-bar"></span>
				   		<span class="icon-bar"></span>
				   	</button>

				   	<a class="navbar-brand" href="<?php echo get_option('admin'); ?>">Aquarella</a>

				  </div>
				 
				</nav>
			
		<?php

		}


		function header_web(){

		?>
				<nav class="navbar navbar-default" role="navigation">
				  <!-- El logotipo y el icono que despliega el menú se agrupan
				       para mostrarlos mejor en los dispositivos móviles -->
				  <div class="navbar-header">

				   	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-1">
				   		<span class="icon-bar"></span>
				   		<span class="icon-bar"></span>
				   		<span class="icon-bar"></span>
				   	</button>

				   	<a class="navbar-brand" href="<?php echo get_option('home'); ?>">Aquarella</a>
				   	<div class="pago-tarjetas"><img src="<?php echo theme()."/images/visa.png"; ?>"></div>

				  </div>
				 
				</nav>
			
		<?php

		}

		function bootstrap($online=""){
			
			if($online=="online"){
				?>
					<!-- Latest compiled and minified CSS -->
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
					
					<!-- Optional theme -->
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
					
					<script src="https://code.jquery.com/jquery-latest.js"></script>

					<!-- Latest compiled and minified JavaScript -->
					<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

			<?php }else{ ?>

				<link rel="stylesheet" href="<?php echo URL_PLUGIN ?>/bootstrap/css/bootstrap.min.css">

				<!-- Optional theme -->

				<link rel="stylesheet" href="<?php echo URL_PLUGIN ?>/bootstrap/css/bootstrap-theme.min.css">

				<script src="<?php echo URL_PLUGIN ?>/jquery/jquery-latest.js"></script>

				<!-- Latest compiled and minified JavaScript -->

				<script src="<?php echo URL_PLUGIN ?>/bootstrap/js/bootstrap.min.js"></script>
				<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

			<?php } ?>

				<?php if($_GET['reset']){ ?>

				<link rel="stylesheet" type="text/css" href="<?php echo get_option('admin'); ?>/fonts/style.css?<?php echo time(); ?>">
				<link rel="stylesheet" type="text/css" href="<?php echo get_option('admin'); ?>/style_boot.css?<?php echo time(); ?>">
				<!--<link rel="stylesheet" type="text/css" href="<?php echo get_option('admin'); ?>/style_comun.css?<?php echo time(); ?>">-->

				<?php	}else{ ?>

					<link rel="stylesheet" type="text/css" href="<?php echo get_option('admin'); ?>/fonts/style.css?<?php echo time(); ?>">
					<link rel="stylesheet" type="text/css" href="<?php echo get_option('admin'); ?>/style_boot.css?<?php echo time(); ?>">
					<link rel="stylesheet" type="text/css" href="<?php echo get_option('admin'); ?>/style_admin_360.css?<?php echo time(); ?>">
					<!--<link rel="stylesheet" type="text/css" href="<?php echo get_option('admin'); ?>/style_comun.css?<?php echo time(); ?>">-->

				<?php	} ?>

			<?php

		}


		function bootstrap_web($online=""){
			if($online=="online"){
				?>
					<!-- Latest compiled and minified CSS -->
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
					
					<!-- Optional theme -->
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
					
					<script src="https://code.jquery.com/jquery-latest.js"></script>

					<!-- Latest compiled and minified JavaScript -->
					<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

			<?php }else{ ?>

				<link rel="stylesheet" href="<?php echo URL_PLUGIN ?>/bootstrap/css/bootstrap.min.css">

				<!-- Optional theme -->

				<link rel="stylesheet" href="<?php echo URL_PLUGIN ?>/bootstrap/css/bootstrap-theme.min.css">

				<script src="<?php echo URL_PLUGIN ?>/jquery/jquery-latest.js"></script>

				<!-- Latest compiled and minified JavaScript -->

				<script src="<?php echo URL_PLUGIN ?>/bootstrap/js/bootstrap.min.js"></script>
				<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

			<?php } ?>

				<link rel="stylesheet" type="text/css" href="<?php echo theme(); ?>/fonts/style.css?<?php echo time(); ?>">

				<link rel="stylesheet" type="text/css" href="<?php echo theme(); ?>/style_boot.css?<?php echo time(); ?>">
				<link rel="stylesheet" type="text/css" href="<?php echo theme(); ?>/style_360.css?<?php echo time(); ?>">
				<link rel="stylesheet" type="text/css" href="<?php echo theme(); ?>/style_480.css?<?php echo time(); ?>">
				<link rel="stylesheet" type="text/css" href="<?php echo theme(); ?>/style_600.css?<?php echo time(); ?>">
				<link rel="stylesheet" type="text/css" href="<?php echo theme(); ?>/style_800.css?<?php echo time(); ?>">
				<!--<link rel="stylesheet" type="text/css" href="<?php echo theme(); ?>/style_comun.css?<?php echo time(); ?>">-->

			<?php			
		}
	

		function table_header($config){
			?>
		<div class="table-responsive">
			<table class="table <?php echo $config['CLASS']; ?> text-center table-striped table-bordered table-hover" id="<?php echo $config['ID']; ?>">
				<tbody>
			<?php
		}
		function table_footer(){
			?>
				</tbody>
			</table>
		</div>
			<?php
		}

		function open_panel(){
			?>
				<div class="panel panel-default">
					<div class="panel-body">		
			<?php
		}

		function exit_panel(){
			?>
					</div>
				</div>			
			<?php
			
		}

		function modal($config){

			?>
			<!-- Taken from Bootstrap's documentation -->
			<div class="modal fade <?php echo $config['CLASS']; ?>" id="<?php echo $config['ID']; ?>">

			  <div class="modal-dialog <?php echo $config['CLASS_GALERY']; ?>">

			    <div class="modal-content">

			      <!-- modal header -->
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title"><?php echo $config['TITLE']; ?></h4>
			      </div>

  				  <!-- modal body -->

			      <div class="modal-body">
			        <p class="text-center">Estamos cargado el contenido...! &hellip;</p>
			        <p class="text-center"><img src="<?php echo theme(); ?>/images/loading.gif"></p>
			      </div>

			      <!-- modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			        <?php if($config['HIDDEN-GUARDAR']=="true"){ ?>
			        
			        <?php }else{ ?>
						<a type="button" class="btn btn-primary guardar-cambios-modal">Guardar Cambios</a>
			        <?php	} ?>
			      
			      </div>

			    </div>
			    <!-- /.modal-content -->
			  </div>
			  <!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<?php
		}

		function upload_css($IDPRODUCTO=""){

			if($IDPRODUCTO<>""){
				$_GET['IDPRODUCTO']= $IDPRODUCTO;
			}


			?>
			<link href="<?php echo URL_PLUGIN; ?>/upload_css/assets/css/style.css?<?php echo time(); ?>" rel="stylesheet" />
					
				<div class="div_redondeado subir_modelos">

					<form id="upload" method="post" action="<?php echo URL_PLUGIN; ?>/upload_css/upload.php?uploadtype=productos&IDPRODUCTO=<?php echo $_GET['IDPRODUCTO']; ?>&TIPO=color" enctype="multipart/form-data">

						<div id="drop">
							<p class="text-center">Agregar colores / modelos</p>
							<a class="glyphicon glyphicon-camera"></a>
							<input type="file" class="" name="Filedata" accept="image/x-png, image/gif, image/jpeg" multiple />
						</div>
			
						<ul>
							<!-- The file uploads will be shown here -->
						</ul>
					</form>
				</div>

						<!-- JavaScript Includes -->
				<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/jquery.knob.js"></script>

				<!-- jQuery File Upload Dependencies -->
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/jquery.ui.widget.js"></script>
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/jquery.iframe-transport.js"></script>
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/jquery.fileupload.js"></script>
				
				<!-- Our main JS file -->
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/script.js"></script>
				

			<?php
		}


		function upload_css_fotos_producto($IDPRODUCTO="",$label="",$type=""){

			if($IDPRODUCTO<>""){
				$_GET['IDPRODUCTO']= $IDPRODUCTO;
			}


			?>
			<link href="<?php echo URL_PLUGIN; ?>/upload_css/assets/css/style.css?<?php echo time(); ?>" rel="stylesheet" />
					
				<div class="div_redondeado subir_modelos">

					<form class="upload" method="post" action="<?php echo URL_PLUGIN; ?>/upload_css/upload.php?uploadtype=productos&IDPRODUCTO=<?php echo $_GET['IDPRODUCTO']; ?>&TIPO=<?php echo $type; ?>" enctype="multipart/form-data">
					
						<div class="drop">
							<p class="text-center"><?php echo $label; ?></p>
							<a class="glyphicon glyphicon-camera"></a>
							<input type="file" class="" name="Filedata" accept="image/x-png, image/gif, image/jpeg" multiple />
						</div>
			
						<ul>
							<!-- The file uploads will be shown here -->
						</ul>
					</form>
				</div>

						<!-- JavaScript Includes -->
				<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
				
				<!-- Our main JS file -->
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/script_fotos_producto.js"></script>

				<style>
					.drop a {
					    background-color: #007a96;
					    padding: 12px 26px;
					    color: #fff;
					    font-size: 18px;
					    border-radius: 2px;
					    cursor: pointer;
					    display: inline-block;
					    margin-top: 12px;
					    line-height: 1;
					}

					.drop input {
					    display: none;
					}


					.upload ul li {
					    background-color: #333639;
					    background-image: -webkit-linear-gradient(top, #333639, #303335);
					    background-image: -moz-linear-gradient(top, #333639, #303335);
					    background-image: linear-gradient(top, #333639, #303335);
					    border-top: 1px solid #3d4043;
					    border-bottom: 1px solid #2b2e31;
					    padding: 5px;
					    height: 72px;
					    position: relative;
					}
				</style>

			<?php
		}

		function upload_css_medidas_producto($IDPRODUCTO="",$label="",$type=""){

			if($IDPRODUCTO<>""){
				$_GET['IDPRODUCTO']= $IDPRODUCTO;
			}


			?>
			<link href="<?php echo URL_PLUGIN; ?>/upload_css/assets/css/style.css?<?php echo time(); ?>" rel="stylesheet" />
					
				<div class="div_redondeado subir_modelos">

					<form class="upload2" method="post" action="<?php echo URL_PLUGIN; ?>/upload_css/upload.php?uploadtype=productos&IDPRODUCTO=<?php echo $_GET['IDPRODUCTO']; ?>&TIPO=<?php echo $type; ?>" enctype="multipart/form-data">
					
						<div class="drop2">
							<p class="text-center"><?php echo $label; ?></p>
							<a class="glyphicon glyphicon-camera"></a>
							<input type="file" class="" name="Filedata" accept="image/x-png, image/gif, image/jpeg" multiple />
						</div>
			
						<ul>
							<!-- The file uploads will be shown here -->
						</ul>
					</form>
				</div>

						<!-- JavaScript Includes -->
				<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
				
				<!-- Our main JS file -->
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/script_medidas_producto.js"></script>

				<style>
					.drop2 a {
					    background-color: #007a96;
					    padding: 12px 26px;
					    color: #fff;
					    font-size: 18px;
					    border-radius: 2px;
					    cursor: pointer;
					    display: inline-block;
					    margin-top: 12px;
					    line-height: 1;
					}

					.drop2 input {
					    display: none;
					}


					.upload2 ul li {
					    background-color: #333639;
					    background-image: -webkit-linear-gradient(top, #333639, #303335);
					    background-image: -moz-linear-gradient(top, #333639, #303335);
					    background-image: linear-gradient(top, #333639, #303335);
					    border-top: 1px solid #3d4043;
					    border-bottom: 1px solid #2b2e31;
					    padding: 5px;
					    height: 72px;
					    position: relative;
					}
				</style>

			<?php
		}


		function upload_css_fb_producto($IDPRODUCTO="",$label="",$type=""){

			if($IDPRODUCTO<>""){
				$_GET['IDPRODUCTO']= $IDPRODUCTO;
			}


			?>
			<link href="<?php echo URL_PLUGIN; ?>/upload_css/assets/css/style.css?<?php echo time(); ?>" rel="stylesheet" />
					
				<div class="div_redondeado subir_modelos">

					<form class="upload3" method="post" action="<?php echo URL_PLUGIN; ?>/upload_css/upload.php?uploadtype=productos&IDPRODUCTO=<?php echo $_GET['IDPRODUCTO']; ?>&TIPO=<?php echo $type; ?>" enctype="multipart/form-data">
					
						<div class="drop3">
							<p class="text-center"><?php echo $label; ?></p>
							<a class="glyphicon glyphicon-camera"></a>
							<input type="file" class="" name="Filedata" accept="image/x-png, image/gif, image/jpeg" multiple />
						</div>
			
						<ul>
							<!-- The file uploads will be shown here -->
						</ul>
					</form>
				</div>

						<!-- JavaScript Includes -->
				<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
				
				<!-- Our main JS file -->
				<script src="<?php echo URL_PLUGIN; ?>/upload_css/assets/js/script_fotos_fb_producto.js"></script>

				<style>
					.drop3 a {
					    background-color: #007a96;
					    padding: 12px 26px;
					    color: #fff;
					    font-size: 18px;
					    border-radius: 2px;
					    cursor: pointer;
					    display: inline-block;
					    margin-top: 12px;
					    line-height: 1;
					}

					.drop3 input {
					    display: none;
					}


					.upload3 ul li {
					    background-color: #333639;
					    background-image: -webkit-linear-gradient(top, #333639, #303335);
					    background-image: -moz-linear-gradient(top, #333639, #303335);
					    background-image: linear-gradient(top, #333639, #303335);
					    border-top: 1px solid #3d4043;
					    border-bottom: 1px solid #2b2e31;
					    padding: 5px;
					    height: 72px;
					    position: relative;
					}
				</style>

			<?php
		}


		/************************ formulario *************************/

		function input($array,$show=true){

			if($array['LARGO-LABEL']=="" OR $array['LARGO-INPUT']==""){
				$array['LARGO-LABEL'] = 3;
				$array['LARGO-INPUT'] = 9;	
			}



			echo"
				<div class='form-group'>";

				if($show){	
			   		echo"<label for='".$array['ID']."' class='col-sm-".$array['LARGO-LABEL']." control-label'>".$array['LABEL']."</label>";
			   	}
			   		echo "<div class='col-sm-".$array['LARGO-INPUT']."'>";

				if($array['ICON']<>""){	
					echo"<div class='input-group input-group-md'>			
						<span class='input-group-addon'><span class='".$array['ICON']."'></span></span>";
				} 

			    	echo"<input type='text' class='form-control ".$array['CLASSFORM']."' id='".$array['ID']."' value='".$array['VALUE']."' placeholder='".$array['LABEL']."' name='".$array['TABLA']."[".$array['NAME']."]'>
			    	</div>";
			    	
			    if($array['ICON']<>""){	
			    	echo "</div>";	
			    }	

			echo "</div>";
		
		}

		function input_hora($array){

			echo"
				<div class='form-group'>
					<label for='".$array['ID']."' class='col-xs-3 col-sm-3 control-label'>".$array['LABEL']."</label>
					<div class='col-xs-9 col-sm-9'>
						<div class='input-group date datetimepicker' id='".$array['ID']."'>
					       		<span class='input-group-addon'>
					                <span class='glyphicon glyphicon-time'></span>
					            </span>
					        <input type='text' value='".$array['VALUE']."' class='form-control' placeholder='00:00 AM' name='".$array['TABLA']."[".$array['NAME']."]'/>
					    </div>
				    </div>
				</div>

		        <script type=\"text/javascript\">
		        	$(document).ready(function(){
			        	 $(function(){
			                $('#".$array['ID']."').datetimepicker({
			                    format: 'LT'
			                });
			            });	
		        	});
		        </script>
				";

		}

		function input_fecha($array){

			echo"
				<div class='form-group'>
					<label for='".$array['ID']."' class='col-xs-3 col-sm-3 control-label'>".$array['LABEL']."</label>
					<div class='col-xs-9 col-sm-9'>
						<div class='input-group' id='".$array['ID']."'>
					       		<span class='input-group-addon'>
					                <span class='glyphicon glyphicon-calendar'></span>
					            </span>
					        <input type='text' value='".$array['VALUE']."' class='form-control datepicker' placeholder='' name='".$array['TABLA']."[".$array['NAME']."]'/>
					    </div>
				    </div>
				</div>

				<script>
					$(document).ready(function(){
						$('.datepicker').datepicker({
							format: \"yyyy-mm-dd\",
							todayBtn: \"linked\"
						});
					});
				</script>
				";

		}


		function input_select_fecha(){
?>

			<div class="form-group">
				<label for="HORAIN" class="col-xs-3 col-sm-3 control-label">Desde</label>
				<div class="col-xs-9 col-sm-9">
					<div class="input-group date" id="HORAIN">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-time"></span>
						</span>
						<?php echo $pagina->horain(); ?>
						<select class="validar form-control" id="select-HORAIN" placeholder="00:00 AM" name="ventas[HORAIN]">
							<option value="">Seleccione horario</option>
								<?php for($i=10;$i<21;$i++){ 
									 if($pagina->horain()=="$i:00:00"){ ?>
										<option selected value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option> 
									<?php }else{ ?>
										<option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
									<?php } ?>
								<?php } ?>
						 </select>
					 </div>
				</div>
			</div>
																	
											<div class="form-group">
												<label for="HORAOUT" class="col-xs-3 col-sm-3 control-label">Desde</label>
												<div class="col-xs-9 col-sm-9">
													<div class="input-group date" id="HORAOUT">
												       	<span class="input-group-addon">
												            <span class="glyphicon glyphicon-time"></span>
												        </span>
												        <select class="validar form-control" id="select-HORAOUT" placeholder="00:00 AM" name="ventas[HORAOUT]">
												        	<option value="">Seleccione</option>
												        </select>
												    </div>
											    </div>
											</div>	



										<script>
											
											$(document).ready(function(){

												$("#select-HORAIN").change(function(){
													//alert($(this).val());

													var valor;
													var empezar;
													var cadena = "";

													valor = $(this).val();
													//console.log(valor);
												
													var desde = valor.split(":");
													
													empezar = parseInt(desde[0]) + 1
													
													for(i=empezar;i<=21;i++){
														cadena = cadena + '<option value="'+i+':00">'+i+':00</option>';
													}	

													$("#select-HORAOUT").html(cadena);
													
												});
											});

										</script>											
<?php			
		}

		function input_moneda($array){

			echo"
				<div class='form-group'>
			   		<label for='".$array['ID']."' class='col-sm-3 control-label'>".$array['LABEL']."</label>
			   		<div class='col-sm-9'>
			   			<div class='input-group'>
						  <span class='input-group-addon'>S/.</span>
						  <input type='text' class='form-control' id='".$array['ID']."' value='".$array['VALUE']."' placeholder='".$array['LABEL']."' name='".$array['TABLA']."[".$array['NAME']."]'>
						</div>
			    	</div>
				</div>
			";

		}
				

		function password($array){

		
		echo"\n<div class='filas_form'>\n

			  <label for='".$array['NAME']."'>".$array['LABEL']."</label>\n

			  <input type='password' id='".$array['ID']."' value='".$array['VALUE']."' size='".$array['SIZE']."' class='entrada_text ".$array['CLASS']."' name='".$this->tabla."[".$array['NAME']."]'/>\n

			</div>";

		}


		function upload($array,$tipe="file",$show=false){


			echo"\n<div class='form-group'>\n

				 <label for='".$array['ID']."' class='col-sm-3 control-label'>".$array['LABEL']."</label>
			   		<div class='col-sm-9'>
						<input data-codigo='".$array['ID']."' class='btn btn-default btn-file' type='file' id='".$array['ID']."' value='' class='form-control".$array['CLASS']."' name='UPLOAD_FILE[".$array['TABLA']."][".$array['NAME']."]'/>\n
					</div>
				</div>";

			echo"\n<div class='form-group'>\n
					<div class='col-sm-3 col-sm-offset-3'>";

				$extencion = end( explode('.', $array['VALUE']) );

				if($extencion = "JPG" OR $extencion = "PNG" OR $extencion = "jpg" OR $extencion = "png"){

					$archivo = "<a data-link='".URL_UPLOADS."/grande-".$array['VALUE']."' data-toggle='modal' data-target='#modal-upload' class='imagen-link' href='#'><div id='img-".$array['ID']."'><img height='100' src='".existe_imagen(URL_UPLOADS."/thumb-".$array['VALUE'])."'></div></a>\n";

				}else{

					$archivo = "<div class='icon_upload'><a class='fancybox_link' href='".URL_UPLOADS."/grande-".$array['VALUE']."'></a></div>\n";

				}

				if($array['VALUE']<>""){
					echo"\n<div class='filas_form'>\n
					  <label for='".$array['NAME']."'></label>\n
					  $archivo
					  </div>";
				}
				echo "</div>";	

			echo "</div>";	

		}

		

		function checkbox($array){

		

		echo"\n<div class='filas_form'>\n

			  <label for='".$array['NAME']."'>".$array['LABEL']."</label>\n

			  <input type='checkbox' id='".$array['ID']."' value='".$array['VALUE']."' class='entrada_text ".$array['CLASS']."' name='".$array['TABLA']."[".$array['NAME']."]'/>\n

			</div>";

		}

		function btn_guardar_block($array){
			echo"
				<div class='form-group'>
					<div class='col-sm-9 col-sm-offset-3'>
			   			<button id='".$array['ID']."' class='btn btn-primary btn-block'>Guardar Cambios</button>
					</div>
				</div>
			";
		}


		function btn_guardar($array){
			echo"
				<div class='form-group'>
					<div class='col-sm-9 col-sm-offset-3'>
			   			<button id='".$array['ID']."' class='btn btn-primary'>Guardar Cambios</button>
					</div>
				</div>
			";
		}

		function btn_guardar_col($array){
			echo"
				<div class='col-md-12'>
					<div class='form-group'>
						<div class='col-md-11 col-md-offset-1'>
						   	<button id='".$array['ID']."' class='btn btn-primary'>Guardar Cambios</button>
						</div>
					</div>
				</div>
			";
		}

		function textarea($array){

		if($array['LARGO-LABEL']=="" OR $array['LARGO-INPUT']==""){
				$array['LARGO-LABEL'] = 3;
				$array['LARGO-INPUT'] = 9;	
			}	

		echo"\n<div class='form-group'>\n

			  <label for='".$array['ID']."' class='col-sm-".$array['LARGO-LABEL']." control-label'>".$array['LABEL']."</label>
			  <div class='col-sm-".$array['LARGO-INPUT']."'>
			 	 <textarea type='text' id='".$array['ID']."' cols='".$array['COLS']."'  rows='".$array['ROWS']."'  placeholder='".$array['LABEL']."' class='form-control entrada_textarea ".$array['CLASS']."' name='".$array['TABLA']."[".$array['NAME']."]'/>".$array['VALUE']."</textarea>\n
			  </div>	
			</div>";

		}

		

		

		function hidden($array){

			echo"

				<input type='hidden' name='".$array['NAME']."' value='".$array['VALUE']."'>

			";

		}



		function oculto($array){

			echo"

				<input type='hidden' name='".$this->tabla."[".$array['NAME']."]' value='".$array['VALUE']."'>

			";

		}

		

		function select($array){

		
		echo"\n<div class='form-group'>\n

			  <label for='".$array['ID']."' class='col-sm-3 control-label'>".$array['LABEL']."</label>\n	";

			echo"
				<div class='col-sm-9'>
				";


		if($array['ICON']<>""){	
			echo"<div class='input-group input-group-md'>			
				<span class='input-group-addon'><span class='".$array['ICON']."'></span></span> ";
		} 

			echo"<select class='form-control ".$array['CLASS']."' id='".$array['ID']."' name='".$array['TABLA']."[".$array["NAME"]."]"."'>";


				echo"<option value=''>Seleccionar</option>";

				$claves = array_keys($array['VALUE']);

				$i=0;

				foreach($array['VALUE'] as $fila){

					if($array['SELECTED']==$claves[$i]){
						echo"<option selected value='".$claves[$i]."'>".$array['VALUE'][$claves[$i]]."</option>";
					}else{
						echo"<option value='".$claves[$i]."'>".$array['VALUE'][$claves[$i]]."</option>";
					}

					$i++;
				}
			echo"</select>";

		if($array['ICON']<>""){	
			echo "</div><!-- fin de input-group -->";
		} 	

			echo"</div>";

		echo"</div>";	

		}
		

		/******************** fin de formulario **********************/



		function js_timer(){
			?>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
			<?php		
		}

		function js_picker(){
			?>
				    
	    		<link rel="stylesheet" href="<?php echo URL_PLUGIN ?>/picker/bootstrap-datepicker3.min.css">
	    		<script type="text/javascript" src="<?php echo URL_PLUGIN ?>/picker/bootstrap-datepicker.min.js"></script>
			<?php		
		}

		function link_top(){
		?>

			<style>
				.ir-arriba {
					display:none;
					padding:20px;
					background:#024959;
					font-size:20px;
					color:#fff;
					cursor:pointer;
					position: fixed;
					bottom:45px;
					right:10px;
					z-index: 100
				}
			</style>

			<script>
				$(document).ready(function(){
				 
					$('.ir-arriba').click(function(){
						$('body, html').animate({
							scrollTop: '0px'
						}, 300);
					});
					 
					$(window).scroll(function(){
						if( $(this).scrollTop() > 0 ){
							$('.ir-arriba').slideDown(300);
						} else {
							$('.ir-arriba').slideUp(300);
						}
					});
				 
				});
			</script>
			<link rel="stylesheet" href="fonts.css">
			<span class="ir-arriba icon-chevron-up"></span>

		<?php			
		}


		function link_top_web(){
		?>

			<style>
				.ir-arriba {
					display:none;
					padding:20px;
					background:#024959;
					font-size:20px;
					color:#fff;
					cursor:pointer;
					position: fixed;
					bottom:20px;
					right:20px;
					z-index: 100
				}
			</style>

			<script>
				$(document).ready(function(){
				 
					$('.ir-arriba').click(function(){
						$('body, html').animate({
							scrollTop: '0px'
						}, 300);
					});
					 
					$(window).scroll(function(){
						if( $(this).scrollTop() > 0 ){
							$('.ir-arriba').slideDown(300);
						} else {
							$('.ir-arriba').slideUp(300);
						}
					});
				 
				});
			</script>
			<link rel="stylesheet" href="fonts.css">
			<span class="ir-arriba icon-circle-up"></span>

		<?php			
		}

		function navbar_admin($config){
		?>

			<div class="col-md-12">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-btn">
							<a id='link-modal-modelos' class='btn btn-success' href="<?php echo get_option('admin'); ?>/<?php echo $config['LINK'] ?>?CASO=NUEVO"><span class="glyphicon glyphicon-plus  margin-right"></span>Agregar <?php echo $config['LABEL'] ?></a>
						</span>
						<input class="form-control input-buscar" type="" name="" placeholder="Buscar <?php echo $config['LABEL'] ?>">
					</div>

				</div>
			</div>

		<?php			
		}

		function script_ajax_buscar($config){

			if($config['CLASE']==""){
				$clase = "input-buscar";
			}else{
				$clase = $config['CLASE'];
			}	
		?>
			<script>
				$(document).ready(function(){

					$('.sin-resultados').hide();
					$(".<?php echo $clase; ?>").keyup(function(){

						$.ajax({
							type: "POST",
							url: "<?php echo get_option('admin'); ?>/ajax_buscar.php",
							data: { CASO:'<?php echo $config['CASO'] ?>',CADENA: $(this).val()},
							beforeSend: function() {
								//$('.content_totales').html('Cargando...');
							}
						})
								
						.done(function(msg){
							if(msg=="0"){
								$('.resultados').hide(msg);
								$('.sin-resultados').show();
								//$('.sin-resultados').html(msg);
							}else{
								$('.sin-resultados').hide();
								$('.resultados').show(msg);
								$('.resultados').html(msg);
							}
							
						});	

						return false;

					});	
				});
			</script>
		<?php	
		}

		function config_guardar($config){
			/***** CONFIGURACION DE INSERCION ******/
			$this->hiddenhidden(array('NAME'=>'PAGINA','VALUE'=>$config['PAGINA']));
			$this->hidden(array('NAME'=>'TIPO','VALUE'=>$config['TIPO']));
			$this->hidden(array('NAME'=>'KEYPADRE','VALUE'=>$config['KEYPADRE']));
			$this->hidden(array('NAME'=>'KEY','VALUE'=>$config['KEY']));	
		}

	}


class pagina_public{
	
	function __construct(){
			
	}
		
	function title_page(){

	echo "<title>Aquarella</title>";

	
	}
	
	function metas(){
?>

	<link rel="shortcut icon" href="<?php echo theme(); ?>/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo theme(); ?>/favicon.ico" type="image/x-icon">
	<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>		
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="description" content="Aquarella ropa y accesorios es un almacen con cede en Lima, todos nuestros productos se distribuyen via delivery a todo el Peru">	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>	
	<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->	
	<meta property="og:title" content="" />    
	<meta property="og:description" content="Aquarella ropa y accesorios es un almacen con cede en Lima, todos nuestros productos se distribuyen via delivery a todo el Peru" />    
	<meta property="og:image" content="" />          
	<meta property="og:url" content="<?php echo get_option("home"); ?>" />	

<?php 	

	}

	function style(){
		
		$archivos_css = cargar_archivos_directorio(array(theme('dir').'/style'),array(theme().'/style'));
		
?>
	<!--  empieza css  -->
<?php 	
		for($i=0;$i<count($archivos_css);$i++){
?>
		<link rel="stylesheet" href="<?php echo $archivos_css[$i]; ?>?<?php echo time(); ?>" type="text/css" media="screen" />
<?php 
		}		
?>
			<!--  termina css  -->
<?php 	

	}	
	
	function js(){
	
		$archivos_css = cargar_archivos_directorio(array(DIR_CORE.'/js'),array(URL_CORE.'/js'));
	
		?>
		
	<!--  empieza JS  -->
	<?php 	
			for($i=0;$i<count($archivos_css);$i++){
	?>
	
		<script src="<?php echo $archivos_css[$i]; ?>?<?php echo time(); ?>"></script>	
	<?php 
			}		
	?>
	
	<!--  termina JS  -->
	
	<?php 	
	
		}		
		
	function incluir_js_con_php(){
		$archivos_css = cargar_archivos_directorio(array(DIR_CORE.'/js'),array(URL_CORE.'/js'));
			
		for($i=0;$i<count($archivos_css);$i++){
			echo DIR_CORE.'/js/'.$archivos_css[$i]."\n";
			include(DIR_CORE.'/js/'.$archivos_css[$i]);
		}		 			
	}	
		
	function css_texto_input($clase,$texto){
?>
	<script>
	
		$(document).ready(function(){
			
			var cadena_inicial;
			cadena_inicial = $("<?php echo $clase; ?>").val();
			
			$("<?php echo $clase; ?>").focusout(function(){
				if($(this).val()==''){
					$(this).val('<?php echo $texto; ?>');					
				}
			});	
			
			$("<?php echo $clase; ?>").click(function(){
				
				if($(this).val() == cadena_inicial){
					$(this).val('');
				}
			
			});

		});
	
	</script>
<?php
	}
}
 ?>