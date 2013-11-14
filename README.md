# Taller de Slim PHP - Comunidad PHP Puebla

Una pequeña aclaración, el código en este repositorio está incompleto, no solo
porque falta implementar más de una operación sino porque los ejemplos omiten varias prácticas
básicas como [filtrar](http://mx.php.net/manual/es/ref.filter.php) y las entradas de los usuarios y
[escapar](http://php.net/manual/en/function.htmlspecialchars.php) las salidas, por ejemplo.

El servicio REST también está simplificado, no implementamos
[negociación de contenido](http://en.wikipedia.org/wiki/Content_negotiation), omitimos
los [códigos de respuesta HTTP](http://es.wikipedia.org/wiki/Anexo:C%C3%B3digos_de_estado_HTTP),
y no estamos utilizando ningún [formato de hipermedia](http://www.slideshare.net/hustwj/hypermedia-the-confusing-bit-from-rest).
Para más información puedes revisar el
[modelo de madurez de Richardson](http://martinfowler.com/articles/richardsonMaturityModel.html).

Para probar el ejemplo de este repositorio debes seguir los siguientes pasos:

1. Importar la base de datos (en la máquina virtual)

    `mysql -u root -p -D slimphp < sql/schema.sql`

2. Modificar el virtual host que actualmente apunta a `/var/www` para que apunte a la carpeta
`public` de tu proyecto (en la máquina virtual)

    ```apache
    <VirtualHost *:80>
      ServerName slimphp.dev

      ## Vhost docroot
      DocumentRoot /var/www/slimphpworkshop/public

      ## Directories, there should at least be a declaration for /var/www

      <Directory /var/www/slimphpworkshop/public>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        Allow from all
      </Directory>

      ## Logging
      ErrorLog /var/log/apache2/slimphp.dev_error.log
      LogLevel warn
      ServerSignature Off
      CustomLog /var/log/apache2/slimphp.dev_access.log combined

    </VirtualHost>
    ```

3. Instalar las dependencias con Composer (en la máquina virtual)

    `composer install`

4. Modificar tu archivo `/etc/hosts` (en tu máquina real)

    `192.168.56.101 slimphp.dev`

5. Verifica tu instalación (en tu máquina real)

    http://slimphp.dev
