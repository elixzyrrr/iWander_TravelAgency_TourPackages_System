<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite('resources/css/loading.css')
</head>
<body>
    <div class="loading-container">
        <div class="logo-container">
            <svg class="logo-img" viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M30.5 0L61 47H0L30.5 0Z" fill="white" opacity="0.9"/>
                <path d="M30.5 10L50 40H11L30.5 10Z" fill="#237f87"/>
            </svg>
            <div class="logo-text">iWander</div>
        </div>
        <div class="spinner"></div>
        <div class="loading-text">
            Preparing your journey<span class="dots" id="dots"></span>
        </div>
    </div>
    @vite('resources/js/loading.js')
</body>
</html>