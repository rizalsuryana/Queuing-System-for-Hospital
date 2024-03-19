<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabel Antrian</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    th, td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  {{-- <h4 class="card-title">Antrian {{ $patientQueue->poli_name }} {{ date('d-m-Y',strtotime($patientQueue->queue_at)) }}</h4>
            <h4> Kuota Antrian : {{ $patientQueue->quota }}</h4>
            <h4> Terisi : {{ $patientDetailCount }}</h4>
            <h4> Sisa : {{ $patientQueue->quota-$patientDetailCount }}</h4>

  <h4> Selesai dilayani</h4> --}}
  @foreach($dataArray as $id => $patients)
  <table>
    <thead>
      <tr>
        <th>Nomor Rekam Medis</th>
        <th>Nomor Antrian</th>
        <th>Nama</th>
        <th>Poli</th>
        <th>Waktu dan Tanggal Berkunjung</th>
      </tr>
    </thead>
    <tbody>
      
      @foreach($patients as $pp)
      <tr>
        <td>{{$loop->iteration }}</td>
        <td>{{$loop->iteration }}</td>
        <td>{{$pp['name']}}</td>
        <td>{{$pp['poli_name']}}</td>
        <td>{{$pp['waktu']}}</td>
      </tr>
    @endforeach
  
    </tbody>
  </table>
  @endforeach
</body>
</html>
