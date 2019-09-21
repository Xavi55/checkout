<?php
//DB/data
require('model/db.php');

session_start();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL)
{
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL)
    {
        $action = 'home-page';
    }
}

//$_SESSION["name"]="Kevin";
//unset ($_SESSION["cart"]);//=array();
switch($action)
{
  case 'home-page';
	header('Location: view/home.html');
	break;

	case 'load':
		$p=getProducts();
		echo json_encode($p);
		break;

	case 'add':
		$details=($_POST["product"]);
		$product=($_POST["id"]);
		if(isset($_SESSION["cart"][$product]))
		{
			$_SESSION["cart"][$product]["count"]++;
		}
		else
		{
			$_SESSION["cart"][$product][]=$details;
			$_SESSION["cart"][$product]["count"]=1;
		}
		//$_SESSION["cart"].push($product);
		echo $_SESSION["cart"][$product]["count"];
		//$_SESSION["checkout"]=1;
		//$_SESSION["cart"][$product]["count"]+=1;
		break;

	case 'sub':
		$product=($_POST["id"]);
		if(isset($_SESSION["cart"][$product]))
		{
			$_SESSION["cart"][$product]["count"]--;
			
			if($_SESSION["cart"][$product]["count"]==0)
			{
				unset($_SESSION["cart"][$product]);
				echo 0;
				//$_SESSION["cart"][$product]["count"]=0;
			}
			else
			{
				echo ($_SESSION["cart"][$product]["count"]);
			}
		}
		else
		{
			echo 0;
		}
		break;

	case 'reload':
		if(isset($_SESSION['cart']))
		{
			$arr=array();
			foreach($_SESSION["cart"] as $key => $value)
			{
				$arr[$key]=$value["count"];
				//print_r($key);
				//print_r($value["count"]);
			}
			echo json_encode($arr);
		}
		else
		{
			echo 0;
		}
		break;
	case 'clearCart':
		unset($_SESSION["cart"]);
		echo json_encode(1);
		break;
	
	case 'summary':
		if(isset($_SESSION["cart"]))
		{
			echo json_encode($_SESSION["cart"]);
		}
		else
		{
			echo 0;
		}
		break;

}
/*
switch($action)
{
case 'login':
	$email = filter_input(INPUT_POST, 'email');
	$pass = filter_input(INPUT_POST, 'pass');		
	$info=login($email,$pass);
	if( $info )
	{		
		$_SESSION['user'] = $info['fname'].' '.$info['lname'];
		$_SESSION['email'] = $info['email'];
//		var_dump($info);

		//include('view/home.php');
		header('Location: .?action=home');
	}
	else
	{
		//header('Location:view/login.html');
		header('Refresh:0');
		echo '<script>alert("Wrong Email / Password \nPlease Try Again");//window.location.href="https://web.njit.edu/~kxg2/todo";</script>';
	}
	break;

case 'signup':
	$fname = filter_input(INPUT_POST, 'fname');
	$lname = filter_input(INPUT_POST, 'lname');
	$email = filter_input(INPUT_POST, 'email');
	$bday = filter_input(INPUT_POST, 'bday');
	$phone = filter_input(INPUT_POST, 'phone');
	$gender = filter_input(INPUT_POST, 'gender');
	$pass = filter_input(INPUT_POST, 'pass');

		//echo "$fname $lname $email $bday $phone $gender $pass";

	signup($fname, $lname, $email, $bday, $phone, $gender, $pass);

	//header('Location: ../.');
	echo "<br><br><h1 style='text-align:center;color:black;'>Successful sign in!</h1>";
	header('Refresh:1');	
	break;

	case 'add_page':
		include('view/add.php');
		break;

	case 'add':
//        	$email = filter_input(INPUT_POST, 'email');

        	$due = filter_input(INPUT_POST, 'due');
        	$mesg = filter_input(INPUT_POST, 'mesg');
		add($_SESSION['email'],$due,$mesg);
		header('Location: .?action=home');
		break;

	case 'delete':
		delete( filter_input(INPUT_POST,'id') );
		header('Location: .?action=home');
		break;
	
	case 'edit_page':
		$_SESSION['task'] = filter_input(INPUT_POST, 'id');
		include('view/edit.php');
		break;

	case 'edit':

                $due = filter_input(INPUT_POST, 'due');  
                $mesg = filter_input(INPUT_POST, 'mesg');

                edit($_SESSION['task'],$due,$mesg);

		
		unset($_SESSION['task']);

		header('Location: .?action=home');
		break;

	case 'check':
		check( filter_input(INPUT_POST,'id') );
                header('Location: .?action=home');
		break;

        case 'revert':
                revert( filter_input(INPUT_POST,'id') );
                header('Location: .?action=home');
                break;

	case 'home':
		$tasks = getTasks($_SESSION['email']);
		$done = getDone($_SESSION['email']);  
		include('view/home.php');
		break;

	case 'login_page':
		header('Location: ./view/login.html');
		break;

	case 'logout':
		session_unset();
		session_destroy();
		header('Location:view/login.html');
		echo '<script>alert("Logout Successful");</script>';
		break;
}
*/



?>