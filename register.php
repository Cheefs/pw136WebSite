<title> Регистрация | Perfect World</title>
<head>
    <meta http-equiv="content-type" content="text/html"; charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
   
    <div class="header">
        <div class="headerContainer">
            <a href="index.html">Главная</a>
            <a href="#">Форум</a>
            <a href="register.php">Регистрация</a>
            <a href="#">Скачать</a>
            <a href="#">Личный кабинет</a>
        </div>
        <!-- <embed src="audio/1.mp3" width="300" height="450" align="left" hidden="false" autostart="False" loop="True"> -->
        
    </div>
    <hr>
    <div class="container">
        <div class="logo">
                <!-- <img src="images/logo.jpeg" alt="Perfect World"></img> -->
                <strong> Регистрация на сервере </strong>
	           <!--  <h3> Рerfect World Server 1.5.1(v101) </h3> -->
        </div>

        <form id="register" action="?do=register" method=post>

            <div>
                <div>
                    <strong>Логин:</strong>
                    <input class="input_box" type=text name=login>
                </div>

                <div>
                    <strong> Пароль:</strong>
               
                    <input class="input_box" type=password name=passwd>
                </div>

                <div>
                    <strong> Повтор пароля:</strong>
                    <input class="input_box" type=password name=repasswd>
                </div>
               
                <div>
                    <strong> E-Mail:</strong>
                    <input class="input_box" type=text name=email>
            </div>
            <input class="input_submit" type=submit name=submit value="Регистрация">

        </form>
        </div>
    </div>
    <div class="footer"> 
        <div class="statusBlock">
            <?php
                $config = array
                (
		            'host'	=>	'localhost',				// Хост
		            'user'	=>	'root',						// Имя пользователя
		            'pass'	=>	'1234',			            // Пароль от БД
		            'name'	=>	'pw',						// Название БД
		            'gold'	=>	'1000000000',				// Количество голда
                );

                if (isset($_POST['login']))
                {
			        $link = mysql_connect($config['host'], $config['user'], $config['pass']) or die ("Нет соединения с MySQL");
			        mysql_select_db($config['name'], $link) or die ("Базы ".$DBName." не существует o_O");
            
                    $Login = $_POST['login'];
                    $Pass = $_POST['passwd'];
                    $Repass = $_POST['repasswd'];
                    $Email = $_POST['email'];
            
                    $Login = StrToLower(Trim($Login));
                    $Pass = StrToLower(Trim($Pass));
                    $Repass = StrToLower(Trim($Repass));
                    $Email = Trim($Email);

                if (empty($Login) || empty($Pass) || empty($Repass) || empty($Email))
                {
                    echo "Все поля заполнены не верно!";
                }
            
                elseif (ereg("[^0-9a-zA-Z_-]", $Login, $Txt))
                {
                    echo "Не верный формат логина";
                }
            
                elseif (ereg("[^0-9a-zA-Z_-]", $Pass, $Txt))
                {
                    echo "Не верный формат пароля"; 
                }
			
                elseif (ereg("[^0-9a-zA-Z_-]", $Repass, $Txt))
                {
                    echo "Не верный формат повтора пароля";
                }
            
                elseif (StrPos('\'', $Email))
                {
                    echo "Не верный формат E-Mail";
                }
            
                elseif ((StrLen($Login) < 4) or (StrLen($Login) > 10))
                {
                    echo "Логин должен содержать не менее 4 и не более 10 смволов.";
                }
                else
                {
                    $Result = MySQL_Query("SELECT name FROM users WHERE name='$Login'") or ("Can't execute query.");
                
                    if (MySQL_Num_Rows($Result))
                    {
                        echo "<font color='red'>Логин</font> <b>".$Login."</b> <font color='red'>уже есть в базе -_-</font>";
                    }
            
                    elseif ((StrLen($Pass) < 4) or (StrLen($Pass) > 10))
                    {
                        echo "Пароль должен содержать не менее 4 и не более 10 смволов.";
                    }
            
                    elseif ((StrLen($Repass) < 4) or (StrLen($Repass) > 10))
                    {
                        echo "Повтор пароля должен содержать не менее 4 и не более 10 смволов";
                    }
            
                    elseif ((StrLen($Email) < 4) or (StrLen($Email) > 25))
                    {
                        echo "E-Mail  должен содержать не менее 4 и не более 25 смволов";
                    }
		            else
			        {
				        $Result = MySQL_Query("SELECT name FROM users WHERE name='$Email'") or ("Can't execute query.");
		                if (MySQL_Num_Rows($Result))
			            {
				            echo "<font color='red'>E-Mail</font> <b>".$Email."</b> <font color='red'>уже есть в базе -_-</font>";
			            }
            
                        elseif ($Pass != $Repass)
                        {
                            echo "Пароли не совпадают";
                        }        
                        else
                        {
            	        //$Salt = $Login.$Pass;
				        //$Salt = md5($Salt);
                        //$Salt = "0x".$Salt;
				        $Salt = base64_encode(md5($Login.$Pass, true));
				        MySQL_Query("call adduser('$Login', '$Salt', '0', '0', '0', '0', '$Email', '0', '0', '0', '0', '0', '0', '0', '', '', '$Salt')") or die ("Аккаунт не зарегистрирован");
				        $mysqlresult=MySQL_Query("select * from `users` WHERE `name`='$Login'");
				        $User_ID=MySQL_result($mysqlresult,0,'ID');
				        MySQL_Query("call usecash({$User_ID},1,0,1,0,".$config['gold'].",1,@error)") or die ("Голд не выдан");
			            echo "<font color='green'>Аккаунт <b>".$Login."</b> Успешно зарегистрирован :) Ваш ID: ".$User_ID." <br/> ".$config['gold']." голда начислено. Голд придет в течении 5-10 минут";
				        }
			        }
		        }
	        }
            echo $Data;
            ?>
        </div>
    </div>
</body>
