<?php

namespace cal;

class Cashe
{

    use Tsingleton;

    //запись данных в кеш
    public function set($key, $data, $seconds = 3600): bool
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        //создает txt файл и записывает сериализованные данные (serialize строковое представление объекта) в него
        if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
            return true;
        } else {
            return false;
        }
    }

    //получения данных с кеша
    public function get($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            //обратная сериализация и получение данных с файла
            $content = unserialize(file_get_contents($file));
            //проверка на истечние времени
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            //удаление файла
            unlink($file);
        }
        return false;
    }

    //удаления файла
    public function delete($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }

}