<html>
<?php
    session_start();
    $user       = $_SESSION['verifiedUser'];
    //Make Sure User is Logged in
    if (!$user) {
        header("Location: https://gradephd.herokuapp.com/?error=Please Login First"); 
        exit();
    }   

    $final = $_SESSION['final'];
    $class= $_SESSION['class'];
    $misc1name=$_SESSION['misc1name'];
    $misc2name=$_SESSION['misc2name'];
    $misc3name=$_SESSION['misc3name'];
    
     


    $abbrev=array(
        'HW' => 'hw', 
        'Lab' => 'l', 
        'Quiz' => 'q', 
        'Test' => 't', 
        'Final' => 'f', 
        '$misc1name'=>'misc1',
        '$misc2name'=>'misc2',
        '$misc3name'=>'misc3'
        );
   
    $sql = "UPDATE $class SET ";
    foreach ($final as $name){
        if ($_POST[$name]==null) continue;
        $s=explode(" ",$name);
        $sql.=$abbrev[$s[0]].$s[1]."=";
        $sql .= $_POST[$name].", ";
    }
    $sql = rtrim($sql,', ');
    $sql.=" WHERE name = '$user';";
    function pg_connection_string_from_database_url() {
            extract(parse_url($_ENV["DATABASE_URL"]));
            return "user=$user password=$pass host=$host dbname=" . substr($path, 1); 
        }
       
    $db = pg_connect(pg_connection_string_from_database_url());
    echo $sql."<br>";
    pg_query($db,$sql);
    echo pg_last_error();
    
    $class=str_replace("0xDEADBEEF","-",$class);
    //header("Location: https://gradephd.herokuapp.com/plot.php?class=$class");
?>
    
</html>