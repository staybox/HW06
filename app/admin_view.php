<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Burgers Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.min.css">
    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        body {
            padding: 30px;
            font-family: "Verdana", sans-serif;
            font-size: 15px;
        }
        table {
            border: 1px solid #d3d3d3;
            border-collapse: collapse;
            text-align: left;
            margin-bottom: 30px;
        }
        thead {
            text-align: center;
            background-color: #eaeaea;
        }
        tbody {
            font-size: 14px;
        }
        td {
            padding: 6px 0;
            margin: 0;
            border: 1px solid #d3d3d3;
            vertical-align: middle;
        }
        .table-name {
            text-align: left;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 0 11px 15px;
            background-color: #c4e2ba;
        }
        .td-align-center {
            text-align: center;
        }
        .td-align-left {
            text-align: left;
            padding-left: 15px;
        }
    </style>

</head>
<body>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

    <table>
        <thead>
        <tr>
            <td colspan="4" class="table-name">Пользователи</td>
        </tr>
        <tr>
            <td width="50px">USER_ID</td>
            <td width="200px">NAME</td>
            <td width="300px">EMAIL</td>
            <td width="200px">PHONE</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $key=>$value) : ?>
            <tr>
                <td class="td-align-center"><?php echo $value['USER_ID']; ?></td>
                <td class="td-align-left"><?php echo $value['NAME']; ?></td>
                <td class="td-align-left"><?php echo $value['EMAIL']; ?></td>
                <td class="td-align-center"><?php echo $value['PHONE']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

    <table>
        <thead>
        <tr>
            <td colspan="5" class="table-name">Заказы</td>
        </tr>
        <tr>
            <td width="50px">USER_ID</td>
            <td width="200px">USERNAME</td>
            <td width="500px">ADDRESS</td>
            <td width="80px">PAYMENT</td>
            <td width="80px">CALLBACK</td>
        </tr>
        </thead>
        <tbody>
        <?php require_once 'utils.php'; ?>
        <?php foreach ($orders as $key=>$row) : ?>
            <?php $addr = makeBeautyAddress($row['STREET'], $row['HOME'], $row['PART'], $row['APPT'], $row['FLOOR']); ?>
            <?php //$addr = $row['STREET']. $row['HOME']. $row['PART']. $row['APPT']. $row['FLOOR']; ?>
            <tr>
                <td class="td-align-center"><?php echo $row['USER_ID']; ?></td>
                <td class="td-align-left"><?php echo $row['username']; ?></td>
                <td class="td-align-left"><?php echo $addr; ?></td>
                <td class="td-align-center"><?php ($row['PAYMENT'] > 0) ? ($p = 'card') : ($p = '$'); echo $p; ?></td>
                <td class="td-align-center"><?php ($row['CALLBACK'] > 0) ? ($c = 'no') : ($c = ''); echo $c; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

</body>
</html>