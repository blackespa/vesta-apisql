<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SoftlandController extends Controller
{

    public function getLedgerBook(Request $request)
    {
        $params = $request->all();
        $project_id = $params['project'];
        $accounting = $params['accounting'];
        $account = $params['account'];
        $dateFrom = $params['dateFrom'];

        $config = Config::get('database.connections.sqlsrv');
        $config['database'] = $accounting;
        config()->set('database.connections.sqlsrv', $config);
        DB::purge('sqlsrv');

        $dateCarbon = Carbon::createFromFormat('Y-m-d', $dateFrom);
        $dateFrom = $dateCarbon->format("Y-m-d 00:00:00");

        $ledgerBook = DB::connection('sqlsrv')->select("select * from softland.cwmovim where cpbnum != '00000000' and pctcod = ? and cast( cpbfec as date ) >= cast( ? as date ) order by cpbfec asc ", array($account,$dateFrom) );
        DB::disconnect('sqlsrv');

        $ledgerBook['project'] = $project_id;

        return response()->json($ledgerBook);

    }


    public function getCustomers(Request $request)
    {
        $params = $request->all();
        $project_id = $params['project'];
        $accounting = $params['accounting'];

        $config = Config::get('database.connections.sqlsrv');
        $config['database'] = $accounting;
        config()->set('database.connections.sqlsrv', $config);
        DB::purge('sqlsrv');

        $customers = DB::connection('sqlsrv')->select("select * from softland.cwtauxi" );
        DB::disconnect('sqlsrv');

        $customers['project'] = $project_id;

        return response()->json($customers);

    }
}
