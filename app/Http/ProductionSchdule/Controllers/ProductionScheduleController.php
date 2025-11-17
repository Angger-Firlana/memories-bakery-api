<?php

namespace App\Http\ProductionSchedule\Controllers;

use App\Models\ProductionSchedule;
use App\Http\ProductionSchdule\Requests\PostProductionScheduleRequest;
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

    public function store(PostProductionScheduleRequest $request){
        //
        DB::beginTransaction();
        try {
            $schedule = ProductionSchedule::create([
                'branch_id' => $request->branch_id,
                'scheduled_date' => $request->scheduled_date,
                'status' => $request->status,
            ]);

            // Simpan detail jadwal produksi
            foreach ($request->details as $detail) {
                $schedule->details()->create([
                    'menu_id' => $detail['menu_id'],
                    'quantity' => $detail['quantity'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Production Schedule created successfully",
                'data' => $schedule
            ], 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Failed to create Production Schedule: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function update(PutProductionScheduleRequest $request, $id){
        //
        DB::beginTransaction();
        try{
            $schedule = ProductionSchedule::findOrFail($id);

            if ($request->has('branch_id')) {
                $schedule->branch_id = $request->branch_id;
            }
            if ($request->has('scheduled_date')) {
                $schedule->scheduled_date = $request->scheduled_date;
            }
            if ($request->has('status')) {
                $schedule->status = $request->status;
            }
            $schedule->save();

            // Update detail jadwal produksi jika ada
            if ($request->has('details')) {
                foreach ($request->details as $detail) {
                    if (isset($detail['id'])) {
                        // Update existing detail
                        $scheduleDetail = $schedule->details()->find($detail['id']);
                        if ($scheduleDetail) {
                            $scheduleDetail->menu_id = $detail['menu_id'];
                            $scheduleDetail->quantity = $detail['quantity'];
                            $scheduleDetail->save();
                        }
                    } else {
                        // Create new detail
                        $schedule->details()->create([
                            'menu_id' => $detail['menu_id'],
                            'quantity' => $detail['quantity'],
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Production Schedule updated successfully",
                'data' => $schedule
            ]);
        }catch(\Exception $ex){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Failed to update Production Schedule: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function destroy($id){
        //
        try {
            $schedule = ProductionSchedule::findOrFail($id);
            $schedule->delete();
            return response()->json([
                'success' => true,
                'message' => "Production Schedule deleted successfully"
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete Production Schedule: {$ex->getMessage()}"
            ], 500);
        }
    }
}
