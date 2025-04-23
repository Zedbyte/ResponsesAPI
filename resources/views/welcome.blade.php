<!DOCTYPE html>
<html>
<head>
    <title>OpenAI Document Evaluator</title>
</head>
<body>
    <h1>Upload a Document</h1>

    @if(session('result'))
        <h2>Evaluation Result:</h2>
        <pre>{{ session('result') }}</pre>
    @endif

    <form action="{{ route('openai.evaluate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="document">Choose an image or scanned page:</label>
        <input type="file" name="document" id="document" required>

        <br><br>
        <button type="submit">Evaluate Document</button>
    </form>
</body>
</html>
