<!doctype html>
 
<html>
<head>
<meta http-equiv="refresh" content="3000;url=https://www.dotiko.cz/jobs/dragdrop.php">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <neta http-equiv="cache-control" content="no-cache">
  <title>Dotiko - nastenka</title>
  
  <script src="jquery-2.2.0.min.js"></script>
  <script src="jquery-ui-1.11.4/jquery-ui.min.js"></script>



<style>

div#stitekx
{
    font-size: 10px;
    font-family: Arial;
}

#set div
{
    position: absolute;
    border-width: 1px;
    border-style: solid;
    border-color: gray;
    display: table;
    font-size: 14px;
    font-family: Arial;
    width: 135px;
    float: left;
}


#set { clear:both; float:left; width: 150px;}
  p { clear:both; margin:0; padding:1em 0; }


#set .float
 {
  display: table-cell;
  vertical-align: middle;
  text-align: center;
 }
a:link, a:visited    {text-decoration: none; color:black}


</style>

<style type="text/css">
input[type='checkbox'] {
width:10px;
height:10px;

}
</style>



  <script>

 $(function() {
  $( "#set div" ).draggable({

 cursor: "move",
//  grid: [ 140, 2 ],
//  snap: true,
 // snapTolerance: 20,
 // opacity: 0.85,
 // handle: "#set div",
 // zIndex: 100,
  //snap: "#set div",
  // grid: [ 2, 2 ],
  
  //cursor: 'move',
   // cursorAt: { top: 25, left: 65 },
      
    stack: "#set div",
      stop: function(event, ui) {
  
  var pos_x = ui.offset.left;
  var pos_y = ui.offset.top;
  var need = ui.helper.data("need");
  
var barva = $(this).css("background-color");
          
          console.log(pos_x);
          console.log(pos_y);
          console.log(need);
          console.log(barva);
          
          //Do the ajax call to the server
          $.ajax({
              type: "POST",
              url: "drag_uloz.php",
              data: { x: pos_x, y: pos_y, need_id: need, b: barva}
            }).done(function( msg ) {
       //       alert( "Data Saved: " + msg );
            }); 
      }
  });


   $('#trash').droppable({
           over: function(event, ui) {
           ui.draggable.remove();

          }
   });
});


  </script>

</head>
<body
 style="color: rgb(0, 0, 0); background-color: rgb(192, 196, 220);"
 alink="#000099" link="#000099" vlink="#990099">

<div style="width:1920px;high:1080px; overflow: auto;">
 
 <form action="dragdrop.php" method="get">
 
 <div id="set">
 
<?php 

$dodelat = $_GET['stitek'];
$boxselect = implode(" or id=", $dodelat);
//echo $boxselect;


include("inc/connect.php");

$xquery="select id, maj_mesto from ubytovatele where id = $boxselect";
$xresult=mysql_query($xquery);
$num = mysql_num_rows ($xresult);
mysql_close();
//echo $num;
$i=0;

while ($i < $num): 

$drag_id = mysql_result($xresult,$i,"id");
$drag_stitek = mysql_result($xresult,$i,"maj_mesto");
$stitekstring = explode("/", $drag_stitek);

$stitekstring[3]=$akce;
//$novabarva = implode("/", $stitekstring);

include("inc/connect.php");

if ($akce=="odstranit"):
$xquery="update ubytovatele set maj_mesto = ''  where id = $drag_id";
elseif($akce=="opravit"):
//echo "oprav".$stitek[0];
header("Location: https://www.dotiko.cz/jobs/update.php?id=$stitek[0]");
exit;

elseif($akce=="presunout"):
//echo "presun";

https://www.dotiko.cz/jobs/index.php?box%5B%5D=56&box%5B%5D=363
$urlpresunout = str_replace ("stitek", "box", $_SERVER['REQUEST_URI']);
$urlpresunout = str_replace ("dragdrop", "index", $urlpresunout);
$urlpresunout = str_replace ("&akce=presunout", "&skupiny=dotiko", $urlpresunout);
header("Location: https://www.dotiko.cz$urlpresunout");
exit;
else:
$xquery="update ubytovatele set maj_mesto = '$stitekstring[0]/$stitekstring[1]/$stitekstring[2]/$stitekstring[3]'  where id = $drag_id";
endif;
//echo $xquery;
mysql_query($xquery);

//mysql_close();

