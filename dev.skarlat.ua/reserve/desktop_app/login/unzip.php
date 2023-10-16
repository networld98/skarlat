<?php
$archive_path = 'note.zip';
$extract_path = './';

// ������������� zip �����, ��� ���� ���� ��������� ��������� ����������� ������ (�����) � ���� ������������ ����������.
// ����� ����� ���� � ����� �� ��������� ���� ����� ��, ��� � ������ unzip.php 
// ����� �� ���� � ����� ��������� ������ ���� ����������� ��� �����, � ������� ��������� ��� unzip.php 


if (!file_exists($archive_path)) {
  echo "file not found " . $archive_path;
  exit;
}

$zip = new ZipArchive;
$zip->open($archive_path);
echo "extracting " . $zip->numFiles . " files...\n";
$zip->extractTo($extract_path);

$dirs = array();

echo"\nFiles:\n";

for( $i = 0; $i < $zip->numFiles; $i++ ){ 
    $stat = $zip->statIndex( $i ); 
    echo  $stat['name']  . "\n"; 
    touch($extract_path . $stat['name'], filemtime($archive_path));

    if (!array_search(dirname($stat['name']), $dirs))
      { array_push($dirs, dirname($stat['name'])); }
}

$zip->close();

echo"\nFolders:\n";

touch( dirname(__FILE__), filemtime($archive_path));

foreach($dirs as $key=>$value) {
  if ($value <>".") {
    echo $value . "\n" ;
    touch( $extract_path . $value, filemtime($archive_path));
    }
}
echo "Ok!";
?>