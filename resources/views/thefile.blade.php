<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>online excel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <!-- //table style -->
    <style>
        .table td,
        .table th {
            padding: 0rem;
            vertical-align: top;
            border-top: 0px solid #dee2e6;
        }

        .input {
            padding: 50px 150px;
        }
    </style>
    <!-- rightclick style -->
    <style>
        .cls-context-menu-link {
            display: block;
            padding: 20px;
            background: #ECECEC;
        }

        .cls-context-menu {
            position: absolute;
            display: none;
        }

        .cls-context-menu ul,
        #context-menu li {
            list-style: none;
            margin: 0;
            padding: 0;
            background: white;
        }

        .cls-context-menu {
            border: solid 1px #CCC;
        }

        .cls-context-menu li {
            border-bottom: solid 1px #CCC;
        }

        .cls-context-menu li:last-child {
            border: none;
        }

        .cls-context-menu li a {
            display: block;
            padding: 5px 10px;
            text-decoration: none;
            color: green;
        }

        .cls-context-menu li a:hover {
            background: green;
            color: #FFF;
        }
    </style>
    <script>
        function gomainpage() {
            location.href = "http://localhost:8000/";
        }
        // rightclick default
        window.onload = function() {
            activecontextcell();
        };
        // cell's value 
        function onclickhandler(e) {
            console.log(e.value);
            var rowid = e.id + 'row';
            var therowid = document.getElementById(rowid).value;

            var colid = e.id + 'col';
            var thecolid = document.getElementById(colid).value;

            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/updatecell',
                type: 'get',
                data: {
                    cid: e.id,
                    row: therowid,
                    col: thecolid,
                    data: e.value
                },
                success: function(response) {},
                error: function(response) {}
            });
            return true;
        }
        // new sheet for file
        function newsheet(val) {
            var fileid = document.getElementById('fileid').value;
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/newsheet',
                type: 'get',
                data: {
                    fileid: fileid
                },
                success: function(response) {
                    getsheetbyid(response.newsheetid);
                },
                error: function(response) {
                    alert('failed');
                }
            });
            return true;
        }
        // open the sheet
        function getsheetbyid(sheetid) {
            var l = window.location;
            $.ajax({
                type: 'GET',
                url: "/getsheetbyid",
                data: {
                    sheetid: sheetid,
                    fileid: document.getElementById('fileid').value
                },
                success: function(response) {
                    $('#mytable').html(response);
                    activecontextcell();
                },
                error: function(data) {
                    alert('failed');
                }
            });
            return false;
        }

        //add new row
        function addrowup(e) {
            cid = e;
            therowid = e + 'row';
            rownumb = document.getElementById(therowid).value;
            addrow(cid, rownumb);
        }

        function addrowdown(e) {
            cid = e;
            therowid = e + 'row';
            rownumb = document.getElementById(therowid).value;
            rownumb = parseInt(rownumb) + 1;
            addrow(e, rownumb);
        }

        function addrow(idofcell, rownumb) {

            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/rowadd',
                type: 'get',
                data: {
                    idofcell: idofcell,
                    rownumb: rownumb,
                    sheetdataopenid: document.getElementById('sheetdataopenid').value,
                    fileid: document.getElementById('fileid').value,
                    rowmax: document.getElementById('sheetdataopenrows').value,
                    colmax: document.getElementById('sheetdataopencols').value

                },
                success: function(response) {
                    getsheetbyid(response.sheetid);

                },
                error: function(response) {
                    alert('failed');
                }
            });
            return true;
        }

        // remove row
        function removerow(e, rownumb) {
            cid = e;
            therowid = e + 'row';
            rownumb = document.getElementById(therowid).value;
            removerowto(cid, rownumb);
        }

        function removerowto(cid, rownumb) {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/removerow',
                type: 'get',
                data: {
                    rownumb: rownumb,
                    sheetdataopenid: document.getElementById('sheetdataopenid').value,
                    fileid: document.getElementById('fileid').value,
                    rowmax: document.getElementById('sheetdataopenrows').value,
                    colmax: document.getElementById('sheetdataopencols').value
                },
                success: function(response) {
                    getsheetbyid(response.sheetid);
                },
                error: function(response) {
                    alert('failed');
                }
            });
            return true;
        }

        // remove column
        function removecolumn(e, colnumb) {
            cid = e;
            colnumb = e + 'col';
            colnumb = document.getElementById(colnumb).value;
            removecolumnto(cid, colnumb);
        }

        function removecolumnto(cid, colnumb) {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/removecolumn',
                type: 'get',
                data: {
                    colnumb: colnumb,
                    sheetdataopenid: document.getElementById('sheetdataopenid').value,
                    fileid: document.getElementById('fileid').value,
                    rowmax: document.getElementById('sheetdataopenrows').value,
                    colmax: document.getElementById('sheetdataopencols').value
                },
                success: function(response) {
                    getsheetbyid(response.sheetid);
                },
                error: function(response) {
                    alert('failed');
                }
            });
            return true;
        }

        // add column
        function addcolumnleft(e, colnumb) {
            cid = e;
            thecolid = e + 'col';
            colnumb = document.getElementById(thecolid).value;
            addcolumn(e, colnumb);

        }

        function addcolumnright(e) {
            cid = e;
            thecolid = e + 'col';
            colnumb = document.getElementById(thecolid).value;
            colnumb = parseInt(colnumb) + 1;
            addcolumn(e, colnumb);
        }

        function addcolumn(idofcell, colnumb) {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/columnadd',
                type: 'get',
                data: {
                    idofcell: idofcell,
                    colnumb: colnumb,
                    sheetdataopenid: document.getElementById('sheetdataopenid').value,
                    fileid: document.getElementById('fileid').value,
                    rowmax: document.getElementById('sheetdataopenrows').value,
                    colmax: document.getElementById('sheetdataopencols').value

                },
                success: function(response) {
                    getsheetbyid(response.sheetid);
                },
                error: function(response) {
                    alert('failed');
                }
            });
            return false;
        }

        // other functions for cells
        function addrowupspec(val) {
            cid = document.getElementById('defaulcellid').value
            rownumb = val.id.replace("row", "");
            rownumb = parseInt(rownumb);
            addrow(cid, rownumb);
        }

        function addrowdownspec(val) {
            cid = document.getElementById('defaulcellid').value
            rownumb = val.id.replace("row", "");
            rownumb = parseInt(rownumb) + 1;
            rownumb = parseInt(rownumb);
            addrow(cid, rownumb);
        }

        function removerowspec(val) {
            cid = document.getElementById('defaulcellid').value
            rownumb = val.id.replace("row", "");
            rownumb = parseInt(rownumb);
            rownumb = parseInt(rownumb);
            removerowto(cid, rownumb);
        }

        function addcolumnleftspec(val) {
            cid = document.getElementById('defaulcellid').value
            colnumb = val.id.replace("col", "");
            colnumb = parseInt(colnumb);
            addcolumn(cid, colnumb);
        }

        function addcolumnrightspec(val) {
            cid = document.getElementById('defaulcellid').value
            colnumb = val.id.replace("col", "");
            colnumb = parseInt(colnumb) + 1;
            colnumb = parseInt(colnumb);
            addcolumn(cid, colnumb);
        }

        function removecolumnspec(val) {
            cid = document.getElementById('defaulcellid').value
            colnumb = val.id.replace("col", "");
            colnumb = parseInt(colnumb);
            removecolumnto(cid, colnumb);
        }
    </script>

