<?php
	$action = (isset($_REQUEST["action"])) ? htmlspecialchars($_REQUEST["action"]) : '';

    switch ($action) {
        case 'list':
            list_products();
            break;
        case 'detail':
            detail_product();
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
        
        if ($page && $per_page) {
            $begin = ($page * $per_page) - $per_page;
            $add_limit .= " limit $begin, $per_page";
        }
        
        $products = $d->rawQuery("select id,id_list,concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo,content,p.desc,name,code,regular_price,sale_price from table_product p where find_in_set('hienthi',status) $add_where order by id asc $add_limit",array());
        $arr_product = array();

        foreach ($products as $i => $v) {
            $arr_product_list = array();
            $arr_gallery = array();

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
            );

            array_push($arr_product, $list_item);
        }

        echo json_encode($arr_product, JSON_NUMERIC_CHECK);
    }

    function detail_product() {
        global $d, $configBase;

        $add_where = '';
        $id = (isset($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
        if ($id) $add_where .= " and id = $id";
        
        $product = $d->rawQueryOne("select id,id_list,concat('".$configBase.UPLOAD_PRODUCT_L."',photo) as photo,content,p.desc,name,code,regular_price,sale_price from table_product p where find_in_set('hienthi',status) $add_where limit 0,1",array());
        $arr_product = array();

        $arr_product_list = array();
        $arr_gallery = array();

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
        );

        array_push($arr_product, $list_item);

        echo json_encode($arr_product, JSON_NUMERIC_CHECK);
    }
?>