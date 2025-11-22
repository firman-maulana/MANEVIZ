@extends('layouts.app2')

@section('content')

    <style>


        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            margin-top: 30px;
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

        .email-link {
            color: #0066cc;
            text-decoration: none;
        }

        .email-link:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }

        .highlight {
            font-weight: bold;
        }
    </style>
    <div class="container">
        <div class="header">
            <h1 class="title" id="page-title">REFUND POLICY</h1>
        </div>

        <div class="language-selector">
            <button class="lang-btn active" onclick="setLanguage('id')" id="btn-id">Bahasa Indonesia</button>
            <button class="lang-btn" onclick="setLanguage('en')" id="btn-en">English</button>
        </div>

        <!-- Indonesian Content -->
        <div id="content-id" class="language-content">
            @if(isset($policies['refund_policy']))
                @foreach($policies['refund_policy'] as $policy)
                    <div class="section">
                        <h2 class="section-title">{{ $policy->title_id }}</h2>
                        <div class="content">
                            @php
                                // Convert line breaks to paragraphs
                                $paragraphs = explode("\n\n", $policy->content_id);
                            @endphp
                            @foreach($paragraphs as $paragraph)
                                @if(trim($paragraph))
                                    <p>{{ $paragraph }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            @if(isset($policies['exchange_policy']))
                @foreach($policies['exchange_policy'] as $policy)
                    <div class="section">
                        <h2 class="section-title">{{ $policy->title_id }}</h2>
                        <div class="content">
                            @php
                                // Convert line breaks to paragraphs
                                $paragraphs = explode("\n\n", $policy->content_id);
                            @endphp
                            @foreach($paragraphs as $paragraph)
                                @if(trim($paragraph))
                                    <p>{{ $paragraph }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- English Content -->
        <div id="content-en" class="language-content hidden">
            @if(isset($policies['refund_policy']))
                @foreach($policies['refund_policy'] as $policy)
                    <div class="section">
                        <h2 class="section-title">{{ $policy->title_en }}</h2>
                        <div class="content">
                            @php
                                // Convert line breaks to paragraphs
                                $paragraphs = explode("\n\n", $policy->content_en);
                            @endphp
                            @foreach($paragraphs as $paragraph)
                                @if(trim($paragraph))
                                    <p>{{ $paragraph }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            @if(isset($policies['exchange_policy']))
                @foreach($policies['exchange_policy'] as $policy)
                    <div class="section">
                        <h2 class="section-title">{{ $policy->title_en }}</h2>
                        <div class="content">
                            @php
                                // Convert line breaks to paragraphs
                                $paragraphs = explode("\n\n", $policy->content_en);
                            @endphp
                            @foreach($paragraphs as $paragraph)
                                @if(trim($paragraph))
                                    <p>{{ $paragraph }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
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
                pageTitle.textContent = 'KEBIJAKAN PENGEMBALIAN';
                document.documentElement.lang = 'id';
            } else {
                pageTitle.textContent = 'REFUND POLICY';
                document.documentElement.lang = 'en';
            }
        }
    </script>
@endsection
