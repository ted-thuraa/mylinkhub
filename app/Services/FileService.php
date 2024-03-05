<?php

namespace App\Services;

use Image;

class FileService
{
    public function updateImage($model, $request)
    {
        $image = Image::make($request->file('image'));

         
<<<<<<< HEAD
        if (!empty($model->image)) {
            $currentImage = public_path() . $model->image;
=======
        if (!empty($model->icon)) {
            $currentImage = public_path() . $model->icon;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

            if (
                file_exists($currentImage)
                && $currentImage != public_path() . '/user-placeholder.png'
                && $currentImage != public_path() . '/link-placeholder.png'
            ) {
                unlink($currentImage);
            }
        }
        


        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $image->crop(
            $request->width,
            $request->height,
            $request->left,
            $request->top
        );

        $name = time() . '.' . $extension;
        $image->save(public_path() . '/files/' . $name);
<<<<<<< HEAD
        $model->image = '/files/' . $name;
=======
        $model->icon = '/files/' . $name;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

        return $model;
    }
    public function updatePageImage($model, $request)
    {
        $image = Image::make($request->file('image'));

        
<<<<<<< HEAD
            $currentImage = public_path() . $model->bioimage;

            if (!empty($model->bioimage)) {
                $currentImage = public_path() . $model->bioimage;
=======
            $currentImage = public_path() . $model->image;

            if (!empty($model->image)) {
                $currentImage = public_path() . $model->image;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    
                if (
                    file_exists($currentImage)
                    && $currentImage != public_path() . '/user-placeholder.png'
                    && $currentImage != public_path() . '/link-placeholder.png'
                ) {
                    unlink($currentImage);
                }
            }

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $image->crop(
            $request->width,
            $request->height,
            $request->left,
            $request->top
        );

        $name = time() . '.' . $extension;
        $image->save(public_path() . '/files/' . $name);
<<<<<<< HEAD
        $model->bioimage = '/files/' . $name;
=======
        $model->image = '/files/' . $name;

        return $model;
    }
    public function updateThumbnailImage($model, $request)
    {
        $image = Image::make($request->file('image'));

        
            $currentImage = public_path() . $model->thumbnailimage;

            if (!empty($model->thumbnailimage)) {
                $currentImage = public_path() . $model->thumbnailimage;
    
                if (
                    file_exists($currentImage)
                    
                ) {
                    unlink($currentImage);
                }
            }

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $image->crop(
            $request->width,
            $request->height,
            $request->left,
            $request->top
        );

        $name = time() . '.' . $extension;
        $image->save(public_path() . '/files/' . $name);
        $model->thumbnailimage = '/files/' . $name;

        return $model;
    }
    public function updateportfolioThumbnailImage($model, $request)
    {
        $image = Image::make($request->file('image'));

        
            $currentImage = public_path() . $model->portfolio_thumbnail;

            if (!empty($model->portfolio_thumbnail)) {
                $currentImage = public_path() . $model->portfolio_thumbnail;
    
                if (
                    file_exists($currentImage)
                    && $currentImage != public_path() . '/user-placeholder.png'
                    && $currentImage != public_path() . '/link-placeholder.png'
                ) {
                    unlink($currentImage);
                }
            }

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $image->crop(
            $request->width,
            $request->height,
            $request->left,
            $request->top
        );

        $name = time() . '.' . $extension;
        $image->save(public_path() . '/files/' . $name);
        $model->portfolio_thumbnail = '/files/' . $name;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

        return $model;
    }
}