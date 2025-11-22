@extends('layouts.app2')

@section('content')

<style>
    /* Reset dan Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: white;
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        text-align: left;
        margin-bottom: 30px;
        margin-top: 75px;
        margin-left: 25px;
    }

    .header h3 {
        font-size: 2.0em;
        font-weight: bold;
        color: black;
        margin-bottom: 20px;
    }

    .content-wrapper {
        display: flex;
        gap: 40px;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .logo-section {
        flex: 0 0 350px;
        padding: 40px 20px;
        text-align: center;
        min-height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .logo-container {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-image {
        width: 100%;
        max-width: 400px;
        height: auto;
        object-fit: contain;
    }

    .text-section {
        flex: 1;
        padding-left: 20px;
    }

    .text-content {
        font-size: 0.95em;
        text-align: justify;
        margin-bottom: 20px;
        color: #444;
    }

    .text-content p {
        margin-bottom: 15px;
    }

    .highlight {
        font-weight: bold;
        color: #000;
    }

    .additional-content {
        margin-top: 20px;
    }

    .additional-content p {
        margin-bottom: 15px;
        font-size: 0.95em;
        color: #444;
        text-align: justify;
    }

    .footer-text {
        margin-top: 30px;
        font-style: italic;
        color: #666;
        font-size: 0.9em;
    }

    /* Large Desktop */
    @media (max-width: 1400px) {
        .container {
            max-width: 1100px;
            padding: 20px 15px;
        }
    }

    /* Desktop */
    @media (max-width: 1200px) {
        .container {
            max-width: 1000px;
            padding: 20px 15px;
        }

        .content-wrapper {
            gap: 35px;
        }

        .logo-section {
            flex: 0 0 320px;
        }

        .logo-image {
            max-width: 350px;
        }
    }

    /* Large Tablet */
    @media (max-width: 1024px) {
        .container {
            padding: 20px 15px;
        }

        .content-wrapper {
            gap: 30px;
        }

        .logo-section {
            flex: 0 0 300px;
            padding: 30px 15px;
        }

        .logo-image {
            max-width: 320px;
        }

        .header h3 {
            font-size: 1.7em;
        }

        .text-content,
        .additional-content p {
            font-size: 0.92em;
        }
    }

    /* Medium Tablet */
    @media (max-width: 900px) {
        .container {
            padding: 18px 12px;
        }

        .content-wrapper {
            gap: 25px;
        }

        .logo-section {
            flex: 0 0 280px;
            padding: 25px 12px;
            min-height: 280px;
        }

        .logo-image {
            max-width: 300px;
        }

        .header h3 {
            font-size: 1.6em;
        }

        .text-content,
        .additional-content p {
            font-size: 0.9em;
        }
    }

    /* Small Tablet / Large Mobile */
    @media (max-width: 768px) {
        .container {
            padding: 15px 10px;
        }

        .content-wrapper {
            flex-direction: column;
            gap: 20px;
        }

        .logo-section {
            flex: none;
            width: 100%;
            margin-bottom: 20px;
            padding: 20px 10px;
            min-height: 250px;
        }

        .logo-image {
            max-width: 280px;
        }

        .text-section {
            padding-left: 0;
            width: 100%;
        }

        .header {
            margin-top: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .header h3 {
            font-size: 1.5em;
        }

        .text-content,
        .additional-content p {
            font-size: 0.9em;
            text-align: left;
            line-height: 1.7;
        }

        .additional-content {
            margin-top: 15px;
        }
    }

    /* Medium Mobile */
    @media (max-width: 640px) {
        .container {
            padding: 12px 8px;
        }

        .header h3 {
            font-size: 1.3em;
            margin-bottom: 15px;
        }

        .logo-section {
            padding: 18px 8px;
            min-height: 220px;
        }

        .logo-image {
            max-width: 260px;
        }

        .text-content,
        .additional-content p {
            font-size: 0.88em;
            margin-bottom: 14px;
            line-height: 1.6;
        }

        .content-wrapper {
            gap: 18px;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .container {
            padding: 10px 8px;
        }

        .header h3 {
            font-size: 1.1em;
            margin-bottom: 15px;
        }

        .logo-section {
            padding: 15px 5px;
            min-height: 200px;
        }

        .logo-image {
            max-width: 240px;
        }

        .text-content,
        .additional-content p {
            font-size: 0.85em;
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .content-wrapper {
            gap: 15px;
        }

        .additional-content {
            margin-top: 12px;
        }
    }

    /* Extra Small Mobile */
    @media (max-width: 400px) {
        .container {
            padding: 8px 6px;
        }

        .header h3 {
            font-size: 0.9em;
            margin-bottom: 12px;
            margin-top: 90px;
        }

        .logo-section {
            padding: 12px 4px;
            min-height: 180px;
        }

        .logo-image {
            max-width: 220px;
        }

        .text-content,
        .additional-content p {
            font-size: 0.82em;
            margin-bottom: 11px;
            line-height: 1.5;
        }

        .content-wrapper {
            gap: 12px;
        }
    }

    /* Very Small Mobile */
    @media (max-width: 320px) {
        .container {
            padding: 6px 4px;
        }

        .header h3 {
            font-size: 0.8em;
            margin-bottom: 10px;
        }

        .logo-section {
            padding: 10px 2px;
            min-height: 160px;
        }

        .logo-image {
            max-width: 200px;
        }

        .text-content,
        .additional-content p {
            font-size: 0.8em;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .content-wrapper {
            gap: 10px;
        }
    }

    /* Landscape Mobile */
    @media (max-height: 500px) and (orientation: landscape) {
        .container {
            padding: 10px 15px;
        }

        .header {
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .header h3 {
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        .content-wrapper {
            flex-direction: row;
            gap: 20px;
        }

        .logo-section {
            flex: 0 0 200px;
            min-height: 150px;
            padding: 10px 5px;
        }

        .logo-image {
            max-width: 180px;
        }

        .text-content,
        .additional-content p {
            font-size: 0.8em;
            line-height: 1.4;
        }
    }

    /* High DPI / Retina Displays */
    @media (-webkit-min-device-pixel-ratio: 2),
    (min-resolution: 192dpi) {

        .text-content,
        .additional-content p {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    }

    /* Print Styles */
    @media print {
        .container {
            max-width: none;
            padding: 0;
        }

        .content-wrapper {
            flex-direction: column;
            gap: 20px;
        }

        .logo-section {
            flex: none;
            width: 100%;
            padding: 20px 0;
        }

        .text-content,
        .additional-content p {
            font-size: 12pt;
            color: black;
        }
    }
</style>

<div class="container">
    <div class="header">
        <h3>About Us</h3>
    </div>

    @if($about)
    <div class="content-wrapper">
        <div class="logo-section">
            <div class="logo-container">
                @if($about->image)
                    <img src="{{ asset('storage/' . $about->image) }}" alt="MANEVIZ Logo" class="logo-image">
                @else
                    <img src="{{ asset('image/about.jpg') }}" alt="MANEVIZ Logo" class="logo-image">
                @endif
            </div>
        </div>

        <div class="text-section">
            <div class="text-content">
                @if($about->paragraph_1)
                    <p>{!! nl2br(e($about->paragraph_1)) !!}</p>
                @endif

                @if($about->paragraph_2)
                    <p>{!! nl2br(e($about->paragraph_2)) !!}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="additional-content">
        @if($about->paragraph_3)
            <p>{!! nl2br(e($about->paragraph_3)) !!}</p>
        @endif

        @if($about->paragraph_4)
            <p>{!! nl2br(e($about->paragraph_4)) !!}</p>
        @endif

        @if($about->paragraph_5)
            <p>{!! nl2br(e($about->paragraph_5)) !!}</p>
        @endif
    </div>
    @else
    <!-- Fallback jika belum ada data -->
    <div class="content-wrapper">
        <div class="logo-section">
            <div class="logo-container">
                <img src="{{ asset('image/about.jpg') }}" alt="MANEVIZ Logo" class="logo-image">
            </div>
        </div>

        <div class="text-section">
            <div class="text-content">
                <p><span class="highlight">MANEVIZ</span> Was Born In The Heart Of Malang, A City Known For Its Creative Spirit And Youthful Energy.</p>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
