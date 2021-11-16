<?php namespace App\Repositories;

use App\Contracts\VINRequestInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Database Implementation Of Searching And Storing VIN
 */
class DbVINRequestRepository implements VINRequestInterface
{
    public function searchVin($code)
    {
        DB::beginTransaction();
        try {
            $param = http_build_query([
                'vin' => $code,
            ]);
            $url = env('VIN_DECODE_URL') . '?' . $param;
            $response = Http::withHeaders([
                'x-rapidapi-host' => env('VIN_HEADER_HOST_VALUE'),
                'x-rapidapi-key' => env('VIN_HEADER_HOST_KEY'),
            ])->get(
                $url,
            );

            if ($response->successful()) {
                $data = json_decode($response->body())->specification;
                $data = Cache::remember($code, 5000, function () use ($data) {
                    return $data;
                });
                $this->storeVIN($code);
                DB::commit();

                return ['success' => true, 'message' => json_decode($response->body())->success, 'data' => $data];
            } else {
                return ['success' => false, 'message' => json_decode($response->body())->success];
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            return ['success' => false, 'message' => $exception->getMessage()];
        }
        // TODO: Implement searchVin() method.
    }

    public function checkSalvageRecord($code)
    {
        DB::beginTransaction();
        try {
            $param = http_build_query([
                'vin' => $code,
            ]);
            $url = env('VIN_SALVAGE_URL') . '?' . $param;
            $response = Http::withHeaders([
                'x-rapidapi-host' => env('VIN_HEADER_HOST_VALUE'),
                'x-rapidapi-key' => env('VIN_HEADER_HOST_KEY'),
            ])->get(
                $url,
            );

            if ($response->successful()) {
                $success = json_decode($response->body())->success;
                if ($success) {
                    $reponseData = json_decode($response->body());
                    $data['is_salvage'] =  $reponseData->is_salvage ;
                    $data['info'] =  $reponseData->info ;
                }
                else {
                    $data['is_salvage'] =  false ;
                    $data['info'] =  null ;
                }
                    $data = Cache::remember($code . '-salvage', 5000, function () use ($data) {
                        return $data;
                    });
                    $this->storeVINSalvageRecord($code);
                    DB::commit();
                    return [
                        'success' => $success,
                        'message' => json_decode($response->body())->success,
                        'data' => $data,
                    ];
            } else {
                return ['success' => false, 'message' => json_decode($response->body())->message];
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            return ['success' => false, 'message' => $exception->getMessage()];
        }
        // TODO: Implement searchVin() method.
    }

    public function storeVIN($data)
    {
        // TODO: Implement DB storeVIN() method.
    }

    public function retrieveVINFromStore($user, $code)
    {
        if (Cache::has($code)) {
            $specData = Cache::get($code);
            if ($specData == null) {
                return $this->searchVin($code);
            }

            return ['success' => true, 'message' => '', 'data' => $specData];
        } else {
            return $this->searchVin($code);
        }
    }

    public function retrieveSalvageDataFromStore($user, $code)
    {
        if (Cache::has($code . '-salvage')) {
            $salvageData = Cache::get($code . '-salvage');
            if ($salvageData == null) {
                return $this->checkSalvageRecord($code);
            }
            return ['success' => true, 'message' => '', 'data' => $salvageData];
        } else {
            return $this->checkSalvageRecord($code);
        }
    }

    public function storeVINSalvageRecord($code)
    {
        // TODO: Implement DB storeVINSalvage() method.

    }
}











