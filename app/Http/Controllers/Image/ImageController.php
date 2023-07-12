<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use finfo;
class ImageController extends Controller {

        
    /**
     * phrases
     *
     * @param  mixed $request
     * @return void
     */
    public function phrases(Request $request) {
        $phrase     = $request->input('phrase');
        $background = $request->file('background');
        $avatar     = $request->file('avatar');

        $images = $this->createImages($phrase, $background, $avatar);

        return response()->json(['message' => 'Form data received successfully', 'images' => $images]);
    }
    
    /**
     * createImages
     *
     * @param  mixed $phrase
     * @param  mixed $background
     * @param  mixed $avatar
     * @return void
     */
    public function createImages($phrase, $background, $avatar) {
        $image1 = $this->image720($phrase, $background, $avatar);
        $image2 = $this->image1280($phrase, $background, $avatar);
        $image3 = $this->image1920($phrase, $background, $avatar);
        return ['image1' => $image1, 'image2' =>$image2, 'image3' =>$image3];
    }
    
    /**
     * image1920
     *
     * @param  mixed $phrase
     * @param  mixed $background
     * @param  mixed $avatar
     * @return void
     */
    private function image1920($phrase, $background, $avatar) {
        $filename    = '1920x1080.' . 'png';
        $background1 = Image::make($background)->resize(1920, 1080);
        $avatar1     = Image::make($avatar)->resize(540, 540);
        
        $background1->insert($avatar1, 'top-right');
        $background1->text($phrase, 50, 50, function ($font) {
            $font->file(public_path('font/Arial.ttf'));
            $font->size(70);
            $font->color('#fdf6e3');
            $font->align('left');
            $font->valign('top');
        });
        $background1->save("/tmp/". $filename);
        
        return $filename;
    }
    
    /**
     * image1280
     *
     * @param  mixed $phrase
     * @param  mixed $background
     * @param  mixed $avatar
     * @return void
     */
    private function image1280($phrase, $background, $avatar) {
        $filename    = '1280x720.' . 'png';
        $background1 = Image::make($background)->resize(1280, 720);
        $avatar1     = Image::make($avatar)->resize(360, 360);

        $background1->insert($avatar1, 'top-right');
        $background1->text($phrase, 50, 50, function ($font) {
            $font->file(public_path('font/Arial.ttf'));
            $font->size(50);
            $font->color('#fdf6e3');
            $font->align('left');
            $font->valign('top');
        });
        $background1->save("/tmp/". $filename);
        
        return $filename;
    }
    
    /**
     * image720
     *
     * @param  mixed $phrase
     * @param  mixed $background
     * @param  mixed $avatar
     * @return void
     */
    private function image720($phrase, $background, $avatar) {
        $filename    = '720x480.' . 'png';
        $background1 = Image::make($background)->resize(720, 480);
        $avatar1     = Image::make($avatar)->resize(260, 260);
       
        $background1->insert($avatar1, 'top-right');
        $background1->text($phrase, 50, 50, function ($font) {
            $font->file(public_path('font/Arial.ttf'));
            $font->size(30);
            $font->color('#fdf6e3');
            $font->align('left');
            $font->valign('top');
        });    
        $background1->save("/tmp/". $filename);
       
        return $filename;
    }
   
    /**
     * Obtener la imagen.
     *
     * Esta función imprime la imagen creada.
     *
     * @param int $filename nombre del archivo.
     */
    public function getImages(string $filename): void {
   
        $url = "/tmp/". $filename; // URL de la imagen que deseas mostrar

        // Obtener el contenido de la imagen
        $imageData = file_get_contents($url);

        $base64Image = base64_encode($imageData);
        echo '<img src="data:image/jpeg;base64,' . $base64Image . '">';
    }

}