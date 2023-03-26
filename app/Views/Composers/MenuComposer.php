<?php

namespace App\Views\Composers;

use App\Http\Controllers\Auth\RoleName;
use App\Models\Client;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuComposer {

    protected function genForContract(Contract $contract): iterable {
        $result = [
            'type' => 'submenu',
            'title' => $contract->getTitle(),
            'icon' => 'fa fa-lightbulb',
            'pattern' => ['pages.*'],
            'items' => [
                [
                    'title' => 'Общие сведения',
                    'link' => route('dashboard'),
                    'pattern' => ['dashboard'],
                ],
                [
                    'title' => 'Лицензии',
                    'link' => route('contracts.licenses.index', ['contract' => $contract->getKey()]),
                    'pattern' => ['dashboard'],
                ],
                [
                    'title' => 'Результаты',
                    'link' => route('pages.datatables'),
                    'pattern' => ['pages.datatables'],
                ],
                // [
                //     'title' => 'DataTables',
                //     'route' => 'pages.datatables',
                //     'pattern' => ['pages.datatables'],
                // ],
                // ['title' => 'Slick Slider', 'route' => 'pages.slick', 'pattern' => ['pages.slick']],
                // ['title' => 'Blank', 'route' => 'pages.blank', 'pattern' => ['pages.blank']],
            ],
        ];
        return $result;
    }
    protected function genForClient(Client $client): iterable {
        $result = [];
        $result[] = ['type' => 'heading', 'title' => $client->getTitle()];
        foreach ($client->contracts as $contract)
            $result[] = $this->genForContract($contract);

        return $result;
    }

    public function compose(View $view) {
        if (!Auth::check())
            return;
        $menu = [];
        $menu[] = ['type' => 'item', 'title' => 'Главная', 'icon' => 'fa fa-home', 'link' => route('dashboard'), 'pattern' => ['dashboard']];
        if (auth()->user()->hasRole(RoleName::ADMIN->value))
            foreach (Client::all()->sortBy('name') as $client)
                $menu = array_merge($menu, $this->genForClient($client));

        $menu[] = ['type' => 'heading', 'title' => 'More'];
        $menu[] = ['type' => 'item', 'title' => 'Landing', 'icon' => 'fa fa-globe', 'link' => route('home'), 'pattern' => ['home']];

        $view->with('menu', $menu);
    }
}