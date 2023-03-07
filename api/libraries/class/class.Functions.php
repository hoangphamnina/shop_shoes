<?php
class Functions {
    private $d;
    
    function __construct($d) {
        $this->d = $d;
    }

    function var_dump($arr) {
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
                echo('Dung lượng file không được vượt quá ' . $postMaxSize);
                return false;
            }
            
            $ext = explode('.', $_FILES[$file]['name']);
            $ext = strtolower(end($ext));
            $allowed_ext = ".jpg|.gif|.png|.jpeg|.gif";
            if (strpos($allowed_ext, $ext) === false) {
                echo('Chỉ hỗ trợ upload file dạng ' . $allowed_ext);
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
}
