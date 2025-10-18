Listado de errores o cosas a mejorar:

1. Descubrir porque me sale que el estilo: esilo_index.css es inalcanzable.

2. Crear un regex más robusto, sobretodo para contraseñas.

3. Agregar pagina para añadir videojuegos.

4. Añadir javascript para mostrar si la contraseña cumple con la validación, si el titulo coincide con juegos que esten en la base de datos.

7. Modificar include y cambiarlos por require_once en todos los imports. ademas de añadir un manejo de errores en caso de que no se encuentre ese archivo, con algún redireccionamiento a otra pagina.

8. Problemas con la validación en el front-end de autor en editar videojuegos, checkear tanto el front como el backend.

9. Ahora ya puedo hacer un update a la base de datos; Faltan por resolver las siguientes cuestiones:

    caratulas -> utilizar algoritmo/función para evitar que halla nombre repetidos
    (Recordar que el usuario puede añadir un videojuego sin caratula.)


10. Añadir que los usuarios que no hallan inciado sesión no puedan ver el listado de videojuegos ni el formulario para añadir nuevos videojuegos ni el icono de la cuenta de usuario. 


11. Comprobar si se pueden subir imagenes con el mismo nombre.

12. Hacer que el usuario pueda añadir y editar videojuegos sin agregar uno el mismo y se use la imagen default.png por defecto.





///// PARTE IMPORTANTE QUE CUENTA PARA NOTA PRIORIDAD MAXIMA:


2. Agregar icono de cuenta en la parte superior derecha de la pagina,
la cual dispone de la opción de cerrar sesión y link a pagina para editar datos del usuario, menos el email.

3. Crear vista de estadísticas para ver visualizaciones de nuestros videojuegos.

4. Añadir a la vista de detalles de videojuegos la posibilidad de indicar
si nos gusta o no. esto se enviara mediante petición ajax.

5. Crear check para autologgear al usuario mediante cookies.


IMPORTANTE ITERAR EN ORDEN DE MENOR A MAYOR DIFICULTAD AGREGANDO FEATURES.