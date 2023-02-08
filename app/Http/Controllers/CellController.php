<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\cell;
use App\Models\file;
use App\Models\sheet;

class CellController extends Controller
{
    // update data
    function updatecell(Request $request)
    {
        $thecell = cell::query()->find($request->cid);
        $thecell->data = $request->data;
        $thecell->save();
        return true;
    }

    // 
    function columnadd(Request $request)
    {
        $sheetdataopenid = $request->sheetdataopenid;
        $colnumb = $request->colnumb;
        $colmax = $request->colmax;
        $rowmax = $request->rowmax;

        // add other cell's column value +1 for space to add new column 
        $updatecell = " ";
        for ($i = $colnumb; $i <= $colmax; $i++) {
            $old = $i;
            $new = $i + 1;
            $val = "   WHEN col = '$old' THEN  '$new'   ";
            $updatecell = $updatecell . $val;
        }
        $sqlquery = "UPDATE cells SET col = CASE  " . $updatecell . " ELSE col END WHERE sid = $sheetdataopenid";

        DB::update($sqlquery);

        // insert new column
        $newcelldata = array();
        for ($i = 1; $i <= $rowmax; $i++) {
            $val = ['row' => $i, 'col' => $colnumb, 'data' => "", 'sid' => $sheetdataopenid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
            array_push($newcelldata, $val);
        }
        DB::table('cells')->insert($newcelldata);

        // sheet table cols value +1
        sheet::where('id', '=', $sheetdataopenid)
            ->update(["cols" => ($colmax + 1)]);

        return response()->json([
            'success' => 'kayit basariyla olusturuldu',
            'sheetid' => $sheetdataopenid
        ]);
    }

    function removecolumn(Request $request)
    {
        $sheetdataopenid = $request->sheetdataopenid;
        $colnumb = $request->colnumb;
        $colmax = $request->colmax;
        $rowmax = $request->rowmax;

        // delete the column
        cell::where('sid', '=', $sheetdataopenid)->where('col', '=', $colnumb)->delete();
        // add other cell's column value -1 
        $updatecell = " ";
        for ($i = $colnumb; $i <= $colmax; $i++) {
            $old = $i;
            $new = $i - 1;
            $val = "   WHEN col = '$old' THEN  '$new'   ";
            $updatecell = $updatecell . $val;
        }
        $sqlquery = "UPDATE cells SET col = CASE  " . $updatecell . " ELSE col END WHERE sid = $sheetdataopenid";
        DB::update($sqlquery);

        // sheet table cols value -1
        sheet::where('id', '=', $sheetdataopenid)
            ->update(["cols" => ($colmax - 1)]);

        return response()->json([
            'success' => 'kayit basariyla olusturuldu',
            'sheetid' => $sheetdataopenid
        ]);
    }

    function rowadd(Request $request)
    {
        $sheetdataopenid = $request->sheetdataopenid;
        $rownumb = $request->rownumb;
        $colmax = $request->colmax;
        $rowmax = $request->rowmax;

        // add other cell's row value +1 for space to add new row 
        $updatecell = " ";
        for ($i = $rownumb; $i <= $rowmax; $i++) {
            $old = $i;
            $new = $i + 1;
            $val = "   WHEN `cells`.`row` = '$old' THEN  '$new'   ";
            $updatecell = $updatecell . $val;
        }

        $sqlquery = "UPDATE cells SET `cells`.`row` = CASE  " . $updatecell . " ELSE `cells`.`row` END WHERE sid = $sheetdataopenid";
        DB::update($sqlquery);

        // insert new row
        $newcelldata = array();
        for ($i = 1; $i <= $colmax; $i++) {
            $val = ['row' => $rownumb, 'col' => $i, 'data' => "", 'sid' => $sheetdataopenid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
            array_push($newcelldata, $val);
        }
        DB::table('cells')->insert($newcelldata);

        // sheet table rows value +1
        sheet::where('id', '=', $sheetdataopenid)
            ->update(["rows" => ($rowmax + 1)]);

        return response()->json([
            'success' => 'kayit basariyla olusturuldu',
            'sheetid' => $sheetdataopenid
        ]);
    }

    function removerow(Request $request)
    {
        $sheetdataopenid = $request->sheetdataopenid;
        $rownumb = $request->rownumb;
        $colmax = $request->colmax;
        $rowmax = $request->rowmax;

        // delete the row
        cell::where('sid', '=', $sheetdataopenid)->where('row', '=', $rownumb)->delete();
        // add other cell's row value -1 
        $updatecell = " ";
        for ($i = $rownumb; $i <= $colmax; $i++) {
            $old = $i;
            $new = $i - 1;
            
            $val = "   WHEN `cells`.`row` = '$old' THEN  '$new'   ";
            $updatecell = $updatecell . $val;
        }
        $sqlquery = "UPDATE cells SET `cells`.`row` = CASE  " . $updatecell . " ELSE `cells`.`row` END WHERE sid = $sheetdataopenid";
        DB::update($sqlquery);

        // sheettable rows value -1
        sheet::where('id', '=', $sheetdataopenid)
            ->update(["rows" => ($rowmax - 1)]);

        return response()->json([
            'success' => 'kayit basariyla olusturuldu',
            'sheetid' => $sheetdataopenid
        ]);
    }
}
