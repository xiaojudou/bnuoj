<?php
include_once("conn.php");
$pid=$_GET['pid'];
$path=$_SERVER['PHP_SELF'];
$dir=explode("/",$path);
$ref="http://".$_SERVER['SERVER_NAME'];
for ($i=0;$i<count($dir)-1;$i++) $ref=$ref.$dir[$i]."/";

include 'php-ofc-library/open-flash-chart.php';

$title=new title( 'Statistatics Of Problem '.$pid.'' );
$title->set_style('color: #000000; font-size: 20px');
list($nac)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result like 'Accepted%'"));
list($nce)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Compile Error'"));
//list($nwa)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Wrong Answer'"));
//list($npe)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Presentation Error'"));
//list($nre)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Runtime Error'"));
//list($ntle)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Time Limit Exceed'"));
//list($nmle)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Memory Limit Exceed'"));
//list($nole)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Output Limit Exceed'"));
//list($nrf)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid and result='Restricted Function'"));
list($ntot)=mysql_fetch_array(mysql_query("select count(*) from status where pid=$pid"));

$not=$ntot-$nac-$nce;


$d = array(
    new pie_value(intval($nac),  "Accepted"),
    new pie_value(intval($nce),  "Compile Error"),
//    new pie_value(intval($nwa),  "Wrong Answer"),
//    new pie_value(intval($npe),  "Presentation Error"),
//    new pie_value(intval($nre),  "Runtime Error"),
//    new pie_value(intval($ntle),  "Time Limit Exceed"),
//    new pie_value(intval($nmle),  "Memory Limit Exceed"),
//    new pie_value(intval($nole), "Output Limit Exceed"),
//    new pie_value(intval($nrf), "Restricted Function"),
    new pie_value(intval($not), "Unaccepted")
    );
$d[0]->on_click($ref."status.php?showpid=$pid&showres=Accepted");
$d[1]->on_click($ref."status.php?showpid=$pid&showres=Compile+Error");
$d[2]->on_click($ref."status.php?showpid=$pid&showres=Unaccepted");
//$d[3]->on_click($ref."status.php?showpid=$pid&showres=Presentation+Error");
//$d[4]->on_click($ref."status.php?showpid=$pid&showres=Runtime+Error");
//$d[5]->on_click($ref."status.php?showpid=$pid&showres=Time+Limit+Exceed");
//$d[6]->on_click($ref."status.php?showpid=$pid&showres=Memory+Limit+Exceed");
//$d[7]->on_click($ref."status.php?showpid=$pid&showres=Output+Limit+Exceed");
//$d[8]->on_click($ref."status.php?showpid=$pid&showres=Restricted+Function");

$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Num:#val# Percent:#percent#' )
    ->colours(array("#0060ff","#008347","#FF0000"))
    ->values( $d )
    ->radius(100);

$chart = new open_flash_chart();
//$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#e6e9f2');

?>

