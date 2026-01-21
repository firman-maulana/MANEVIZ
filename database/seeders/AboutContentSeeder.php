<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
        AboutContent::create([
            'image' => null, // atau path gambar default
            'paragraph_1' => 'MANEVIZ Was Born In The Heart Of Malang, A City Known For Its Creative Spirit And Youthful Energy. Founded By A Vocational High School Student With A Fierce Desire To Build Something Meaningful, MANEVIZ Began As More Than Just A Fashion Project—It Was A Personal Mission. In A Time When Meets An Still Figuring Things Out, This Young Founder Chose To Take A Leap Into The World Of Fashion, Driven By A Simple Yet Powerful Belief: That Great Style And Authentic Expression Can Happen When Vision Meets Courage—Proof That Age Is No Barrier To Building A Legacy.',

            'paragraph_2' => 'Deeply Inspired By The Wild Worlds Of Anime, MANEVIZ Embodies Character Transformation Seen In Its Stories Into Every Design. We See Anime Not Just As Entertainment, But As An Art Form That Mirrors Real Life The Battles We Fight Within, The Identities We Try To Define, The Dreams We Chase. Our Clothing Becomes A Medium For That Same Transformation—Rich In Symbolism, Bold Graphic Language, And Emotional Resonance. Each Piece Is Crafted To Echo The Spirit Of Heroes Who Rise From Chaos, Who Embrace Their Flaws, And Who Refuse To Be Ordinary.',

            'paragraph_3' => 'But MANEVIZ Is Not Just About Design—It\'s About Expression. It\'s About Giving Gen-Z A Platform To Wear Their Stories, Their Emotions, Their Beliefs. Every Shirt Is More Than Fabric; It\'s A Statement. Every Hoodie Is More Than Warmth; It\'s An Armor Against A World That Often Feels Like Fashion And Feeling, Who Find Power In Standing Out Instead Of Fitting In. With Drops That Feel Raw And Real, MANEVIZ Isn\'t Interested In Trends—We\'re Here To Shape Culture, To Speak To Those Who Refuse To Whisper.',

            'paragraph_4' => 'As A Movement Born From A Bedroom In Malang And Driven By The Pulse Of Youth Culture, MANEVIZ Stands For All Who Believe In Starting Small But Dreaming Wide. We Are Here For The Creators, The Artists, The Makers, And The Believers. In Every Thread, There Is Intention. In Every Collection\'s A Narrative. And Behind It All, A Belief That Style Can Be Rebellion—And Clothing Can Carry The Soul.',

            'paragraph_5' => 'MANEVIZ — Born In Malang. Forged By Vision. Styled Through Chaos. Inspired By Anime. Created For Gen Z.',

            'is_active' => true,
        ]);
    }
}
