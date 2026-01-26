<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>ভোটকেন্দ্র ডাটা তুলনা</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'SolaimanLipi', Arial, sans-serif; padding: 20px; }
        .table-hover tbody tr:hover { background-color: #f2f2f2; }
    </style>
</head>
<body>

<div class="container-fluid">
    <h3 class="mb-4 text-center">ভোটকেন্দ্রের নাম ও বিস্তারিত নাম তুলনা (১-১৪২)</h3>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>আইডি (ID)</th>
                    <th>কোড (Code - বাংলা)</th>
                    <th>নাম (Short Name)</th>
                    <th>বিস্তারিত নাম (Detailed Name)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($centers as $center)
                <tr>
                    <td>{{ $center->id }}</td>
                    <td class="fw-bold text-primary">{{ $center->code }}</td>
                    <td>{{ $center->name }}</td>
                    <td class="text-success">{{ $center->name_detail }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>