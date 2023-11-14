<?php

namespace App\Http\Controllers;

use App\Models\Central;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Domain;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller {
    public function getCurrentTenant(Request $request) {
        // Obtém a origem da URL que chamou a API
        // Isso facilita a identificação do tenant
        $currentURL = parse_url($request->headers->get('origin'));

        if (isset($currentURL['host'])) {
            $domain = $currentURL['host'];
        }
        else {
            $domain = 'localhost';
        }

        // Obtém o domínio e o tenant pelo domínio
        $domain = Domain::where('domain', $domain)->first();
        $userList = [];
        if ($domain!=null) {
            $tenant = Tenant::find($domain->tenant_id);
            // Faz reconexão com o banco de dados de acordo com o tenant atual
            DB::purge('mysql');
            Config::set('database.connections.mysql.driver', 'mysql');
            Config::set('database.connections.mysql.port', 3306);
            Config::set('database.connections.mysql.database', $tenant->tenancy_db_name);
            DB::reconnect('mysql');
            $tenantData = $tenant;
            $userList = User::all();
        }
        else {
            $tenantData = 'central';
            $userList = Central::all();
        }

        // Conecta ao banco da central dos tenants

        return [
            "url" => $currentURL,
            "tenant" => $tenantData,
            "users" => $userList
            //"domain" => $domain,
        ];
    }
}
