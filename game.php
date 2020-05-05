<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/widgets.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/scripts.js"></script>


    <title>河內塔</title>
</head>

<body>
    
    <div id="container-game" class="gameRunning">
        <div class="row">
            <div class="layout">
                <h2>河內塔</h2>

                <div class="game">
                    <div class="clear colNumber">
                        <div class="col3">
                            <span>3</span>
                        </div>
                        <div class="col3">
                            <span>2</span>
                        </div>
                        <div class="col3">
                            <span>1</span>
                        </div>
                    </div>
                    <div id="t3" ondrop="drop(event,3)" ondragover="allow(event)" class="col" data-id="3">
                    </div>
                    <div id="t2" ondrop="drop(event,2)" ondragover="allow(event)" class="col" data-id="2">
                    </div>
                    <div id="t1" ondrop="drop(event,1)" ondragover="allow(event)" class="col" data-id="1">
                    </div>

                    <div class="clear moveButton">
                        <div class="col3">
                            <button onclick="move(3,2)">2</button>
                            <button onclick="move(3,1)">1</button>
                        </div>
                        <div class="col3">
                            <button onclick="move(2,3)">3</button>
                            <button onclick="move(2,1)">1</button>
                        </div>
                        <div class="col3">
                            <button onclick="move(1,3)">3</button>
                            <button onclick="move(1,2)">2</button>
                        </div>
                    </div>

                </div>
                <div class="desc left">
                    <a href="index.php" class="btn btn-secondary">回到設定頁面</a>
                </div>
            </div>
            <div class="module">
                <div class="mod">
                    <h4>暱稱</h4>
                    <h2 id="name"></h2>
                </div>
                <div class="mod" id="move">
                    <h4>移動次數</h4>
                    <h2 id="step"></h2>
                </div>
				 <div class="mod" id="asideFuncButtons">
					<button onclick="replay()">重播</button>
				 </div>
            </div>
        </div>
    </div>
	<center id='err'>
	</center>
</body>
<?PHP
session_start();
if(isset($_GET["nickname"]) && isset($_GET["difficulty"]))
{
	$_SESSION["name"]=$_GET["nickname"];
	$_SESSION["level"]=$_GET["difficulty"];
	$_SESSION["step"]=0;
	$_SESSION["record"][0]=[1,1,1,1,1,1,1,1];
	$_SESSION["errstep"][0]=-1;
	$_SESSION["time"][0]=time();
	echo"<script>location.href='game.php'</script>";
}
$level=$_SESSION["level"];
$step=$_SESSION["step"];
$record=$_SESSION["record"];
$name=$_SESSION["name"];
$ec=count($_SESSION["errstep"]);
$all=$step-$ec+1;
echo
"
<script>
var s1=0,s2=0,s3=0;
var mid;
$('#step').html('$all');
$('#name').html('$name');
if($all>0)
{
	$('#asideFuncButtons').prepend(' <button onclick=\"prestep()\">上一步</button> ');
}
else
{
	$('#asideFuncButtons').prepend(' <button onclick=\"auto()\">自動解答</button> ');
}
$.ajax(
{
	url:'ajax.php',
	data:
	{
		'action':1
	},
	success:function(msg)
	{
		var req=msg.split('*');
		for(i=1;i<=$level;i++)
		{
			var c='\"brick b'+i+'\"';
			if(req[i]==1)
			{
				if(s1==0)
				{
					s1=i;
					$('#t1').append(' <div class='+c+' ondrag=\"drag(event)\" draggable=\"true\"></div> ');
				}
				else
				{
					$('#t1').append(' <div class='+c+'></div> ');
				}
			}
			if(req[i]==2)
			{
				if(s2==0)
				{
					s2=i;
					$('#t2').append(' <div class='+c+' ondrag=\"drag(event)\" draggable=\"true\"></div> ');
				}
				else
				{
					$('#t2').append(' <div class='+c+'></div> ');
				}
			}
			if(req[i]==3)
			{
				if(s3==0)
				{
					s3=i;
					$('#t3').append(' <div class='+c+' ondrag=\"drag(event)\" draggable=\"true\"></div> ');
				}
				else
				{
					$('#t3').append(' <div class='+c+'></div> ');
				}
			}
		}
		if(req[$level+1]==1)
		{
			$('body').append('<div hidden class=\"success\"><div class=\"container\"><div class=\"message\">遊戲成功!</div></div></div>');
		}
	}
});
function move(f,t)
{
	var bid=0;
	if(f==1){bid=s1;}
	if(f==2){bid=s2;}
	if(f==3){bid=s3;}
	$.ajax(
	{
		url:'ajax.php',
		data:
		{
			'fromStackId':f,
			'toStackId':t,
			'brickId':bid
		},
		success:function(msg)
		{
			var req=msg.split('*');
			if(req[1]=='1')
			{
				location.href=location.href;
			}
			else
			{
				$('#err').html('不被允許的移動!');
			}
		}
	});
}
function allow(e)
{
	e.preventDefault();
}
function drag(e)
{
	mid=e.target.parentElement.id;
}
function drop(e,t)
{
	var f=mid[1];
	if(f==t || f>3 || f<1 || t>3 || t<1)
	{
		return;
	}
	move(f,t);
}
function prestep()
{
	$.ajax(
	{
		url:'ajax.php',
		data:
		{
			'action':2
		},
		success:function(msg)
		{
			var req=msg.split('*');
			if(req[1]=='1')
			{
				location.href=location.href;
			}
		}
	});
}
function replay()
{
	location.href='replay.php?step=0';
}
function auto()
{
	location.href='auto.php?step=0';
}
</script>
";
?>

</html>