<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerOverviewRequest;
use App\Models\MatchStatParameter;
use App\Models\Player;
use App\Models\PlayerOverview;
use Illuminate\Http\Request;

class PlayerOverviewController extends Controller
{
    public function index(PlayerOverviewRequest $request)
    {
        $parameters = MatchStatParameter::all();

        if ($request->has('param_id')) {
            $currentParameter = $request->param_id;
        } else {
            $currentParameter = $parameters[0];
        }

        if ($request->has('param_id')) {
            $currentYear = $request->year;
        } else {
            $currentYear = intval(date("Y"));
        }

        // TODO: currently hardcoded, confirm with proctors if this is 
        // acceptable or mark it as technical debt.
        $years = range($currentYear, $currentYear - 20, -1);

        return view('player-overview/index', [
            'parameters' => $parameters,
            'years' => $years,
            'overviews' => Player::paginate(25)
        ]);
    }

    public function paginatedJson(PlayerOverviewRequest $request)
    {
        return Player::paginate(25);
    }
}
