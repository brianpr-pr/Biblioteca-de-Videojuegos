Listado de errores o cosas a mejorar:

1. Descubrir porque me sale que el estilo: esilo_index.css es inalcanzable.

4. Añadir javascript para mostrar si la contraseña cumple con la validación, si el titulo coincide con juegos que esten en la base de datos.

13. Eliminar output de añadir_videojuego.php en el footer.

///// PARTE IMPORTANTE QUE CUENTA PARA NOTA PRIORIDAD MAXIMA:

1. Añadir la columna vistas a la tabla videojuegos.

3. Crear vista de estadísticas para ver visualizaciones de nuestros videojuegos.

4. Hacer que la imagen de perfil se actualice y se muestre como icono arriba a la derecha.


IMPORTANTE ITERAR EN ORDEN DE MENOR A MAYOR DIFICULTAD AGREGANDO FEATURES.

/////// TESTING

1. Comprobar que las cookies que esten caducadas no son utilizables. 

Posibles bugs:

1. administrarVideojuegos.php en línea 69, puede que cause algún bug inesperado.


2. En inicio de sesión: 
Creación de cookie iniciada.
Fatal error: Uncaught TypeError: setRememberCookie(): Argument #1 ($token) must be of type string, null given, called in C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\inicio_sesion.php on line 87 and defined in C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\caracteristicas\cookies\manejo_tokens.php:63 Stack trace: #0 C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\inicio_sesion.php(87): setRememberCookie(NULL) #1 {main} thrown in C:\xampp\htdocs\servidor\Biblioteca-de-Videojuegos\caracteristicas\cookies\manejo_tokens.php on line 63