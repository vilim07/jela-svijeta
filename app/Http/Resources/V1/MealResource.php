<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\TagResource;
use App\Http\Resources\V1\IngredientResource;



class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = $request->query('lang');


        $translations = [
            'title' => $this->translate($locale)->title,
            'description' => $this->translate($locale)->description ///tu treba dobit jezik kao param
        ];

        $with = explode(',', $request->query('with'));
        $showColumns = [];

        // With check for extra data
        if ($with){
            if (in_array('category', $with)) {
                $showColumns['category'] = CategoryResource::make($this->category);
            }
            if (in_array('tags', $with)) { 
                $showColumns['tags'] = TagResource::collection($this->tags);
            }
            if (in_array('ingredients', $with)) { 
                $showColumns['ingredients'] = IngredientResource::collection($this->ingredients);
            }
        }

        //Status
        $status = 'created';

        if ($request->query('diff_time')) {
            if ($this->deleted_at) {
                $status = 'deleted';
            } else if ($this->updated_at) {
                $status = 'modified';
            }
        }



        return [
            'id' => $this->id,
            'status' => $status,
            ...$translations,
            ...$showColumns
        ];
    }
}
