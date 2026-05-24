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
            <svg class="logo-img" viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: white;">
                <path d="M6 24L55 6L33 41L28 27L6 24Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M28 27L55 6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
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