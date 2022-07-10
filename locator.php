<?php 
#создаем функцию возвращающую ip адрес при запуске на удаленном компе
function get_ip() { 
 if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP']; 
 else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR']; 
 else return $_SERVER['REMOTE_ADDR']; 
}
# оеделяем ip адрес этой функцией
$ip = get_ip(); 
# передаем этот ip адрес на вебсервис Геоплагин для позиционирования но нему местоположения
# ответ получаем в виде файла с набором данных в формате json
echo 'IP-адрес: ' . $ip . '<br>'; 
$file =  file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);
# проверяем получили мы файл или нет 
if ($file === false) {
 echo 'Ошибка получения данных geoplugin.net!'; exit;
}
# декодируем полученные данные из формата json в удобочитаемый и записываем их в переменную $ipat
#  с проверкой правильности интерпретации данных
$ipdat = json_decode($file);
if (!$ipdat) {
  echo 'Ошибка интерпретации данных geoplugin.net!'; exit;
}
# выводим полученные данные в удобочитаемом формате построчно
echo 'Континент: ' . $ipdat->geoplugin_continentName . '<br>'; 
echo 'Страна: ' . $ipdat->geoplugin_countryName . '<br>'; 
echo 'Город: ' . $ipdat->geoplugin_city . '<br>'; 
echo 'Широта: ' . $ipdat->geoplugin_latitude . '<br>'; 
echo 'Долгота: ' . $ipdat->geoplugin_longitude . '<br>'; 
echo 'Символ валюты: ' . $ipdat->geoplugin_currencySymbol . '<br>'; 
echo 'Код валюты: ' . $ipdat->geoplugin_currencyCode . '<br>'; 
echo 'Часовой пояс: ' . $ipdat->geoplugin_timezone; 
?> 