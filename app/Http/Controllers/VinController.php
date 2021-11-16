<?php

namespace App\Http\Controllers;

use App\Contracts\VINRequestInterface;
use Illuminate\Http\Request;

class VinController extends Controller
{
    /**
     * @var VINRequestInterface
     */
    private $vinFetcher;

    public function __construct(VINRequestInterface $vinRequest)
    {
        $this->vinFetcher = $vinRequest;
    }

    public function search(Request $request)
    {
        $request->validate([
            'vin' => 'required|min:17|max:17',
        ]);
        $vinFound = $this->vinFetcher->retrieveVINFromStore($request->user(), $request->vin);
        $salvageFound = $this->vinFetcher->retrieveSalvageDataFromStore($request->user(), $request->vin);

        if ($vinFound['success']) {
            $data = [
                'specification' => $vinFound['data'],
                'salvage' => $salvageFound,
            ];

//            dd($data);
//            Cache Data
            return response()->json(['success' => true, 'message' => '', 'data' => $data], 200);
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'OTP notification failed , Try Again Later',
                    'description' => $vinFound['message'],
                    'data' => $vinFound['message'],
                ]
            );
        }
    }
}
