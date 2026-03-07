<h2>Bonjour, {{ $participant->user->name }}</h2>
<p>Votre réservation pour l'événement "{{ $participant->event->title }}" a été annulée.</p>
<p>Voici les détails de votre réservation annulée :</p>
<ul>
    <li><strong>Événement :</strong> {{ $participant->event->title }}</li>
    <li><strong>Date :</strong> {{ $participant->event->date }}</li>
    <li>
        <strong>Heure :</strong>
        {{ $participant->event->start_time }} - {{ $participant->event->end_time }}
    </li>
</ul>
<p>Nous sommes désolés pour ce désagrément. Si vous avez des questions ou besoin de plus d'informations, n'hésitez pas à nous contacter.</p>
<p>Cordialement,</p>
<p>L'équipe de DanceClub</p>