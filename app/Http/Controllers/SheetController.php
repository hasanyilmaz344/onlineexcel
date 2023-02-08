<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\cell;
use App\Models\file;
use App\Models\sheet;

class SheetController extends Controller
{
    //
    function thefile(Request $request)
    {
        $result = DB::table('sheets')
            ->join('cells', 'sheets.id', '=', 'cells.sid')
            ->where('fid', '=', $request->fileid)
            ->get();
        $fileid = $request->fileid;

        // open first sheet as default
        $sheetdataopenid = $result->min('sid');
        // sheet's table to open
        $sheetdataopen = $result->where('sid', '=', $sheetdataopenid);
        // sheet's id and name
        $sheetdata = $result->unique('sid');
        return view('thefile', compact('sheetdataopenid', 'sheetdataopen', 'sheetdata', 'fileid'));
    }

    function getsheetbyid(Request $request)
    {
        $result = DB::table('sheets')
            ->join('cells', 'sheets.id', '=', 'cells.sid')
            ->where('fid', '=', $request->fileid)
            ->get();

        $fileid = $request->fileid;
        $sheetdataopenid = $request->sheetid;        
        $sheetdataopen = $result->where('sid', '=', $sheetdataopenid);
        $sheetdata = $result->unique('sid');

        if ($request->ajax()) {
            return view('thecells',  compact('sheetdataopenid', 'sheetdataopen', 'sheetdata', 'fileid'));
        } else {
            return $sheetdataopen->where('row', '=', 1)->where('col', '=', 1)->first()->data;
            return view('thecells',  compact('sheetdataopenid', 'sheetdataopen', 'sheetdata', 'fileid'));

            return dd($request->all(),$fileid,$sheetdataopenid,$sheetdataopen,$sheetdata);
        }
    }

    function newsheet(Request $request)
    {
        // createsheet
        $newfileid = $request->fileid;
        // new sheet's has 10 column and 10 row as default
        $defaultColumnNumb = 10;
        $defaultRowNumb = 10;
        $newsheetdata = [
            ['sname' => 'newsheet', 'rows' => $defaultRowNumb, 'cols' => $defaultColumnNumb, 'fid' => $newfileid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")]
        ];
        DB::table('sheets')->insert($newsheetdata);
        // create cell for new sheet
        $newsheetid = DB::table('sheets')->where('fid', '=', $newfileid)->get()->last()->id;
        $newcelldata = array();
        $defaultColumnNumb = 10;
        $defaultRowNumb = 10;
        for ($i = 1; $i <= $defaultRowNumb; $i++) {
            for ($k = 1; $k <= $defaultColumnNumb; $k++) {
                $val = ['row' => $i, 'col' => $k, 'data' => "", 'sid' => $newsheetid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
                array_push($newcelldata, $val);
            }
        }
        DB::table('cells')->insert($newcelldata);
        
        return response()->json([
            'success' => 'yeni sheet basariyla olusturuldu',
            'newsheetid' => $newsheetid
        ]);
    }
}
