<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use App\Models\Agent;
use App\Models\Guest;
use App\Models\Client;
use App\Models\Referee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function refereedata(Request $request)
    {
        $referees=DB::select('select r.id,r.referee_code,r.id, u.name,u.phone,op.operationstaff_code,COUNT(a.id) as agentcount FROM agents a right join referees r on a.referee_id = r.id right join users u on r.user_id = u.id join operationstaffs op on r.operationstaff_id = op.id GROUP BY a.referee_id,r.referee_code, u.name,u.phone,op.operationstaff_code,r.id;');

        //$agentcounts=DB::select('select referee_id, COUNT(NULLIF(id, `referee_id`)) as agentcount FROM `agents` GROUP BY referee_id');
        //$referees=DB::select('select r.id,r.referee_code, u.name,u.phone,op.operationstaff_code,COUNT(a.id) as agentcount FROM agents a right join referees r on a.referee_id = r.id right join users u on r.user_id = u.id right join operationstaffs op on r.operationstaff_id = op.id GROUP BY a.referee_id,r.referee_code, u.name,u.phone,op.operationstaff_code,r.id');
        // $referees=DB::select('select b.id,b.name, b.phone,b.referee_id,b.parent_id, count(a.agent_id) as AgentCount,a.parent_id FROM `clients` a INNER join clients b on a.parent_id = b.referee_id GROUP by b.id,b.referee_id,a.parent_id, b.parent_id,b.agent_id,b.name,b.phone');
        return view('system_admin.data.refereedata',compact('referees'));
    }

    public function agentdata()
    {
        return view('system_admin.data.agentdata');
    }

}
