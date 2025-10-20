Listado de errores o cosas a mejorar:

1. Descubrir porque me sale que el estilo: esilo_index.css es inalcanzable.

4. Añadir javascript para mostrar si la contraseña cumple con la validación, si el titulo coincide con juegos que esten en la base de datos.

13. Eliminar output de añadir_videojuego.php en el footer.

///// PARTE IMPORTANTE QUE CUENTA PARA NOTA PRIORIDAD MAXIMA:

4. Hacer que cuando el usuario modifique la imagen de perfil se actualize automaticamente.

IMPORTANTE ITERAR EN ORDEN DE MENOR A MAYOR DIFICULTAD AGREGANDO FEATURES.

/////// TESTING


Comienzo de realización de pruebas:


Debemos mejorar nuestra aplicación web de una biblioteca online de libros, películas, videojuegos... (lo que prefieran). Debe tener las siguientes nuevas características:




1. Debe tener un registro mejorado, con foto de perfil opcional. En caso de no subirla que se ponga una por defecto. 
Falta que la foto de perfil se actualize automaticamente al editarla.



2. Debe haber un menú en la parte superior. Y arriba derecha la imagen de perfil, aquí tendremos el 'cerrar sesión' y enlace a editar perfil.
Falta probar que funcione correctamente.



3. Debemos crear una vista de estadísticas donde vemos las visualizaciones que tienen nuestros juegos.
Falta probar que funcione correctamente.


4. En la vista de detalles de los juegos tenemos algún elemento que nos permita indicar si nos gusta o no. Estos mandaran mediante AJAX el voto al servidor e indicará ahora la puntuación que tiene.
Falta probar que funcione correctamente.


5. Un mismo usuario no puede votar más de una vez a un juego.
Hecho.

6. Debe haber una barra de búsqueda de juegos con AJAX.
Falta añadir sugerencias. Falta probar que funcione correctamente.

7. (NUEVO) Debemos crear el check de recordar sesión en el login usando Cookies.
Falta probar que funcione correctamente.

Creación de cookie iniciada.
Fatal error: Uncaught TypeError: setRememberCookie(): Argument #1 ($token) must be of type string, null given, called in C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\inicio_sesion.php on line 87 and defined in C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\caracteristicas\cookies\manejo_tokens.php:63 Stack trace: #0 C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\inicio_sesion.php(87): setRememberCookie(NULL) #1 {main} thrown in C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\caracteristicas\cookies\manejo_tokens.php on line 63


7. 2. Comprobar que las cookies que esten caducadas no son utilizables. 


8. Añadir control de errores en todo.





Registro mejorado, foto de perfil.	
No hecho o no funciona
0 puntos
Mejorable
0.5 puntos
Correcto
1.5 puntos


Menú parte superior y editar perfil.	
No hecho o no funciona
0 puntos
Mejorable
0.5 puntos
Correcto
1.5 puntos


Recordar sesión (Cookies)	
No hecho o no funciona
0 puntos
Mejorable
0.5 puntos
Correcto
1.5 puntos


Vista estadísticas	
No hecho o no funciona
0 puntos
Mejorable
0.5 puntos
Correcto
1.5 puntos


Me gusta (AJAX)	
No hecho o no funciona
0 puntos
Mejorable
0.5 puntos
Correcto
1.5 puntos


Me gusta (AJAX) 1 user 1 voto	
No hecho o no funciona
0 puntos
Correcto
1.5 puntos


Barra de busqueda (AJAX)	
No hecho o no funciona
0 puntos
Mejorable
0.5 puntos
Correcto
1.5 puntos


Usabilidad	
La usabilidad de la aplicación es engorroso o poco práctico
0 puntos
La usabilidad es mejorable
0.5 puntos
La usabilidad es correcta
1.5 puntos


Control de errores	
No existe el control de errores
0 puntos
Existe el control de errores pero está incompleto
0.5 puntos
Está completo
1.5 puntos