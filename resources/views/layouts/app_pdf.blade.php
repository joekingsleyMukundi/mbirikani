<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        pre {
            padding: 0;
            white-space: pre-wrap; /* css-3 */
            white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
            white-space: -pre-wrap; /* Opera 4-6 */
            white-space: -o-pre-wrap; /* Opera 7 */
            word-wrap: break-word; /* Internet Explorer 5.5+ */
        }

        * {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1
        }

        body {
            font-family: "Geeza Pro", "Nadeem", "Al Bayan", "DecoType Naskh", "DejaVu Serif", "STFangsong", "STHeiti", "STKaiti", "STSong", "AB AlBayan", "AB Geeza", "AB Kufi", "DecoType Naskh", "Aldhabi", "Andalus", "Sakkal Majalla", "Simplified Arabic", "Traditional Arabic", "Arabic Typesetting", "Urdu Typesetting", "Droid Naskh", "Droid Kufi", "Roboto", "Tahoma", "Times New Roman", "Arial", serif;
        }

        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 3rem;
        }

        td {
            padding: 2pt;
            margin-bottom: 0;
            height: 1px;
        }

        br {
            display: block;
            margin-top: 10px;
            line-height: 5px;
        }


        body.watermarked {
            background: url({{ asset('img/wtrmrk.jpg') }});
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-blend-mode: lighten;
        }

        table.padded td {
            padding: 0pt;
            width: 100px;
            word-wrap: break-word;
        }

        td p {
            margin: 3pt !important;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-9 text-center" >
                    <h3>{{ $title }}</h3>
                    <small>Time {{Carbon\Carbon::parse(Carbon\Carbon::now())->format('d/m/Y H:m A')}}</small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                @yield('content')
            </div>
        </div>
    </div>
</div>

</body>
</html>
