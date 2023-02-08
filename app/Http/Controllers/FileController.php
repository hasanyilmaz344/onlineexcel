<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\cell;
use App\Models\file;
use App\Models\sheet;

class FileController extends Controller
{
    function createfile(Request $request)
    {
        // check for file name 
        if (DB::table('files')->where('fname', '=', $request->newfname)->get()->first()) {
            $files = DB::table('files')->get();
            return view('mainpage', compact('files'));
        }

        // createfile
        $newfile = new file;
        $newfile->fname = $request->newfname;
        $newfile->lastModified = date("Y-m-d H:i:s");
        $newfile->save();

        // createsheet
        $newfileid = DB::table('files')->where('fname', '=', $request->newfname)->get()->first()->id;
        $defaultColumnNumb = 10;
        $defaultRowNumb = 10;
        $newsheetdata = [
            ['sname' => 'sheet1', 'rows' => $defaultRowNumb, 'cols' => $defaultColumnNumb, 'fid' => $newfileid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['sname' => 'sheet2', 'rows' => $defaultRowNumb, 'cols' => $defaultColumnNumb, 'fid' => $newfileid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['sname' => 'sheet3', 'rows' => $defaultRowNumb, 'cols' => $defaultColumnNumb, 'fid' => $newfileid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['sname' => 'sheet4', 'rows' => $defaultRowNumb, 'cols' => $defaultColumnNumb, 'fid' => $newfileid, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
        ];
        DB::table('sheets')->insert($newsheetdata);         // sheet::insert($data);        

        // createcell
        $newsheets = DB::table('sheets')->where('fid', '=', $newfileid)->get();
        $newcelldata = array();
        $defaultColumnNumb = 10;
        $defaultRowNumb = 10;
        foreach ($newsheets as $item) {
            for ($i = 1; $i <= $defaultRowNumb; $i++) {
                for ($k = 1; $k <= $defaultColumnNumb; $k++) {
                    $val = ['row' => $i, 'col' => $k, 'data' => "", 'sid' => $item->id, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
                    array_push($newcelldata, $val);
                }
            }
        }
        DB::table('cells')->insert($newcelldata); 
        
        // return mainpage
        $files = DB::table('files')->get();
        return view('mainpage', compact('files'));
    }
    function getallfiles(Request $request)
    {
        $files = DB::table('files')->get();
        return view('mainpage', compact('files'));
    }
    function deletefile(Request $request)
    {
        file::where('id', '=', $request->id)->delete();
        $files = DB::table('files')->get();
        return view('mainpage', compact('files'));
    }
}
