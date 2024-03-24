<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ $title }}</title>
</head>
<body>
<style>
    @font-face {
        font-family: 'Sylfaen';
        src: url('{{ asset('fonts/sylfaen.ttf') }}') format('truetype');
    }
    .AM{
        font: normal 12px/20px Sylfaen;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
</style>
{{--{{dd($partnerPersonList)}}--}}
<table class="table AM">
    <thead>
    <tr>
        <th><b>{{ trans("auth.email_address") }}</b></th>
        <th><b>{{ trans("auth.last_name") }}</b></th>
        <th><b>{{ trans("auth.first_name") }}</th>
        <th><b>{{ trans("auth.patronymic_name") }}</b></th>
        <th><b>{{ trans("auth.position") }}</b></th>
{{--        <th><b>{{ trans("auth.company_code_short") }}</b></th>--}}
        <th><b>{{ trans("auth.created_at") }}</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($partnerPersonList as $partnerPerson)

        <tr>
            <td>{{ $partnerPerson["email"] }}</td>
            <td>{{ $partnerPerson["first_name"] }}</td>
            <td>{{ $partnerPerson["last_name"] }}</td>
            <td>{{ $partnerPerson["patronymic_name"] }}</td>
            <td>{{ $partnerPerson["position"] }}</td>
{{--            <td>{{ $partnerPerson->company_code }}</td>--}}
{{--            <td>{{ $partnerPerson["created_at"] }}</td>--}}
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
