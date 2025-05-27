<!DOCTYPE html>
<html>
<head>
    <title>Notificación de retroalimentación</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style>
         .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: blue; /* Azul claro */
            border: none;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombreado */
            color: #ffffff; /* Color del texto */
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }
      .letra{
            font-family: 'Roboto', sans-serif;
            font-weight:400;
         }

    </style>
</head>
<body>
    <p class="letra">Hola, {{ $nombre }},</p> 

    <p class="letra">¡Espero que te encuentres muy bien! Queremos informarte que has recibido una nueva retroalimentación sobre tu respuesta.</p>

    <p class="letra"><b>Mensaje:</b></p>
    <p class="letra">{{ $mensaje }}</p>

    <p class="letra">
      Puedes revisar todos tus mensajes en el siguiente enlace: 
    <a class="btn letra" href="https://glearning.com.co/informe/comentarios" target="_blank">Clic aquí</a>
    </p>

    <br>
    <p class="letra" style="text-align: center;">¡Nunca dejes de aprender!</p>
    <br>

</body>
</html>
