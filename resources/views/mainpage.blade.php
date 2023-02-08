<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <title>online excel</title>
    <style>
    </style>
</head>

<body>
    <div id="divmain">
        <div id="divtable" class="container">
            <table class="table table-bordered" style="width: auto; margin-left: auto; margin-right: auto;">
            <thead>
                    <tr>
                        <td colspan="3" style="top: 50%;left: 50%;">&nbsp; <p style="margin-left: 178px;"> -- File List --</p></td>
                    </tr>
                    <tr>
                        <td>
                            <p>File Name</p>
                        </td>
                        <td>
                            Last Updated Date
                        </td>
                        <td>
                            \\\\
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $files as $item)
                    <tr>
                        <td>
                            <a href="thefile?fileid={{ $item->id }}">
                                <p>{{ $item->fname }}</p>
                            </a>
                        </td>
                        <td>
                            <p>{{ $item->lastModified }}</p>
                        </td>
                        <td>
                            <a href="deletefile?id={{ $item->id }}">
                                Sil</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <form action="createfile" method="GET">
                            <td>
                                <input type="text"  style="padding: 10px 20px" name="newfname" id="newfname" placeholder="yeni dosya adi giriniz">
                            </td>
                            <td colspan="2">
                                <button style="margin-left: 35px;margin-right: auto;    padding: 11px 44px;" class="btn btn-success" type="submit">oluştur</button>
                            </td>
                        </form>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</body>