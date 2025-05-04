<?php
// add_event.php

require_once 'utils/Database.php';
require_once 'classes/Event.php';

$database = new Database();
$db = $database->getConnection();

$event = new Event($db);

if ($_POST) {
  $event->title = $_POST['title'];
  $event->description = $_POST['description'];
  $event->start_time = $_POST['start_time'];
  $event->end_time = $_POST['end_time'];
  $event->day = $_POST['day'];
  $event->date = $_POST['date'];

  if ($event->create()) {
    header("Location: index.php");
  } else {
    echo "Erreur lors de la création de l'événement.";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un événement</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans m-0 p-0">
  <?php include 'includes/header.php'; ?>
  <h1 class="text-2xl font-bold mb-4">Ajouter un événement</h1>
  <form method="post" class="space-y-4">
    <div>
      <label for="title" class="block text-sm font-medium text-gray-700">Titre:</label>
      <input type="text" name="title" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
      <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
      <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
    </div>
    <div>
      <label for="start_time" class="block text-sm font-medium text-gray-700">Heure de début:</label>
      <input type="time" name="start_time" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
      <label for="end_time" class="block text-sm font-medium text-gray-700">Heure de fin:</label>
      <input type="time" name="end_time" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
      <label for="day" class="block text-sm font-medium text-gray-700">Jour:</label>
      <select name="day" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="Lundi">Lundi</option>
        <option value="Mardi">Mardi</option>
        <option value="Mercredi">Mercredi</option>
        <option value="Jeudi">Jeudi</option>
        <option value="Vendredi">Vendredi</option>
        <option value="Samedi">Samedi</option>
        <option value="Dimanche">Dimanche</option>
      </select>
    </div>
    <div>
      <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
      <input type="date" name="date" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ajouter</button>
  </form>
  <?php include 'includes/footer.php'; ?>
</body>
</html>
