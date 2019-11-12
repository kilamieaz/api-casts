<?php

use App\Video;
use Illuminate\Database\Seeder;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $video = new Video();
        $video->name = 'ES2015 Arrow Functions';
        $video->description = "<p>ES2015 (aka ES6) has some great ways to make your code easier to write and understand. In this episode, we cover two different ways that you can make your code clearer by removing the 'function' keyword.</p>";
        $video->thumbnail = 'https://vue-screencasts.s3.us-east-2.amazonaws.com/images/video-thumbnails/Thumbnail+-+Arrow+Function.png';
        $video->video_url = "https://vue-screencasts.s3.us-east-2.amazonaws.com/video-files/38-+es2015-+functions+minus+'function'.mp4";
        $video->save();

        $video2 = new Video;
        $video2->name = 'ES2015 Template Strings';
        $video2->description = '<p>Template strings are an incredibly useful new feature in ES2015... and you can use them in your Ember apps today!</p><p> Here are 3 cool things that template strings enable. < /p>';
        $video2->thumbnail = 'https://vue-screencasts.s3.us-east-2.amazonaws.com/images/video-thumbnails/Thumbnail+-+Template+Strings.png';
        $video2->video_url = 'https://vue-screencasts.s3.us-east-2.amazonaws.com/video-files/42-+ES2015+template+strings.mp4';
        $video2->save();

        $video3 = new Video();
        $video3->name = 'ES2015 Modules';
        $video3->description = "<p>Before modules, javascript code loading was a mess. Now it's pretty amazing.</p><p>Learn about ES2015 modules and how they work together with ember-cli.</p>";
        $video3->thumbnail = 'https://vue-screencasts.s3.us-east-2.amazonaws.com/images/video-thumbnails/Thumbnail+-+ES2015+Modules.png';
        $video3->video_url = 'https://vue-screencasts.s3.us-east-2.amazonaws.com/video-files/EmberScreencast+62+-+ES2015+Modules+-+Import%2C+Export.mp4';
        $video3->save();
    }
}
