<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Http\Resources\V1\MealResource;
use App\Http\Resources\V1\MealCollection;
use App\Filters\V1\MealFilter;
use App\Http\Requests\V1\MealRequest;
class MealController extends Controller
{
    public function index(MealRequest $request)
    {

        $filter = new MealFilter();
        $queryItems = $filter->transform($request);
        $meals = Meal::query();

        $perPage = $request->query('per_page', 20);

        //Time
        $diffTime = $request->query('diff_time');
        if ($diffTime && $diffTime > 0) {
            $meals = $meals->withTrashed()->where('created_at', '>', now()->createFromTimestamp($diffTime));
        }

        //Category
        $categoryFilter = strtolower($request->query('category'));

        if ($categoryFilter === 'null') {
            $queryItems[] = ['category_id', '!=', null];
        } else if ($categoryFilter === '!null') {
            $queryItems[] = ['category_id', null];
        } else if ($categoryFilter) {
            $queryItems[] = ['category_id', '=', $categoryFilter];
        }

        //Tags
        $tagIds = $request->query('tags');

        if ($tagIds) {        
            foreach ($tagIds as $tagId) {
                $meals->whereHas('tags', function ($query) use ($tagId) {
                    $query->where('tag_id', $tagId);
                });
            }
        }
        
        $meals = $meals->where($queryItems)->paginate($perPage);
        $res = new MealCollection($meals);

        if (count($res) > 0) {
            return response()->json([
                'message' => 'success',
                'data' => $res
            ], 200);
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    public function show(Meal $meal)
    {
        return new MealResource($meal);
    }
}
