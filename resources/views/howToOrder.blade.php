@extends('layouts.app2')

@section('content')

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        margin-top: 40px;
    }

    .header {
        border-bottom: 2px solid #333;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .language-selector {
        margin: 20px 0;
        display: flex;
        gap: 10px;
    }

    .lang-btn {
        padding: 8px 16px;
        border: 2px solid #333;
        background: white;
        color: #333;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .lang-btn.active {
        background: #333;
        color: white;
    }

    .lang-btn:hover {
        background: #555;
        color: white;
    }

    .section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
    }

    .content {
        font-size: 13px;
        color: #444;
        line-height: 1.8;
    }

    .content p {
        margin-bottom: 12px;
    }

    .hidden {
        display: none;
    }

    .highlight {
        font-weight: bold;
        text-transform: uppercase;
    }

    .step {
        margin-bottom: 12px;
    }
</style>
<div class="container">
    <div class="header">
        <h1 class="title" id="page-title">HOW TO ORDER</h1>
    </div>

    <div class="language-selector">
        <button class="lang-btn active" onclick="setLanguage('id')" id="btn-id">Bahasa Indonesia</button>
        <button class="lang-btn" onclick="setLanguage('en')" id="btn-en">English</button>
    </div>

    <!-- Indonesian Content -->
    <div id="content-id" class="language-content">
        <div class="section">
            <h2 class="section-title">CARA PEMESANAN</h2>
            <div class="content">
                @foreach($steps as $step)
                <div class="step">
                    <p>{!! $step->content_id !!}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- English Content -->
    <div id="content-en" class="language-content hidden">
        <div class="section">
            <h2 class="section-title">HOW TO ORDER</h2>
            <div class="content">
                @foreach($steps as $step)
                <div class="step">
                    <p>{!! $step->content_en !!}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function setLanguage(lang) {
        // Hide all language content
        const allContent = document.querySelectorAll('.language-content');
        allContent.forEach(content => content.classList.add('hidden'));

        // Show selected language content
        document.getElementById(`content-${lang}`).classList.remove('hidden');

        // Update active button
        const allButtons = document.querySelectorAll('.lang-btn');
        allButtons.forEach(btn => btn.classList.remove('active'));
        document.getElementById(`btn-${lang}`).classList.add('active');

        // Update page title
        const pageTitle = document.getElementById('page-title');
        if (lang === 'id') {
            pageTitle.textContent = 'CARA PEMESANAN';
            document.documentElement.lang = 'id';
        } else {
            pageTitle.textContent = 'HOW TO ORDER';
            document.documentElement.lang = 'en';
        }
    }
</script>
@endsection
