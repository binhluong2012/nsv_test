<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Work+Sans:wght@500&display=swap" rel="stylesheet">

    <head>
        <style>
            @font-face {
                font-family: ipag;
                font-style: normal;
                font-weight: normal;
                src: url('font/ipag.ttf') format('truetype');
            }

            @font-face {
                font-family: roboto;
                font-style: normal;
                font-weight: normal;
                src: url('font/roboto.ttf') format('truetype');
            }

            .japanese {
                font-family: ipag !important;
            }
            .utf8{
                font-family: roboto !important;
            }


            table th,
            table td {
                border: 1px solid black;
                padding: 10px;
                 text-align: left;
            }

            table {
                border-collapse: collapse;
                width: 80%;
                margin: 0 auto;
            }
        </style>
    </head>
</head>

<body>
    <?= $this->fetch('content') ?>
</body>

</html>
