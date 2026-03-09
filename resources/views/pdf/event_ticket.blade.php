<div style="border:2px dashed #000;padding:30px;text-align:center">
<h2>{{ $participant->event->title }}</h2>
<p>{{ $participant->event->date }}</p>

<img src="data:image/png;base64,{{ $participant->generateQrCodeBase64() }}" width="200">

<p>{{ $participant->token }}</p>
</div>