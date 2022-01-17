<?php 

namespace App\Helper;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UiAvatar {
    public function avatar($name) {
        $response = Http::get('https://ui-avatars.com/api/?background=random&format=png&name='.$name);

        $img = $response->body();

        $pathAvatar = Str::random(40).'.png';
        Storage::disk('local')->put('public/'.$pathAvatar, $img);

        return $pathAvatar;
    }
}