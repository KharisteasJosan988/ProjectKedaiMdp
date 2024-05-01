<form action="{{ route('upload.proses') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Unggah</button>
</form>
