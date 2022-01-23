<?php

namespace App\Widgets;

use App\Models\Member;
use App\Models\Sprint;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class SprintDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(): Factory|View|Application
    {
        $count = Sprint::all()->count();
        $string = trans_choice('Sprint', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-logbook',
            'title'  => "{$count} {$string}",
            'text'   => "You have {$count} {$string} in your database. Click on button below to view all sprint",
            'button' => [
                'text' => "View all Sprint",
                'link' => route('voyager.sprints.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/01.jpg'),
        ]));
    }
}
