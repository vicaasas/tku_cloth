<html class="no-touch" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Method Not Allowed</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .code {
            border-right: 2px solid;
            font-size: 26px;
            padding: 0 15px 0 15px;
            text-align: center;
        }

        .message {
            font-size: 18px;
            text-align: center;
        }
    </style>
    <style type="text/css">
        /*
         * contextMenu.js v 1.4.0
         * Author: Sudhanshu Yadav
         * s-yadav.github.com
         * Copyright (c) 2013 Sudhanshu Yadav.
         * Dual licensed under the MIT and GPL licenses
        **/

        .iw-contextMenu {
            box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.10) !important;
            border: 1px solid #c8c7cc !important;
            border-radius: 11px !important;
            display: none;
            z-index: 1000000132;
            max-width: 300px !important;
            width: auto !important;
        }

        .dark-mode .iw-contextMenu,
        .TnITTtw-dark-mode.iw-contextMenu,
        .TnITTtw-dark-mode .iw-contextMenu {
            border-color: #747473 !important;
        }

        .iw-cm-menu {
            background: #fff !important;
            color: #000 !important;
            margin: 0px !important;
            padding: 0px !important;
            overflow: visible !important;
        }

        .dark-mode .iw-cm-menu,
        .TnITTtw-dark-mode.iw-cm-menu,
        .TnITTtw-dark-mode .iw-cm-menu {
            background: #525251 !important;
            color: #FFF !important;
        }

        .iw-curMenu {
        }

        .iw-cm-menu li {
            font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", Helvetica, Arial, Ubuntu, sans-serif !important;
            list-style: none !important;
            padding: 10px !important;
            padding-right: 20px !important;
            border-bottom: 1px solid #c8c7cc !important;
            font-weight: 400 !important;
            cursor: pointer !important;
            position: relative !important;
            font-size: 14px !important;
            margin: 0 !important;
            line-height: inherit !important;
            border-radius: 0 !important;
            display: block !important;
        }

        .dark-mode .iw-cm-menu li, .TnITTtw-dark-mode .iw-cm-menu li {
            border-bottom-color: #747473 !important;
        }

        .iw-cm-menu li:first-child {
            border-top-left-radius: 11px !important;
            border-top-right-radius: 11px !important;
        }

        .iw-cm-menu li:last-child {
            border-bottom-left-radius: 11px !important;
            border-bottom-right-radius: 11px !important;
            border-bottom: none !important;
        }

        .iw-mOverlay {
            position: absolute !important;
            width: 100% !important;
            height: 100% !important;
            top: 0px !important;
            left: 0px !important;
            background: #FFF !important;
            opacity: .5 !important;
        }

        .iw-contextMenu li.iw-mDisable {
            opacity: 0.3 !important;
            cursor: default !important;
        }

        .iw-mSelected {
            background-color: #F6F6F6 !important;
        }

        .dark-mode .iw-mSelected, .TnITTtw-dark-mode .iw-mSelected {
            background-color: #676766 !important;
        }

        .iw-cm-arrow-right {
            width: 0 !important;
            height: 0 !important;
            border-top: 5px solid transparent !important;
            border-bottom: 5px solid transparent !important;
            border-left: 5px solid #000 !important;
            position: absolute !important;
            right: 5px !important;
            top: 50% !important;
            margin-top: -5px !important;
        }

        .dark-mode .iw-cm-arrow-right, .TnITTtw-dark-mode .iw-cm-arrow-right {
            border-left-color: #FFF !important;
        }

        .iw-mSelected > .iw-cm-arrow-right {
        }

        /*context menu css end */</style>
    <style type="text/css">
        @-webkit-keyframes load4 {
            0%,
            100% {
                box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
            }
            12.5% {
                box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
            }
            25% {
                box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
            }
            37.5% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
            }
            50% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
            }
            62.5% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
            }
            75% {
                box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
            }
            87.5% {
                box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
            }
        }

        @keyframes load4 {
            0%,
            100% {
                box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
            }
            12.5% {
                box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
            }
            25% {
                box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
            }
            37.5% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
            }
            50% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
            }
            62.5% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
            }
            75% {
                box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
            }
            87.5% {
                box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
            }
        }</style>
    <style type="text/css">/* This is not a zero-length file! */</style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="code">
        405
    </div>
    <div class="message" style="padding: 10px;">
        This action is not allowed.
    </div>
</div>
</body>
</html>
