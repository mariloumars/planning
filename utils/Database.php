<?php
// classes/Database.php

class Database
{
  private $host;
  private $db_name;
  private $username;
  private $password;
  private $conn;

  // Constructeur pour initialiser les informations d'identification de la base de données à partir du fichier database.init
  public function __construct()
  {
    $config = parse_ini_file('database.init', true);
    $this->host = $config['database']['host'];
    $this->db_name = $config['database']['db_name'];
    $this->username = $config['database']['username'];
    $this->password = $config['database']['password'];
  }

  // Méthode pour obtenir la connexion à la base de données
  public function getConnection()
  {
    if ($this->conn === null) {
      try {
        // Crée une nouvelle instance PDO pour PostgreSQL
        $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

        // Définit le mode d'erreur sur exception pour une meilleure gestion des erreurs
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Définit l'encodage des caractères sur UTF-8
        $this->conn->exec("SET NAMES 'utf8'");
      } catch (PDOException $exception) {
        // Enregistre le message d'erreur à des fins de débogage
        error_log("Erreur de connexion : " . $exception->getMessage());

        // Lance une exception générique pour éviter d'exposer des informations sensibles
        throw new Exception("Impossible de se connecter à la base de données.");
      }
    }

    return $this->conn;
  }

  // Méthode pour fermer la connexion à la base de données
  public function closeConnection()
  {
    $this->conn = null;
  }
}