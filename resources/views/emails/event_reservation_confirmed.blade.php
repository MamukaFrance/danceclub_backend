<h2>Bonjour, {{ $participant->user->name }}</h2>
<p>Votre réservation pour l'événement "{{ $participant->event->title }}" a été confirmée.</p>
<p>Voici les détails de votre réservation :</p>
<ul>
    <li><strong>Événement :</strong> {{ $participant->event->title }}</li>
    <li><strong>Date :</strong> {{ $participant->event->date }}</li>
    <li>
        <strong>Heure :</strong>
        {{ $participant->event->start_time }} - {{ $participant->event->end_time }}
    </li>
</ul>
<p>Voici votre QR Code pour accéder à l'événement :</p>
<img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
<p>Présentez ce QR code à l'entrée de l'événement.</p>
<p>Code de réservation : {{ $participant->id }}</p>
<p>Nous avons hâte de vous voir à l'événement !</p>
<p>Si vous avez des questions ou besoin de plus d'informations, n'hésitez pas à nous contacter.</p>
<p>Cordialement,</p>
<p>L'équipe de DanceClub</p>