$i++;
endwhile;


 //select id,  ubytovatel, telefon, maj_mesto from ubytovatele where maj_mesto > 0
 
 include("inc/connect.php");

$xquery="select id,  ubytovatel, telefon, maj_mesto, okres, kontroly from ubytovatele where maj_mesto > 0 and skupina = 'dotiko'";
$xresult=mysql_query($xquery);
$num = mysql_num_rows ($xresult);
mysql_close();

echo "<b>".$num."</b> zaměstnanců";

$i=0;

while ($i < $num): 

$drag_id = mysql_result($xresult,$i,"id");
$drag_okres = mysql_result($xresult,$i,"okres");
$drag_prijmeni = mysql_result($xresult,$i,"ubytovatel");
$drag_jmeno = mysql_result($xresult,$i,"telefon");

if(mb_strlen($drag_prijmeni,"UTF-8")>7):
$drag_jmeno="";
elseif(mb_strlen($drag_prijmeni,"UTF-8")+mb_strlen($drag_jmeno,"UTF-8")>=12):
$drag_jmeno=mb_substr($drag_jmeno,0,3,"UTF-8").".";
else:
$drag_jmeno=mb_substr($drag_jmeno,0,10,"UTF-8");
endif;

$drag_stitek = mysql_result($xresult,$i,"maj_mesto");
$drag_kontroly = mysql_result($xresult,$i,"kontroly");

$stitekstring = explode("/", $drag_stitek);

if ($drag_kontroly=="ano"):
  $drag_kontroly= "<img style=\"width:10px;\" src=auto.jpg>";
  else:
  $drag_kontroly= "";
  endif;


//<table border="0"><tr><td style="text-align: center; width: 100%;" rowspan="2">
//</td><td style="text-align: right;">
//</td></tr><tr><td style="text-align: center;">
//</td></tr></table>
//style="column-count:2;
?>

<div title="<?php echo $drag_okres;?>" style="left:<?php echo $stitekstring[0];?>px;top:<?php echo $stitekstring[1];?>px; background: <?php echo $stitekstring[3];?>;" data-need="<?php echo $drag_id;?>">
<span class="left"><input type="checkbox" name="stitek[]" value="<?php echo $drag_id;?>">
<?php // echo $drag_kontroly;?>
<a href=detail.php?id=<?php echo $drag_id;?>&disabled=disabled>

<?php if(mb_strlen($drag_prijmeni,"UTF-8")>=12):?>
<font size="1"><?php echo mb_strtoupper($drag_prijmeni,"UTF-8");?></font>

<?php elseif(mb_strlen($drag_prijmeni,"UTF-8")>10):?>
<font size="2"><?php echo mb_strtoupper($drag_prijmeni,"UTF-8");?></font>

<?php else: ?>
<?php echo mb_strtoupper($drag_prijmeni,"UTF-8");?>
<?php endif;?>

<small><?php  echo $drag_jmeno;?></a></small>
</span>
</div>

<?php
 
$i++;

endwhile;


?>

<?php
include("inc/connect.php");
$xquery="select * from stitky";
$xresult=mysql_query($xquery);
$num = mysql_num_rows ($xresult);
mysql_close();

$i=0;

while ($i < $num): 

$dragdrop_id = mysql_result($xresult,$i,"id");
$dragdrop_firma = mysql_result($xresult,$i,"firma");
$dragdrop_mesto = mysql_result($xresult,$i,"mesto");
$dragdrop_left_x = mysql_result($xresult,$i,"left_x");
$dragdrop_top_y = mysql_result($xresult,$i,"top_y");
$dragdrop_sirka = mysql_result($xresult,$i,"sirka");
$dragdrop_vyska = mysql_result($xresult,$i,"vyska");
$dragdrop_barva = mysql_result($xresult,$i,"barva");


?>

<?php if(strlen($dragdrop_mesto)>0):?>

<div id="stitekx"; style="overflow:scroll;overflow-x:hidden;overflow-y:scroll;  height:<?php echo $dragdrop_vyska;?>px; width:<?php echo $dragdrop_sirka;?>px;left:<?php echo $dragdrop_left_x;?>px;top:<?php echo $dragdrop_top_y;?>px; background: <?php echo $dragdrop_barva;?>;" data-need="<?php echo $dragdrop_id;?>"><span class="float">
<a href=./stitky/update.php?id=<?php echo $dragdrop_id;?>><b><?php echo $dragdrop_mesto;?></b><?php echo $dragdrop_firma;?></a></span>
</div>
<?php endif;?>

