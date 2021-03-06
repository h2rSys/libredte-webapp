<div class="btn-group" role="group">
<?php foreach ($nav as $link => $info) : ?>
  <a href="<?=$_base?>/certificacion<?=$link?>" class="btn btn-default">
    <span class="<?=$info['icon']?>" />
    <?=$info['name']?>
  </a>
<?php endforeach; ?>
</div>

<h1>Proceso de certificación &raquo; Etapa 1: set de pruebas</h1>

<div class="panel panel-default">
    <div class="panel-heading">Instrucciones SII</div>
    <div class="panel-body">
        <p class="lead">Este paso consiste en la recepción en el SII, sin rechazos ni reparos, de un envío de documentos que el postulante construye en base a un <a href="https://maullin2.sii.cl/cvc_cgi/dte/pe_generar" title="Generar set de pruebas">archivo con datos de prueba</a> que el SII genera en forma única para cada Postulante, en función de su giro y de los documentos que desea certificar. Además de documentos tributarios electrónicos, en este paso los Postulantes deben enviar también al SII, como parte de las pruebas, la Información Electrónica de Ventas y la Información Electrónica de Compras.</p>
        <p>Se recomienda realizar el Set de Pruebas, una vez que Ud. haya realizado pruebas de envíos exitosos al SII (Aceptados sin Reparos). En cualquier momento, además, tiene la opción de obtener un nuevo Set de Pruebas. Recuerde que los envíos correspondientes al Set de Prueba serán evaluados respecto al último Set de Pruebas que haya bajado.</p>
        <p>Los envíos con los documentos generados a partir de los datos del set de prueba deben ser enviados al SII dentro del plazo de 2 meses contados a partir del momento de obtener el set de prueba. Los envíos que excedan ese plazo serán rechazados y el postulante deberá Generar un Nuevo Set de pruebas para realizar las pruebas. El postulante puede iterar cuanto desee enviando archivos correspondientes al set de prueba. Cuando el resultado de la validación de dichos envíos resulte sin rechazos ni reparos el usuario administrador puede declararlos para la revisión del SII. Esta revisión consistirá en comprobar que el envío haya sido realizado con los datos del set de prueba entregado al postulante. Usando la opción <a href="https://maullin2.sii.cl/cvc_cgi/dte/pe_avance1">Declarar Avance de la Postulación</a>, el Postulante puede informar al SII que completó exitosamente el Set de Pruebas, señalando la fecha y número de cada envío para permitir al SII verificar su validez.</p>
        <p>Una vez que el SII haya verificado que el postulante completó satisfactoriamente el set de prueba, el SII le permitirá avanzar al siguiente paso, <a href="simulacion">la Simulación</a>.</p>
    </div>
</div>

<script type="text/javascript">
$(function() {
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
    }
});
</script>

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#dte" aria-controls="dte" role="tab" data-toggle="tab">Emisión de DTE</a></li>
        <li role="presentation"><a href="#ventas" aria-controls="ventas" role="tab" data-toggle="tab">Libro de Ventas</a></li>
        <li role="presentation"><a href="#compras" aria-controls="compras" role="tab" data-toggle="tab">Libro de Compras</a></li>
        <li role="presentation"><a href="#guias" aria-controls="guias" role="tab" data-toggle="tab">Libro de Guías de Despacho</a></li>
        <li role="presentation"><a href="#boletas" aria-controls="boletas" role="tab" data-toggle="tab">Boletas</a></li>
    </ul>
    <div class="tab-content">

<!-- INICIO EMISIÓN DTE -->
<div role="tabpanel" class="tab-pane active" id="dte">
<?php
$f = new \sowerphp\general\View_Helper_Form();
echo $f->begin(['action'=>$_base.'/certificacion/set_pruebas_dte', 'id'=>'form_dte', 'onsubmit'=>'Form.check(\'form_dte\')']);
echo $f->input([
    'type' => 'file',
    'name' => 'archivo',
    'label' => 'Set pruebas ventas',
    'check' => 'notempty',
    'help' => 'Archivo del set de pruebas con los casos (de un mismo SET) que se desean generar, debe estar codificado en ISO-8859-1. Puedes ver un ejemplo del archivo que se espera <a href="https://github.com/sascocl/LibreDTE/blob/master/examples/set_pruebas/001-basico.txt" target="_blank">para el set básico</a> o <a href="https://github.com/sascocl/LibreDTE/blob/master/examples/set_pruebas/004-factura_exenta.txt" target="_blank">para el set de factura exenta</a>',
    'attr' => 'accept=".txt"',
]);
echo $f->input([
    'type' => 'js',
    'name' => 'folios',
    'label' => 'Folios a usar',
    'titles' => ['Tipo documento', 'Folio desde'],
    'inputs' => [['name'=>'folios'], ['name'=>'desde']],
    'check' => 'notempty',
    'help' => 'Se debe indicar el código del tipo de documento y el folio desde el cual se generarán los documentos',
]);
echo $f->end('Siguiente &raquo;');
?>
</div>
<!-- FIN EMISIÓN DTE -->

