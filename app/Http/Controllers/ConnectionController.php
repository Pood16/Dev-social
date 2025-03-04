<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    // send connection request
    public function sendRequest(User $user){

        // Check the connection
        $existingConnection = Connection::where(function($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })
            ->first();

        if ($existingConnection) {
            return response()->json([
                'success' => false,
                'message' => 'Connection request already exists'
            ]);
        }

        // Create new connection request
        $connection = Connection::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Connection request sent successfully',
            'connection' => $connection
        ]);
    }

    // accept connection request
    public function acceptRequest(Connection $connection){

        if ($connection->receiver_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $connection->update(['status' => 'accepted']);

        return response()->json([
            'success' => true,
            'message' => 'Connection request accepted',
            'connection' => $connection
        ]);
    }

    // reject connection
    public function rejectRequest(Connection $connection){

        if ($connection->receiver_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $connection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Connection request rejected',
            'connection' => $connection
        ]);
    }

    // remove connection
    public function removeConnection(Connection $connection){

        if (!in_array(Auth::id(), [$connection->sender_id, $connection->receiver_id])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $connection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Connection removed successfully'
        ]);
    }

    // pending requests
    public function getPendingRequests(){
        $pendingRequests = Connection::with(['sender', 'receiver'])
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        return response()->json([
            'success' => true,
            'pending_requests' => $pendingRequests
        ]);
    }

    // accepted connection
    public function getAcceptedConnections(){
        $connections = Connection::with(['sender', 'receiver'])
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->where('status', 'accepted')
            ->get();

        return response()->json([
            'success' => true,
            'connections' => $connections
        ]);
    }

    // check the connection status
    public function checkConnectionStatus(User $user){
        $connection = Connection::where(function($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })
            ->first();

        $status = 'not_connected';
        if ($connection) {
            $status = $connection->status;
        }


        return response()->json([
            'success' => true,
            'status' => $status
        ]);
    }

    // get all connections : render the connections view
    public function getAllConnections(){
        $connections = Connection::where('sender_id', Auth::id())
        ->orWhere('receiver_id', Auth::id())
        ->paginate(10);
        return view('connections', compact('connections'));
    }
}