<?php if(strlen($dragdrop_firma)>0):?>
<div style="background-color:darkorange; font-size:11px; border-width: 0px; height:<?php echo $dragdrop_vyska;?>px; width:<?php echo $dragdrop_sirka;?>px;left:<?php echo $dragdrop_left_x;?>px;top:<?php echo $dragdrop_top_y;?>px; background: <?php echo $dragdrop_barva;?>;" data-need="<?php echo $dragdrop_id;?>"><span class="float">
<a href=./stitky/update.php?id=<?php echo $dragdrop_id;?>><b><?php echo $dragdrop_mesto;?></b><b><?php echo $dragdrop_firma;?></b></a></span>
</div>
<?php endif;?>

 <?php
 
$i++;

endwhile;




?>

<div id = "trash" style="border-width: 0px; left:5px;top:926px;"><img src="kos.png">
</div>

</div> 

<?php
include("inc/connect.php");
$xquery1="SELECT * FROM ubytovatele WHERE (maj_mesto like '%white%' or maj_mesto like '%rgb(255, 255, 255)%') and skupina = 'dotiko'";
$xresult1=mysql_query($xquery1);
$num_white = mysql_num_rows ($xresult1);

$xquery2="SELECT * FROM ubytovatele WHERE (maj_mesto like '%yellow%' or maj_mesto like '%rgb(255, 255, 0)%' ) and skupina = 'dotiko'";
$xresult2=mysql_query($xquery2);
$num_yellow = mysql_num_rows ($xresult2);

$xquery3="SELECT * FROM ubytovatele WHERE (maj_mesto like '%LightGray%' or maj_mesto like '%rgb(211, 211, 211)%' ) and skupina = 'dotiko'";
$xresult3=mysql_query($xquery3);
$num_LightGray = mysql_num_rows ($xresult3);

$xquery4="SELECT * FROM ubytovatele WHERE (maj_mesto like '%fuchsia%' or maj_mesto like '%rgb(255, 0, 255)%' ) and skupina = 'dotiko'";
$xresult4=mysql_query($xquery4);
$num_fuchsia = mysql_num_rows ($xresult4);

$xquery5="SELECT * FROM ubytovatele WHERE (maj_mesto like '%aqua%' or maj_mesto like '%rgb(0, 255, 255)%' ) and skupina = 'dotiko'";
$xresult5=mysql_query($xquery5);
$num_aqua = mysql_num_rows ($xresult5);

$xquery6="SELECT * FROM ubytovatele WHERE (maj_mesto like '%red%' or maj_mesto like '%rgb(255, 0, 0)%' ) and skupina = 'dotiko'";
$xresult6=mysql_query($xquery6);
$num_red = mysql_num_rows ($xresult6);

$xquery7="SELECT * FROM ubytovatele WHERE (maj_mesto like '%blue%' or maj_mesto like '%rgb(0, 0, 255)%' ) and skupina = 'dotiko'";
$xresult7=mysql_query($xquery7);
$num_blue = mysql_num_rows ($xresult7);

$xquery8="SELECT * FROM ubytovatele WHERE (maj_mesto like '%green%' or maj_mesto like '%rgb(0, 128, 0)%' ) and skupina = 'dotiko'";
$xresult8=mysql_query($xquery8);
$num_green = mysql_num_rows ($xresult8);

$xquery9="SELECT * FROM ubytovatele WHERE (maj_mesto like '%olive%' or maj_mesto like '%rgb(128, 128, 0)%' ) and skupina = 'dotiko'";
$xresult9=mysql_query($xquery9);
$num_olive = mysql_num_rows ($xresult9);

$xquery10="SELECT * FROM ubytovatele WHERE (maj_mesto like '%teal%' or maj_mesto like '%rgb(0, 128, 128)%' ) and skupina = 'dotiko'";
$xresult10=mysql_query($xquery10);
$num_teal = mysql_num_rows ($xresult10);



$xquery11="SELECT * FROM ubytovatele WHERE (maj_mesto like '%magenta%' or maj_mesto like '%rgb(255, 0, 255)%' ) and skupina = 'dotiko'";
$xresult11=mysql_query($xquery11);
$num_magenta = mysql_num_rows ($xresult11);

