<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body{
            background: gray;
        }
        .sti_container {
        position: relative;
        }

        .btn {
        position: relative;
        display: inline-block;
        padding: 5px;
        background-color: #fff;
        cursor: pointer;
        outline: none;
        border: 0;
        vertical-align: middle;
        text-decoration: none;
        color: #000;
        border-radius: 25px;
        /* -webkit-transition: width 0.5s;
        transition: width 0.5s; */
        transition-duration: 0.8s;
        }

        .btn .btn-text {
        max-width: 0;
        display: inline-block;
        -webkit-transition: color .25s .5s, max-width .5s;
        transition: color .25s .5s, max-width .5s;
        vertical-align: top;
        /* white-space: nowrap; */
        overflow: hidden;
        color: #fff;
        }

        .btn:hover {
            color: white;
            background-color: #6caf00;
            border: 1px solid #6caf00;
        }
        .btn:hover .btn-text {
        max-width: 300px;
        color: white;
        }
    </style>
</head>
<body>

<button class="btn" name="reloadbtn" title="Reload">
    <span class="btn-icon"><i class="fa fa-refresh" aria-hidden="true"></i></span>
    <span class="btn-text">Reload</span>
</button>

</body>
</html>
