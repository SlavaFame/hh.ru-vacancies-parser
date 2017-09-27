<?php

function getAttribute($attrib, $tag){
    $re = '/'.$attrib.'=["\']?([^"\' ]*)["\' ]/is';
    preg_match($re, $tag, $match);
    if($match){
        return urldecode($match[1]); //Декодирование URL-кодированной строки
    }else {
        return false;
    }
}
//получить содержимой URL-ссылки
$file = file_get_contents("http://api.hh.ru/1/xml/vacancy/search?region=104&items=all&&employment=0&employment=1&schedules=0&schedules=1&schedules=2&schedules3&experience=0&experience=1&experience=2&order=2&field=1&text=");

preg_match_all("/<vacancy .*?\>.*?<\/vacancy\>/is", $file, $m); // глобальный поиск шаблона в строке

for ($i = 0; $i < count($m); $i++)
{
    for($j=0;$j<count($m[$i]);$j++)
    {
        preg_match("/<name>(.*?)<\/name>/", $m[$i][$j], $k);
        $k_str = $k[0];
        $k_str = preg_replace("/<name>/", "", $k_str); //Выполняем поиск и замену по регулярному выражению
        $k_str = preg_replace("/<\/name>/", "", $k_str);

        //если name - разработчик, то преобразуем строку в нижний регистр и возвращает позицию первого вхождения подстроки
       if(strpos(strtolower($k_str),'разработчик'))
       {
           $id = getAttribute('id',$m[$i][$j]);
           //переход по ссылке на полученную вакансию
           echo "<a href=\"http://chelyabinsk.hh.ru/vacancy/".$id."\">".$k_str."<br />";
       }
        if(strpos(strtolower($k_str),'программист'))
        {
            $id = getAttribute('id',$m[$i][$j]);
            //переход по ссылке на полученную вакансию
            echo "<a href=\"http://chelyabinsk.hh.ru/vacancy/".$id."\">".$k_str."<br />";
        }
        if(strpos(strtolower($k_str),'developer'))
        {
            $id = getAttribute('id',$m[$i][$j]);
            //переход по ссылке на полученную вакансию
            echo "<a href=\"http://chelyabinsk.hh.ru/vacancy/".$id."\">".$k_str."<br />";
        }

    }
}
?>