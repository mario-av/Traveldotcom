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
        
        $field = $this->cleanField($request->field);
        $order = $this->cleanOrder($request->order);
        $q = $request->q;
        $category_id = $request->category_id;
        $active = true; 
        $priceMin = $this->cleanNumbers($request->priceMin);
        $priceMax = $this->cleanNumbers($request->priceMax);

        
        
        $query = Vacation::query()->with('category');

        
        $query->where('active', true);

        
        if ($priceMin != null) {
            $query->where('price', '>=', $priceMin);
        }
        if ($priceMax != null) {
            $query->where('price', '<=', $priceMax);
        }
        if ($category_id != null) {
            $query->where('category_id', '=', $category_id);
        }

        
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

        
        if (!$request->has('field')) {
            $query->orderBy('featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('title', 'asc');
        } else {
            $sortingField = $this->getOrderBy($field);
            $query->orderBy($sortingField, $order);
        }

        
        $vacations = $query->paginate(9)->withQueryString();

        
        
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
        $value = $array[0]; 
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
