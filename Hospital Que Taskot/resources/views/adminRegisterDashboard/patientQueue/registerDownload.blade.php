<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .text-center {
            text-align: center !important;
        }

        .lh-sm {
            line-height: 1.25 !important;
        }

        .font-monospace {
            font-family: 'SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace';
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .fw-bold {
            font-weight: 700 !important;
            font-size: large !important;
        }

    </style>
</head>

<body>
    <div style="font-size: small;">
        <div class="text-center font-monospace lh-sm" style="display: block;">
           <div>RSUD Kota Tasikmalaya</div> 
            <div>Jl Rumah Sakit No.55</div>
            <div>Telp: (027)8923923</div>
        </div>
        <hr>
        <div class="text-center font-monospace">
            <p id="afterRegPoliName" class="text-uppercase" style="margin-top: 10px;">{{ $poliName }}</p>
                <p class="fw-bold" id="afterRegQueueNumber">{{ $queueNumber }}</p>
            <p id="afterRegPatientName">{{ $patientName }}</p>
            <p id="afterRegGuarantor">{{ $guarantor }}</p>
            <p>Tanggal Antrian</p>
            <p id="afterRegQueueAt">{{ $queueAt }}</p>
        </div>
    </div>
</body>

</html>
