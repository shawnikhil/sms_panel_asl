<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SenderId;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    protected function render(string $view, array $data = [])
    {
        return view($view, array_merge([
            'user' => Auth::user(),
        ], $data));
    }

    public function senderId(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = SenderId::with('user')->orderBy('id', 'desc');

                if ($request->filled('reg_no')) {
                    $regNo = $request->reg_no;
                    $query->where(function($q) use ($regNo) {
                        $q->where('user_id', 'like', '%' . $regNo . '%')
                          ->orWhereHas('user', function($uq) use ($regNo) {
                              $uq->where('regno', 'like', '%' . $regNo . '%');
                          });
                    });
                }

                if ($request->filled('user_name')) {
                    $userName = $request->user_name;
                    $query->whereHas('user', function($q) use ($userName) {
                        $q->where('fname', 'like', '%' . $userName . '%')
                          ->orWhere('lname', 'like', '%' . $userName . '%');
                    });
                }

                if ($request->filled('sender_id')) {
                    $query->where('sender_id', 'like', '%' . $request->sender_id . '%');
                }

                if ($request->filled('entity_id')) {
                    $query->where('entity_id', 'like', '%' . $request->entity_id . '%');
                }

                if ($request->filled('from_date')) {
                    $query->whereDate('entry_date', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $query->whereDate('entry_date', '<=', $request->to_date);
                }

                $perPage = 10;
                $paginated = $query->paginate($perPage);

                return response()->json([
                    'status' => 'success',
                    'data' => $paginated->items(),
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                    'from' => $paginated->firstItem() ?? 0,
                    'to' => $paginated->lastItem() ?? 0,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => [],
                    'total' => 0,
                ], 500);
            }
        }

        return $this->render('admin.pages.manage.manage-sender-id');
    }

    public function updateSenderStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);

        try {
            $sender = SenderId::find($request->id);
            if ($sender) {
                $statusInput = strtolower(trim((string)$request->status));
                if ($statusInput === 'approved' || $statusInput === '1' || $statusInput === 'active') {
                    $sender->status = 1;
                } elseif ($statusInput === 'rejected' || $statusInput === '2' || $statusInput === 'inactive') {
                    $sender->status = 2;
                } else {
                    $sender->status = 0;
                }

                if ($request->has('remarks')) {
                    $sender->modified_mesg = $request->remarks;
                }
                $sender->modified_date = Carbon::now()->format('Y-m-d');
                $sender->modified_time = Carbon::now()->format('H:i:s');
                $sender->update_date = Carbon::now()->format('Y-m-d H:i:s');
                $sender->update_user = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';
                $sender->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Sender ID status updated successfully!',
                    'data' => $sender
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Sender ID record not found!'
        ], 404);
    }

    public function template()
    {
        return $this->render('admin.pages.manage.manage-template');
    }
}
