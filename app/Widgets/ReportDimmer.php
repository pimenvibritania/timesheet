<?php

namespace App\Widgets;

use App\Models\Member;
use App\Models\Report;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class ReportDimmer extends BaseDimmer
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
        $count = Report::all()->count();
        $string = trans_choice('Report', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-window-list',
            'title'  => "{$count} {$string}",
            'text'   => "You have {$count} {$string} in your database. Click on button below to view all report",
            'button' => [
                'text' => "View all Report",
                'link' => route('voyager.reports.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/03.jpg'),
        ]));
    }
}
