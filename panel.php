<?php include("lib/roles.php")?>
<?php include("lib/lista-solicitud-usuario.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Adminstracion cliente</title>
    <link rel="stylesheet" href="assets/css/estilo-formulario.css">

</head>
<body>

<?php include("modulo-certificados/solicitud-certificado.php")?>

<?php if ($rol === 1): ?>
<?php include("modulo-certificados/administrar-certificados.php")?>


<?php elseif ($rol === 2): ?>
   
<?php elseif ($rol === 3): ?>
<?php include("modulo-certificados/solicitud-cliente.php")?>
<?php else: ?>

<?php endif; ?>





    
</body>
</html>