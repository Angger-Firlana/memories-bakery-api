<?php

namespace App\Http\ProductionSchedule\Controllers;

use App\Models\ProductionSchedule;
use App\Http\ProductionSchedule\Requests\PostProductionScheduleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductionScheduleDetail;
use App\Http\ProductionSchedule\Requests\PutProductionScheduleRequest;
use Illuminate\Support\Facades\DB;

class ProductionScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = ProductionSchedule::with('production_schedule_details.menu');

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $schedules->whereBetween('scheduled_date', [
                $request->date_from,
                $request->date_to
            ]);
        }

        if ($request->filled('status')) {
            $schedules->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $schedules->where('branch_id', $request->branch_id);
        }

        $schedules = $schedules->paginate(
            $request->input('pagination', 10),
            ['*'],
            'page',
            $request->input('page', 1)
        );

        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'meta' => [
                'current_page' => $schedules->currentPage(),
                'per_page' => $schedules->perPage(),
                'total' => $schedules->total(),
                'last_page' => $schedules->lastPage(),
                'from' => $schedules->firstItem(),
                'to' => $schedules->lastItem(),
            ],
            'filters' => [
                'date_from' => $request->date_from ?? null,
                'date_to' => $request->date_to ?? null,
                'status' => $request->status ?? null,
                'branch_id' => $request->branch_id ?? null,
            ],
            'data' => $schedules->items(),
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
                'schedule_date' => $request->schedule_date,
                'status' => $request->status,
                'manager_id' => $request->manager_id,
            ]);

            // Simpan detail jadwal produksi
            foreach ($request->details as $detail) {
                $schedule->production_schedule_details()->create([
                    'production_schedule_id' => $schedule->id,
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

    public function updateStatus($id, Request $request){
        try{
            $schedule = ProductionSchedule::findOrFail($id);
            $schedule->status = $request->status;
            $schedule->save();

            return response()->json([
                'success' => true,
                'message' => "Production Schedule status updated successfully",
                'data' => $schedule
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Error updating status: " . $e->getMessage()
            ], 500);
        }
    }

    public function updateDetailStatus($id, Request $request){
        //
        try{
            $detail = ProductionScheduleDetail::findOrFail($id);
            $detail->status = $request->status;
            $detail->save();

            return response()->json([
                'success' => true,
                'message' => "Production Schedule detail status updated successfully",
                'data' => $detail
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Error updating detail status: " . $e->getMessage()
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
            if ($request->has('schedule_date')) {
                $schedule->schedule_date = $request->schedule_date;
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
                        $scheduleDetail = $schedule->production_schedule_details()->find($detail['id']);
                        if ($scheduleDetail) {
                            $scheduleDetail->menu_id = $detail['menu_id'];
                            $scheduleDetail->quantity = $detail['quantity'];
                            $scheduleDetail->save();
                        }
                    } else {
                        // Create new detail
                        $schedule->production_schedule_details()->create([
                            'production_schedule_id' => $schedule->id,
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
