<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 14/10/2021
 * Time: 10:22
 */

class Animaux
{
    // Variable de connexion à la bdd
    public $connection ="";
    // Tableau des valeurs retournées
    public $array =[];

    /**
     * Animaux constructor.
     * @link https://www.php.net/manual/fr/language.oop5.decon.php
     */
    function __construct() {
        // Connexion automatique à la base dans le constructeur
        $this->connectBdd();
        $this->createTable();
    }

    /**
     * Animaux destructor.
     * @link https://www.php.net/manual/fr/language.oop5.decon.php
     */
    function __destruct() {
        $this->closeConnexion();
    }

    /**
     * Méthode de connexion à la base de données
     * @link https://www.php.net/manual/fr/book.mysqli.php
     */
    function connectBdd(){
        // Variable de login à la bdd
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'animaux';
        // Création de la connexion
        $this->connection = new mysqli($servername, $username, $password, $dbname);
        // Vérification du bon fonctionnement de la connexion
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    function createTable(){
        $sql = "CREATE TABLE Animaux(
                        Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        Nom VARCHAR(30) NOT NULL,
                        Espece VARCHAR(30) NOT NULL,
                        Genre VARCHAR(30) NOT NULL)";

        $this->connection->query($sql);
    }

    /**
     * Sélection des 10 derniers animaux
     * @return array
     */
    function getDernierAnimaux(){
        // Requête SQL
        $sql = "SELECT Id, Nom, Espece, Genre FROM Animaux ORDER BY Id DESC LIMIT 10";
        // Exécution de la requête
        $result = $this->connection->query($sql);

        // Si il y a des résultat
        if ($result->num_rows > 0) {
            // On boucle pour créer un tableau de ligne
            while($row = $result->fetch_assoc()) {
                array_push($this->array,  "<td>{$row["Id"]}</td><td>{$row["Nom"]}</td><td>{$row["Espece"]}</td><td>{$row["Genre"]}</td>");
            }
            // Retour du tableau
            return $this->array;
        } else {
            // Retourne rien
            return [];
        }
    }

    /**
     * Sélection de tout les animaux
     * @return array
     */
    function getAnimaux(){
        //Même commentaire que la méthode du dessus
        $sql = "SELECT Id, Nom, Espece, Genre FROM Animaux";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($this->array,  "<td>{$row["Id"]}</td><td>{$row["Nom"]}</td><td>{$row["Espece"]}</td><td>{$row["Genre"]}</td>");
            }
            return $this->array;
        } else {
            return [];
        }
    }

    /**
     * Fermeture de la connexion à la base
     */
    function closeConnexion(){
        $this->connection->close();
    }

}
