<?php
class pm25
{
    static function connect(){
        $db_ip="127.0.0.1";
        $db_user="root";
        $db_password="pomelo8911285";
        $db_select="PM2.5";
        $db_charset = "UTF8";

        $DSN="mysql:host=$db_ip;dbname=$db_select;charset=$db_charset";

        try{
            $connect=new PDO($DSN,$db_user,$db_password);
            $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo "連接失敗 ： " . $e->getMessage();
        }
        return $connect;
    }

    static function get_data(){
            $handle = fopen('http://opendata.epa.gov.tw/ws/Data/ATM00625/?$format=json',"rb");
        $content = "";
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        $data = json_decode($content);
        return $data;
    }

    static function sql_data(){
        $sql="SELECT * FROM `pm25_data`";
        $result=self::connect()->query($sql);
        return $result;
    }

    static function data_list(){
        foreach (self::sql_data() as $data){
            echo $data['county'];
            echo $data['site']."&nbsp&nbsp&nbsp&nbsp";
            echo $data['pm25']."&nbsp&nbsp&nbsp&nbsp";
            echo $data['time']. "<br>";
        }
    }

    static function time_list(){
        $temp_time[0]="";
        $temp=0;
        foreach (self::sql_data() as $data) {
            $find=0;
            for($i=0;$i<=$temp;$i++) {
                if ($data['time']==$temp_time[$i]){
                    $find++;
                }
            }
            if($find==0){
                $temp++;
                $temp_time[$temp]=$data['time'];
                echo "<a href='time_data.php?time=" . $data['time'] . "'>" . $data['time'] . "</a><br>";
            }
        }
    }

    static function time_data($time){
        foreach (self::sql_data() as $row){
            if($row['time']==$time){
                echo "<a href='data.php?id=" . $row['id'] . "'>" . $row['site'] . "</a><br>";
            }
        }
    }

    static function place_data($id){
        foreach (self::sql_data() as $data) {
            if($data['id']==$id) {
                echo $data['site']. "<br>";
                echo $data['county']. "<br>";
                echo $data['pm25']."<br>";
                echo $data['time']. "<br>";
            }
        }
    }

    static function save_data(){
        echo "上次更新時間： " . date("Y-m-d h:i:sa")."<br>";

        $data=self::get_data();
        $data_size=count($data);
        for($i=0;$i<$data_size;$i++) {
            $site = $data[$i]->Site;
            $county = $data[$i]->county;
            $pm25 = $data[$i]->PM25;
            $time = $data[$i]->DataCreationDate;

            $sql="SELECT COUNT(*) FROM `pm25_data` WHERE `site`='$site' AND `time`='$time'";
            $result=self::connect()->query($sql);
            foreach ($result as $row){
                if($row[0]==0){
                    $sql="INSERT INTO `pm25_data`(`id`, `site`, `county`, `pm25`, `time`) 
                    VALUES (NULL ,'$site','$county','$pm25','$time')";
                    echo $site."_". $sql."<br>";
                    $insert=self::connect()->prepare($sql);
                    $insert->execute();
                }
                else {
                    echo $site. "_已有資料<br>";
                }
            }
        }
    }

}
?>