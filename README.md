Para poder ejecutar la aplicación de manera local, primero hay que clonar el repositorio donde se desee. Se puede utilizar el comando:
git clone -b EjercicioDigitalAxis https://github.com/GastonSabaj/DigitalAxisTest.git

Una vez clonado el proyecto, se debe pararse sobre la carpeta de DigitalAxisTest, y ejecutar el comando "symfony server:start". Este mismo comando aportará una ruta "localhost:8000", el cual será el dominio del proyecto.
Para la conexión a la base de datos, se deberá entrar a PostgreSQL y crear la base de datos de la siguiente manera:
CREATE USER gaston WITH PASSWORD '123';

ALTER USER gaston WITH SUPERUSER;

CREATE DATABASE digitalAxisDatabase;

GRANT ALL PRIIVLEGES ON DATABASE digitalAxisDatabase TO gaston;

  Luego hay que tirar el comando "php bin/console doctrine:schema:update --force" para crear (aunque se suele usar para actualizar) las tablas en la base de datos.
  
  Para navegar por las páginas, primeramente se debe logear, por lo tanto la primera página al cual se debe dirigir es: "localhost:8000/login". En caso de no tener un usuario creado, se puede apretár el botón de "You don't have an account? register here!", y te llevará a la página para registrar un usuario nuevo.
  Una vez creado el usuario, se redirigá a la página de login para finalmente logear a nuestra aplicación.
  Finalmente al estar ya dentro de la aplicación, se tendrá una página de listado de productos, donde se podrán agregar productos al listado ("Create a new product"), ver los datos ("Show"), editar los datos ("Edit") y eliminar la fila. Si se desea, también se puede deslogear de la aplicación, redirigiéndose a la página de login.
  
Observaciones: por motivos de seguridad, las páginas propias del proyecto están protegidas ante los usuarios no autenticados, por lo tanto si se quiere acceder directamente a una ruta y no se logeó previamente el usuario, se redirigirá a una página como aviso de que se necesita logearse.
  

Requerimientos:
- Symfony 5.5.1
- PHP 8.1.18

Se requerirán ejecutar los siguientes comandos:
- composer require doctrine/dbal
- composer require symfony/maker-bundle --dev
- composer require security
- composer require orm
- composer require form  validator twig-bundle

  
