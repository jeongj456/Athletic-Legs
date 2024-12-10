<!DOCTYPE html>
<html>
    <head>
        <title>Nutrition Calculator</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        
        <style>
            h1 {text-align: center; color: #FFAEAE; font-family: Josefin Sans; font-style: italic; font-weight: bold;}
            body {background-color: #006CA1; font-style: Josefin Sans; font-weight: bold;}            
            .containing_box {background-color: #008CD1; border-radius: 10px;}            
            form {text-align: center;}                       
            input[type=text] {width: 10%; background-color: #D9D9D9; transition: width 0.4s ease-in-out;}            
            input[type=text]:focus {width: 25%;}
            input[type="text"]::placeholder {text-align: right;}   
            th {border: red; text-align: center;}
            td {text-align: center;}
        </style>

    </head>
    <body>
        <h1>Nutrition Calculator</h1>

        <div class="containing_box">
            <form action="backend.php" method="POST">
                <center><div class="date_consumed">
                    <label for="date_consumed">Date</label>
                    <input type="date" id="date_consumed" name="date_consumed">
                </div></center>
            
                <center><div class="food_name">
                    <label for="food_name">Name of Food</label>
                    <input type="text" id="food_name" name="food_name">
                </div></center>

                <center><div class="protein_content">
                    <label for="protein_content">Protein</label>
                    <input type="text" id="protein_content" name="protein_content" placeholder="g">
                </div></center>

                <center><div class="fat_content">
                    <label for="fat_content">Fat</label>
                    <input type="text" id="fat_content" name="fat_content" placeholder="g">
                </div></center>

                <center><div class="carb_content">
                    <label for="carb_content">Carbs</label>
                    <input type="text" id="carb_content" name="carb_content" placeholder="g">
                </div></center>
                <button type="submit">Submit</button>
            </form>
        </div>

        <br><br><br>

        <center><table style="width: 600px;">
            <tr style="text-align: center; background-color: gray; border: 4px solid black">
                <th>ID</th>
                <th>Date</th>
                <th>Name</th>
                <th>Protein</th>
                <th>Fat</th>
                <th>Carbs</th>
            </tr>
            <div style="overflow-y: scroll;">
                <?php
                    $conn = mysqli_connect('localhost', 'jjjeong', '50233699', 'jjjeong_db');
                    $result = $conn->query("SELECT * FROM nutrition ORDER BY id ASC");
                    /*
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"] . "</td><td>". $row["date"] . "</td><td>" . $row["name"] . "</td><td>" . $row["protein"] . "</td><td>" . $row["fat"] . "</td><td>" . $row["carbs"]. "</td></tr>";
                    }
                    */
                    $counter = 0;
                    while ($counter<10) {
                        $row = $result->fetch_assoc();
                        echo "<tr><td>" . $row["id"] . "</td><td>". $row["date"] . "</td><td>" . $row["name"] . "</td><td>" . $row["protein"] . "</td><td>" . $row["fat"] . "</td><td>" . $row["carbs"]. "</td></tr>";
                        $counter++;
                    }
                ?>
            </div>
        </table></center>

    </body>
</html>