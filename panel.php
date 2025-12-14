<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="procesar_solicitud.php" method="POST">

    <h3>Solicitud de Certificado</h3>

    <label for="id_certi">Tipo de certificado</label>
    <select name="id_certi" id="id_certi" required>
        <option value="">Seleccione un certificado</option>
        <!-- Estos valores vienen de la BD -->
        <option value="1">Certificado de residencia</option>
        <option value="2">Certificado de inscripción vecinal</option>
        <option value="3">Certificado de participación en proyectos comunitarios</option>
        <option value="4">Certificado de buena conducta vecinal</option>
        <option value="5">Certificado de voluntariado barrial</option>
    </select>

    <br><br>

    <label for="observacion">Observación (opcional)</label>
    <textarea name="observacion" id="observacion" rows="4"
        placeholder="Puede agregar información adicional si lo desea"></textarea>

    <br><br>

    <button type="submit">Enviar solicitud</button>

</form>



    
</body>
</html>