<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeeCalculatorService;

class FeeCalculatorController extends Controller
{
    protected $svc;
    public function __construct(FeeCalculatorService $svc)
    {
        $this->svc = $svc;
    }

    public function countries()    { return response()->json($this->svc->getCountries()); }
    public function terms(Request $r){ return response()->json($this->svc->getTerms($r->all())); }
    // ...
    public function calculate(Request $r)
    {
        $data = $r->validate([
            'country_id'   => 'required|int',
            'term_year'    => 'required|int',
            // diğerleri…
        ]);

        $result = $this->svc->calculate($data);
        return response()->json($result);
    }
}
