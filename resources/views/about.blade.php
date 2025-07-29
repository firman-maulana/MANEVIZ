@extends('layouts.app2')

@section('content')

<style>
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
        padding: 40px 20px;
    }

    .header {
        text-align: left;
        margin-bottom: 15px;
        margin-top: 40px;
    }

    .header h1 {
        font-size: 2.5em;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
    }

    .content-wrapper {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .logo-section {
        flex: 0 0 350px;
        padding: 60px 40px;
        text-align: center;
        min-height: 400px;
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
        margin-left: -40px;
        margin-top: -50px;
    }

    .logo-image {
        width: 500px;
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

    .footer-text {
        margin-top: 30px;
        font-style: italic;
        color: #666;
        font-size: 0.9em;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            flex-direction: column;
        }

        .logo-section {
            flex: none;
            width: 100%;
            margin-bottom: 30px;
        }

        .text-section {
            padding-left: 0;
        }

        .header h1 {
            font-size: 1.5em;
        }
    }
</style>

<div class="container">
    <div class="header">
        <h1>About Us</h1>
    </div>

    <div class="content-wrapper">
        <div class="logo-section">
            <div class="logo-container">
                <img src="storage/image/about.jpg" alt="MANEVIZ Logo" class="logo-image">
                <!-- Ganti "path/to/your/maneviz-logo.png" dengan path gambar logo Anda -->
            </div>
        </div>

        <div class="text-section">
            <div class="text-content">
                <p><span class="highlight">MANEVIZ</span> Was Born In The Heart Of Malang, A City Known For Its Creative Spirit And Youthful Energy. Founded By A Vocational High School Student With A Fierce Desire To Build Something Meaningful, <span class="highlight">MANEVIZ</span> Began As More Than Just A Fashion Project—It Was A Personal Mission. In A Time When Meets An Still Figuring Things Out, This Young Founder Chose To Take A Leap Into The World Of Fashion, Driven By A Simple Yet Powerful Belief: That Great Style And Authentic Expression Can Happen When Vision Meets Courage—Proof That Age Is No Barrier To Building A Legacy.</p>

                <p>Deeply Inspired By The Wild Worlds Of Anime, <span class="highlight">MANEVIZ</span> Embodies Character Transformation Seen In Its Stories Into Every Design. We See Anime Not Just As Entertainment, But As An Art Form That Mirrors Real Life The Battles We Fight Within, The Identities We Try To Define, The Dreams We Chase. Our Clothing Becomes A Medium For That Same Transformation—Rich In Symbolism, Bold Graphic Language, And Emotional Resonance. Each Piece Is Crafted To Echo The Spirit Of Heroes Who Rise From Chaos, Who Embrace Their Flaws, And Who Refuse To Be Ordinary.</p>

            </div>

            <div class="text-content">
            </div>

            <div class="footer-text">
            </div>
        </div>
    </div>
    <p>But <span class="highlight">MANEVIZ</span> Is Not Just About Design—It's About Expression. It's About Giving Gen-Z A Platform To Wear Their Stories, Their Emotions, Their Beliefs. Every Shirt Is More Than Fabric; It's A Statement. Every Hoodie Is More Than Warmth; It's An Armor Against A World That Often Feels Like Fashion And Feeling, Who Find Power In Standing Out Instead Of Fitting In. With Drops That Feel Raw And Real, <span class="highlight">MANEVIZ</span> Isn't Interested In Trends—We're Here To Shape Culture, To Speak To Those Who Refuse To Whisper.</p><br>
    <p>As A Movement Born From A Bedroom In Malang And Driven By The Pulse Of Youth Culture, <span class="highlight">MANEVIZ</span> Stands For All Who Believe In Starting Small But Dreaming Wide. We Are Here For The Creators, The Artists, The Makers, And The Believers. In Every Thread, There Is Intention. In Every Collection's A Narrative. And Behind It All, A Belief That Style Can Be Rebellion—And Clothing Can Carry The Soul.</p><br>
    <p><span class="highlight">MANEVIZ</span> — Born In Malang. Forged By Vision. Styled Through Chaos. Inspired By Anime. Created For Gen Z.</p>


</div>

@endsection