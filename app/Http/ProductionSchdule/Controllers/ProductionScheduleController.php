<?php

namespace App\Http\ProductionSchedule\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionScheduleController extends Controller
{
    //
    public function index(Request $request){
        //

        $schedules = ProductionSchedule::query();

        if($request->has('date_from') && $request->has('date_to')){
            $schedules->whereBetween('scheduled_date', [$request->date_from, $request->date_to]);
        }

        if($request->has('status')){
            $schedules->where('status', $request->status);
        }

        if($request->has('branch_id')){
            $schedules->where('branch_id', $request->branch_id);
        }
        $schedules = $schedules->paginate(
            $perpage = $request->input('pagination', 10), 
            ['*'], 
            'page', $page = $request->input('page', 1)
        );
        $schedules = $schedules->orderBy('scheduled_date', 'desc')->get();
        return response ->json([
            'success' => true,
            'message' => "Success received data",
            'data' => $schedules
        ]);
    }

    public function show($id){
        try {
            $schedule = ProductionSchedule::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => "Success received data",
                'data' => $schedule
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Production Schedule not found: {$ex->getMessage()}"
            ], 404);
        }
    }

}
