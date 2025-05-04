<?php
// index.php

require_once 'utils/Database.php';
require_once 'classes/Event.php';
require_once 'classes/Calendar.php';

$database = new Database();
$db = $database->getConnection();

$event = new Event($db);

// Récupérer le mois courant
$current_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$start_date = date('Y-m-01', strtotime($current_month)); // Premier jour du mois
$end_date = date('Y-m-t', strtotime($current_month)); // Dernier jour du mois

// Récupérer les événements du mois
$stmt = $event->readByMonth($start_date, $end_date);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$calendar = new Calendar($events, $start_date);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planning Mensuel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .cursor-grab { cursor: grab; }
        .cursor-grabbing { cursor: grabbing; }
        .drop-target { background-color: #e0f7fa; }
    </style>
</head>
<body class="font-sans m-0 p-0">
    <?php include 'includes/header.php'; ?>
    <h1 class="text-2xl font-bold mb-4">Planning Mensuel</h1>

    <!-- Navigation entre les mois -->
    <div class="flex justify-between items-center mb-5">
        <a href="index.php?month=<?php echo date('Y-m', strtotime('-1 month', strtotime($current_month))); ?>" class="text-blue-500 font-bold no-underline hover:underline">Mois précédent</a>
        <span class="text-lg"><?php echo date('F Y', strtotime($current_month)); ?></span>
        <a href="index.php?month=<?php echo date('Y-m', strtotime('+1 month', strtotime($current_month))); ?>" class="text-blue-500 font-bold no-underline hover:underline">Mois suivant</a>
    </div>

    <a href="add_event.php" class="text-blue-500 underline">Ajouter un événement</a>
    <?php $calendar->display(); ?>
    <?php include 'includes/footer.php'; ?>

    <script>
        // Fonction pour gérer le drag and drop
        $(document).ready(function() {
            // Rendre les événements draggables
            $('.event').attr('draggable', true);

            // Événement de début de drag
            $('.event').on('dragstart', function(e) {
                e.originalEvent.dataTransfer.setData('text/plain', $(this).data('event-id'));
            });

            // Événement de drop
            $('.day').on('dragover', function(e) {
                e.preventDefault(); // Permettre le drop
            });

            $('.day').on('drop', function(e) {
                e.preventDefault();
                const eventId = e.originalEvent.dataTransfer.getData('text/plain');
                const newDate = $(this).data('date'); // Récupérer la nouvelle date

                // Envoyer une requête AJAX pour mettre à jour la date de l'événement
                $.ajax({
                    url: 'update_event_date.php',
                    method: 'POST',
                    data: {
                        event_id: eventId,
                        new_date: newDate
                    },
                    success: function(response) {
                        if (response === 'success') {
                            location.reload(); // Recharger la page pour afficher les changements
                        } else {
                            alert('Erreur lors de la mise à jour de l\'événement.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
