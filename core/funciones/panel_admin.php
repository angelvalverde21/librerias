<?php
function validar_select(){
	?>
						<style>

							.btn_click{
								display: block;
								margin: 10px 0;
								border: 0px solid #ccc;
							}

							.btn_click a{
								color: #696969;
								font-family: Arial;	
								font-size: 15pt;
								text-decoration: none;
								border: 1px solid #7B7B7B;
								width: 250px;
								height: 50px;
								display: table-cell;
								text-align: center;
								vertical-align: middle;
								background: linear-gradient(to bottom, rgba(248,248,248,1) 0%, rgba(221,221,221,1) 100%);
								margin: 20px 0;
							}

							.btn_click a:active{
								background: linear-gradient(to bottom, rgba(221,221,221,1) 0%, rgba(248,248,248,1) 100%);
							}

						</style>

						<script>
							$(document).ready(function(){

								$(document).on('click','.btn_click',function(){
									event.preventDefault();
									var formulario_correcto;
									var campos_validados = new Array(); 
									$(".select_talla").each(function(index){
										
										if($(this).val() != ""){
											if($(this).val() == null){
												campos_validados[index] = false;

												$(this).attr('style', 'border: 1px solid red !important');
											}else{

												$(this).attr('style', 'border: 1px solid #ccc !important');
												campos_validados[index]  = true;				
											}
										}else{
											
												campos_validados[index]  = false;
												$(this).attr('style', 'border: 1px solid red !important');
												
										}

										var i;
									});

									for(i=0;i<campos_validados.length;i++){
										if(campos_validados[i]){
											formulario_correcto = true;
										}else{
											formulario_correcto = false;
											break;
										}
									}

									if(formulario_correcto){
										
										$("#formulario").submit();
										//alert('CONCLUSION: formulario correcto');
									}else{
									
										$('.mensaje_system_rojo').show();
										$('.mensaje_system_rojo').html("No ha llenado correctamente los productos");
										//alert('CONCLUSION: FALLIDO');
									}

								});

							});
						</script>
<?php
}
