<h2>Réservation annulée</h2>
<p>Bonjour {{ $reservation->user->name }},</p>

<p>Votre réservation pour le cours suivant a bien été annulée :</p>

<ul>
    <li><strong>Cours :</strong> {{ $course->title }}</li>
    <li><strong>Date :</strong> {{ $course->date }}</li>
    <li><strong>Heure :</strong> {{ $course->start_time }} - {{ $course->end_time }}</li>
</ul>

<p>Merci pour votre visite.</p>
