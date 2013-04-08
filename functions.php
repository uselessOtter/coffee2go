<?php  
/**
* Пример использования пользовательских функций для обработки событий системы.
* Добавляет в заголовок страницы приставку "Лучший магазин".
* Создана для демонстрации работоспособности файла  functions.php
*/
function myTitle(){ 
  setOption('title', ' Coffee2Go | '.getOption('title'));
}

mgAddAction('mg_titlepage', 'myTitle');

