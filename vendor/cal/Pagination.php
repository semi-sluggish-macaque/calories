<?php


namespace cal;


class Pagination
{

    public $currentPage;
    public $perpage;
    public $total;
    public $countPages;
    public $uri;

    public function __construct($page, $perpage, $total)
    {
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();
    }

    public function getHtml()
    {
        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        // $back
        if ($this->currentPage > 1) {
            $back = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage - 1) . "'>&lt;</a></li>";
        }

        // $forward
        if ($this->currentPage < $this->countPages) {
            $forward = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage + 1) . "'>&gt;</a></li>";
        }

        // $startpage
        if ($this->currentPage > 3) {
            $startpage = "<li class='page-item'><a class='page-link' href='" . $this->getLink(1) . "'>&laquo;</a></li>";
        }

        // $endpage
        if ($this->currentPage < ($this->countPages - 2)) {
            $endpage = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->countPages) . "'>&raquo;</a></li>";
        }

        // $page2left
        if ($this->currentPage - 2 > 0) {
            $page2left = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage - 2) . "'>" . ($this->currentPage - 2) . "</a></li>";
        }

        // $page1left
        if ($this->currentPage - 1 > 0) {
            $page1left = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage - 1) . "'>" . ($this->currentPage - 1) . "</a></li>";
        }

        // $page1right
        if ($this->currentPage + 1 <= $this->countPages) {
            $page1right = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage + 1) . "'>" . ($this->currentPage + 1) . "</a></li>";
        }

        // $page2right
        if ($this->currentPage + 2 <= $this->countPages) {
            $page2right = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage + 2) . "'>" . ($this->currentPage + 2) . "</a></li>";
        }

        return '<nav aria-label="Page navigation example"><ul class="pagination">' . $startpage . $back . $page2left . $page1left . '<li class="page-item active"><a class="page-link">' . $this->currentPage . '</a></li>' . $page1right . $page2right . $forward . $endpage . '</ul></nav>';
    }


    //добавление гет параметра page
    public function getLink($page)
    {
        if ($page == 1) {
            //если это первая странице, то гет параметр не нужен
            return rtrim($this->uri, '?&');
        }

        //проверка на наличие доп гет параметров
        if (str_contains($this->uri, '&')) {
            return "{$this->uri}page={$page}";
        } else {
            //проверка на наличие одного гет параметра
            if (str_contains($this->uri, '?')) {
                return "{$this->uri}page={$page}";
            } else {
                return "{$this->uri}?page={$page}";
            }
        }
    }

    public function __toString()
    {
        return $this->getHtml();
    }

    public function getCountPages()
    {
        //получения номера страницы
        //ceil округление в большую сторону
        return ceil($this->total / $this->perpage) ?: 1;
    }

    public function getCurrentPage($page)
    {
        //проверки на существование коректнось и номера страницы
        if (!$page || $page < 1) $page = 1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    //задача метода в том, чтобы указать с sql запросе с какого товара необходимо начать выборку товаров
    public function getStart()
    {
        //pepage - количество товаров на странице
        //если товаров 3, а страница 1, то выбирать надо с нолевого продкта ((1 - 1) * 3 = 0)
        //если товаров 3, а страница 2, то выбирать надо с третего продкта ((2 - 1) * 3 = 3)
        return ($this->currentPage - 1) * $this->perpage;
    }

    public function getParams()
    {
        //получает url
        $url = $_SERVER['REQUEST_URI'];
        //разбивка url по  ? чтоюы получить гет параметри
        $url = explode('?', $url);
        //записываеть первый элемент массива(часть ссылки до "?", то есть ссылку без гет параметров)
        $uri = $url[0];
        //проверка на существование гет параметров
        if (isset($url[1]) && $url[1] != '') {
            //формируеться строка запроса
            $uri .= '?';
            //разбивка параметров по & (разделяються гет параметры)
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                //если гет параметр = "page=", тогда его пропускаем,
                //если нет, то добавляем параметры к ссылке
                if (!preg_match("#page=#", $param)) $uri .= "{$param}&";
            }
        }
        //возвращает полученую ссылку с гет запросами, но без гет запроса page
        return $uri;
    }

}
