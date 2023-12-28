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
- composer install
- composer require doctrine/dbal
- composer require symfony/maker-bundle --dev
- composer require security
- composer require orm
- composer require form  validator twig-bundle
############################################################################################################################################################################################################################
############################################################################################################################################################################################################################
############################################################################################################################################################################################################################
############################################################################################################################################################################################################################
############################################################################################################################################################################################################################
############################################################################################################################################################################################################################


To run the application locally, you need to first clone the repository wherever you prefer. You can use the following command:
git clone -b EjercicioDigitalAxis https://github.com/GastonSabaj/DigitalAxisTest.git

Once the project is cloned, navigate to the DigitalAxisTest folder and execute the command "symfony server:start." This command will provide a URL "localhost:8000," which will be the project's domain.
For the database connection, you should access PostgreSQL and create the database as follows:
CREATE USER gaston WITH PASSWORD '123';

ALTER USER gaston WITH SUPERUSER;

CREATE DATABASE digitalAxisDatabase;

GRANT ALL PRIVILEGES ON DATABASE digitalAxisDatabase TO gaston;

Then run the command "php bin/console doctrine:schema:update --force" to create (although it is commonly used to update) the tables in the database.

To navigate through the pages, you must first log in. Therefore, the initial page to visit is: "localhost:8000/login." If you don't have a user created, you can click the "You don't have an account? register here!" button, which will take you to the page to register a new user.
Once the user is created, you will be redirected to the login page to finally log in to our application.
Finally, when inside the application, you will have a product listing page, where you can add products to the list ("Create a new product"), view the data ("Show"), edit the data ("Edit"), and delete the row. If desired, you can also log out of the application by redirecting to the login page.

Note: For security reasons, the project's pages are protected against unauthenticated users. Therefore, if attempting to access a route without prior login, it will redirect to a page indicating the need to log in.

Requirements:
- Symfony 5.5.1
- PHP 8.1.18

The following commands need to be executed:
- composer install
- composer require doctrine/dbal
- composer require symfony/maker-bundle --dev
- composer require security
- composer require orm
- composer require form validator twig-bundle


  
