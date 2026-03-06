<h2>Réservation confirmée</h2>

<p>Bonjour {{ $reservation->user->name }},</p>

<p>Votre réservation pour le cours suivant est confirmée :</p>

<ul>
    <li><strong>Cours :</strong> {{ $course->title }}</li>
    <li><strong>Date :</strong> {{ $course->date }}</li>
    <li><strong>Heure :</strong> {{ $course->start_time }} - {{ $course->end_time }}</li>
</ul>

<p>Voici le QR Code pour accéder au cours :</p>
<img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
<p>Présentez ce QR code à l'entrée du cours.</p>

<p>Code de réservation : {{ $reservation->id }}</p>

<p>Merci pour votre réservation.</p>