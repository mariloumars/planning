<?php
// classes/Calendar.php

class Calendar
{
  private $events;
  private $start_date;

  public function __construct($events, $start_date)
  {
    $this->events = $events;
    $this->start_date = $start_date;
  }

  public function display()
  {
    $first_day_of_month = date('N', strtotime($this->start_date)); // Jour de la semaine du premier jour du mois (1 = Lundi, 7 = Dimanche)
    $total_days_in_month = date('t', strtotime($this->start_date)); // Nombre total de jours dans le mois

    echo '<div class="calendar border border-gray-300">';
    echo '<div class="flex border-b border-gray-300 week">';
    echo '<div class="flex-1 p-2.5 font-bold text-center border-r border-gray-300 day-header">Lundi</div>';
    echo '<div class="flex-1 p-2.5 font-bold text-center border-r border-gray-300 day-header">Mardi</div>';
    echo '<div class="flex-1 p-2.5 font-bold text-center border-r border-gray-300 day-header">Mercredi</div>';
    echo '<div class="flex-1 p-2.5 font-bold text-center border-r border-gray-300 day-header">Jeudi</div>';
    echo '<div class="flex-1 p-2.5 font-bold text-center border-r border-gray-300 day-header">Vendredi</div>';
    echo '<div class="flex-1 p-2.5 font-bold text-center border-r border-gray-300 day-header">Samedi</div>';
    echo '<div class="flex-1 p-2.5 font-bold text-center day-header">Dimanche</div>';
    echo '</div>';

    // Ajouter des cellules vides pour les jours avant le premier jour du mois
    echo '<div class="flex week">';
    for ($i = 1; $i < $first_day_of_month; $i++) {
      echo '<div class="flex-1 p-2.5 border-r border-gray-300 min-h-[100px] day empty"></div>';
    }

    // Afficher les jours du mois
    for ($day = 1; $day <= $total_days_in_month; $day++) {
      $current_date = date('Y-m-d', strtotime($this->start_date . " +" . ($day - 1) . " days"));
      echo '<div class="flex-1 p-2.5 border-r border-gray-300 min-h-[100px] relative day" data-date="' . $current_date . '">';
      echo '<div class="font-bold mb-2.5 day-number">' . $day . '</div>';
      foreach ($this->events as $event) {
        if ($event['date'] == $current_date) {
          echo '<div class="bg-gray-200 p-1.5 mb-1.5 rounded cursor-grab event" data-event-id="' . $event['id'] . '">';
          echo '<h3 class="text-sm m-0">' . $event['title'] . '</h3>';
          echo '<p class="text-xs m-0">' . $event['description'] . '</p>';
          echo '<p class="text-xs m-0">' . $event['start_time'] . ' - ' . $event['end_time'] . '</p>';
          echo '<a href="edit_event.php?id=' . $event['id'] . '" class="text-blue-500 underline">Modifier</a> | ';
          echo '<a href="delete_event.php?id=' . $event['id'] . '" class="text-blue-500 underline">Supprimer</a>';
          echo '</div>';
        }
      }
      echo '</div>';

      // Passer à la ligne suivante après chaque dimanche
      if (($day + $first_day_of_month - 1) % 7 == 0) {
        echo '</div><div class="flex week">';
      }
    }

    // Ajouter des cellules vides pour les jours après le dernier jour du mois
    $last_day_of_month = date('N', strtotime($this->start_date . " +" . ($total_days_in_month - 1) . " days"));
    for ($i = $last_day_of_month; $i < 7; $i++) {
      echo '<div class="flex-1 p-2.5 border-r border-gray-300 min-h-[100px] day empty"></div>';
    }

    echo '</div>';
    echo '</div>';
  }
}
