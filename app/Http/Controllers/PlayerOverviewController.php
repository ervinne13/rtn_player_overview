<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerOverviewRequest;
use App\Models\MatchStatParameter;
use App\Models\Player;
use App\Models\PlayerOverview;

class PlayerOverviewController extends Controller
{
    public function index(PlayerOverviewRequest $request)
    {
        $parameters = MatchStatParameter::all();
        $filters = $this->getFiltersFromRequestOrDefault($request);

        // TODO: currently hardcoded to 20 years from now, confirm         
        // with proctors if this is  acceptable or mark it as technical debt.
        $currentYear = intval(date("Y"));
        $years = range($currentYear, $currentYear - 20, -1);

        return view('player-overview/index', [
            'parameters' => $parameters,
            'years' => $years,
            'filters' => $filters,
            'overviews' => PlayerOverview::whereParamId($filters['param_id'])
                ->whereMatchYear($filters['year'])
                ->orderBy('value', 'DESC')
                ->paginate(25)
        ]);
    }

    public function paginatedJson(PlayerOverviewRequest $request)
    {
        $filters = $this->getFiltersFromRequestOrDefault($request);
        return PlayerOverview::whereParamId($filters['param_id'])
            ->whereMatchYear($filters['year'])
            ->orderBy('value', 'DESC')
            ->paginate(25);
    }

    private function getFiltersFromRequestOrDefault(PlayerOverviewRequest $request)
    {
        $parameters = MatchStatParameter::first();
        if ($request->has('param_id')) {
            $currentParameter = $request->param_id;
        } else {
            $currentParameter = $parameters->id;
        }

        if ($request->has('param_id')) {
            $currentYear = $request->year;
        } else {
            $currentYear = intval(date("Y"));
        }

        return [
            'param_id' => $currentParameter,
            'year' => $currentYear
        ];
    }
}
