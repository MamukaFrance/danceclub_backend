<h1>Edit Mon</h1>

<form method="POST" action="{{ route('mon.update', $item) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Title</label>
        <input type="text" name="title" value="{{ '{{' }} $item->title {{ '}}' }}">
    </div>

    <button type="submit">Update</button>
</form>
