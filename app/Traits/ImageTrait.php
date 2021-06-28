<?php


namespace App\Traits;


use Illuminate\Support\Facades\File;


trait ImageTrait {

     /**
     *  Store incoming photo
     * @var $photo
     * @var $folder
     *  @return photo
     */

     function saveImage($image,$folder){

        $file_extension = $image->getClientOriginalExtension();
        $file_name = time(). '.'.$file_extension;
        $image->move($folder,$file_name);

        return $file_name;

    }


    /**
     *  Delete Image
     *  @param  string $image
     *  @param string $image_folder
     *  @return void
     */
    function deleteImage($image,$image_folder){

        // Find the path for this image
        $image_path = public_path(). '/'.$image_folder.'/'.$image;

        // Delete image
        File::delete($image_path);
    }


}
