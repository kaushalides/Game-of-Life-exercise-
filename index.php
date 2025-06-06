<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{Game Of Excercise }}</title>
    <style>
        .centerTable {
            margin: 0px auto;
            border-collapse: collapse;
            margin-top: 50px;
        }

        td {
            width: 20px;
            height: 20px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .alive {
            background-color: green;
        }

        .dead {
            background-color: white;
        }
    </style>
</head>

<body>
    <table class="centerTable">
        <?php
        define('ROWS', 25);
        define('COLS', 25);
        function populateNextGen($currentGrid)
        {
            $rows = ROWS;
            $cols = COLS;
            $newGrid = array_fill(0, $rows, array_fill(0, $cols, 0));
            for ($a = 0; $a < $rows; $a++) {
                for ($b = 0; $b < $cols; $b++) {
                    $status = $currentGrid[$a][$b];
                    $neighborStatusCount = getNeighborStatus($currentGrid, $a, $b);
                    // rules
                    if ($status === 1) {
                        if ($neighborStatusCount < 2) {
                            $newGrid[$a][$b] = 0;
                        } else if ($neighborStatusCount == 2 ||  $neighborStatusCount == 3) {
                            $newGrid[$a][$b] = 1;
                        } else if ($neighborStatusCount > 3) {
                            $newGrid[$a][$b] = 0;
                        }
                    } else {
                        if ($neighborStatusCount == 3) {
                            $newGrid[$a][$b] = 1;
                        }
                    }
                }
            }
            return $newGrid;
        }
        function getNeighborStatus($currentGrid, $x, $y)
        {
            $livecount = 0;
            $directions = [
                [0, 1],   // x,y+1
                [1, 1],   // x+1,y+1
                [1, 0],   // x+1,y
                [1, -1],  // x+1,y-1
                [0, -1],  // x,y-1
                [-1, -1], // x-1,y-1
                [-1, 0],  // x-1,y
                [-1, 1]   // x-1,y
            ];

            foreach ($directions as $dir) {
                $neighborX = $x + $dir[0];
                $neighborY = $y + $dir[1];
                if ($neighborX >= 0 && $neighborX < ROWS && $neighborY >= 0 && $neighborY < COLS) {
                    if ($currentGrid[$neighborX][$neighborY] === 1) {
                        $livecount++;
                    }
                }
            }
            return $livecount;
        }
        $grid = array();
        $grid = array_fill(0, 25, array_fill(0, 25, 0));

        $grid[11][12] = 1;
        $grid[12][13] = 1;
        $grid[13][11] = 1;
        $grid[13][12] = 1;
        $grid[13][13] = 1;
        // print "<pre>";
        // print_r($grid);
        // print "</pre>";
        $grid =    populateNextGen($grid);
        for ($i = 0; $i < ROWS; $i++) { ?>
            <tr>
                <?php
                for ($j = 0; $j < COLS; $j++) {


                    $class = $grid[$i][$j] === 1 ? 'alive' : 'dead';

                ?>
                    <td class="<?= $class ?>">
                    </td>
                <?php
                }
                ?>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>