<!-- INICIO VENTAS -->
<div role="tabpanel" class="tab-pane" id="ventas">
<?php
$f = new \sowerphp\general\View_Helper_Form();
echo $f->begin(['action'=>$_base.'/certificacion/set_pruebas_ventas', 'id'=>'form_ventas', 'onsubmit'=>'Form.check(\'form_ventas\')']);
echo $f->input([
    'type' => 'file',
    'name' => 'archivo',
    'label' => 'XML EnvioDTE',
    'check' => 'notempty',
    'help' => 'Archivo XML del EnvioDTE generado a partir del caso de prueba que se desea crear su libro de ventas',
    'attr' => 'accept=".xml"',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'simplificado',
    'label' => '¿Libro normal o simplificado?',
    'options' => ['Normal', 'Simplificado'],
    'value' => 1,
    'check' => 'notempty',
    'help' => 'Si el contribuyente nunca ha sido autorizado debe ser simplificado'
]);
echo $f->input([
    'name' => 'PeriodoTributario',
    'label' => 'Periodo tributario',
    'value' => '1980-01',
    'placeholder' => '1980-01',
    'check' => 'notempty',
    'help' => 'Si el libro es simplificado, debe ser un mes del año 1980',
]);
echo $f->input([
    'type' => 'date',
    'name' => 'FchResol',
    'label' => 'Fecha resolución',
    'value' => '2006-01-20',
    'placeholder' => '2006-01-20',
    'check' => 'notempty date',
    'help' => 'Si el libro es simplificado, debe ser 2006-01-20',
]);
echo $f->input([
    'type' => 'file',
    'name' => 'firma',
    'label' => 'Firma electrónica',
    'help' => 'Obligatorio si libro es normal. Certificado digital con extensión .p12 o .pfx',
    'attr' => 'accept=".p12,.pfx"',
]);
echo $f->input([
    'type' => 'password',
    'name' => 'contrasenia',
    'label' => 'Contraseña firma',
    'help' => 'Contraseña que permite abrir el certificado digital de la firma electrónica',
]);
echo $f->end('Descargar Libro de Ventas');
?>
</div>
<!-- FIN VENTAS -->

<!-- INICIO COMPRAS -->
<div role="tabpanel" class="tab-pane" id="compras">
    <p>Para generar el libro de compras deberá crear un archivo en formato CSV que contendrá los datos de las compras del set de pruebas entregado por el SII. Luego deberá cargar dicho archivo CSV en el <a href="<?=$_base?>/utilidades/generar_libro">Generador de XML de Libro de Compra</a> de LibreDTE.</p>
    <p>Ejemplos archivos:</p>
    <ul>
        <li><a href="https://github.com/sascocl/LibreDTE/blob/master/examples/set_pruebas/003-compras.txt">Ejemplo set de pruebas de compras entregado por el SII</a></li>
        <li><a href="https://raw.githubusercontent.com/LibreDTE/libredte-lib/master/examples/libros/libro_compras.csv">Ejemplo archivo CSV generado con los datos del set de pruebas</a></li>
    </ul>
    <a class="btn btn-primary btn-lg btn-block" href="<?=$_base?>/utilidades/generar_libro" role="button">Generar XML de Libro de Compras usando archivo CSV</a>
</div>
<!-- FIN COMPRAS -->

<!-- INICIO GUÍAS -->
<div role="tabpanel" class="tab-pane" id="guias">
    <p>Para generar el libro de guías de despacho deberá crear un archivo en formato CSV que contendrá los datos de las guías del set de pruebas entregado por el SII. Luego deberá cargar dicho archivo CSV en el <a href="<?=$_base?>/utilidades/generar_libro_guia">Generador de XML de Libro de Guías de Despacho</a> de LibreDTE.</p>
    <p>Ejemplos archivos:</p>
    <ul>
        <li><a href="https://github.com/sascocl/LibreDTE/blob/master/examples/set_pruebas/006-libro_guias.txt">Ejemplo set de pruebas de guías entregado por el SII</a></li>
        <li><a href="https://raw.githubusercontent.com/LibreDTE/libredte-lib/master/examples/libros/libro_guias.csv">Ejemplo archivo CSV generado con los datos del set de pruebas</a></li>
    </ul>
    <a class="btn btn-primary btn-lg btn-block" href="<?=$_base?>/utilidades/generar_libro_guia" role="button">Generar XML de Libro de Guías de Despacho usando archivo CSV</a>
