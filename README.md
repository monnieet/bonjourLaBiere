# bonjourLaBiere

Displays a new picture of beer every day

______________________
1- Folder Architecture

./
  admin/
    crud/
      add.php
      delete.php
      edit.php
      read.php 
    affichageBdd.php
    approvingPage.php
    connectBdd.php
    deconnectBdd.php
    deconnexionAdmin.php
    
  css/
    aPropos.css
    home.css
    suggestion.css
    
  images/
    bieres/
      chouffe.jpg
      guinness.jpg
      hoegaarden.jpg
      leffe.jpg
    bar.jpg
    endPrecedent.png
    endSuivant.png
    precedent.png
    suivant.png
    
  polices/
    dayrom.eot
    dayrom.svg
    dayrom.ttf
    dayrom.woff
  
  aPropos.html
  home.php
  images_bieres.sql
  README.md
  suggestion.php
 
_____________________________________________
2- Set up for users using virtual wamp server

  - Technical stack & browser: Chrome, Html5, Css3, PHP 7.3.12, Apache 2.4.41, MySQL 8.0.1

  - Create a new virtual host 'bonjourlabiere' in wamp64/www/ and upload github project in it.
  
  - Create database (MySQL 8.0.18) in phpMyAdmin and import table:
    -> username: 'root', password: ''
    -> database name: 'bieres'
    -> import images_bieres.sql
  
  - Use a browser to access your localhost wamp server and go to 'bonjourlabiere' localhost.
  
  - Go to 'home.php'
  
!!! 'home.php' is not working without setting database !!!
  
_____________________________________________________
3- Information for those using another virtual server

  - Technical stack & browser: Chrome, Html5, Css3, PHP 7.3.12, Apache 2.4.41, MySQL 8.0.1
  
  - Connect database:
    -> create a database 'bieres'
    -> import images_bieres.sql into this database
    -> change connection information in file './admin/connectBdd.php' (username, password, database server (if not MySQL))
    
  - Use a browser and go to 'home.php' using your own virtual server.
  
!!! 'home.php' is not working without setting database !!!

____________________
4- Admin information

  - Credentials: login: 'admin'
                 password: 'lezard'
  
  - CRUD possibilities: create, read, update and delete operations on the database
  
  
