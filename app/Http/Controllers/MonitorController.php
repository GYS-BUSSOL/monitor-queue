<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function emptyCache(){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    // public function romanNumerals($number) {
    //     $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    //     $value = '';
    //     foreach ($map as $roman => $int) {
    //         while ($number >= $int) {
    //             $value .= $roman;
    //             $number -= $int;
    //         }
    //     }
    //     return $value;
    // }

    public function showMonitor() {
        $data = $this->monitor();
        return view('monitor', ['data' => $data]);
    }

    public function showWaiting() {
        $data['type'] = DB::select('SELECT * FROM v_queuing_scrap_type_all');
        $data['type2'] = DB::select('SELECT * FROM v_queuing_scrap_type');
        
        foreach ($data['type2'] as $item) {
            $item->loc = $this->getGangScrapType($item->type);
        }
        return view('waiting', ['data' => $data]);
    }

    public function monitor() {
        $query = DB::select('EXEC [dbo].[usp_QMGetQueuingMonitor]');
        $getData = $query[0];
        $queryQueueIn = DB::select('EXEC [dbo].[usp_QMGetListQueueIn]');

        $gang_next_queue = $getData->gang_next_queue ? sprintf('%03d', $getData->gang_next_queue) : "---";

        $active_gangs = DB::select('EXEC [dbo].[usp_QMGetActiveGang]');

        $applications = [];
        foreach ($active_gangs as $gang) {
            $id_gang = $gang->id_location;
            $location_name = $gang->location_name;
            $is_active = $gang->is_active;
            $reason = $gang->reason;
            $applications[] = [
                'name' => $location_name,
                'queue' => $getData->{'gang_' . $id_gang} ?? null,
                'grader' => $getData->{'gang_grader_' . $id_gang} ?? null,
                'status' => $getData->{'gang_' . $id_gang} ? 'enabled' : 'disabled',
                'durasi' => $getData->{'TotalTime_' . $id_gang} ?? null,
                'active_gang' => $is_active,
                'type' => $getData->{'gang_type_' . $id_gang} ?? null,
                'reason' => $reason,
            ];
        }

        $data = [
            'in_queue' => $getData->gang_inqueue,
            'complited' => $getData->gang_complited,
            'next_queue_number' => $gang_next_queue,
            'is_registed' => $getData->gang_isregisted,
            'in_progress' => $getData->gang_inprogress,
            'outstanding_trucks' =>  $getData->gang_outstanding,
            'dataIn' => $queryQueueIn,
            'applications' => $applications,
        ];

        return $data;
    }

    public function getGangScrapType($type) {
        $data= DB::select('EXEC [dbo].[usp_QMGetGangScrapType] ?', [$type]);
        $loc = $data[0]->location_name;
        return $loc;
    }

    public function toScrapYardList($truck_no) {
        $data = DB::select('EXEC [dbo].[usp_QMtoScrapYardList] ?', [$truck_no]);
        return $data;
    }

    public function getWaitingList($truck_no) {
        $data = DB::select('EXEC [dbo].[usp_QMGetWaitingList] ?', [$truck_no]);
        return $data;

    }

    public function waiting() {
        $this->emptyCache();
        $type = DB::select('SELECT * FROM v_queuing_scrap_type_all');
        $type2 = DB::select('SELECT * FROM v_queuing_scrap_type');
        $list = [];
        $list2 = [];

        foreach ($type2 as $item) {
            $list2[] = $this->toScrapYardList($item->truck_no);
        }

        foreach ($type as $item) {
            $list[] = $this->getWaitingList($item->truck_no);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved signature type data',
            'data' => [
                'list' => $list,
                'list2' => $list2,
            ],
        ], 200);

    }
}

