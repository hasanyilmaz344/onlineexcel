<!-- some value for functions -->
<input type="hidden" id="defaulcellid" value="<?php echo $sheetdataopen->first()->id; ?>">
<input type="hidden" id="sheetdataopenrows" value="<?php echo $sheetdata->where('sid', '=', $sheetdataopenid)->first()->rows; ?>">
<input type="hidden" id="sheetdataopencols" value="<?php echo $sheetdata->where('sid', '=', $sheetdataopenid)->first()->cols; ?>">
<input type="hidden" id="sheetdataopenid" value="<?php echo $sheetdataopenid; ?>">
<input type="hidden" id="fileid" value="<?php echo $fileid; ?>">
<!-- showing column with alphabet -->
<?php $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); ?>
<thead>
    <tr>
        <td>
            <!-- homepage -->
            <img style="    vertical-align: middle;border-style: none;    border: 0px solid;padding: 3px;    background: rgba(236,236,236,255);margin-top: 3px;" width="60px" height="40px" onclick="gomainpage()" src="https://ucgen.gen.tr/images/Ucgen-25.jpg">
        </td>
        <!-- col -->
        @for ($k = 1; $k <= $sheetdataopen->max('col'); $k++)
            <td class="bg-success">
                <input style="background: rgba(236,236,236,255);width: 200px;height: 40px;" type="text" id="col{{ $k }}" oninput="onclickhandler(this)" class="cls-context-menu-link" value="<?php echo $alphabet[$k - 1]  ?>" readonly>
            </td>
            @endfor
    </tr>
</thead>
<tbody>
    <!-- row -->
    @for ($i = 1; $i <= $sheetdataopen->max('row'); $i++)
        <tr id=<?php echo $i . 'trid'  ?>>
            <td>
                <input style="width: 60px;height: 40px;" type="text" id="row{{ $i }}" oninput="onclickhandler(this)" class="cls-context-menu-link" value="{{ $i }}" readonly>
            </td>
            <!-- cells -->
            @for ($k = 1; $k <= $sheetdataopen->max('col'); $k++)
                <?php
                $thevalue = $sheetdataopen->where('row', '=', $i)->where('col', '=', $k)->first()->data;
                $theid = $sheetdataopen->where('row', '=', $i)->where('col', '=', $k)->first()->id;
                $therow = $sheetdataopen->where('row', '=', $i)->first()->row;
                $thecol = $sheetdataopen->where('col', '=', $k)->first()->col;
                ?>

                <td id="row{{ $i }}-col{{ $k }}td">
                    <input type="hidden" id="{{ $theid }}row" value="{{ $therow }}">
                    <input type="hidden" id="{{ $theid }}col" value="{{ $thecol }}">
                    <input style="background: white; outline: none;width: 200px;height: 40px;" type="text" id="{{ $theid }}" oninput="onclickhandler(this)" class="cls-context-menu-link" value="{{ $thevalue }}">
                </td>
                @endfor
        </tr>
        @endfor
        <tr>
            <!-- last row for showing sheets -->
            <td>
                ***
            </td>
            @foreach($sheetdata as $data)
            @if(intval($data->sid) === intval($sheetdataopenid) )
            <td style="border-style: solid;">
                <button style=" background-color: #5e5f60; width: 198px;height: 40px;" onclick="getsheetbyid(<?php echo $data->sid ?>)" ondblclick="myalert()">{{ $data->sname }} - {{ $data->sid }} - {{ $sheetdataopenid }}</button>
            </td>
            @else
            <td style="border-style: solid;">
                <button  style="background-color: #d6d6d7; width: 198px;height: 40px;" onclick="getsheetbyid(<?php echo $data->sid ?>)" ondblclick="myalert()">{{ $data->sname }} - {{ $data->sid }} - {{ $sheetdataopenid }}</button>
            </td>
            @endif
            @endforeach
            <td style="border-style: solid;">
                <button  style="background-color: #f1f1f2; width: 198px;height: 40px;    outline: 0;" onclick="newsheet()"> New Sheet+ </button>
            </td>

        </tr>
        <!-- right click  -->
        <div id="div-context-menu" class="cls-context-menu">
            <ul>
                <li id="liaddrowuplink"><a id="addrowuplink" href="javascript:addrowup(tototo);">add row to up</a></li>
                <li id="liaddrowdownlink"><a id="addrowdownlink" href="javascript:addrowdown(tototo);">add row to down</a></li>
                <li id="liaddcolumnleftlink"><a id="addcolumnleftlink" href="javascript:addcolumnleft(tototo);">add column to left</a></li>
                <li id="liaddcolumnrightlink"><a id="addcolumnrightlink" href="javascript:addcolumnright(tototo);">add column to right</a></li>
                <li id="liremoverowlink"><a id="removerowlink" href="javascript:removerow(tototo);">remove row</a></li>
                <li id="liremovecolumnlink"><a id="removecolumnlink" href="javascript:removecolumn(tototo);">remove column</a></li>
            </ul>
        </div>
</tbody>