<?php
require_once("class/class.php");

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$_SESSION["simbolo"]."</strong>");
?>



<!--######################### LISTAR PRODUCTOS POR FAMILIAS ########################-->
<?php if (isset($_GET['CargarProductos'])): ?>

<?php
$familia = new Login();
$familia = $familia->ListarFamilias();
?>
    <div class="row-horizon">
        <span class="categories selectedGat" id=""><i class="fa fa-home"></i></span>
        <?php 
        if($familia==""){ echo ""; } else {
        $a=1;
        for ($i = 0; $i < sizeof($familia); $i++) { ?>
        <span class="categories" id="<?php echo $familia[$i]['nomfamilia'];?>"><i class="fa fa-tasks"></i> <?php echo $familia[$i]['nomfamilia'];?></span>
        <?php } } ?>
    </div>

    <div class="col-md-12">
        <div id="searchContaner"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label"></label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busquedaproducto" id="busquedaproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                  <i class="fa fa-search form-control-feedback2"></i> 
            </div> 
        </div>
    </div>
    
    <div id="productList2">
        <?php
        $producto = new Login();
        $producto = $producto->ListarProductosModal();

        if($producto==""){

        echo "<div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS REGISTRADOS ACTUALMENTE</center>";
        echo "</div>";  

        } else { ?>

        <div class="row-vertical">
            <div class="row">
        <?php for ($ii = 0; $ii < sizeof($producto); $ii++) { ?>
        
        <!-- column -->
        <div ng-click="afterClick()" ng-repeat="product in ::getFavouriteProducts()" OnClick="DoAction(
        '<?php echo $producto[$ii]['idproducto']; ?>',
        '<?php echo $producto[$ii]['codproducto']; ?>',
        '<?php echo $producto[$ii]['producto']; ?>',
        '<?php echo $producto[$ii]['codmarca']; ?>',
        '<?php echo $producto[$ii]['nommarca'] == '' ? "******" : $producto[$ii]['nommarca']; ?>',
        '<?php echo $producto[$ii]['codmodelo']; ?>',
        '<?php echo $producto[$ii]['nommodelo'] == '' ? "******" : $producto[$ii]['nommodelo']; ?>',
        '<?php echo $producto[$ii]['codpresentacion']; ?>',
        '<?php echo $producto[$ii]['nompresentacion'] == '' ? "******" : $producto[$ii]['nompresentacion']; ?>',
        '<?php echo number_format($producto[$ii]['preciocompra'], 2, '.', ''); ?>',
        '<?php echo number_format($producto[$ii]['precioxpublico'], 2, '.', ''); ?>',
        '<?php echo number_format($producto[$ii]['descproducto'], 2, '.', ''); ?>',
        '<?php echo $producto[$ii]['ivaproducto']; ?>',
        '<?php echo $producto[$ii]['existencia']; ?>',
        '<?php echo $precioconiva = ( $producto[$ii]['ivaproducto'] == 'SI' ? number_format($producto[$ii]['precioxpublico'], 2, '.', '') : "0.00"); ?>',
        '1');">
        <div id="<?php echo $producto[$ii]['codproducto']; ?>">
            <div class="darkblue-panel pn" title="<?php echo $producto[$ii]['producto'].' | ('.$producto[$ii]['nomfamilia'].')';?>">
                <div class="darkblue-header">
                   <div id="proname" class="text-white font-12"><?php echo getSubString($producto[$ii]['producto'],16);?></div>
                </div>
                <?php if (file_exists("./fotos/productos/".$producto[$ii]["codproducto"].".jpg")){
                echo "<img src='fotos/productos/".$producto[$ii]['codproducto'].".jpg?' class='rounded-circle' style='width:130px;height:94px;'>"; 
                } else {
                echo "<img src='fotos/producto.png' class='rounded-circle' style='width:130px;height:94px;'>";  } ?>
                <input type="hidden" id="category" name="category" value="<?php echo $producto[$ii]['nomfamilia']; ?>">

                <div class="mask">
                <h5 style="font-size: 11.5px;" class="text-white pull-left"><i class="fa fa-bars"></i> <?php echo $producto[$ii]['existencia'];?></h5>
                <abbr title="<?php echo $producto[$ii]['montocambio'] == '' ? "" : $producto[$ii]['simbolo2'].number_format($producto[$ii]['precioxpublico']/$producto[$ii]['montocambio'], 2, '.', ','); ?>"><h5 class="text-white pull-right font-12"><?php echo $simbolo.number_format($producto[$ii]['precioxpublico'], 2, '.', ',');?></h5></abbr> 
                </div>
            </div>
        </div>

        </div>
        <!-- column -->
                
        <?php } // fin for ?>
        </div><!-- fin row -->
       </div><!-- fin row-vertical -->

        <?php } // fin if ?>

        </div> 
    </div>

<?php endif; ?>
<!--######################### LISTAR PRODUCTOS POR FAMILIAS ########################-->

<script type="text/javascript">
$(document).ready(function() {

    //  search product
   $("#busquedaproducto").keyup(function(){
      // Retrieve the input field text
      var filter = $(this).val();
      // Loop through the list
      $("#productList2 #proname").each(function(){
         // If the list item does not contain the text phrase fade it out
         if ($(this).text().search(new RegExp(filter, "i")) < 0) {
             $(this).parent().parent().parent().hide();
         // Show the list item if the phrase matches
         } else {
             $(this).parent().parent().parent().show();
         }
      });
   });
});


$(".categorias").on("click", function () {
   // Retrieve the input field text
   var filter = $(this).attr('id');
   $(this).parent().children().removeClass('selectedGat');
   $(this).addClass('selectedGat');
});


$(".categories").on("click", function () {
   // Retrieve the input field text
   var filter = $(this).attr('id');
   $(this).parent().children().removeClass('selectedGat');

   $(this).addClass('selectedGat');
   // Loop through the list
   $("#productList2 #category").each(function(){
      // If the list item does not contain the text phrase fade it out
      if ($(this).val().search(new RegExp(filter, "i")) < 0) {
         $(this).parent().parent().parent().hide();
         // Show the list item if the phrase matches
      } else {
         $(this).parent().parent().parent().show();
      }
   });
});

</script>