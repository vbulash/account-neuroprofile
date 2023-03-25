<?php

namespace App\Views\Composers;

use Illuminate\View\View;

class MenuComposer {
    public function compose(View $view) {
        $menu = [];
        $menu[] = ['type' => 'item', 'title' => 'Dashboard', 'icon' => 'fa fa-home', 'route' => 'dashboard', 'pattern' => ['dashboard']];
        $menu[] = ['type' => 'heading', 'title' => 'Общеобразовательная школа № 2 Якутск'];
        $menu[] = [
            'type' => 'submenu',
            'title' => 'Examples',
            'icon' => 'fa fa-lightbulb',
            'pattern' => ['pages.*'],
            'items' => [
                [
                    'title' => 'DataTables',
                    'route' => 'pages.datatables',
                    'pattern' => ['pages.datatables'],
                ],
                ['title' => 'Slick Slider', 'route' => 'pages.slick', 'pattern' => ['pages.slick']],
                ['title' => 'Blank', 'route' => 'pages.blank', 'pattern' => ['pages.blank']],
            ],
        ];
        $menu[] = ['type' => 'heading', 'title' => 'More'];
        $menu[] = ['type' => 'item', 'title' => 'Landing', 'icon' => 'fa fa-globe', 'route' => 'home', 'pattern' => ['home']];

        $view->with('menu', $menu);
    }
}
