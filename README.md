Listado de errores o cosas a mejorar:

1. Descubrir porque me sale que el estilo: esilo_index.css es inalcanzable.

2. Crear un regex más robusto, sobretodo para contraseñas.


4. Añadir javascript para mostrar si la contraseña cumple con la validación, si el titulo coincide con juegos que esten en la base de datos.

7. Modificar include y cambiarlos por require_once en todos los imports. ademas de añadir un manejo de errores en caso de que no se encuentre ese archivo, con algún redireccionamiento a otra pagina.

13. Eliminar output de añadir_videojuego.php en el footer.

///// PARTE IMPORTANTE QUE CUENTA PARA NOTA PRIORIDAD MAXIMA:

Cambios en la base de datos:

1. Se añade la columna vistas a la tabla videojuegos.

2. Creación de la tabla votos en la cual se lleva el registro de likes 
habiendo como par de clave primarias titulo_clave, nombre_usuario, estas son además 
claves foraneas con update / delete on cascade.
El usuario solo puede votar una vez el mismo videojuego, este puedo votar su propio videojuego si así lo desea (Como en la mayoria de redes sociales).

Dispondra de las columnas: titulo_clave, nombre_usuario, voto (String LIKE/DISLIKE).
///////////////////

3. Crear vista de estadísticas para ver visualizaciones de nuestros videojuegos.

4. Añadir a la vista de detalles de videojuegos la posibilidad de indicar
si nos gusta o no. esto se enviara mediante petición ajax.

6. Reforzar validación de password en backend.

IMPORTANTE ITERAR EN ORDEN DE MENOR A MAYOR DIFICULTAD AGREGANDO FEATURES.

/////// TESTING

1. Comprobar que las cookies que esten caducadas no son utilizables. 