$xquery12="SELECT * FROM ubytovatele WHERE (maj_mesto like '%orange%' or maj_mesto like '%rgb(255, 165, 0)%' ) and skupina = 'dotiko'";
$xresult12=mysql_query($xquery12);
$num_orange = mysql_num_rows ($xresult12);

$xquery13="SELECT * FROM ubytovatele WHERE (maj_mesto like '%pink%' or maj_mesto like '%rgb(255, 192, 203)%' ) and skupina = 'dotiko'";
$xresult13=mysql_query($xquery13);
$num_pink = mysql_num_rows ($xresult13);

?>


<input type="submit" name="akce" value="odstranit">
<input type="submit" name="akce" value="presunout">
<input type="submit" name="akce" value="opravit">
<input type="button" value="Jobs" onclick="window.open('https://www.dotiko.cz/jobs/', '_self')" />
<input type="button" value="stitky" onclick="window.open('https://www.dotiko.cz/jobs/stitky/', '_self')" />
<input type="button" value="lepítka" onclick="window.open('https://www.dotiko.cz/jobs/stitky/add.php?lepitko=1', '_self')" />
<input type="button" value="backup!" onclick="window.open('https://www.dotiko.cz/jobs/historie.php?datum_hist=<? echo date('Y-m-d');?>', '_self')" />
<input type="button" value="tisk" onclick="window.open('https://www.dotiko.cz/jobs/tisknastenka.php', '_blank')" />
<input type="button" value="nastenka2" onclick="window.open('https://www.dotiko.cz/jobs/dragdrop2.php', '_self')" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="akce" value="white" style="background-color: white; color: white; width: 20px"><img src=gd.php?text=<?php echo $num_white; ?>>
<input type="submit" name="akce" value="yellow" style="background-color: yellow; color: yellow; width: 20px"><img src=gd.php?text=<?php echo $num_yellow; ?>>
<input type="submit" name="akce" value="fuchsia" style="background-color: fuchsia; color: fuchsia; width: 20px"><img src=gd.php?text=<?php echo $num_fuchsia; ?>>
<input type="submit" name="akce" value="aqua" style="background-color: aqua; color: aqua; width: 20px"><img src=gd.php?text=<?php echo $num_aqua; ?>>
<input type="submit" name="akce" value="red" style="background-color: red; color: red; width: 20px"><img src=gd.php?text=<?php echo $num_red; ?>>
<input type="submit" name="akce" value="blue" style="background-color: blue; color: blue; width: 20px"><img src=gd.php?text=<?php echo $num_blue; ?>>
<input type="submit" name="akce" value="green" style="background-color: green; color: green; width: 20px"><img src=gd.php?text=<?php echo $num_green; ?>>
<input type="submit" name="akce" value="olive" style="background-color: olive; color: olive; width: 20px"><img src=gd.php?text=<?php echo $num_olive; ?>>
<input type="submit" name="akce" value="teal" style="background-color: teal; color: teal; width: 20px"><img src=gd.php?text=<?php echo $num_teal; ?>>
<input type="submit" name="akce" value="LightGray" style="background-color: LightGray; color: LightGray; width: 20px"><img src=gd.php?text=<?php echo $num_LightGray; ?>>
<input type="submit" name="akce" value="Magenta" style="background-color: Magenta; color: Magenta; width: 20px"><img src=gd.php?text=<?php echo $num_magenta; ?>>
<input type="submit" name="akce" value="Orange" style="background-color: Orange; color: Orange; width: 20px"><img src=gd.php?text=<?php echo $num_orange; ?>>
<input type="submit" name="akce" value="Pink" style="background-color: Pink; color: Pink; width: 20px"><img src=gd.php?text=<?php echo $num_pink; ?>>


<?php
echo "&nbsp; Narozeniny má dnes: ";
$muz = date(md);
$zena = $muz+5000;
$xquery14="SELECT distinct rc1, prij, jmeno FROM byznys WHERE substring(rc1, 3, 6) = '$muz' or substring(rc1, 3, 6) = '$zena'";
$xresult14=mysql_query($xquery14);
$num_narozky = mysql_num_rows ($xresult14);
$i=0;
while ($i < $num_narozky):
if ($i>0):
echo ",";
endif;
echo " ".mysql_result($xresult14,$i,"prij");
$i++;
endwhile;
mysql_close();
?>
</form>
</div>
</body>

</html>
