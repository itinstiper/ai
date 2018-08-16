<div align="right" style="font-size:18px; padding-left:15px; color:#CCCCCC"><B>Nomor Barcode</B></div>
<BR>
<?
if ($_POST['SubUbah']==true){
		mysql_query("UPDATE pegawai SET barcode='".$_POST['barcode']."' WHERE IDpeg='".$_POST['IDpeg']."'");
		header("Location: ".$_SERVER["PHP_SELF"]."?modul=".$_SESSION['modul']."&hal=BarcodePegawai&Tab=DataBarcode&aksi=ubah&page=".$_POST['page']."&msg=Nomor Barcode sukses di ubah.");
} 


if ($_GET['aksi']=="ubah") { 
$r=mysql_fetch_array(mysql_query("SELECT IDpeg,nama,barcode FROM pegawai WHERE IDpeg='".$_GET['IDpeg']."'"));
?>
<BR>
                        <form method="post" action="<?=$_SERVER['PHP_SELF']."?modul=".$_SESSION['modul']."&hal=BarcodePegawai&Tab=DataBarcode"?>">
								<div style="padding:10px 20px 10px 20px; border:1px solid #CCCCCC; background-color:#F9F9F9; width:520px"><table width="100%">
								<tr>
								  <td width="25%">Nama Pegawai</td>
								  <td width="75%"><?=$r['nama']?></td></tr>
								  <tr>
								  <td width="25%"> <B>Nomor Barcode</B></td>
								  <td width="75%"><input name="barcode" type="text" style="border:1px solid #999999; width:250px; background-color:#FFFFFF" value="<?=$r['barcode']?>">
							      <input type="hidden" name="IDpeg" value="<?=$r['IDpeg']?>">
								  <input type="hidden" name="page" value="<?=$_GET['page']?>">
								  <input type="submit" name="SubUbah" value="Ubah Data" style="border:1px solid #999999; padding:2px; text-align:center; background-color:#CCCCCC" /></td></tr>
								</table>
								</div>
						</form><BR><BR>
<? 
	}

	require("./inc/paging_class.php");
	$paging=new paging(50,5);
	$paging->db($mysql_host,$mysql_user,$mysql_pass,$dbase_name);
								   $Q1	 = "SELECT * FROM pegawai ";
	
	if ($_POST['Cari']==true)      $Q1	.=	"WHERE NIP like '%".$_POST['CariPegawai']."%' 
											 OR nama like '%".$_POST['CariPegawai']."%'
											 OR telp like '%".$_POST['CariPegawai']."%'
											 OR barcode like '%".$_POST['CariPegawai']."%' ";
	/*							   
								   $Q1	.=	"ORDER BY ";

	if ($_GET['Urut']=="NIP")	   $Q1	.=	"NIP ";
	elseif ($_GET['Urut']=="nama") $Q1	.=	"nama ";
	elseif ($_GET['Urut']=="HP")   $Q1	.=	"telp ";
	else                           $Q1  .=	"nama ";	

								   $Q1	.=	"ASC";
	*/
	
	$paging->query($Q1);
	$page=$paging->print_info();
	?>
	<form method="post" action="<?=$_SERVER['PHP_SELF']."?modul=".$_SESSION['modul']."&hal=BarcodePegawai&Tab=DataBarcode"?>">
	<table width="90%" style="border-top:1px solid #CCCCCC; border-bottom:1px solid #CCCCCC"><tr>
	<td width="53%"><input type="text" name="CariPegawai" style="border:1px solid #CCCCCC"> <input type="submit" name="Cari" value="Cari Pegawai"></td>
	<td width="47%" align="right" style="color:#666666">Terdapat <?=$page[start]." - ".$page[end]?> baris, dari total <?=$page[total]?> data.</td>
	</tr>

	</table></form>
	<div style="padding-bottom:1px">&nbsp;</div>
	<table width="90%" border="1" cellpadding="1" cellspacing="0" bordercolor="#999999" style="border-collapse: collapse">
        <tr bgcolor='#E0E0E0'>
        <td width="5%" height="25" align='center' bgcolor="#C7C7C7">No.</td>
        <td width="31%" style="padding-left:10px" bgcolor="#C7C7C7"><strong>Nama Pegawai</strong></td>
         <td width="19%" align="center" bgcolor="#C7C7C7">Unit Kerja </td>
       <td width="20%" align="center" bgcolor="#CEDAE8"><B> Barcode</B> </td>
        <td width="13%" align="center" bgcolor="#CEDAE8">Nomor Barcode</td>
        <td width="12%" align="center" bgcolor="#C7C7C7">Ubah <br />
          No. Barcode </td>
        </tr>
    <?
	while ($r2=$paging->result_assoc()) {
	
	$r1=mysql_fetch_array(mysql_query("SELECT * FROM unitkerja
									   WHERE iduk='".$r2['iduk']."'"));

	//echo $paging->print_no()." : ";
	//echo "$result->judul<br>\n";
	echo "<tr onmouseover=bgColor='#FFEAF4' onmouseout=bgColor='#ffffff'>";
	echo "<td align=\"center\">".$paging->print_no().".</td>";
	echo "<td style=\"padding-left:10px\"><B>".$r2['nama']."</B></td>";
	echo "<td align=\"center\"><B>".$r1['namauk']."</td>";
	echo "<td align=\"center\" style=\"padding-top:10px\"><img src='./inc/barcode.php?barcode=".$r2['barcode']."'></td>";
	echo "<td align=\"center\" style=\"background-color:#F7F9FB\">".$r2['barcode']."</td>";
	echo "<td align=\"center\" style=\"background-color:#F7F9FB\"><a href=\"".$_SERVER['PHP_SELF']."?modul=".$_SESSION['modul']."&hal=BarcodePegawai&Tab=DataBarcode&aksi=ubah&IDpeg=".$r2['IDpeg']."&page=".$_GET['page']."\"><img src='./bullet/edit.gif' alt='Ubah user' border='0'></a></td>";
	echo "</tr>";
	}
	?>
</table>
	<?
	echo "<BR><span class='style11'>".$paging->print_link()."</span>";
	?>
