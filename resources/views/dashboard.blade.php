<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.location.href = "{{ route('index') }}";
        });
    </script>
</head>
<body>
    <p>Redirecting to home page...</p>
</body>
</html>
