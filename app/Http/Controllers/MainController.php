<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * Display a listing of vacations with filters, sorting, and pagination.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // 1. CLEAN INPUTS
        $field = $this->cleanField($request->field);
        $order = $this->cleanOrder($request->order);
        $q = $request->q;
        $category_id = $request->category_id;
        $active = true; // Use active field instead of active() method
        $priceMin = $this->cleanNumbers($request->priceMin);
        $priceMax = $this->cleanNumbers($request->priceMax);

        // 2. BASE QUERY
        // Using with('category') for eager loading
        $query = Vacation::query()->with('category');

        // Show only active vacations (assuming there's an 'active' column as per migration)
        $query->where('active', true);

        // 3. CONDITIONAL FILTERS
        if ($priceMin != null) {
            $query->where('price', '>=', $priceMin);
        }
        if ($priceMax != null) {
            $query->where('price', '<=', $priceMax);
        }
        if ($category_id != null) {
            $query->where('category_id', '=', $category_id);
        }

        // 4. SEARCH (title, description, location, category name)
        if ($q != null) {
            $query->where(function ($sq) use ($q) {
                $sq->where('title', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhere('location', 'like', '%' . $q . '%')
                    ->orWhereHas('category', function ($catQ) use ($q) {
                        $catQ->where('name', 'like', '%' . $q . '%');
                    });
            });
        }

        // 5. SORTING
        if (!$request->has('field')) {
            $query->orderBy('featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('title', 'asc');
        } else {
            $sortingField = $this->getOrderBy($field);
            $query->orderBy($sortingField, $order);
        }

        // 6. PAGINATION
        $vacations = $query->paginate(9)->withQueryString();

        // 7. DATA FOR FILTERS
        // Pluck returns an array [id => name], using Category model
        $categories = Category::pluck('name', 'id')->all();

        return view('main.index', [
            'vacations' => $vacations,
            'field' => $field,
            'priceMin' => $priceMin,
            'categories' => $categories,
            'priceMax' => $priceMax,
            'category_id' => $category_id,
            'order' => $order,
            'q' => $q,
        ]);
    }

    private function getOrderBy($orderRequest): string
    {
        $array = [
            'recent' => 'created_at',
            'title' => 'title',
            'price' => 'price',
            'location' => 'location'
        ];
        // Default to created_at if key not found (though cleanField should handle valid keys)
        return $array[$orderRequest] ?? 'created_at';
    }

    private function cleanField($field): string
    {
        return $this->cleanInput($field, ['recent', 'title', 'price', 'location']);
    }

    private function cleanOrder($order): string
    {
        return $this->cleanInput($order, ['desc', 'asc']);
    }

    private function cleanInput($input, array $array): string
    {
        $value = $array[0]; // Default value
        if (in_array($input, $array)) {
            $value = $input;
        }
        return $value;
    }

    private function cleanNumbers($number): mixed
    {
        if (is_numeric($number)) {
            return $number;
        }
        return null;
    }
}
