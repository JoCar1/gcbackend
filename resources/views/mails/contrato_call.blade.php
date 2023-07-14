<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Gestión de Contrato</title>
</head>
<body>
    <table style="border:1px solid black;border-collapse:collapse;">
        <tbody>
            <tr>
                <td>
                  <h2>Este es un recordatorio de Mananco S.A. sobre un evento.</h2>
                </td>
                <td>
                    <img width="150px" src="https://image.isu.pub/150709195610-e5a407d34009a300ab2d29109cfb45f9/jpg/page_1.jpg"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h3>Título del evento</h3>
                    <p>{{ $distressCall->nombre }}</p>
                    <h3>Fecha del evento</h3>
                    <p>{{ $distressCall->fecha_evento }}</p>
                    <h3>Fecha de recordatorio</h3>
                    <p>{{ $distressCall->fecha_recordatorio }}</p>
                    <h3>Descripción</h3>
                    <p>{{ $distressCall->descripcion }}</p>
                    <h3>Contrato</h3>
                    <p>{{ $distressCall->contrato->nombre }}</p>
                    <h3>Nombre de la empresa</h3>
                    <p>{{ $distressCall->contrato->socio->nombre }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p><strong>Gracias y saludos cordiales.</strong></p>
                    <p style="float: right">Por favor no responda este mensaje.</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>