<h1>Create Mon</h1>

<form method="POST" action="{{ route('mon.store') }}">
    @csrf

    <div>
        <label>Title</label>
        <input type="text" name="title">
    </div>

    <button type="submit">Save</button>
</form>
