<?php

namespace App\Services\Forum;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageService
{
    public function processImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }

            $image = $request->file('image');
            $imageName = time() . rand(0, 100) . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/');
            $image->move($imagePath, $imageName);
            $imageURL = '/images/' . $imageName;

            return $imageURL;
        }

        return null;
    }

    public function processUpdateImage(Request $request)
    {

        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }

            $oldImage = public_path($request->image);
            if (file_exists($oldImage) && !is_null($request->image)) {
                unlink($oldImage);
            }

            $image = $request->file('image');
            $imageName = time() . rand(0, 100) . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/');
            $image->move($imagePath, $imageName);
            $imageURL = '/images/' . $imageName;

            return $imageURL;
        }

        return null;
    }


}
