<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;

class DashboardGeneral {
    protected $month;

    function __construct($month) {
        $this->month = $month;
    }

    public function users() {
        $users = User::withTrashed()->get();
        
        $activeUsers = 0;
        $inactiveUsers = 0;

        foreach ($users as $key => $user) {
            if ($user->deleted_at) {
                $inactiveUsers++;
            } else {
                $activeUsers++;
            }
        }

        return [
            'activeUsers' => $activeUsers, 'inactiveUsers' => $inactiveUsers
        ];
    }

    public function countCategories() {
        $categories = Category::count();
        $subCategories = SubCategory::count();

        return [
            'categories' => $categories, 'subCategories' => $subCategories
        ];
    }

    public function movementsForDays() {
        $rows = DB::table('movements')
            ->join('sub_categories', 'movements.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->where('movements.date', 'LIKE', '%'.$this->month.'%')
            ->select('categories.id', 'categories.name', DB::raw('dayofweek(movements.date) as day, count(*) as count'))
            ->groupBy('categories.id', 'categories.name', DB::raw('dayofweek(movements.date)'))
            ->get();

        $days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

        $seriesForDay = [];
        $labelForDay = $days;

        // Cantidad por categorias
        $seriesCategories = [];
        $labelsCategories = [];
        foreach ($rows as $key => $row) {
            $seriesForDay[$row->id]['name'] = $row->name;
            $seriesForDay[$row->id]['data'][] = $row->count;

            if (array_key_exists($row->id, $seriesCategories)) {
                $seriesCategories[$row->id] += $row->count;
            } else {
                $seriesCategories[$row->id] = $row->count;
            }

            $labelsCategories[$row->id] = $row->name;
        }
        
        $movements = [
            'series' => array_values($seriesForDay),
            'chart' => [
                'type' => 'bar',
                'width' => '100%',
                'height' => '150%'
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'endingShape' => 'rounded'
                ]
            ],
            'dataLabels' => [
                'enabled' => false
            ],
            'stroke' => [
                'show' => true,
                'width' => 2,
                'colors' => ['transparent']
            ],
            'xaxis' => [
                'categories' => $labelForDay
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Movimientos'
                ]
            ],
            'fill' => [
                'opacity' => 1
            ]
        ];

        $detailsCategories = [
            'series' => array_values($seriesCategories),
            'chart' => [
                'type' => 'pie'
            ],
            'labels' => array_values($labelsCategories),
            'dataLabels' => [
                'offset' => 0,
                'minAngleToShowLabel' => 10
            ]
        ];
        
        return ['movements' => $movements, 'detailsCategories' => $detailsCategories];
    }

    // Usuarios con mas movimientos
    public function userMovements() {
        $rows = DB::table('users')
            ->join('movements', 'users.id', '=', 'movements.user_id')
            // ->join('sub_categories', 'movements.sub_category_id', '=', 'sub_categories.id')
            // ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->where('movements.date', 'LIKE', '%'.$this->month.'%')
            ->select('users.id', 'users.name', DB::raw('count(movements.id) AS countMovements'))
            ->groupBy('users.id', 'users.name')
            ->orderBy(DB::raw('count(movements.id)'), 'DESC')
            // ->limit(10)
            ->get();

        $series = [];
        $series[0]['name'] = 'Movimientos';
        
        $categories = [];
        foreach ($rows as $key => $row) {
            $series[0]['data'][] = $row->countMovements;

            $categories[] = $row->name;
        }
        
        $options = [
            'series' => array_values($series),
            'chart' => [
                'type' => 'bar',
                'height' => 350,
                'stacked' => true,
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 4,
                    'horizontal' => true,
                ],
            ],
            'dataLabels' => [
                'enabled' => false
            ],
            'xaxis' => [
                'categories' => array_values($categories),
            ]
        ];

        return $options;
    }
}