<?php
	$action = (isset($_REQUEST["act"])) ? htmlspecialchars($_REQUEST["act"]) : '';

    switch ($action) {
        case 'list':
            list_products();
            break;
        case 'detail':
            detail_product($id);
            break;
        case 'save':
            save_product();
            break;
        default:
            list_products();
            break;
    }

    function list_products() {
        global $d, $configBase;

        $add_where = '';
        $add_limit = '';
        $page = (isset($_REQUEST['page'])) ? htmlspecialchars($_REQUEST['page']) : 0;
        $per_page = (isset($_REQUEST['per_page'])) ? htmlspecialchars($_REQUEST['per_page']) : 0;
        $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
        $idbrand = (isset($_REQUEST['id_brand'])) ? htmlspecialchars($_REQUEST['id_brand']) : 0;
        if ($idlist) $add_where .= " and id_list = $idlist";
        if ($idbrand) $add_where .= " and id_brand = $idbrand";
        if (isset($_REQUEST['keyword'])) {
            $keyword = htmlspecialchars($_REQUEST['keyword']);
            $add_where .= " and (name LIKE '%$keyword%')";
        }

        if ($page && $per_page) {
            $begin = ($page * $per_page) - $per_page;
            $add_limit .= " limit $begin, $per_page";
        }
        
        $products = $d->rawQuery("select id,id_list,concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo,content,p.desc,name,code,regular_price,sale_price,view,status from table_product p where find_in_set('hienthi',status) $add_where order by id asc $add_limit",array());
        $arr_product = array();

        foreach ($products as $i => $v) {
            $arr_product_list = array();
            $arr_gallery = array();
            $arr_size = array();
            $arr_color = array();

            $product_list = $d->rawQueryOne("select id,content,p.desc,name,concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo from table_product_list p where id = ? and find_in_set('hienthi',status) limit 0,1", array($v['id_list']));
            if(!empty($product_list)){
                $arr_product_list = array(
                    'id' => $product_list['id'],
                    'name' => $product_list['name'],
                    'photo' => $product_list['photo'],
                    'desc' => $product_list['desc'],
                    'content' => $product_list['content'],
                );
            }

            $gallery = $d->rawQuery("select concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo from table_gallery where id_parent = ? and find_in_set('hienthi',status) order by numb,id", array($v['id']));
            foreach ($gallery as $i2 => $v2) {
                array_push($arr_gallery, $v2['photo']);
            }

            $size = $d->rawQuery("select b.id, b.name from table_product_size a, table_size b where a.id_size = b.id and a.id_product = ?", array($v['id']));
            foreach ($size as $i2 => $v2) {
                array_push($arr_size, $v2);
            }
            
            $color = $d->rawQuery("select b.id, b.name from table_product_color a, table_color b where a.id_color = b.id and a.id_product = ?", array($v['id']));
            foreach ($color as $i2 => $v2) {
                array_push($arr_color, $v2);
            }

            $list_item = array(
                'id' => $v['id'],
                'name' => $v['name'],
                'photo' => $v['photo'],
                'desc' => $v['desc'],
                'content' => $v['content'],
                'product_list' => $arr_product_list,
                'gallery' => $arr_gallery,
                'code' => $v['code'],
                'regular_price' => $v['regular_price'],
                'sale_price' => $v['sale_price'],
                'sizes' => $arr_size,
                'colors' => $arr_color,
                'view' => $v['view'],
                'status' => $v['status'],
            );

            array_push($arr_product, $list_item);
        }

        echo json_encode($arr_product, JSON_NUMERIC_CHECK);
    }

    function detail_product($id) {
        global $d, $configBase;

        $add_where = '';
        $id = (isset($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
        if ($id) $add_where .= " and id = $id";
        
        $product = $d->rawQueryOne("select id,id_list,concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo,content,p.desc,name,code,regular_price,sale_price,view,status from table_product p where find_in_set('hienthi',status) $add_where limit 0,1",array());
        $arr_product = array();

        $arr_product_list = array();
        $arr_gallery = array();
        $arr_size = array();
        $arr_color = array();

        $product_list = $d->rawQueryOne("select id,content,p.desc,name,concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo from table_product_list p where id = ? and find_in_set('hienthi',status) limit 0,1", array($product['id_list']));
        if(!empty($product_list)){
            $arr_product_list = array(
                'id' => $product_list['id'],
                'name' => $product_list['name'],
                'photo' => $product_list['photo'],
                'desc' => $product_list['desc'],
                'content' => $product_list['content'],
            );
        }

        $gallery = $d->rawQuery("select concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo from table_gallery where id_parent = ? and find_in_set('hienthi',status) order by numb,id", array($product['id']));
        foreach ($gallery as $i2 => $v2) {
            array_push($arr_gallery, $v2['photo']);
        }

        $size = $d->rawQuery("select b.id, b.name from table_product_size a, table_size b where a.id_size = b.id and a.id_product = ?", array($product['id']));
        foreach ($size as $i2 => $v2) {
            array_push($arr_size, $v2);
        }
        
        $color = $d->rawQuery("select b.id, b.name from table_product_color a, table_color b where a.id_color = b.id and a.id_product = ?", array($product['id']));
        foreach ($color as $i2 => $v2) {
            array_push($arr_color, $v2);
        }

        $list_item = array(
            'id' => $product['id'],
            'name' => $product['name'],
            'photo' => $product['photo'],
            'desc' => $product['desc'],
            'content' => $product['content'],
            'product_list' => $arr_product_list,
            'gallery' => $arr_gallery,
            'code' => $product['code'],
            'regular_price' => $product['regular_price'],
            'sale_price' => $product['sale_price'],
            'sizes' => $arr_size,
            'colors' => $arr_color,
            'view' => $product['view'],
            'status' => $product['status'],
        );

        array_push($arr_product, $list_item);

        echo json_encode($arr_product, JSON_NUMERIC_CHECK);
    }

    function save_product() {
        global $func, $d;

        if (empty($_POST)) {
            echo json_encode(['status' => 404, 'messages' => 'No data'], JSON_NUMERIC_CHECK);
        }

        $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
        $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
        if ($data) {
            foreach ($data as $column => $value) {
                if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                    $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
                } else {
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }
            }
            if (!empty($_POST['slug']))
                $data['slug'] = $func->changeTitle(htmlspecialchars($_POST['slug']));
            else
                $data['slug'] = (!empty($data['name'])) ? $func->changeTitle($data['name']) : '';

            if (isset($_POST['status'])) {
                $status = '';
                foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
                $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
            } else {
                $data['status'] = "";
            }
            $data['regular_price'] = (isset($data['regular_price']) && $data['regular_price'] != '') ? str_replace(",", "", $data['regular_price']) : 0;
            $data['sale_price'] = (isset($data['sale_price']) && $data['sale_price'] != '') ? str_replace(",", "", $data['sale_price']) : 0;
        }

        if($id) {
            $data['date_updated'] = time();
            $d->where('id', $id);
            if ($d->update('table_product', $data)) {
                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES["file"]["name"]);
                    if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                        $exist = $d->rawQueryOne("select id, photo from table_product where id = ? limit 0,1", array($id));
                        if (!empty($exist)) {
                            unlink(UPLOAD_PRODUCT . $exist['photo']);
                        }
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id);
                        $d->update('table_product', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                detail_product($id);
            }
        } else {
            $data['date_created'] = time();
            /*lay stt*/
            $last_numb = $d->rawQuery("select numb from table_product order by numb desc", array());
            $data['numb'] = $last_numb[0]['numb'] + 1;

            if ($d->insert('table_product', $data)) {
                $id_insert = $d->getLastInsertId();
                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES["file"]["name"]);
                    if ($photo = $func->uploadImage("file", UPLOAD_PRODUCT, $file_name)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->update('table_product', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                detail_product($id_insert);
            }
        }
    }
?>