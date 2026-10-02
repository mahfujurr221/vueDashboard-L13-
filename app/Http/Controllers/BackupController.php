<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ifsnop\Mysqldump as IMysqldump;
use Exception;

class BackupController extends Controller
{
    public function download(Request $request)
    {
        // Only allow super-admin or users with backup-database permission
        if (!auth()->user()->hasRole('super-admin') && !auth()->user()->hasPermissionTo('backup-database')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->input('password') !== 'tiger') {
            abort(403, 'Invalid backup password.');
        }

        try {
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbHost = env('DB_HOST');
            $dbPort = env('DB_PORT', 3306);

            $dumpSettings = [
                'compress' => IMysqldump\Mysqldump::NONE,
                'no-data' => false,
                'add-drop-table' => true,
                'single-transaction' => true,
                'lock-tables' => true,
                'add-locks' => true,
                'extended-insert' => true,
                'disable-keys' => true,
                'skip-triggers' => false,
                'add-drop-trigger' => true,
                'databases' => true,
                'add-drop-database' => true,
                'hex-blob' => true,
            ];

            $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}";
            
            $dump = new IMysqldump\Mysqldump($dsn, $dbUser, $dbPass, $dumpSettings);

            $filename = 'backup_' . $dbName . '_' . date('Y_m_d_H_i_s') . '.sql';
            $path = storage_path('app/' . $filename);
            
            $dump->start($path);

            return response()->download($path)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }
}
