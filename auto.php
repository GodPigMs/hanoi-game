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
					<button>重播</button>
				 </div>
            </div>
        </div>
    </div>
	<font color="red" size="8px" id="err"></font>
</body>
<?PHP
session_start();
if(!isset($_GET["step"]) )
{
	echo"<script>location.href='game.php'</script>";
}
$level=$_SESSION["level"];
$nows=$_GET["step"];
echo
"
<script>
var brick=[1,1,1,1,1,1,1,1];
var all=0;
var nowc=0;
auto($level,1,2,3);
$('#step').html('$nows');
$('#name').html('自動解答');
function auto(n,f,st,t)
{
	if(n==1)
	{
		all++;
		if(nowc<=$nows)
		{
			nowc++;
			brick[n]=t;
		}
	}
	else
	{
		auto(n-1,f,t,st);
		all++;
		if(nowc<=$nows)
		{
			nowc++;
			brick[n]=t;
		}
		auto(n-1,st,f,t);
	}
}
for(i=1;i<=$level;i++)
{
	var c='\"brick b'+i+'\"';
	if(brick[i]==1)
	{
		$('#t1').append(' <div class='+c+'></div> ');
	}
	if(brick[i]==2)
	{
		$('#t2').append(' <div class='+c+'></div> ');
	}
	if(brick[i]==3)
	{
		$('#t3').append(' <div class='+c+'></div> ');
	}
}
setTimeout(function()
{
	//alert('');
	if(nowc>=all)
	{
		location.href='game.php';
	}
	else
	{
		location.href='auto.php?step='+($nows+1);
	}
},500);
</script>
";
?>

</html>