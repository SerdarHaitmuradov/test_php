<?php


class People
{
public $_id;
public $_name;
public $_surname;
public $_date_of_birth;
public $_gender_number;
public $_place_of_birth;

public function __construct($id,$name,$surname,$date_of_birth,$gender_number,$place_of_birth)
{
$this->_id=$id;
$this->_name=$name;
$this->_surname=$surname;
$this->_date_of_birth=$date_of_birth;
$this->_gender_number=$gender_number;
$this->_place_of_birth=$place_of_birth;
$db=mysqli_connect('localhost','root','','people_list');
if(mysqli_connect_errno($db))
{
echo'error to connect to data base';
}
else
{
    $res = mysqli_query($db,"SELECT * FROM people WHERE id ='$this->_id'");
    $count=mysqli_num_rows($res);

}
    if( $count > 0 )
    {
        while($human=$res->fetch_array())
        {
            echo 'id:' .' '. $human['id']; 
        }
    }
    else
    {
        mysqli_query($db,"INSERT INTO people(id,name, surname, date_of_birth, gender, place_of_birth)
        VALUES('$this->_id','$this->_name','$this->_surname','$this->_date_of_birth','$this->_gender_number','$this->_place_of_birth')"); 
    }
}

public function save_to_dataBase($host,$login,$password,$name_of_db,$table_of_base)
{
$db=mysqli_connect($host,$login,$password,$name_of_db);
if(mysqli_connect_errno($db))
{
echo'error to connect to data base';
}
return
    mysqli_query($db,"INSERT INTO $table_of_base(id,name, surname, date_of_birth, gender, place_of_birth)
VALUES('$this->_id','$this->_name','$this->_surname','$this->_date_of_birth','$this->_gender_number','$this->_place_of_birth')");
}

public function delete_from_dataBase($host,$login,$password,$name_of_db,$table_of_base,$id)
{
$db=mysqli_connect($host,$login,$password,$name_of_db);
if(mysqli_connect_errno($db))
{
echo'error to connect to data base';
}
else
{
mysqli_query($db,"DELETE FROM $table_of_base WHERE id=$id");
}
}

public static function date_to_age($date_of_birth)
{
$date=new DateTime($date_of_birth);
$now=new DateTime();
$inter=$now->diff($date);
return $inter->y;
}

public static function genderNumber_to_str($gender)
{
    if($gender==0)
    {
        $gender='female';
        return $gender;
    }
    if($gender==1)
    {
        $gender='male';
        return $gender;
    }
}

public function format_to_stdClass($id,$name,$surname,$date_of_birth,$gender_number,$place_of_birth)
{
    $age=People::date_to_age($date_of_birth);
    $gender=People::genderNumber_to_str($gender_number);
    $obj=new stdClass();
    $obj->id=$id;
    $obj->name=$name;
    $obj->surname=$surname;
    $obj->age=$age;
    $obj->gender=$gender;
    $obj->place_of_birth=$place_of_birth;
    return $obj;
}
}














