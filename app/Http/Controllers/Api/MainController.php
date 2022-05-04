<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder[]
     */
    public function indexChartInformation(): array|\Illuminate\Database\Eloquent\Collection
    {
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect();

        $servicesInformation = Service::query()
            ->selectRaw('COUNT(created_at) as count, created_at')
            ->groupByRaw(DB::raw('Date(created_at)'))->get();

        $requirementInformation = Requirement::query()
            ->selectRaw('COUNT(created_at) as count, created_at')
            ->groupByRaw(DB::raw('Date(created_at)'))->get();

        $projectInformation = Project::query()
            ->selectRaw('COUNT(created_at) as count, created_at')
            ->groupByRaw(DB::raw('Date(created_at)'))->get();

        $productInformation = Product::query()
            ->selectRaw('COUNT(created_at) as count, created_at')
            ->groupByRaw(DB::raw('Date(created_at)'))->get();

        config()->set('database.connections.mysql.strict', true);
        DB::reconnect();

        return [
            'service' => $servicesInformation,
            'requirement' => $requirementInformation,
            'project' => $projectInformation,
            'product' => $productInformation
        ];
    }
}