</div>
<!-- FIN GUÍAS -->

<!-- INICIO BOLETAS -->
<div role="tabpanel" class="tab-pane" id="boletas">
<?php
$f = new \sowerphp\general\View_Helper_Form();
echo $f->begin(['action'=>$_base.'/certificacion/set_pruebas_boletas', 'id'=>'form_boletas', 'onsubmit'=>'Form.check(\'form_boletas\')']);
echo $f->input([
    'name' => 'RUTEmisor',
    'label' => 'RUT',
    'placeholder' => 'RUT del emisor: 11222333-4',
    'check' => 'notempty rut',
    'attr' => 'maxlength="12" onblur="Emisor.setDatos(\'form_boletas\')"',
]);
echo $f->input([
    'name' => 'RznSoc',
    'label' => 'Razón social',
    'placeholder' => 'Razón social del emisor: Empresa S.A.',
    'check' => 'notempty',
    'attr' => 'maxlength="100"',
]);
echo $f->input([
    'name' => 'GiroEmis',
    'label' => 'Giro',
    'placeholder' => 'Giro del emisor',
    'check' => 'notempty',
    'attr' => 'maxlength="80"',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'Acteco',
    'label' => 'Actividad económica',
    'options' => [''=>'Actividad económica del emisor'] + $actividades_economicas,
    'check' => 'notempty',
]);
echo $f->input([
    'name' => 'DirOrigen',
    'label' => 'Dirección',
    'placeholder' => 'Dirección del emisor',
    'check' => 'notempty',
    'attr' => 'maxlength="70"',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'CmnaOrigen',
    'label' => 'Comuna',
    'options' => [''=>'Comuna del emisor'] + $comunas,
    'check' => 'notempty',
]);
echo $f->input([
    'type' => 'hidden',
    'name' => 'Telefono',
]);
echo $f->input([
    'type' => 'hidden',
    'name' => 'CorreoEmisor',
]);
echo $f->input([
    'type' => 'date',
    'name' => 'FchResol',
    'label' => 'Fecha resolución',
    'help' => 'Fecha en que fue otorgada la resolución',
    'check' => 'notempty date',
]);
echo $f->input([
    'type' => 'hidden',
    'name' => 'NroResol',
]);
echo $f->input([
    'type' => 'file',
    'name' => 'archivo',
    'label' => 'Set de pruebas',
    'check' => 'notempty',
    'help' => 'Archivo CSV (separado por punto y coma) con el set de pruebas de las boletas electrónicas: <a href="https://raw.githubusercontent.com/LibreDTE/libredte-lib/master/examples/set_pruebas/007-boletas.csv">ejemplo archivo CSV</a>',
    'attr' => 'accept=".csv"',
]);
echo $f->input([
    'type' => 'js',
    'name' => 'folios_boletas',
    'label' => 'Folios a usar',
    'titles' => ['Tipo documento', 'Folio desde', 'CAF'],
    'inputs' => [
        ['name'=>'folios', 'check'=>'notempty integer'],
        ['name'=>'desde', 'check'=>'notempty integer'],
        ['type'=>'file', 'name'=>'caf', 'check'=>'notempty', 'attr' => 'accept=".xml"'],
    ],
    'check' => 'notempty',
    'help' => 'Se debe indicar el código del tipo de documento, el folio desde el cual se generarán los documentos y el XML del CAF para cada tipo de documento',
]);
echo $f->input([
    'name' => 'web_verificacion',
    'label' => 'Web verificación',
    'value' => 'libredte.cl/boletas',
    'check' => 'notempty',
    'help' => 'Página web para verificar las boletas (se coloca bajo el timbre en el PDF)',
]);
echo $f->input([
    'type' => 'file',
    'name' => 'firma',
    'label' => 'Firma electrónica',
    'help' => 'Certificado digital con extensión .p12',
    'check' => 'notempty',
    'attr' => 'accept=".p12,.pfx"',
]);
echo $f->input([
    'type' => 'password',
    'name' => 'contrasenia',
    'label' => 'Contraseña firma',
    'check' => 'notempty',
    'help' => 'Contraseña que permite abrir el certificado digital de la firma electrónica',
]);
echo $f->end('Generar boletas, notas de crédito, consumo de folios, libro de boletas y muestras impresas');
?>
</div>
<!-- FIN BOLETAS -->

    </div>
</div>
