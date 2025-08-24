<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Secant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8e0e6;
            text-align: center;
            font-size: 16px;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            display: table;
            margin: 0 auto;
            width: fit-content;
            box-sizing: border-box;
            overflow: auto;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 15px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        form {
            text-align: center;
            margin-bottom: 15px;
        }

        label,
        input {
            display: block;
            margin: 0 auto 10px auto;
            font-size: 16px;
        }

        input[type="text"],
        input[type="number"] {
            font-size: 16px;
            padding: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            overflow-x: auto;
            font-size: 16px;
        }

        table,
        th,
        td {
            border: 1px solid #f4a5b1;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f7d4db;
        }

        input[type="submit"] {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Metode Secant</h2>
        <form action="secant.php" method="post">
            <label for="equation">Masukkan Persamaan (contoh: x^3 - 5*x + 1):</label>
            <input type="text" id="equation" name="equation" required><br>

            <label for="x0">Masukkan nilai x0:</label>
            <input type="number" step="any" id="x0" name="x0" required><br>

            <label for="x1">Masukkan nilai x1:</label>
            <input type="number" step="any" id="x1" name="x1" required><br>

            <label for="significant_digits">Masukkan jumlah angka signifikan:</label>
            <input type="number" id="significant_digits" name="significant_digits" min="1" required><br>

            <input type="submit" value="Hitung Akar">
        </form>

        <div class="result">
            <h3>Hasil Perhitungan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Iterasi</th>
                        <th>X_{i-1}</th>
                        <th>X_i</th>
                        <th>X_{i+1}</th>
                        <th>f(X_{i-1})</th>
                        <th>f(X_i)</th>
                        <th>f(X_{i+1})</th>
                        <th>E_a (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['result'])) {
                        $result = $_SESSION['result'];

                        if (isset($result[0]['error'])) {
                            echo "<tr><td colspan='8' class='error'>{$result[0]['error']}</td></tr>";
                        } else {
                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>{$row['iterasi']}</td>";
                                echo "<td>{$row['x0']}</td>";
                                echo "<td>{$row['x1']}</td>";
                                echo "<td>{$row['x_new']}</td>";
                                echo "<td>{$row['f_x0']}</td>";
                                echo "<td>{$row['f_x1']}</td>";
                                echo "<td>{$row['f_x_new']}</td>";
                                echo "<td>{$row['Ea']}</td>";
                                echo "</tr>";
                            }
                        }

                        unset($_SESSION['result']);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>