<?php
class Functions
{
    private $d;

    function __construct($d)
    {
        $this->d = $d;
    }

    /* Is number */
    public function isNumber($numbs)
    {
        if (preg_match('/^[0-9]+$/', $numbs)) {
            return true;
        }
        
        return false;
    }

    function var_dump($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    /* Kiểm tra dữ liệu nhập vào */
    public function cleanInput($input = '', $type = '')
    {
        $output = '';
        if ($input != '') {
            // Loại bỏ HTML tags
            /* '@<[\/\!]*?[^<>]*?>@si', */
            $search = array(
                'script' => '@<script[^>]*?>.*?</script>@si',
                'style' => '@<style[^>]*?>.*?</style>@siU',
                'blank' => '@<![\s\S]*?--[ \t\n\r]*>@',
                'iframe' => '/<iframe(.*?)<\/iframe>/is',
                'title' => '/<title(.*?)<\/title>/is',
                'pre' => '/<pre(.*?)<\/pre>/is',
                'frame' => '/<frame(.*?)<\/frame>/is',
                'frameset' => '/<frameset(.*?)<\/frameset>/is',
                'object' => '/<object(.*?)<\/object>/is',
                'embed' => '/<embed(.*?)<\/embed>/is',
                'applet' => '/<applet(.*?)<\/applet>/is',
                'meta' => '/<meta(.*?)<\/meta>/is',
                'doctype' => '/<!doctype(.*?)>/is',
                'link' => '/<link(.*?)>/is',
                'body' => '/<body(.*?)<\/body>/is',
                'html' => '/<html(.*?)<\/html>/is',
                'head' => '/<head(.*?)<\/head>/is',
                'onclick' => '/onclick="(.*?)"/is',
                'ondbclick' => '/ondbclick="(.*?)"/is',
                'onchange' => '/onchange="(.*?)"/is',
                'onmouseover' => '/onmouseover="(.*?)"/is',
                'onmouseout' => '/onmouseout="(.*?)"/is',
                'onmouseenter' => '/onmouseenter="(.*?)"/is',
                'onmouseleave' => '/onmouseleave="(.*?)"/is',
                'onmousemove' => '/onmousemove="(.*?)"/is',
                'onkeydown' => '/onkeydown="(.*?)"/is',
                'onload' => '/onload="(.*?)"/is',
                'onunload' => '/onunload="(.*?)"/is',
                'onkeyup' => '/onkeyup="(.*?)"/is',
                'onkeypress' => '/onkeypress="(.*?)"/is',
                'onblur' => '/onblur="(.*?)"/is',
                'oncopy' => '/oncopy="(.*?)"/is',
                'oncut' => '/oncut="(.*?)"/is',
                'onpaste' => '/onpaste="(.*?)"/is',
                'php-tag' => '/<(\?|\%)\=?(php)?/',
                'php-short-tag' => '/(\%|\?)>/'
            );
            if (!empty($type)) {
                unset($search[$type]);
            }
            $output = preg_replace($search, '', $input);
        }
        return $output;
    }
    /* Kiểm tra dữ liệu nhập vào */
    public function checkInput($input = '', $type = '')
    {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = $this->checkInput($val, $type);
            }
        } else {
            $output  = $this->cleanInput($input, $type);
        }
        return $output;
    }
    /* UTF8 convert */
    public function utf8Convert($str = '')
    {
        if ($str != '') {
            $utf8 = array(
                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'd' => 'đ|Đ',
                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
                '' => '`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
            );
            foreach ($utf8 as $ascii => $uni) {
                $str = preg_replace("/($uni)/i", $ascii, $str);
            }
        }
        return $str;
    }
    /* Chuyển đổi tên thành slug link (vd: Hoàng Phạm -> hoang-pham) */
    public function changeTitle($text = '')
    {
        if ($text != '') {
            $text = strtolower($this->utf8Convert($text));
            $text = preg_replace("/[^a-z0-9-\s]/", "", $text);
            $text = preg_replace('/([\s]+)/', '-', $text);
            $text = str_replace(array('%20', ' '), '-', $text);
            $text = preg_replace("/\-\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-/", "-", $text);
            $text = '@' . $text . '@';
            $text = preg_replace('/\@\-|\-\@|\@/', '', $text);
        }
        return $text;
    }
    /* Has file */
    public function hasFile($file)
    {
        if (isset($_FILES[$file])) {
            if ($_FILES[$file]['error'] == 4) {
                return false;
            } else if ($_FILES[$file]['error'] == 0) {
                return true;
            }
        }

        return false;
    }
    /* Upload name */
    public function uploadName($name = '')
    {
        $result = '';
        if ($name != '') {
            $rand = rand(1000, 9999);
            $new_name = pathinfo($name, PATHINFO_FILENAME);
            $result = $this->changeTitle($new_name) . "-" . $rand;
        }
        return $result;
    }
    /* Upload images */
    public function uploadImage($file = '', $folder = '', $newname = '')
    {
        if (isset($_FILES[$file]) && !$_FILES[$file]['error']) {
            $postMaxSize = ini_get('post_max_size');
            $MaxSize = explode('M', $postMaxSize);
            $MaxSize = $MaxSize[0];

            if ($_FILES[$file]['size'] > $MaxSize * 1048576) {
                echo ('Dung lượng file không được vượt quá ' . $postMaxSize);
                return false;
            }

            $ext = explode('.', $_FILES[$file]['name']);
            $ext = strtolower(end($ext));
            $allowed_ext = ".jpg|.gif|.png|.jpeg|.gif";
            if (strpos($allowed_ext, $ext) === false) {
                echo ('Chỉ hỗ trợ upload file dạng ' . $allowed_ext);
                return false;
            }

            $name = basename($_FILES[$file]['name'], '.' . $ext);
            if ($newname == '' && file_exists($folder . $_FILES[$file]['name']))
                for ($i = 0; $i < 100; $i++) {
                    if (!file_exists($folder . $name . $i . '.' . $ext)) {
                        $_FILES[$file]['name'] = $name . $i . '.' . $ext;
                        break;
                    }
                }
            else {
                $_FILES[$file]['name'] = $newname . '.' . $ext;
            }
            if (!copy($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                if (!move_uploaded_file($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                    return false;
                }
            }

            return $_FILES[$file]['name'];
        }
        return false;
    }
    /* Get image */
    public function getImage($data = array())
    {
        global $config;
        /* Defaults */
        $defaults = [
            'width' => '',
            'height' => '',
            'upload' => '',
            'image' => '',
            'upload-error' => 'assets/images/',
            'image-error' => 'noimage.png',
            'alt' => ''
        ];
        /* Data */
        $info = array_merge($defaults, $data);
        /* Upload - Image */
        if (empty($info['upload']) || empty($info['image'])) {
            $info['upload'] = $info['upload-error'];
            $info['image'] = $info['image-error'];
        }
        /* Path error */
        $info['pathError'] = $info['upload-error'] . $info['image-error'];
        /* Path origin */
        $info['pathOrigin'] = $info['upload'] . $info['image'];
        /* Path src */
        $info['pathSrc'] = $info['pathOrigin'];
        /* Src */
        $info['src'] = "src='" . $info['pathSrc'] . "'";
        /* Image */
        $result = "<img style='width:" . $info['width'] . "px; height:" . $info['height'] . "px' onerror=\"this.src='" . $info['pathError'] . "';\" " . $info['src'] . " alt='" . $info['alt'] . "'/>";
        return $result;
    }
    /* Redirect */
    public function redirect($url = '', $response = null)
    {
        header("location:$url", true, $response);
        exit();
    }
    /* Transfer */
    public function transfer($msg = '', $page = '', $numb = true)
    {
        global $configBase;
        $basehref = $configBase;
        $showtext = $msg;
        $page_transfer = $page;
        $numb = $numb;
        include("../templates/layout/transfer.php");
        exit();
    }
    /* Lấy link page hiện tại */
    public function getCurrentPageURL()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $urlpos = strpos($pageURL, "?page");
        $pageURL = ($urlpos) ? explode("?page=", $pageURL) : explode("&page=", $pageURL);
        return $pageURL[0];
    }

    /* Pagination */
    public function pagination($totalq = 0, $perPage = 10, $page = 1, $url = '?')
    {
        $urlpos = strpos($url, "?");
        $url = ($urlpos) ? $url . "&" : $url . "?";
        $total = $totalq;
        $adjacents = "2";
        $firstlabel = "First";
        $prevlabel = "Prev";
        $nextlabel = "Next";
        $lastlabel = "Last";
        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $perPage;
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total / $perPage);
        $lpm1 = $lastpage - 1;
        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination flex-wrap justify-content-center mb-0'>";
            $pagination .= "<li class='page-item'><a class='page-link'>Page {$page} / {$lastpage}</a></li>";
            if ($page > 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$this->getCurrentPageURL()}'>{$firstlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$prev}'>{$prevlabel}</a></li>";
            }
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                    else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
                } else {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=1'>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                }
            }
            if ($page < $counter - 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
            $pagination .= "</ul>";
        }
        return $pagination;
    }

    /* Get category by link */
    public function getLinkCategory($table = '', $level = '', $title_select = 'Chọn danh mục')
    {
        global $d;

        $where = '';
        $id_parent = 'id_' . $level;

        $rows = $d->rawQuery("select name, id from table_" . $table . "_" . $level . " where id > 0 " . $where . " order by numb,id desc", array());
        $str = '<select id="' . $id_parent . '" name="' . $id_parent . '" onchange="onchangeCategory($(this))" class="form-control filter-category select2"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get category by ajax */
    public function getAjaxCategory($table = '', $level = '', $title_select = 'Chọn danh mục', $class_select = 'select-category')
    {
        global $d;

        $where = '';
        $id_parent = 'id_' . $level;
        $data_level = '';
        $data_table = '';
        $data_child = '';
        if ($level == 'list') {
            $data_level = 'data-level="0"';
            $data_table = 'data-table="#_' . $table . '_list"';
            $data_child = 'data-child="id_list"';
        } else if ($level == 'brand') {
            $data_level = '';
            $class_select = '';
        }
        $rows = $d->rawQuery("select name, id from table_" . $table . "_" . $level . " where id > 0 " . $where . " order by numb,id desc", array());
        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" ' . $data_level . ' ' . $data_table . ' ' . $data_child . ' class="form-control select2 ' . $class_select . '"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Decode html characters */
    public function decodeHtmlChars($htmlChars)
    {
        return htmlspecialchars_decode($htmlChars ?: '');
    }
    /* Check title */
    public function checkTitle($data = array())
    {
        global $config;
        $result = array();
        if (isset($data['name'])) {
            $title = trim($data['name']);
            if (empty($title)) {
                $result[] = 'Tiêu đề không được trống';
            }
        }
        return $result;
    }
    /* Check slug */
    public function checkSlug($data = array())
    {
        global $d;

        $result = 'valid';
        if (isset($data['slug'])) {
            $slug = trim($data['slug']);
            if (!empty($slug)) {
                $table = array(
                    "table_product_list",
                    "table_product_brand",
                    "table_product",
                    "table_news",
                );
                $where = (!empty($data['id'])) ? "id != " . $data['id'] . " and " : "";
                foreach ($table as $v) {
                    $check = $d->rawQueryOne("select id from $v where $where slug = ? limit 0,1", array($data['slug']));
                    if (!empty($check['id'])) {
                        $result = 'exist';
                        break;
                    }
                }
            } else {
                $result = 'empty';
            }
        }
        return $result;
    }
}
