Listado de errores o cosas a mejorar:

1. Descubrir porque me sale que el estilo: esilo_index.css es inalcanzable.

2. Crear un regex más robusto, sobretodo para contraseñas.

3. Agregar pagina para añadir videojuegos.

4. Añadir javascript para mostrar si la contraseña cumple con la validación, si el titulo coincide con juegos que esten en la base de datos.

7. Modificar include y cambiarlos por require_once en todos los imports. ademas de añadir un manejo de errores en caso de que no se encuentre ese archivo, con algún redireccionamiento a otra pagina.

8. En validacionVideojuegos.php añadir que si ya existe en nuestro directorio una caratula con el mismo nombre que se lo cambie usando el nombre del directorio temporal:

9. Ahora ya puedo hacer un update a la base de datos; Faltan por resolver las siguientes cuestiones:

    url -> Deberia de asignar un valor a el array POST antes de hacer la llamada en caso de que todo sea correcto?

    caratulas -> utilizar algoritmo/función para evitar que halla nombre repetidos
    (Recordar que el usuairo puede añadir un videojuego sin caratula.)