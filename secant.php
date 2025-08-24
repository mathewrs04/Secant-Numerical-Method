<?php
session_start(); 


function evaluate_equation($equation, $x)
{
    $equation = str_replace("^", "**", $equation);
    $equation = str_replace("x", "($x)", $equation);
    return eval("return $equation;");
}


function calculate_absolute_error($significant_digits) {
    return 0.5 * pow(10, 2 - $significant_digits);
}

function secant_method($equation, $x0, $x1, $max_iter = 100, $significant_digits) {
    $iter_count = 0;
    $result = [];

    $es = calculate_absolute_error($significant_digits); 

    while ($iter_count < $max_iter) {
        
        $f_x0 = evaluate_equation($equation, $x0);
        $f_x1 = evaluate_equation($equation, $x1);

        
        if (($f_x0 - $f_x1) == 0) {
            return [["error" => "Error: Division by zero encountered."]];
        }

        
        $x_new = $x1 - ($f_x1 * ($x0 - $x1)) / ($f_x0 - $f_x1);

        $f_x_new = evaluate_equation($equation, $x_new);

        
        $Ea = ($iter_count > 0) ? abs(($x_new - $x1) / $x_new) * 100 : 0;

        $result[] = [
            'iterasi' => $iter_count + 1,
            'x0' => $x0,
            'x1' => $x1,
            'x_new' => $x_new,
            'f_x0' => $f_x0,
            'f_x1' => $f_x1,
            'f_x_new' => $f_x_new,
            'Ea' => $Ea
        ];

        if ($Ea < $es && $iter_count > 0) {
            return $result; 
        }

        $x0 = $x1;
        $x1 = $x_new;
        $iter_count++;
    }
    return $result; 
}


if (isset($_POST['equation']) && isset($_POST['x0']) && isset($_POST['x1']) && isset($_POST['significant_digits'])) {
    $equation = $_POST['equation'];
    $x0 = $_POST['x0'];
    $x1 = $_POST['x1'];
    $significant_digits = intval($_POST['significant_digits']); 

    if (!is_numeric($x0) || !is_numeric($x1)) {
        $_SESSION['result'] = [["error" => "Error: x0 and x1 must be numeric."]];
    } else {
        $result = secant_method($equation, $x0, $x1, 100, $significant_digits); 
        $_SESSION['result'] = $result;
    }

    header('Location: tes.php');
    exit();
} else {
    $_SESSION['result'] = [["error" => "Error: All inputs must be filled."]];
    header('Location: tes.php');
    exit();
}
?>