</head>

<body>

    <div id=maindiv>
        <div id="tablediv">
            <table id="mytable" class="table table-responsive table-strip" style="width:100%">
                @include('thecells')
            </table>

        </div>
    </div>

    <script>
        function activecontextcell() {
            console.log('activecontextcell func ');
            var rgtClickContextMenu = document.getElementById('div-context-menu');

            // reset after right click
            document.onclick = function(e) {
                rgtClickContextMenu.style.display = 'none';
                document.getElementById("liaddrowuplink").hidden = false;
                document.getElementById("liaddrowdownlink").hidden = false;
                document.getElementById("liaddcolumnleftlink").hidden = false;
                document.getElementById("liaddcolumnrightlink").hidden = false;
                document.getElementById("liremoverowlink").hidden = false;
                document.getElementById("liremovecolumnlink").hidden = false;
            }

            document.oncontextmenu = function(e) {
                var elmnt = e.target
                if (elmnt.className.startsWith("cls-context-menu")) {
                    e.preventDefault();
                    var eid = elmnt.id;
                    console.log(eid);

                    if (eid.startsWith("col")) {
                        // right click for column
                        document.getElementById('addcolumnleftlink').href = "javascript:addcolumnleftspec(" + eid + ");"
                        document.getElementById('addcolumnrightlink').href = "javascript:addcolumnrightspec(" + eid + ");"
                        document.getElementById('removecolumnlink').href = "javascript:removecolumnspec(" + eid + ");"
                        //
                        document.getElementById("liaddrowuplink").hidden = true;
                        document.getElementById("liaddrowdownlink").hidden = true;
                        document.getElementById("liremoverowlink").hidden = true;
                    } else if (eid.startsWith("row")) {
                        // right click for row
                        document.getElementById('addrowuplink').href = "javascript:addrowupspec(" + eid + ");"
                        document.getElementById('addrowdownlink').href = "javascript:addrowdownspec(" + eid + ");"
                        document.getElementById('removerowlink').href = "javascript:removerowspec(" + eid + ");"
                        //
                        document.getElementById("liaddcolumnleftlink").hidden = true;
                        document.getElementById("liaddcolumnrightlink").hidden = true;
                        document.getElementById("liremovecolumnlink").hidden = true;
                    } else {
                        // right click for cells
                        document.getElementById('addrowuplink').href = "javascript:addrowup(" + eid + ");"
                        document.getElementById('addrowdownlink').href = "javascript:addrowdown(" + eid + ");"
                        document.getElementById('addcolumnleftlink').href = "javascript:addcolumnleft(" + eid + ");"
                        document.getElementById('addcolumnrightlink').href = "javascript:addcolumnright(" + eid + ");"
                        document.getElementById('removerowlink').href = "javascript:removerow(" + eid + ");"
                        document.getElementById('removecolumnlink').href = "javascript:removecolumn(" + eid + ");"
                    }
                    rgtClickContextMenu.style.left = e.pageX + 'px';
                    rgtClickContextMenu.style.top = e.pageY + 'px';
                    rgtClickContextMenu.style.display = 'block';

                    console.log(rgtClickContextMenu.innerHTML.toString());
                }


                var columncontextmenu = document.getElementById('div-column-context');


            }
            console.log('activecontextcell func end');

        };
    </script>
</body>

</html>