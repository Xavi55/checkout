<?php
$db=json_decode(file_get_contents(__DIR__.'/bikerentals.json'),true)["products"];
function getProducts()
{
  global $db;
  /* $arr=array();
  foreach($db as $product)
  {
    if($product["product_type"]==$name)
    {
      $arr[]=$product;
    }
  } */
  return $db;
}

//$bikes=getProducts('bike');
//var_dump($bikes);
?>
